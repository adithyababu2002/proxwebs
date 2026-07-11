/**
 * Build short looping feature demo MP4s from generated UI mockup images.
 * Usage: node scripts/generate-feature-videos.mjs
 */
import { spawnSync } from 'node:child_process';
import { mkdirSync, existsSync, copyFileSync, readdirSync, writeFileSync } from 'node:fs';
import { dirname, join, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import { createRequire } from 'node:module';

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = resolve(__dirname, '..');
const require = createRequire(import.meta.url);

const ids = [
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

const outDir = join(root, 'public', 'onix', 'assets', 'videos', 'features');
const posterDir = join(outDir, 'posters');
const cursorAssets = resolve(
  process.env.USERPROFILE || '',
  '.cursor/projects/c-xampp8-2-htdocs-proxwebs-2/assets',
);

function findFfmpeg() {
  try {
    const installer = require('@ffmpeg-installer/ffmpeg');
    if (installer?.path && existsSync(installer.path)) return installer.path;
  } catch (_) {}
  return 'ffmpeg';
}

function findSourceImage(id) {
  const names = [`feature-${id}.png`, `feature-${id}.jpg`, `${id}.png`];
  const dirs = [posterDir, cursorAssets, join(root, 'assets'), join(root, 'public', 'onix', 'assets', 'images')];
  for (const dir of dirs) {
    if (!existsSync(dir)) continue;
    for (const name of names) {
      const p = join(dir, name);
      if (existsSync(p)) return p;
    }
  }
  return null;
}

mkdirSync(posterDir, { recursive: true });
const ffmpeg = findFfmpeg();
console.log('ffmpeg:', ffmpeg);

const manifest = {};
let failed = 0;

for (const id of ids) {
  const src = findSourceImage(id);
  if (!src) {
    console.error('Missing image for', id);
    failed += 1;
    continue;
  }

  const poster = join(posterDir, `${id}.png`);
  if (src !== poster) copyFileSync(src, poster);

  const out = join(outDir, `${id}.mp4`);

  // Ken Burns zoom + slight pan, 5s loop-friendly clip
  const vf =
    "scale=1280:800:force_original_aspect_ratio=increase,crop=1280:800,zoompan=z='min(zoom+0.0015,1.12)':x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)':d=150:s=1280x800:fps=30,format=yuv420p";

  const result = spawnSync(
    ffmpeg,
    [
      '-y',
      '-loop',
      '1',
      '-i',
      poster,
      '-vf',
      vf,
      '-t',
      '5',
      '-c:v',
      'libx264',
      '-pix_fmt',
      'yuv420p',
      '-movflags',
      '+faststart',
      '-an',
      out,
    ],
    { encoding: 'utf8' },
  );

  if (result.status !== 0) {
    console.error('Failed', id, result.stderr?.slice(-600));
    failed += 1;
    continue;
  }

  manifest[id] = {
    video: `/onix/assets/videos/features/${id}.mp4`,
    poster: `/onix/assets/videos/features/posters/${id}.png`,
  };
  console.log('OK', id);
}

writeFileSync(join(outDir, 'manifest.json'), JSON.stringify(manifest, null, 2));
console.log(failed ? `Done with ${failed} failures` : 'All feature videos generated');
process.exitCode = failed ? 1 : 0;
