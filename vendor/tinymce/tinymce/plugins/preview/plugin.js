(function () {
var preview = (function () {
  'use strict';

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var Env = tinymce.util.Tools.resolve('tinymce.Env');

  var getPreviewDialogWidth = function (editor) {
    return parseInt(editor.getParam('plugin_preview_width', '650'), 10);
  };
  var getPreviewDialogHeight = function (editor) {
    return parseInt(editor.getParam('plugin_preview_height', '500'), 10);
  };
  var getContentStyle = function (editor) {
    return editor.getParam('content_style', '');
  };
<<<<<<< HEAD
  var $_cm5d0ehwjd08mdlh = {
=======
  var $_21k1eii6jducwrsm = {
>>>>>>> installer
    getPreviewDialogWidth: getPreviewDialogWidth,
    getPreviewDialogHeight: getPreviewDialogHeight,
    getContentStyle: getContentStyle
  };

  var Tools = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var getPreviewHtml = function (editor) {
    var previewHtml;
    var headHtml = '';
    var encode = editor.dom.encode;
<<<<<<< HEAD
    var contentStyle = $_cm5d0ehwjd08mdlh.getContentStyle(editor);
=======
    var contentStyle = $_21k1eii6jducwrsm.getContentStyle(editor);
>>>>>>> installer
    headHtml += '<base href="' + encode(editor.documentBaseURI.getURI()) + '">';
    if (contentStyle) {
      headHtml += '<style type="text/css">' + contentStyle + '</style>';
    }
    Tools.each(editor.contentCSS, function (url) {
      headHtml += '<link type="text/css" rel="stylesheet" href="' + encode(editor.documentBaseURI.toAbsolute(url)) + '">';
    });
    var bodyId = editor.settings.body_id || 'tinymce';
    if (bodyId.indexOf('=') !== -1) {
      bodyId = editor.getParam('body_id', '', 'hash');
      bodyId = bodyId[editor.id] || bodyId;
    }
    var bodyClass = editor.settings.body_class || '';
    if (bodyClass.indexOf('=') !== -1) {
      bodyClass = editor.getParam('body_class', '', 'hash');
      bodyClass = bodyClass[editor.id] || '';
    }
    var preventClicksOnLinksScript = '<script>' + 'document.addEventListener && document.addEventListener("click", function(e) {' + 'for (var elm = e.target; elm; elm = elm.parentNode) {' + 'if (elm.nodeName === "A") {' + 'e.preventDefault();' + '}' + '}' + '}, false);' + '</script> ';
    var dirAttr = editor.settings.directionality ? ' dir="' + editor.settings.directionality + '"' : '';
    previewHtml = '<!DOCTYPE html>' + '<html>' + '<head>' + headHtml + '</head>' + '<body id="' + encode(bodyId) + '" class="mce-content-body ' + encode(bodyClass) + '"' + encode(dirAttr) + '>' + editor.getContent() + preventClicksOnLinksScript + '</body>' + '</html>';
    return previewHtml;
  };
  var injectIframeContent = function (editor, iframe, sandbox) {
    var previewHtml = getPreviewHtml(editor);
    if (!sandbox) {
      var doc = iframe.contentWindow.document;
      doc.open();
      doc.write(previewHtml);
      doc.close();
    } else {
      iframe.src = 'data:text/html;charset=utf-8,' + encodeURIComponent(previewHtml);
    }
  };
<<<<<<< HEAD
  var $_7wp00mhxjd08mdli = {
=======
  var $_f39h6xi7jducwrsn = {
>>>>>>> installer
    getPreviewHtml: getPreviewHtml,
    injectIframeContent: injectIframeContent
  };

  var open = function (editor) {
    var sandbox = !Env.ie;
    var dialogHtml = '<iframe src="javascript:\'\'" frameborder="0"' + (sandbox ? ' sandbox="allow-scripts"' : '') + '></iframe>';
<<<<<<< HEAD
    var dialogWidth = $_cm5d0ehwjd08mdlh.getPreviewDialogWidth(editor);
    var dialogHeight = $_cm5d0ehwjd08mdlh.getPreviewDialogHeight(editor);
=======
    var dialogWidth = $_21k1eii6jducwrsm.getPreviewDialogWidth(editor);
    var dialogHeight = $_21k1eii6jducwrsm.getPreviewDialogHeight(editor);
>>>>>>> installer
    editor.windowManager.open({
      title: 'Preview',
      width: dialogWidth,
      height: dialogHeight,
      html: dialogHtml,
      buttons: {
        text: 'Close',
        onclick: function (e) {
          e.control.parent().parent().close();
        }
      },
      onPostRender: function (e) {
        var iframeElm = e.control.getEl('body').firstChild;
<<<<<<< HEAD
        $_7wp00mhxjd08mdli.injectIframeContent(editor, iframeElm, sandbox);
      }
    });
  };
  var $_6sp20hujd08mdlf = { open: open };

  var register = function (editor) {
    editor.addCommand('mcePreview', function () {
      $_6sp20hujd08mdlf.open(editor);
    });
  };
  var $_5ed84fhtjd08mdle = { register: register };
=======
        $_f39h6xi7jducwrsn.injectIframeContent(editor, iframeElm, sandbox);
      }
    });
  };
  var $_1gdk1pi4jducwrsk = { open: open };

  var register = function (editor) {
    editor.addCommand('mcePreview', function () {
      $_1gdk1pi4jducwrsk.open(editor);
    });
  };
  var $_e98z67i3jducwrsj = { register: register };
>>>>>>> installer

  var register$1 = function (editor) {
    editor.addButton('preview', {
      title: 'Preview',
      cmd: 'mcePreview'
    });
    editor.addMenuItem('preview', {
      text: 'Preview',
      cmd: 'mcePreview',
      context: 'view'
    });
  };
<<<<<<< HEAD
  var $_4l8owhzjd08mdln = { register: register$1 };

  PluginManager.add('preview', function (editor) {
    $_5ed84fhtjd08mdle.register(editor);
    $_4l8owhzjd08mdln.register(editor);
=======
  var $_29px8ri9jducwrsp = { register: register$1 };

  PluginManager.add('preview', function (editor) {
    $_e98z67i3jducwrsj.register(editor);
    $_29px8ri9jducwrsp.register(editor);
>>>>>>> installer
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
