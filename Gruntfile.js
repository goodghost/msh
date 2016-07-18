module.exports = function(grunt) {
  grunt.initConfig({
    less: {
      all: {
        files: {
          'css/less.css': 'less/less.less'
        },
        options: {
          compress: false,
          sourceMap: false,
        },
      },
    },
    watch: {
      css: {
        files: [
          'less/{,*/}*.less',
        ],
        tasks: ['less'],
        options: {
          livereload: 12345,
          spawn: false,
        },
      },
    },
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');

  grunt.registerTask('default', [
    'watch',
  ]);
};
