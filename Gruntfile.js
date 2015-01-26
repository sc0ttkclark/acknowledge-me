module.exports = function (grunt) {

	grunt.loadNpmTasks( 'grunt-contrib-compress' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-git' );
	grunt.loadNpmTasks( 'grunt-text-replace' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		clean: {
			main: ['release/<%= pkg.version %>']
		},
		copy: {
			main: {
				src:  [
					'**',
					'!node_modules/**',
					'!release/**',
					'!.git/**',
					'!.sass-cache/**',
					'!Gruntfile.js',
					'!package.json',
					'!.gitignore',
					'!.gitmodules'
				],
				dest: 'release/build/<%= pkg.version %>/'
			}
		},
		compress: {
			main: {
				options: {
					mode: 'zip',
					archive: './release/<%= pkg.name %>-<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'release/build/<%= pkg.version %>/',
				src: [ '**/*' ],
				dest: '<%= pkg.name %>-<%= pkg.version %>/'
			}
		},
		gittag: {
			addtag: {
				options: {
					tag: '<%= pkg.version %>',
					message: 'Version <%= pkg.version %>'
				}
			}
		},
		gitpush: {
			push_tag: {
				options: {
					tags: true
				}
			}
		},
		replace: {
			version: {
				src: [ 'acknowledge-me.php', 'readme.txt', 'README.md' ],
				overwrite: true,
				replacements: [{
					from: "<%= pkg.last_version %>",
					to: "<%= pkg.version %>"
				}]
			}
		}

	});



	grunt.registerTask( 'build', [ 'clean', 'copy', 'compress', 'gittag', 'gitpush' ] );


};
