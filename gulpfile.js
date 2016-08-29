const gulp = require('gulp');
const gulpLess = require('gulp-less');
const gulpAutoPrefixer = require('gulp-autoprefixer');
const gulpConcat = require('gulp-concat');
const cleanCSS = require('gulp-clean-css');

const rootDir = './web/html/DezPhpTemplate/';
const publicDirectory = './web';
const minCSSLocation = `${publicDirectory}/css`;

gulp.task('styles', () => {
    return gulp.src(`${rootDir}/less/main.less`)
        .pipe(gulpLess())
        .pipe(gulpAutoPrefixer({
            browsers: ['last 10 versions']
        }))
        .pipe(gulp.dest(`${rootDir}\css`))
});

gulp.task('minify-css', function() {
    return gulp.src(`${rootDir}/css/*.css`)
        .pipe(gulpConcat('site.min.css'))
        .pipe(cleanCSS({compatibility: 'ie8', name: 'min'}))
        .pipe(gulp.dest(minCSSLocation));
});

gulp.task('develop', ['styles', 'minify-css'], () => {
    gulp.watch(`${rootDir}/less/*.less`, ['styles']);
    gulp.watch(`${rootDir}/css/*.css`, ['minify-css']);
});