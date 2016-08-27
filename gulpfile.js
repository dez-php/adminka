const gulp = require('gulp');
const gulpLess = require('gulp-less');
const gulpAutoPrefixer = require('gulp-autoprefixer');

const rootDir = './web/html/DezPhpTemplate/';

gulp.task('styles', () => {
    return gulp.src(`${rootDir}/less/main.less`)
        .pipe(gulpLess())
        .pipe(gulpAutoPrefixer({
            browsers: ['last 10 versions']
        }))
        .pipe(gulp.dest(`${rootDir}\css`))
});

gulp.task('develop', ['styles'], () => {
    gulp.watch(`${rootDir}/less/*.less`, ['styles']);
});