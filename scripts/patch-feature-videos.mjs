import { readFileSync, writeFileSync } from 'node:fs';

const path = new URL('../resources/js/onix/content/features.js', import.meta.url);
let s = readFileSync(path, 'utf8');

const demos = [
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

for (const demo of demos) {
  const videoPath = `/onix/assets/videos/features/${demo}.mp4`;
  if (s.includes(videoPath)) continue;
  const needle = `demo: '${demo}',`;
  const idx = s.indexOf(needle);
  if (idx === -1) {
    console.warn('missing', demo);
    continue;
  }
  const insert = `${needle}\n    video: '${videoPath}',\n    poster: '/onix/assets/videos/features/posters/${demo}.png',`;
  s = s.slice(0, idx) + insert + s.slice(idx + needle.length);
  console.log('added', demo);
}

writeFileSync(path, s);
console.log('done');
