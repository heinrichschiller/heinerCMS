(function () {
var save = (function () {
  'use strict';

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var DOMUtils = tinymce.util.Tools.resolve('tinymce.dom.DOMUtils');

  var Tools = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var enableWhenDirty = function (editor) {
    return editor.getParam('save_enablewhendirty', true);
  };
  var hasOnSaveCallback = function (editor) {
    return !!editor.getParam('save_onsavecallback');
  };
  var hasOnCancelCallback = function (editor) {
    return !!editor.getParam('save_oncancelcallback');
  };
<<<<<<< HEAD
  var $_dowwoaiajd08mdmd = {
=======
  var $_awhi0xikjducwrtb = {
>>>>>>> installer
    enableWhenDirty: enableWhenDirty,
    hasOnSaveCallback: hasOnSaveCallback,
    hasOnCancelCallback: hasOnCancelCallback
  };

  var displayErrorMessage = function (editor, message) {
    editor.notificationManager.open({
      text: editor.translate(message),
      type: 'error'
    });
  };
  var save = function (editor) {
    var formObj;
    formObj = DOMUtils.DOM.getParent(editor.id, 'form');
<<<<<<< HEAD
    if ($_dowwoaiajd08mdmd.enableWhenDirty(editor) && !editor.isDirty()) {
      return;
    }
    editor.save();
    if ($_dowwoaiajd08mdmd.hasOnSaveCallback(editor)) {
=======
    if ($_awhi0xikjducwrtb.enableWhenDirty(editor) && !editor.isDirty()) {
      return;
    }
    editor.save();
    if ($_awhi0xikjducwrtb.hasOnSaveCallback(editor)) {
>>>>>>> installer
      editor.execCallback('save_onsavecallback', editor);
      editor.nodeChanged();
      return;
    }
    if (formObj) {
      editor.setDirty(false);
      if (!formObj.onsubmit || formObj.onsubmit()) {
        if (typeof formObj.submit === 'function') {
          formObj.submit();
        } else {
          displayErrorMessage(editor, 'Error: Form submit field collision.');
        }
      }
      editor.nodeChanged();
    } else {
      displayErrorMessage(editor, 'Error: No form element found.');
    }
  };
  var cancel = function (editor) {
    var h = Tools.trim(editor.startContent);
<<<<<<< HEAD
    if ($_dowwoaiajd08mdmd.hasOnCancelCallback(editor)) {
=======
    if ($_awhi0xikjducwrtb.hasOnCancelCallback(editor)) {
>>>>>>> installer
      editor.execCallback('save_oncancelcallback', editor);
      return;
    }
    editor.setContent(h);
    editor.undoManager.clear();
    editor.nodeChanged();
  };
<<<<<<< HEAD
  var $_daeufni7jd08mdm9 = {
=======
  var $_5upiaaihjducwrt9 = {
>>>>>>> installer
    save: save,
    cancel: cancel
  };

  var register = function (editor) {
    editor.addCommand('mceSave', function () {
<<<<<<< HEAD
      $_daeufni7jd08mdm9.save(editor);
    });
    editor.addCommand('mceCancel', function () {
      $_daeufni7jd08mdm9.cancel(editor);
    });
  };
  var $_1hrzn7i6jd08mdm8 = { register: register };
=======
      $_5upiaaihjducwrt9.save(editor);
    });
    editor.addCommand('mceCancel', function () {
      $_5upiaaihjducwrt9.cancel(editor);
    });
  };
  var $_dmkmfnigjducwrt8 = { register: register };
>>>>>>> installer

  var stateToggle = function (editor) {
    return function (e) {
      var ctrl = e.control;
      editor.on('nodeChange dirty', function () {
<<<<<<< HEAD
        ctrl.disabled($_dowwoaiajd08mdmd.enableWhenDirty(editor) && !editor.isDirty());
=======
        ctrl.disabled($_awhi0xikjducwrtb.enableWhenDirty(editor) && !editor.isDirty());
>>>>>>> installer
      });
    };
  };
  var register$1 = function (editor) {
    editor.addButton('save', {
      icon: 'save',
      text: 'Save',
      cmd: 'mceSave',
      disabled: true,
      onPostRender: stateToggle(editor)
    });
    editor.addButton('cancel', {
      text: 'Cancel',
      icon: false,
      cmd: 'mceCancel',
      disabled: true,
      onPostRender: stateToggle(editor)
    });
    editor.addShortcut('Meta+S', '', 'mceSave');
  };
<<<<<<< HEAD
  var $_bypxc5ibjd08mdme = { register: register$1 };

  PluginManager.add('save', function (editor) {
    $_bypxc5ibjd08mdme.register(editor);
    $_1hrzn7i6jd08mdm8.register(editor);
=======
  var $_drag6siljducwrtd = { register: register$1 };

  PluginManager.add('save', function (editor) {
    $_drag6siljducwrtd.register(editor);
    $_dmkmfnigjducwrt8.register(editor);
>>>>>>> installer
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
