(function () {
var nonbreaking = (function () {
  'use strict';

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var stringRepeat = function (string, repeats) {
    var str = '';
    for (var index = 0; index < repeats; index++) {
      str += string;
    }
    return str;
  };
  var isVisualCharsEnabled = function (editor) {
    return editor.plugins.visualchars ? editor.plugins.visualchars.isEnabled() : false;
  };
  var insertNbsp = function (editor, times) {
    var nbsp = isVisualCharsEnabled(editor) ? '<span class="mce-nbsp">&nbsp;</span>' : '&nbsp;';
    editor.insertContent(stringRepeat(nbsp, times));
    editor.dom.setAttrib(editor.dom.select('span.mce-nbsp'), 'data-mce-bogus', '1');
  };
<<<<<<< HEAD
  var $_at3ow4gcjd08mdfn = { insertNbsp: insertNbsp };

  var register = function (editor) {
    editor.addCommand('mceNonBreaking', function () {
      $_at3ow4gcjd08mdfn.insertNbsp(editor, 1);
    });
  };
  var $_8h09jrgbjd08mdfm = { register: register };
=======
  var $_c2p1n1gljducwrn5 = { insertNbsp: insertNbsp };

  var register = function (editor) {
    editor.addCommand('mceNonBreaking', function () {
      $_c2p1n1gljducwrn5.insertNbsp(editor, 1);
    });
  };
  var $_fwzasygkjducwrn4 = { register: register };
>>>>>>> installer

  var VK = tinymce.util.Tools.resolve('tinymce.util.VK');

  var getKeyboardSpaces = function (editor) {
    var spaces = editor.getParam('nonbreaking_force_tab', 0);
    if (typeof spaces === 'boolean') {
      return spaces === true ? 3 : 0;
    } else {
      return spaces;
    }
  };
<<<<<<< HEAD
  var $_210e6pgfjd08mdfr = { getKeyboardSpaces: getKeyboardSpaces };

  var setup = function (editor) {
    var spaces = $_210e6pgfjd08mdfr.getKeyboardSpaces(editor);
=======
  var $_2fx5apgojducwrn7 = { getKeyboardSpaces: getKeyboardSpaces };

  var setup = function (editor) {
    var spaces = $_2fx5apgojducwrn7.getKeyboardSpaces(editor);
>>>>>>> installer
    if (spaces > 0) {
      editor.on('keydown', function (e) {
        if (e.keyCode === VK.TAB && !e.isDefaultPrevented()) {
          if (e.shiftKey) {
            return;
          }
          e.preventDefault();
          e.stopImmediatePropagation();
<<<<<<< HEAD
          $_at3ow4gcjd08mdfn.insertNbsp(editor, spaces);
=======
          $_c2p1n1gljducwrn5.insertNbsp(editor, spaces);
>>>>>>> installer
        }
      });
    }
  };
<<<<<<< HEAD
  var $_832tn5gdjd08mdfp = { setup: setup };
=======
  var $_wgqjwgmjducwrn6 = { setup: setup };
>>>>>>> installer

  var register$1 = function (editor) {
    editor.addButton('nonbreaking', {
      title: 'Nonbreaking space',
      cmd: 'mceNonBreaking'
    });
    editor.addMenuItem('nonbreaking', {
      text: 'Nonbreaking space',
      cmd: 'mceNonBreaking',
      context: 'insert'
    });
  };
<<<<<<< HEAD
  var $_f3oht2ggjd08mdfu = { register: register$1 };

  PluginManager.add('nonbreaking', function (editor) {
    $_8h09jrgbjd08mdfm.register(editor);
    $_f3oht2ggjd08mdfu.register(editor);
    $_832tn5gdjd08mdfp.setup(editor);
=======
  var $_fnzmddgpjducwrn8 = { register: register$1 };

  PluginManager.add('nonbreaking', function (editor) {
    $_fwzasygkjducwrn4.register(editor);
    $_fnzmddgpjducwrn8.register(editor);
    $_wgqjwgmjducwrn6.setup(editor);
>>>>>>> installer
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
