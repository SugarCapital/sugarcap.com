const mix = require('laravel-mix');
const fs = require('fs');

const dest = 'public/js/dist.js';
// const paths = JSON.parse(fs.readFileSync('./dev/paths.js'));
// paths = [];
// mix.combine(paths, dest)
//   .sourceMaps(true, 'source-map')
//   .minify(dest)

mix.sass('sass/screen.scss', 'public/stylesheets')
  .setPublicPath('public')
  .version()
  .disableNotifications();
