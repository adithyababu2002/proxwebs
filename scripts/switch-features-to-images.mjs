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
  // Replace video+poster block with image
  const re = new RegExp(
    `demo: '${demo}',\\s*video: '[^']+',\\s*poster: '[^']+',`,
    'm',
  );
  const replacement = `demo: '${demo}',\n    image: 'feature-${demo}.jpg',`;
  if (re.test(s)) {
    s = s.replace(re, replacement);
    console.log('updated', demo);
  } else if (s.includes(`demo: '${demo}'`) && !s.includes(`feature-${demo}.jpg`)) {
    s = s.replace(`demo: '${demo}',`, `demo: '${demo}',\n    image: 'feature-${demo}.jpg',`);
    console.log('inserted', demo);
  } else {
    console.log('skip', demo);
  }
}

// Clean leftover video/poster lines if any
s = s.replace(/\n\s*video: '[^']+',/g, '');
s = s.replace(/\n\s*poster: '[^']+',/g, '');

writeFileSync(path, s);
console.log('done');
