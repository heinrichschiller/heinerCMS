(function () {
var pagebreak = (function () {
  'use strict';

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var Env = tinymce.util.Tools.resolve('tinymce.Env');

  var getSeparatorHtml = function (editor) {
    return editor.getParam('pagebreak_separator', '<!-- pagebreak -->');
  };
  var shouldSplitBlock = function (editor) {
    return editor.getParam('pagebreak_split_block', false);
  };
<<<<<<< HEAD
  var $_de92f6grjd08mdgt = {
=======
  var $_83mli5h0jducwro1 = {
>>>>>>> installer
    getSeparatorHtml: getSeparatorHtml,
    shouldSplitBlock: shouldSplitBlock
  };

  var getPageBreakClass = function () {
    return 'mce-pagebreak';
  };
  var getPlaceholderHtml = function () {
    return '<img src="' + Env.transparentSrc + '" class="' + getPageBreakClass() + '" data-mce-resize="false" data-mce-placeholder />';
  };
  var setup = function (editor) {
<<<<<<< HEAD
    var separatorHtml = $_de92f6grjd08mdgt.getSeparatorHtml(editor);
=======
    var separatorHtml = $_83mli5h0jducwro1.getSeparatorHtml(editor);
>>>>>>> installer
    var pageBreakSeparatorRegExp = new RegExp(separatorHtml.replace(/[\?\.\*\[\]\(\)\{\}\+\^\$\:]/g, function (a) {
      return '\\' + a;
    }), 'gi');
    editor.on('BeforeSetContent', function (e) {
      e.content = e.content.replace(pageBreakSeparatorRegExp, getPlaceholderHtml());
    });
    editor.on('PreInit', function () {
      editor.serializer.addNodeFilter('img', function (nodes) {
        var i = nodes.length, node, className;
        while (i--) {
          node = nodes[i];
          className = node.attr('class');
          if (className && className.indexOf('mce-pagebreak') !== -1) {
            var parentNode = node.parent;
<<<<<<< HEAD
            if (editor.schema.getBlockElements()[parentNode.name] && $_de92f6grjd08mdgt.shouldSplitBlock(editor)) {
=======
            if (editor.schema.getBlockElements()[parentNode.name] && $_83mli5h0jducwro1.shouldSplitBlock(editor)) {
>>>>>>> installer
              parentNode.type = 3;
              parentNode.value = separatorHtml;
              parentNode.raw = true;
              node.remove();
              continue;
            }
            node.type = 3;
            node.value = separatorHtml;
            node.raw = true;
          }
        }
      });
    });
  };
<<<<<<< HEAD
  var $_7lc0hngpjd08mdgq = {
=======
  var $_33tb1ogyjducwrnz = {
>>>>>>> installer
    setup: setup,
    getPlaceholderHtml: getPlaceholderHtml,
    getPageBreakClass: getPageBreakClass
  };

  var register = function (editor) {
    editor.addCommand('mcePageBreak', function () {
      if (editor.settings.pagebreak_split_block) {
<<<<<<< HEAD
        editor.insertContent('<p>' + $_7lc0hngpjd08mdgq.getPlaceholderHtml() + '</p>');
      } else {
        editor.insertContent($_7lc0hngpjd08mdgq.getPlaceholderHtml());
      }
    });
  };
  var $_6g8ectgojd08mdgo = { register: register };

  var setup$1 = function (editor) {
    editor.on('ResolveName', function (e) {
      if (e.target.nodeName === 'IMG' && editor.dom.hasClass(e.target, $_7lc0hngpjd08mdgq.getPageBreakClass())) {
=======
        editor.insertContent('<p>' + $_33tb1ogyjducwrnz.getPlaceholderHtml() + '</p>');
      } else {
        editor.insertContent($_33tb1ogyjducwrnz.getPlaceholderHtml());
      }
    });
  };
  var $_cry6wrgxjducwrnw = { register: register };

  var setup$1 = function (editor) {
    editor.on('ResolveName', function (e) {
      if (e.target.nodeName === 'IMG' && editor.dom.hasClass(e.target, $_33tb1ogyjducwrnz.getPageBreakClass())) {
>>>>>>> installer
        e.name = 'pagebreak';
      }
    });
  };
<<<<<<< HEAD
  var $_5yvjqdgsjd08mdgu = { setup: setup$1 };
=======
  var $_3bcr1kh1jducwro3 = { setup: setup$1 };
>>>>>>> installer

  var register$1 = function (editor) {
    editor.addButton('pagebreak', {
      title: 'Page break',
      cmd: 'mcePageBreak'
    });
    editor.addMenuItem('pagebreak', {
      text: 'Page break',
      icon: 'pagebreak',
      cmd: 'mcePageBreak',
      context: 'insert'
    });
  };
<<<<<<< HEAD
  var $_28dbeugtjd08mdgv = { register: register$1 };

  PluginManager.add('pagebreak', function (editor) {
    $_6g8ectgojd08mdgo.register(editor);
    $_28dbeugtjd08mdgv.register(editor);
    $_7lc0hngpjd08mdgq.setup(editor);
    $_5yvjqdgsjd08mdgu.setup(editor);
=======
  var $_bewve4h2jducwro4 = { register: register$1 };

  PluginManager.add('pagebreak', function (editor) {
    $_cry6wrgxjducwrnw.register(editor);
    $_bewve4h2jducwro4.register(editor);
    $_33tb1ogyjducwrnz.setup(editor);
    $_3bcr1kh1jducwro3.setup(editor);
>>>>>>> installer
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
