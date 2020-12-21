const gulp = require('gulp');
const sass = require('gulp-sass');
const terser = require('gulp-terser');
const concat = require('gulp-concat');
const rename = require('gulp-rename');
const runSequence = require('gulp4-run-sequence');
const watch = require('gulp-watch');
const clean = require('gulp-clean');


sass.compiler = require('node-sass');

const files = {

};

gulp.task('sass', function() {
    return gulp.src('Public/scss/main.scss')
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(rename('main.min.css'))
        .pipe(gulp.dest('Public/main-css'));
});

gulp.task('clean-css', function () {
    return gulp.src('Public/main-css', {read: false})
        .pipe(clean());
});

gulp.task('build', async function(callback) {
    runSequence(
        ['clean-css'],
        ['sass'],
        callback);
});

gulp.task('watch', async function() {
    // Endless stream mode
    gulp.watch([
            './sass/**/*.scss',
            'gulpfile.js'
        ],
        gulp.series('build'));
});