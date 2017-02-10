module.exports = function(grunt) {

  grunt.initConfig({
    version: {
      npm: {
        options: {
          prefix: '"version":\\s*"',
        },
        src: ['package.json']
      },
      enqueues: {
        options: {
          prefix: "false, '\\s*"
        },
        src: ['functions.php']
      },
      ie_enqueue: {
        options: {
          prefix: "array( 'uwmadison-style' ), '\\s*"
        },
        src: ['functions.php']
      },
      style: {
        options: {
          prefix: 'Version:\\s*'
        },
        src: ['style.css']
      },
    },
  });

  grunt.loadNpmTasks('grunt-version');

  grunt.registerTask('default', ['version']);
};