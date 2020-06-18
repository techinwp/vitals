/* jshint node:true */
module.exports = function( grunt ) {
	'use strict';

	var sass = require( 'node-sass' );

	grunt.initConfig({

		// Autoprefixer.
		postcss: {
			options: {
				processors: [
					require( 'autoprefixer' )()
				]
			},
			dist: {
				src: [
					'style.css'
				]
			}
		},

		// JavaScript linting with JSHint.
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'assets/js/*.js',
				'!assets/js/*.min.js'
			]
		},

		// Sass linting with Stylelint.
		stylelint: {
			options: {
				configFile: '.stylelintrc'
			},
			all: [
				'assets/css/**/*.scss',
				'!assets/css/sass/vendors/**/*.scss'
			]
		},

		// Minify .js files.
		uglify: {
			options: {
				output: {
					comments: 'some'
				}
			},
			main: {
				files: [{
					expand: true,
					cwd: 'assets/js/',
					src: [
						'*.js',
						'!*.min.js'
					],
					dest: 'assets/js/',
					ext: '.min.js'
				}]
			},
			vendor: {
				files: [{
					expand: true,
					cwd: 'assets/js/vendor/',
					src: [
						'*.js',
						'!*.min.js'
					],
					dest: 'assets/js/vendor/',
					ext: '.min.js'
				}]
			},
			admin: {
				files: [{
					expand: true,
					cwd: 'assets/js/admin/',
					src: [
						'*.js',
						'!*.min.js'
					],
					dest: 'assets/js/admin/',
					ext: '.min.js'
				}]
			}
		},

		// Compile all .scss files.
		sass: {
			dist: {
				options: {
					implementation: sass,
					require: 'susy',
					sourceMap: false,
					includePaths: require( 'bourbon' ).includePaths
				},
				files: [{
					'style.css': 'style.scss'
				}]
			}
		},


		// Watch changes for assets.
		watch: {
			css: {
				files: [
					'style.scss',
					'assets/css/base/*.scss',
					'assets/css/sass/utils/*.scss'
					
				],
				tasks: [
					'sass',
					'css'
				]
			},
			js: {
				files: [
					// main js
					'assets/js/**/*.js',
					'!assets/js/**/*.min.js',
					'!assets/js/editor.js'
				],
				tasks: [
					'babel',
					'jshint',
					'uglify'
				]
			}
		},

		// Generate POT files.
		makepot: {
			options: {
				type: 'wp-theme',
				domainPath: 'languages',
				potHeaders: {
					'report-msgid-bugs-to': 'https://github.com/techinwp/vitals/issues',
					'language-team': 'LANGUAGE <EMAIL@ADDRESS>'
				}
			},
			frontend: {
				options: {
					potFilename: 'vitals.pot',
					exclude: [
						'vitals/.*' // Exclude deploy directory
					]
				}
			}
		},

		// Check textdomain errors.
		checktextdomain: {
			options:{
				text_domain: 'vitals',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src:  [
					'**/*.php', // Include all files
					'!node_modules/**' // Exclude node_modules/
				],
				expand: true
			}
		},

		// Creates deploy-able theme
		copy: {
			deploy: {
				src: [
					'**',
					'.htaccess',
					'!.*',
					'!.*/**',
					'!*.md',
					'!*.scss',
					'!.DS_Store',
					'!assets/css/**/*.scss',
					'!assets/css/sass/**',
					'!assets/js/src/**',
					'!composer.json',
					'!composer.lock',
					'!Gruntfile.js',
					'!node_modules/**',
					'!npm-debug.log',
					'!package.json',
					'!package-lock.json',
					'!phpcs.xml',
					'!vitals/**',
					'!vitals.zip',
					'!vendor/**'
				],
				dest: 'vitals',
				expand: true,
				dot: true
			}
		},
		compress: {
			zip: {
				options: {
					archive: './vitals.zip',
					mode: 'zip'
				},
				files: [
					{ src: './vitals/**' }
				]
			}
		}
	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-checktextdomain' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-rtlcss' );
	grunt.loadNpmTasks( 'grunt-postcss' );
	grunt.loadNpmTasks( 'grunt-contrib-compress' );
	grunt.loadNpmTasks( 'grunt-stylelint' );
	grunt.loadNpmTasks( 'grunt-babel' );


	// Register tasks
	grunt.registerTask( 'default', [
		'css',
		'jshint',
		'uglify'
	]);

	grunt.registerTask( 'css', [
		'stylelint',
		'sass',
		'postcss'
	]);

	grunt.registerTask( 'dev', [
		'default',
		'makepot'
	]);

	grunt.registerTask( 'deploy', [
		'dev',
		'copy'
	]);
};