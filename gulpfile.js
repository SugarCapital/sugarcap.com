var gulp = require('gulp');
var iconfont = require('gulp-iconfont');
var iconfontCSS = require('gulp-iconfont-css');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var notify = require('gulp-notify');

var fontName = 'sugar-icons';

  gulp.task('iconfont', function() {
    gulp.src(['icons/*.svg'])
      .pipe(iconfontCSS({
        fontName: fontName,
        targetPath: '../../sass/_icons.scss',
        fontPath: '/fonts/'
      }))
      .pipe(iconfont({
        fontName: fontName,
        // Remove woff2 if you get an ext error on compile
        formats: ['svg', 'ttf', 'eot', 'woff', 'woff2'],
        normalize: true,
        fontHeight: 1001
      }))
      .pipe(gulp.dest('./public/fonts'))
  });

  gulp.task('scss', function(){
    gulp.src('./scss/*.scss')
      .pipe(sass())
      .pipe(autoprefixer()) // Requires the gulp-autoprefixer plugin
      .pipe(gulp.dest('public/css/'))
      .pipe(notify({ message: 'SCSS task complete' })) // Requires gulp-notify
  });

  gulp.task('icons', ['iconfont', 'scss']);

