(function () {
var hr = (function () {
  'use strict';

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var register = function (editor) {
    editor.addCommand('InsertHorizontalRule', function () {
      editor.execCommand('mceInsertContent', false, '<hr />');
    });
  };
<<<<<<< HEAD
  var $_9hkkonbjjd08mcne = { register: register };
=======
  var $_5g275dbsjducwqy9 = { register: register };
>>>>>>> installer

  var register$1 = function (editor) {
    editor.addButton('hr', {
      icon: 'hr',
      tooltip: 'Horizontal line',
      cmd: 'InsertHorizontalRule'
    });
    editor.addMenuItem('hr', {
      icon: 'hr',
      text: 'Horizontal line',
      cmd: 'InsertHorizontalRule',
      context: 'insert'
    });
  };
<<<<<<< HEAD
  var $_5y9k72bkjd08mcnf = { register: register$1 };

  PluginManager.add('hr', function (editor) {
    $_9hkkonbjjd08mcne.register(editor);
    $_5y9k72bkjd08mcnf.register(editor);
=======
  var $_3ns4m2btjducwqya = { register: register$1 };

  PluginManager.add('hr', function (editor) {
    $_5g275dbsjducwqy9.register(editor);
    $_3ns4m2btjducwqya.register(editor);
>>>>>>> installer
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
