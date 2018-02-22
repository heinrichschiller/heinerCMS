(function () {
var autosave = (function () {
  'use strict';

  var Cell = function (initial) {
    var value = initial;
    var get = function () {
      return value;
    };
    var set = function (v) {
      value = v;
    };
    var clone = function () {
      return Cell(get());
    };
    return {
      get: get,
      set: set,
      clone: clone
    };
  };

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var LocalStorage = tinymce.util.Tools.resolve('tinymce.util.LocalStorage');

  var Tools = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var fireRestoreDraft = function (editor) {
    return editor.fire('RestoreDraft');
  };
  var fireStoreDraft = function (editor) {
    return editor.fire('StoreDraft');
  };
  var fireRemoveDraft = function (editor) {
    return editor.fire('RemoveDraft');
  };
<<<<<<< HEAD
  var $_flb3g8bjd08mcae = {
=======
  var $_excicq8kjducwqe6 = {
>>>>>>> installer
    fireRestoreDraft: fireRestoreDraft,
    fireStoreDraft: fireStoreDraft,
    fireRemoveDraft: fireRemoveDraft
  };

  var parse = function (time, defaultTime) {
    var multiples = {
      s: 1000,
      m: 60000
    };
    time = /^(\d+)([ms]?)$/.exec('' + (time || defaultTime));
    return (time[2] ? multiples[time[2]] : 1) * parseInt(time, 10);
  };
<<<<<<< HEAD
  var $_4k6usi8djd08mcaj = { parse: parse };
=======
  var $_3ttaky8mjducwqea = { parse: parse };
>>>>>>> installer

  var shouldAskBeforeUnload = function (editor) {
    return editor.getParam('autosave_ask_before_unload', true);
  };
  var getAutoSavePrefix = function (editor) {
    var prefix = editor.getParam('autosave_prefix', 'tinymce-autosave-{path}{query}{hash}-{id}-');
    prefix = prefix.replace(/\{path\}/g, document.location.pathname);
    prefix = prefix.replace(/\{query\}/g, document.location.search);
    prefix = prefix.replace(/\{hash\}/g, document.location.hash);
    prefix = prefix.replace(/\{id\}/g, editor.id);
    return prefix;
  };
  var shouldRestoreWhenEmpty = function (editor) {
    return editor.getParam('autosave_restore_when_empty', false);
  };
  var getAutoSaveInterval = function (editor) {
<<<<<<< HEAD
    return $_4k6usi8djd08mcaj.parse(editor.settings.autosave_interval, '30s');
  };
  var getAutoSaveRetention = function (editor) {
    return $_4k6usi8djd08mcaj.parse(editor.settings.autosave_retention, '20m');
  };
  var $_gc7s768cjd08mcag = {
=======
    return $_3ttaky8mjducwqea.parse(editor.settings.autosave_interval, '30s');
  };
  var getAutoSaveRetention = function (editor) {
    return $_3ttaky8mjducwqea.parse(editor.settings.autosave_retention, '20m');
  };
  var $_enqw888ljducwqe8 = {
>>>>>>> installer
    shouldAskBeforeUnload: shouldAskBeforeUnload,
    getAutoSavePrefix: getAutoSavePrefix,
    shouldRestoreWhenEmpty: shouldRestoreWhenEmpty,
    getAutoSaveInterval: getAutoSaveInterval,
    getAutoSaveRetention: getAutoSaveRetention
  };

  var isEmpty = function (editor, html) {
    var forcedRootBlockName = editor.settings.forced_root_block;
    html = Tools.trim(typeof html === 'undefined' ? editor.getBody().innerHTML : html);
    return html === '' || new RegExp('^<' + forcedRootBlockName + '[^>]*>((\xA0|&nbsp;|[ \t]|<br[^>]*>)+?|)</' + forcedRootBlockName + '>|<br>$', 'i').test(html);
  };
  var hasDraft = function (editor) {
<<<<<<< HEAD
    var time = parseInt(LocalStorage.getItem($_gc7s768cjd08mcag.getAutoSavePrefix(editor) + 'time'), 10) || 0;
    if (new Date().getTime() - time > $_gc7s768cjd08mcag.getAutoSaveRetention(editor)) {
=======
    var time = parseInt(LocalStorage.getItem($_enqw888ljducwqe8.getAutoSavePrefix(editor) + 'time'), 10) || 0;
    if (new Date().getTime() - time > $_enqw888ljducwqe8.getAutoSaveRetention(editor)) {
>>>>>>> installer
      removeDraft(editor, false);
      return false;
    }
    return true;
  };
  var removeDraft = function (editor, fire) {
<<<<<<< HEAD
    var prefix = $_gc7s768cjd08mcag.getAutoSavePrefix(editor);
    LocalStorage.removeItem(prefix + 'draft');
    LocalStorage.removeItem(prefix + 'time');
    if (fire !== false) {
      $_flb3g8bjd08mcae.fireRemoveDraft(editor);
    }
  };
  var storeDraft = function (editor) {
    var prefix = $_gc7s768cjd08mcag.getAutoSavePrefix(editor);
=======
    var prefix = $_enqw888ljducwqe8.getAutoSavePrefix(editor);
    LocalStorage.removeItem(prefix + 'draft');
    LocalStorage.removeItem(prefix + 'time');
    if (fire !== false) {
      $_excicq8kjducwqe6.fireRemoveDraft(editor);
    }
  };
  var storeDraft = function (editor) {
    var prefix = $_enqw888ljducwqe8.getAutoSavePrefix(editor);
>>>>>>> installer
    if (!isEmpty(editor) && editor.isDirty()) {
      LocalStorage.setItem(prefix + 'draft', editor.getContent({
        format: 'raw',
        no_events: true
      }));
      LocalStorage.setItem(prefix + 'time', new Date().getTime().toString());
<<<<<<< HEAD
      $_flb3g8bjd08mcae.fireStoreDraft(editor);
    }
  };
  var restoreDraft = function (editor) {
    var prefix = $_gc7s768cjd08mcag.getAutoSavePrefix(editor);
    if (hasDraft(editor)) {
      editor.setContent(LocalStorage.getItem(prefix + 'draft'), { format: 'raw' });
      $_flb3g8bjd08mcae.fireRestoreDraft(editor);
    }
  };
  var startStoreDraft = function (editor, started) {
    var interval = $_gc7s768cjd08mcag.getAutoSaveInterval(editor);
=======
      $_excicq8kjducwqe6.fireStoreDraft(editor);
    }
  };
  var restoreDraft = function (editor) {
    var prefix = $_enqw888ljducwqe8.getAutoSavePrefix(editor);
    if (hasDraft(editor)) {
      editor.setContent(LocalStorage.getItem(prefix + 'draft'), { format: 'raw' });
      $_excicq8kjducwqe6.fireRestoreDraft(editor);
    }
  };
  var startStoreDraft = function (editor, started) {
    var interval = $_enqw888ljducwqe8.getAutoSaveInterval(editor);
>>>>>>> installer
    if (!started.get()) {
      setInterval(function () {
        if (!editor.removed) {
          storeDraft(editor);
        }
      }, interval);
      started.set(true);
    }
  };
  var restoreLastDraft = function (editor) {
    editor.undoManager.transact(function () {
      restoreDraft(editor);
      removeDraft(editor);
    });
    editor.focus();
  };
<<<<<<< HEAD
  var $_ew42ue88jd08mcab = {
=======
  var $_7fd7g88hjducwqe4 = {
>>>>>>> installer
    isEmpty: isEmpty,
    hasDraft: hasDraft,
    removeDraft: removeDraft,
    storeDraft: storeDraft,
    restoreDraft: restoreDraft,
    startStoreDraft: startStoreDraft,
    restoreLastDraft: restoreLastDraft
  };

  var curry = function (f, editor) {
    return function () {
      var args = Array.prototype.slice.call(arguments);
      return f.apply(null, [editor].concat(args));
    };
  };
  var get = function (editor) {
    return {
<<<<<<< HEAD
      hasDraft: curry($_ew42ue88jd08mcab.hasDraft, editor),
      storeDraft: curry($_ew42ue88jd08mcab.storeDraft, editor),
      restoreDraft: curry($_ew42ue88jd08mcab.restoreDraft, editor),
      removeDraft: curry($_ew42ue88jd08mcab.removeDraft, editor),
      isEmpty: curry($_ew42ue88jd08mcab.isEmpty, editor)
    };
  };
  var $_ckkpar87jd08mca9 = { get: get };
=======
      hasDraft: curry($_7fd7g88hjducwqe4.hasDraft, editor),
      storeDraft: curry($_7fd7g88hjducwqe4.storeDraft, editor),
      restoreDraft: curry($_7fd7g88hjducwqe4.restoreDraft, editor),
      removeDraft: curry($_7fd7g88hjducwqe4.removeDraft, editor),
      isEmpty: curry($_7fd7g88hjducwqe4.isEmpty, editor)
    };
  };
  var $_d0yse78gjducwqe2 = { get: get };
>>>>>>> installer

  var EditorManager = tinymce.util.Tools.resolve('tinymce.EditorManager');

  EditorManager._beforeUnloadHandler = function () {
    var msg;
    Tools.each(EditorManager.get(), function (editor) {
      if (editor.plugins.autosave) {
        editor.plugins.autosave.storeDraft();
      }
<<<<<<< HEAD
      if (!msg && editor.isDirty() && $_gc7s768cjd08mcag.shouldAskBeforeUnload(editor)) {
=======
      if (!msg && editor.isDirty() && $_enqw888ljducwqe8.shouldAskBeforeUnload(editor)) {
>>>>>>> installer
        msg = editor.translate('You have unsaved changes are you sure you want to navigate away?');
      }
    });
    return msg;
  };
  var setup = function (editor) {
    window.onbeforeunload = EditorManager._beforeUnloadHandler;
  };
<<<<<<< HEAD
  var $_c56bdd8ejd08mcam = { setup: setup };
=======
  var $_584cm28njducwqec = { setup: setup };
>>>>>>> installer

  var postRender = function (editor, started) {
    return function (e) {
      var ctrl = e.control;
<<<<<<< HEAD
      ctrl.disabled(!$_ew42ue88jd08mcab.hasDraft(editor));
      editor.on('StoreDraft RestoreDraft RemoveDraft', function () {
        ctrl.disabled(!$_ew42ue88jd08mcab.hasDraft(editor));
      });
      $_ew42ue88jd08mcab.startStoreDraft(editor, started);
=======
      ctrl.disabled(!$_7fd7g88hjducwqe4.hasDraft(editor));
      editor.on('StoreDraft RestoreDraft RemoveDraft', function () {
        ctrl.disabled(!$_7fd7g88hjducwqe4.hasDraft(editor));
      });
      $_7fd7g88hjducwqe4.startStoreDraft(editor, started);
>>>>>>> installer
    };
  };
  var register = function (editor, started) {
    editor.addButton('restoredraft', {
      title: 'Restore last draft',
      onclick: function () {
<<<<<<< HEAD
        $_ew42ue88jd08mcab.restoreLastDraft(editor);
=======
        $_7fd7g88hjducwqe4.restoreLastDraft(editor);
>>>>>>> installer
      },
      onPostRender: postRender(editor, started)
    });
    editor.addMenuItem('restoredraft', {
      text: 'Restore last draft',
      onclick: function () {
<<<<<<< HEAD
        $_ew42ue88jd08mcab.restoreLastDraft(editor);
=======
        $_7fd7g88hjducwqe4.restoreLastDraft(editor);
>>>>>>> installer
      },
      onPostRender: postRender(editor, started),
      context: 'file'
    });
  };
<<<<<<< HEAD
  var $_awle4u8gjd08mcaq = { register: register };

  PluginManager.add('autosave', function (editor) {
    var started = Cell(false);
    $_c56bdd8ejd08mcam.setup(editor);
    $_awle4u8gjd08mcaq.register(editor, started);
    return $_ckkpar87jd08mca9.get(editor);
=======
  var $_9iugml8pjducwqee = { register: register };

  PluginManager.add('autosave', function (editor) {
    var started = Cell(false);
    $_584cm28njducwqec.setup(editor);
    $_9iugml8pjducwqee.register(editor, started);
    return $_d0yse78gjducwqe2.get(editor);
>>>>>>> installer
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
