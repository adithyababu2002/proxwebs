/**
 * Records interactive feature workflow demos to MP4.
 * Run: node scripts/record-feature-videos.mjs
 */
import { chromium } from 'playwright';
import { spawnSync } from 'node:child_process';
import { mkdirSync, existsSync, readdirSync, copyFileSync, rmSync, writeFileSync } from 'node:fs';
import { dirname, join, resolve } from 'node:path';
import { fileURLToPath, pathToFileURL } from 'node:url';
import { createRequire } from 'node:module';

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = resolve(__dirname, '..');
const require = createRequire(import.meta.url);
const htmlPath = join(__dirname, 'feature-demo-studio.html');
const outDir = join(root, 'public', 'onix', 'assets', 'videos', 'features');
const posterDir = join(outDir, 'posters');
const tmpDir = join(root, 'scripts', '.feature-video-tmp');

const features = [
  'loaders',
  'fonts',
  'templates',
  'login',
  'colors',
  'ai',
  'builder',
  'menus',
  'sections',
  'publish',
  'rbac',
  'dashboard',
  'importexport',
  'seo',
  'contacts',
];

function findFfmpeg() {
  const candidates = [
    join(root, 'node_modules', '@ffmpeg-installer', 'win32-x64', 'ffmpeg.exe'),
    join(root, 'node_modules', '@ffmpeg-installer', 'ffmpeg', 'ffmpeg.exe'),
  ];
  try {
    const installer = require('@ffmpeg-installer/ffmpeg');
    if (installer?.path) candidates.unshift(installer.path);
  } catch (_) {}

  for (const c of candidates) {
    if (c && existsSync(c)) return c;
  }
  throw new Error('ffmpeg.exe not found. Run: npm install --no-save @ffmpeg-installer/ffmpeg');
}

mkdirSync(outDir, { recursive: true });
mkdirSync(posterDir, { recursive: true });
mkdirSync(tmpDir, { recursive: true });

const ffmpeg = findFfmpeg();
const htmlUrl = pathToFileURL(htmlPath).href;
console.log('Recording from', htmlUrl);
console.log('ffmpeg:', ffmpeg);

const browser = await chromium.launch({ headless: true });
const manifest = {};

for (const id of features) {
  const webmPath = join(tmpDir, `${id}.webm`);
  const mp4Path = join(outDir, `${id}.mp4`);
  const posterPath = join(posterDir, `${id}.png`);

  console.log('Recording', id, '...');
  const context = await browser.newContext({
    viewport: { width: 1280, height: 720 },
    recordVideo: { dir: tmpDir, size: { width: 1280, height: 720 } },
  });
  const page = await context.newPage();
  await page.goto(`${htmlUrl}?scene=__none__`, { waitUntil: 'domcontentloaded' });
  // Reset by reloading clean page then running demo
  await page.goto(htmlUrl, { waitUntil: 'domcontentloaded' });
  await page.waitForTimeout(300);
  await page.evaluate(async (featureId) => {
    await window.runFeatureDemo(featureId);
  }, id);
  await page.waitForTimeout(400);
  await page.screenshot({ path: posterPath, type: 'png' });
  await context.close();

  // Playwright writes webm with random name in tmpDir for the page
  const webms = readdirSync(tmpDir).filter((f) => f.endsWith('.webm'));
  // pick newest
  webms.sort((a, b) => {
    const pa = join(tmpDir, a);
    const pb = join(tmpDir, b);
    return require('fs').statSync(pb).mtimeMs - require('fs').statSync(pa).mtimeMs;
  });
  if (!webms.length) {
    console.error('No webm for', id);
    continue;
  }
  const newest = join(tmpDir, webms[0]);
  copyFileSync(newest, webmPath);
  // cleanup other webms from this iteration
  for (const f of webms) {
    try { rmSync(join(tmpDir, f)); } catch (_) {}
  }

  const result = spawnSync(
    ffmpeg,
    [
      '-y',
      '-i',
      webmPath,
      '-c:v',
      'libx264',
      '-pix_fmt',
      'yuv420p',
      '-movflags',
      '+faststart',
      '-an',
      mp4Path,
    ],
    { encoding: 'utf8' },
  );

  if (result.status !== 0) {
    console.error('ffmpeg failed for', id, result.stderr?.slice(-500));
    continue;
  }

  try { rmSync(webmPath); } catch (_) {}
  manifest[id] = {
    video: `/onix/assets/videos/features/${id}.mp4`,
    poster: `/onix/assets/videos/features/posters/${id}.png`,
  };
  console.log('OK', id);
}

await browser.close();
writeFileSync(join(outDir, 'manifest.json'), JSON.stringify(manifest, null, 2));
console.log('All workflow videos recorded.');
