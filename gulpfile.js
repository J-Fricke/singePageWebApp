var browserify = require('browserify');
var gulp = require('gulp');
var uglify = require('gulp-uglify');
var streamify = require('gulp-streamify');
var source = require('vinyl-source-stream');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var cleancss = require('gulp-clean-css');

gulp.task('build-js', function() {
    return browserify('./app/Javascript/app.js')
        .bundle()
        //Pass desired output filename to vinyl-source-stream
        .pipe(source('bundle.js'))
        .pipe(streamify(uglify(false)))
        // Start piping stream to tasks!
        .pipe(gulp.dest('./public/js'));
});

gulp.task('build-css', function() {
    return gulp.src(['./node_modules/bootstrap/dist/css/*.min.css', './node_modules/datatables.net-dt/css/*.css', './app/Styles/main.css'])
        .pipe(concat('main.css'))
        .pipe(cleancss())
        .pipe(gulp.dest('./public/css'));
});

gulp.task('build-images', function() {
   return gulp.src(['./node_modules/datatables.net-dt/images/*.*'])
       .pipe(gulp.dest('./public/images'));
});

gulp.task('build-fonts', function() {
   return gulp.src(['./node_modules/bootstrap/dist/fonts/*.*'])
       .pipe(gulp.dest('./public/fonts'))
});

gulp.task('build', ['build-js', 'build-css', 'build-images', 'build-fonts']);