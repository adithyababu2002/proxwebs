import { readFileSync, writeFileSync } from 'node:fs';

const path = new URL('../resources/js/onix/content/features.js', import.meta.url);
let s = readFileSync(path, 'utf8');
s = s.replace(/features\/([a-z]+)\.mp4(\?v=\d+)?'/g, "features/$1.mp4?v=2'");
s = s.replace(/posters\/([a-z]+)\.png(\?v=\d+)?'/g, "posters/$1.png?v=2'");
writeFileSync(path, s);
console.log('cache bust ok');
