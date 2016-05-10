var elixir = require('laravel-elixir');


// Static resources

var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;



// Test launcher

var gulp = require('gulp');
var exec = require('child_process').exec;
var notify = require("gulp-notify");
var gutil = require('gulp-util');
var phpunitBin = /^win/.test(process.platform) ? 'phpunit ' : './vendor/bin/phpunit ';
var phpunitPath = '';

gulp.task('phpunit', function() {
    console.log('\n$ phpunit '+phpunitPath+'\n');
    exec(phpunitBin+phpunitPath, function(error, stdout) {
        console.log('\n'+stdout);
        if (! error) {
            console.log(gutil.colors.bgGreen('                                                                                                            '));
        } else {
            console.log(gutil.colors.bgRed('                                                                                                            '));
        }
        console.log('\n============================================================================================================\n');
    });
});

gulp.task('tdd', function() {
    var watcher = gulp.watch('tests/**/*.php', { debounceDelay: 1000 }, ['phpunit']);
    watcher.on('change', function(event){
        GLOBAL.phpunitPath = event.path.replace(/\\/g, '/');
    });

    var watcher = gulp.watch('app/**/*.php', { debounceDelay: 1000 }, ['phpunit']);
    watcher.on('change', function(event){
        GLOBAL.phpunitPath = event.path.replace(/\\/g, '/').replace('app', 'tests').replace('.php', 'Test.php');
    });
});
