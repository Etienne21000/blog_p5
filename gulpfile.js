const gulp = require('gulp');
const sass = require('gulp-sass');
const terser = require('gulp-terser');
const concat = require('gulp-concat');

sass.compiler = require('node-sass');

const files = {

};

gulp.task('sass', function() {
    return gulp.src('Public/scss/main.scss')
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest('Public/css/main.min.css'));
});