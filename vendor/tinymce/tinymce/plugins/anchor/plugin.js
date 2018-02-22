(function () {
var anchor = (function () {
  'use strict';

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var isValidId = function (id) {
    return /^[A-Za-z][A-Za-z0-9\-:._]*$/.test(id);
  };
  var getId = function (editor) {
    var selectedNode = editor.selection.getNode();
    var isAnchor = selectedNode.tagName === 'A' && editor.dom.getAttrib(selectedNode, 'href') === '';
    return isAnchor ? selectedNode.id || selectedNode.name : '';
  };
  var insert = function (editor, id) {
    var selectedNode = editor.selection.getNode();
    var isAnchor = selectedNode.tagName === 'A' && editor.dom.getAttrib(selectedNode, 'href') === '';
    if (isAnchor) {
      selectedNode.removeAttribute('name');
      selectedNode.id = id;
    } else {
      editor.focus();
      editor.selection.collapse(true);
      editor.execCommand('mceInsertContent', false, editor.dom.createHTML('a', { id: id }));
    }
  };
<<<<<<< HEAD
  var $_fo6uw87ojd08mc8e = {
=======
  var $_a9cy5h7xjducwqc3 = {
>>>>>>> installer
    isValidId: isValidId,
    getId: getId,
    insert: insert
  };

  var insertAnchor = function (editor, newId) {
<<<<<<< HEAD
    if (!$_fo6uw87ojd08mc8e.isValidId(newId)) {
      editor.windowManager.alert('Id should start with a letter, followed only by letters, numbers, dashes, dots, colons or underscores.');
      return true;
    } else {
      $_fo6uw87ojd08mc8e.insert(editor, newId);
=======
    if (!$_a9cy5h7xjducwqc3.isValidId(newId)) {
      editor.windowManager.alert('Id should start with a letter, followed only by letters, numbers, dashes, dots, colons or underscores.');
      return true;
    } else {
      $_a9cy5h7xjducwqc3.insert(editor, newId);
>>>>>>> installer
      return false;
    }
  };
  var open = function (editor) {
<<<<<<< HEAD
    var currentId = $_fo6uw87ojd08mc8e.getId(editor);
=======
    var currentId = $_a9cy5h7xjducwqc3.getId(editor);
>>>>>>> installer
    editor.windowManager.open({
      title: 'Anchor',
      body: {
        type: 'textbox',
        name: 'id',
        size: 40,
        label: 'Id',
        value: currentId
      },
      onsubmit: function (e) {
        var newId = e.data.id;
        if (insertAnchor(editor, newId)) {
          e.preventDefault();
        }
      }
    });
  };
<<<<<<< HEAD
  var $_gaq9wd7njd08mc8d = { open: open };

  var register = function (editor) {
    editor.addCommand('mceAnchor', function () {
      $_gaq9wd7njd08mc8d.open(editor);
    });
  };
  var $_d9nekh7mjd08mc8b = { register: register };
=======
  var $_9d7mxq7wjducwqc2 = { open: open };

  var register = function (editor) {
    editor.addCommand('mceAnchor', function () {
      $_9d7mxq7wjducwqc2.open(editor);
    });
  };
  var $_co4w9j7vjducwqc0 = { register: register };
>>>>>>> installer

  var isAnchorNode = function (node) {
    return !node.attr('href') && (node.attr('id') || node.attr('name')) && !node.firstChild;
  };
  var setContentEditable = function (state) {
    return function (nodes) {
      for (var i = 0; i < nodes.length; i++) {
        if (isAnchorNode(nodes[i])) {
          nodes[i].attr('contenteditable', state);
        }
      }
    };
  };
  var setup = function (editor) {
    editor.on('PreInit', function () {
      editor.parser.addNodeFilter('a', setContentEditable('false'));
      editor.serializer.addNodeFilter('a', setContentEditable(null));
    });
  };
<<<<<<< HEAD
  var $_81c0wz7pjd08mc8f = { setup: setup };
=======
  var $_7zo4da7yjducwqc5 = { setup: setup };
>>>>>>> installer

  var register$1 = function (editor) {
    editor.addButton('anchor', {
      icon: 'anchor',
      tooltip: 'Anchor',
      cmd: 'mceAnchor',
      stateSelector: 'a:not([href])'
    });
    editor.addMenuItem('anchor', {
      icon: 'anchor',
      text: 'Anchor',
      context: 'insert',
      cmd: 'mceAnchor'
    });
  };
<<<<<<< HEAD
  var $_dwl5477qjd08mc8g = { register: register$1 };

  PluginManager.add('anchor', function (editor) {
    $_81c0wz7pjd08mc8f.setup(editor);
    $_d9nekh7mjd08mc8b.register(editor);
    $_dwl5477qjd08mc8g.register(editor);
=======
  var $_3l1h9h7zjducwqc6 = { register: register$1 };

  PluginManager.add('anchor', function (editor) {
    $_7zo4da7yjducwqc5.setup(editor);
    $_co4w9j7vjducwqc0.register(editor);
    $_3l1h9h7zjducwqc6.register(editor);
>>>>>>> installer
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
