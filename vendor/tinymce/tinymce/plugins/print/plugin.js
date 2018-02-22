(function () {
var print = (function () {
  'use strict';

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var register = function (editor) {
    editor.addCommand('mcePrint', function () {
      editor.getWin().print();
    });
  };
<<<<<<< HEAD
  var $_c5q4xfi2jd08mdlz = { register: register };
=======
  var $_6fsub8icjducwrt1 = { register: register };
>>>>>>> installer

  var register$1 = function (editor) {
    editor.addButton('print', {
      title: 'Print',
      cmd: 'mcePrint'
    });
    editor.addMenuItem('print', {
      text: 'Print',
      cmd: 'mcePrint',
      icon: 'print'
    });
  };
<<<<<<< HEAD
  var $_7j4q11i3jd08mdm0 = { register: register$1 };

  PluginManager.add('print', function (editor) {
    $_c5q4xfi2jd08mdlz.register(editor);
    $_7j4q11i3jd08mdm0.register(editor);
=======
  var $_2tbcilidjducwrt1 = { register: register$1 };

  PluginManager.add('print', function (editor) {
    $_6fsub8icjducwrt1.register(editor);
    $_2tbcilidjducwrt1.register(editor);
>>>>>>> installer
    editor.addShortcut('Meta+P', '', 'mcePrint');
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
