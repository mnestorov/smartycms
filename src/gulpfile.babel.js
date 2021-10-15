import gulp from 'gulp';
import yargs from 'yargs';
import gulpless from 'gulp-less';
import cleancss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import sourcemaps from 'gulp-sourcemaps';
import imagemin from 'gulp-imagemin';
import del from 'del';
import webpack from 'webpack-stream';
import uglify from 'gulp-uglify';
import named from 'vinyl-named';
import merge from 'merge-stream';

const PRODUCTION = yargs.argv.prod;

const paths = {
    styles: {
        src: [
            'resources/assets/src/less/admin.less',
            'resources/assets/src/less/login.less',
        ],
        dest: 'resources/assets/dist/css'
    },
    images: {
        src: 'resources/assets/src/images/**/*.{jpg,jpeg,png,svg,gif}',
        dest: 'resources/assets/dist/images'
    },
    scripts: {
        src: [
            'resources/assets/src/js/admin.js',
        ],
        dest: 'resources/assets/dist/js'
    },
    other: {
        src: [
            'resources/assets/src/**/*',
            '!resources/assets/src/{images,js,less}',
            '!resources/assets/src/{images,js,less}/**/*'
        ],
        dest: 'resources/assets/dist'
    },
}

// Default task
exports.default = (done) => {
    console.log('gulp works!')
    done();
}

export const styles = () => {
    return gulp.src(paths.styles.src)
            .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
            .pipe(gulpless())
            .pipe(gulpif(PRODUCTION, cleancss({'compatability': 'ie8'})))
            .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
            .pipe(gulp.dest(paths.styles.dest));
}

export const images = () => {
    return gulp.src(paths.images.src)
            .pipe(gulpif(PRODUCTION, imagemin()))
            .pipe(gulp.dest(paths.images.dest));
}

export const scripts = () => {
    return gulp.src(paths.scripts.src)
            .pipe(named())
            .pipe(webpack({
                module: {
                    rules: [{
                            test: /\.js$/,
                            use: {
                                loader: 'babel-loader',
                                options: {
                                    presets: ['@babel/preset-env']
                                }
                            }
                        }]
                },
                output: {
                    filename: '[name].js'
                },
                devtool: !PRODUCTION ? 'inline-source-map' : false,
                mode: PRODUCTION ? 'production' : 'development' // add this
            }))
            .pipe(gulpif(PRODUCTION, uglify())) // you can skip this now since mode will already minify
            .pipe(gulp.dest(paths.scripts.dest));
}

// Copy third party libraries from /node_modules into /dist/vendors
export const vendors = () => {
    return merge([
        'tinymce/{plugins,skins,themes}',
        'font-awesome/{css,fonts}'
    ].map(function (vendor) {
        return gulp.src('node_modules/' + vendor + '/**/*')
                .pipe(gulp.dest('resources/assets/dist/vendors/' + vendor.replace(/\/.*/, '')));
    }));
}

export const copy = () => {
    return gulp.src(paths.other.src)
            .pipe(gulp.dest(paths.other.dest));
}

export const clean = (done) => {
    del('dist').then(paths => {
        console.log('Deleted files and folders:\n', paths.join('\n'));
    });
    done();
}

export const watch = () => {
    gulp.watch('resources/assets/src/less/**/*.less', styles);
    gulp.watch('resources/assets/src/js/**/*.js', scripts);
    gulp.watch(paths.images.src, images);
    gulp.watch(paths.other.src, copy);
}

export const dev = gulp.series(gulp.parallel(styles, images, scripts, vendors, copy), watch);
export const prod = gulp.series(clean, gulp.parallel(styles, images, scripts, vendors, copy));