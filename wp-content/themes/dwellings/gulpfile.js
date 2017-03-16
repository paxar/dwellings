/*  Gulp config for Word Press    ver:  0.2 beta   */

var gulp = require('gulp'), // Includes Gulp
    sass = require('gulp-sass'), //Includes Sass package
    concat = require('gulp-concat'), // Includes concat package
    //uglify = require('gulp-uglifyjs'), // Includes js file compression package
    cssnano = require('gulp-cssnano'), // Includes css file compression package
    rename = require('gulp-rename'), // Includes rename package
    del = require('del'), // Includes files delete package
    //imagemin = require('gulp-imagemin'), // Includes images package
    //pngquant = require('imagemin-pngquant'), // Includes png files package
    cache = require('gulp-cache'), // Includes cache package
    autoprefixer = require('gulp-autoprefixer'); // Includes autoprefixer package
    plumber = require('gulp-plumber'); // Includes error package
    sourcemaps = require('gulp-sourcemaps'); // Includes sourcemaps package
    notify = require("gulp-notify"); // Includes notify package

plumberErrorHandler = {
    errorHandler: notify.onError({
        title: 'Gulp',
        message: 'Error: <%= error.message %>'
    })
};

gulp.task('style', function(){
    return gulp.src('sass/style.scss')
        .pipe(plumber(plumberErrorHandler))
        .pipe(sourcemaps.init())
        .pipe(sass().on ('error', sass.logError))
        .pipe(autoprefixer(['last 3 versions'], { cascade: true }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('.'))
        .pipe(notify("Done!"))
});

gulp.task('vendor', function(){
    return gulp.src('sass/vendor.scss')
        .pipe(plumber(plumberErrorHandler))
        .pipe(sourcemaps.init())
        .pipe(sass().on ('error', sass.logError))
        .pipe(autoprefixer(['last 3 versions'], { cascade: true }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('css/'))
        .pipe(notify("Done!"))
});

gulp.task('watch', ['style', 'vendor'/*, 'scripts'*/], function() {
    gulp.watch('sass/**/*.scss', ['style']);
});

gulp.task('clear', function () {
    return cache.clearAll();
});

gulp.task('default', ['watch']);
