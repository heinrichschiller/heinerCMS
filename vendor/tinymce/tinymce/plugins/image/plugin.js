(function () {
var image = (function () {
  'use strict';

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var Tools = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var hasDimensions = function (editor) {
    return editor.settings.image_dimensions === false ? false : true;
  };
  var hasAdvTab = function (editor) {
    return editor.settings.image_advtab === true ? true : false;
  };
  var getPrependUrl = function (editor) {
    return editor.getParam('image_prepend_url', '');
  };
  var getClassList = function (editor) {
    return editor.getParam('image_class_list');
  };
  var hasDescription = function (editor) {
    return editor.settings.image_description === false ? false : true;
  };
  var hasImageTitle = function (editor) {
    return editor.settings.image_title === true ? true : false;
  };
  var hasImageCaption = function (editor) {
    return editor.settings.image_caption === true ? true : false;
  };
  var getImageList = function (editor) {
    return editor.getParam('image_list', false);
  };
  var hasUploadUrl = function (editor) {
    return editor.getParam('images_upload_url', false);
  };
  var hasUploadHandler = function (editor) {
    return editor.getParam('images_upload_handler', false);
  };
  var getUploadUrl = function (editor) {
    return editor.getParam('images_upload_url');
  };
  var getUploadHandler = function (editor) {
    return editor.getParam('images_upload_handler');
  };
  var getUploadBasePath = function (editor) {
    return editor.getParam('images_upload_base_path');
  };
  var getUploadCredentials = function (editor) {
    return editor.getParam('images_upload_credentials');
  };
<<<<<<< HEAD
  var $_ff63w1bqjd08mcnz = {
=======
  var $_4a5ue9bzjducwqyp = {
>>>>>>> installer
    hasDimensions: hasDimensions,
    hasAdvTab: hasAdvTab,
    getPrependUrl: getPrependUrl,
    getClassList: getClassList,
    hasDescription: hasDescription,
    hasImageTitle: hasImageTitle,
    hasImageCaption: hasImageCaption,
    getImageList: getImageList,
    hasUploadUrl: hasUploadUrl,
    hasUploadHandler: hasUploadHandler,
    getUploadUrl: getUploadUrl,
    getUploadHandler: getUploadHandler,
    getUploadBasePath: getUploadBasePath,
    getUploadCredentials: getUploadCredentials
  };

  var global = typeof window !== 'undefined' ? window : Function('return this;')();

  var path = function (parts, scope) {
    var o = scope !== undefined && scope !== null ? scope : global;
    for (var i = 0; i < parts.length && o !== undefined && o !== null; ++i)
      o = o[parts[i]];
    return o;
  };
  var resolve = function (p, scope) {
    var parts = p.split('.');
    return path(parts, scope);
  };
  var step = function (o, part) {
    if (o[part] === undefined || o[part] === null)
      o[part] = {};
    return o[part];
  };
  var forge = function (parts, target) {
    var o = target !== undefined ? target : global;
    for (var i = 0; i < parts.length; ++i)
      o = step(o, parts[i]);
    return o;
  };
  var namespace = function (name, target) {
    var parts = name.split('.');
    return forge(parts, target);
  };
<<<<<<< HEAD
  var $_6r188zbujd08mcoh = {
=======
  var $_ewxhkvc3jducwqza = {
>>>>>>> installer
    path: path,
    resolve: resolve,
    forge: forge,
    namespace: namespace
  };

  var unsafe = function (name, scope) {
<<<<<<< HEAD
    return $_6r188zbujd08mcoh.resolve(name, scope);
=======
    return $_ewxhkvc3jducwqza.resolve(name, scope);
>>>>>>> installer
  };
  var getOrDie = function (name, scope) {
    var actual = unsafe(name, scope);
    if (actual === undefined || actual === null)
      throw name + ' not available on this browser';
    return actual;
  };
<<<<<<< HEAD
  var $_fzdo92btjd08mcob = { getOrDie: getOrDie };

  function FileReader () {
    var f = $_fzdo92btjd08mcob.getOrDie('FileReader');
=======
  var $_2i7qrnc2jducwqz4 = { getOrDie: getOrDie };

  function FileReader () {
    var f = $_2i7qrnc2jducwqz4.getOrDie('FileReader');
>>>>>>> installer
    return new f();
  }

  var Promise = tinymce.util.Tools.resolve('tinymce.util.Promise');

  var XHR = tinymce.util.Tools.resolve('tinymce.util.XHR');

  var parseIntAndGetMax = function (val1, val2) {
    return Math.max(parseInt(val1, 10), parseInt(val2, 10));
  };
  var getImageSize = function (url, callback) {
    var img = document.createElement('img');
    function done(width, height) {
      if (img.parentNode) {
        img.parentNode.removeChild(img);
      }
      callback({
        width: width,
        height: height
      });
    }
    img.onload = function () {
      var width = parseIntAndGetMax(img.width, img.clientWidth);
      var height = parseIntAndGetMax(img.height, img.clientHeight);
      done(width, height);
    };
    img.onerror = function () {
      done(0, 0);
    };
    var style = img.style;
    style.visibility = 'hidden';
    style.position = 'fixed';
    style.bottom = style.left = '0px';
    style.width = style.height = 'auto';
    document.body.appendChild(img);
    img.src = url;
  };
  var buildListItems = function (inputList, itemCallback, startItems) {
    function appendItems(values, output) {
      output = output || [];
      Tools.each(values, function (item) {
        var menuItem = { text: item.text || item.title };
        if (item.menu) {
          menuItem.menu = appendItems(item.menu);
        } else {
          menuItem.value = item.value;
          itemCallback(menuItem);
        }
        output.push(menuItem);
      });
      return output;
    }
    return appendItems(inputList, startItems || []);
  };
  var removePixelSuffix = function (value) {
    if (value) {
      value = value.replace(/px$/, '');
    }
    return value;
  };
  var addPixelSuffix = function (value) {
    if (value.length > 0 && /^[0-9]+$/.test(value)) {
      value += 'px';
    }
    return value;
  };
  var mergeMargins = function (css) {
    if (css.margin) {
      var splitMargin = css.margin.split(' ');
      switch (splitMargin.length) {
      case 1:
        css['margin-top'] = css['margin-top'] || splitMargin[0];
        css['margin-right'] = css['margin-right'] || splitMargin[0];
        css['margin-bottom'] = css['margin-bottom'] || splitMargin[0];
        css['margin-left'] = css['margin-left'] || splitMargin[0];
        break;
      case 2:
        css['margin-top'] = css['margin-top'] || splitMargin[0];
        css['margin-right'] = css['margin-right'] || splitMargin[1];
        css['margin-bottom'] = css['margin-bottom'] || splitMargin[0];
        css['margin-left'] = css['margin-left'] || splitMargin[1];
        break;
      case 3:
        css['margin-top'] = css['margin-top'] || splitMargin[0];
        css['margin-right'] = css['margin-right'] || splitMargin[1];
        css['margin-bottom'] = css['margin-bottom'] || splitMargin[2];
        css['margin-left'] = css['margin-left'] || splitMargin[1];
        break;
      case 4:
        css['margin-top'] = css['margin-top'] || splitMargin[0];
        css['margin-right'] = css['margin-right'] || splitMargin[1];
        css['margin-bottom'] = css['margin-bottom'] || splitMargin[2];
        css['margin-left'] = css['margin-left'] || splitMargin[3];
      }
      delete css.margin;
    }
    return css;
  };
  var createImageList = function (editor, callback) {
<<<<<<< HEAD
    var imageList = $_ff63w1bqjd08mcnz.getImageList(editor);
=======
    var imageList = $_4a5ue9bzjducwqyp.getImageList(editor);
>>>>>>> installer
    if (typeof imageList === 'string') {
      XHR.send({
        url: imageList,
        success: function (text) {
          callback(JSON.parse(text));
        }
      });
    } else if (typeof imageList === 'function') {
      imageList(callback);
    } else {
      callback(imageList);
    }
  };
  var waitLoadImage = function (editor, data, imgElm) {
    function selectImage() {
      imgElm.onload = imgElm.onerror = null;
      if (editor.selection) {
        editor.selection.select(imgElm);
        editor.nodeChanged();
      }
    }
    imgElm.onload = function () {
<<<<<<< HEAD
      if (!data.width && !data.height && $_ff63w1bqjd08mcnz.hasDimensions(editor)) {
=======
      if (!data.width && !data.height && $_4a5ue9bzjducwqyp.hasDimensions(editor)) {
>>>>>>> installer
        editor.dom.setAttribs(imgElm, {
          width: imgElm.clientWidth,
          height: imgElm.clientHeight
        });
      }
      selectImage();
    };
    imgElm.onerror = selectImage;
  };
  var blobToDataUri = function (blob) {
    return new Promise(function (resolve, reject) {
      var reader = new FileReader();
      reader.onload = function () {
        resolve(reader.result);
      };
      reader.onerror = function () {
        reject(FileReader.error.message);
      };
      reader.readAsDataURL(blob);
    });
  };
<<<<<<< HEAD
  var $_ebfwb0brjd08mco4 = {
=======
  var $_a0aua8c0jducwqyt = {
>>>>>>> installer
    getImageSize: getImageSize,
    buildListItems: buildListItems,
    removePixelSuffix: removePixelSuffix,
    addPixelSuffix: addPixelSuffix,
    mergeMargins: mergeMargins,
    createImageList: createImageList,
    waitLoadImage: waitLoadImage,
    blobToDataUri: blobToDataUri
  };

  var updateVSpaceHSpaceBorder = function (editor) {
    return function (evt) {
      var dom = editor.dom;
      var rootControl = evt.control.rootControl;
<<<<<<< HEAD
      if (!$_ff63w1bqjd08mcnz.hasAdvTab(editor)) {
=======
      if (!$_4a5ue9bzjducwqyp.hasAdvTab(editor)) {
>>>>>>> installer
        return;
      }
      var data = rootControl.toJSON();
      var css = dom.parseStyle(data.style);
      rootControl.find('#vspace').value('');
      rootControl.find('#hspace').value('');
<<<<<<< HEAD
      css = $_ebfwb0brjd08mco4.mergeMargins(css);
      if (css['margin-top'] && css['margin-bottom'] || css['margin-right'] && css['margin-left']) {
        if (css['margin-top'] === css['margin-bottom']) {
          rootControl.find('#vspace').value($_ebfwb0brjd08mco4.removePixelSuffix(css['margin-top']));
=======
      css = $_a0aua8c0jducwqyt.mergeMargins(css);
      if (css['margin-top'] && css['margin-bottom'] || css['margin-right'] && css['margin-left']) {
        if (css['margin-top'] === css['margin-bottom']) {
          rootControl.find('#vspace').value($_a0aua8c0jducwqyt.removePixelSuffix(css['margin-top']));
>>>>>>> installer
        } else {
          rootControl.find('#vspace').value('');
        }
        if (css['margin-right'] === css['margin-left']) {
<<<<<<< HEAD
          rootControl.find('#hspace').value($_ebfwb0brjd08mco4.removePixelSuffix(css['margin-right']));
=======
          rootControl.find('#hspace').value($_a0aua8c0jducwqyt.removePixelSuffix(css['margin-right']));
>>>>>>> installer
        } else {
          rootControl.find('#hspace').value('');
        }
      }
      if (css['border-width']) {
<<<<<<< HEAD
        rootControl.find('#border').value($_ebfwb0brjd08mco4.removePixelSuffix(css['border-width']));
=======
        rootControl.find('#border').value($_a0aua8c0jducwqyt.removePixelSuffix(css['border-width']));
>>>>>>> installer
      }
      rootControl.find('#style').value(dom.serializeStyle(dom.parseStyle(dom.serializeStyle(css))));
    };
  };
  var makeTab = function (editor, updateStyle) {
    return {
      title: 'Advanced',
      type: 'form',
      pack: 'start',
      items: [
        {
          label: 'Style',
          name: 'style',
          type: 'textbox',
          onchange: updateVSpaceHSpaceBorder(editor)
        },
        {
          type: 'form',
          layout: 'grid',
          packV: 'start',
          columns: 2,
          padding: 0,
          defaults: {
            type: 'textbox',
            maxWidth: 50,
            onchange: function (evt) {
              updateStyle(editor, evt.control.rootControl);
            }
          },
          items: [
            {
              label: 'Vertical space',
              name: 'vspace'
            },
            {
              label: 'Border width',
              name: 'border'
            },
            {
              label: 'Horizontal space',
              name: 'hspace'
            },
            {
              label: 'Border style',
              type: 'listbox',
              name: 'borderStyle',
              width: 90,
              maxWidth: 90,
              onselect: function (evt) {
                updateStyle(editor, evt.control.rootControl);
              },
              values: [
                {
                  text: 'Select...',
                  value: ''
                },
                {
                  text: 'Solid',
                  value: 'solid'
                },
                {
                  text: 'Dotted',
                  value: 'dotted'
                },
                {
                  text: 'Dashed',
                  value: 'dashed'
                },
                {
                  text: 'Double',
                  value: 'double'
                },
                {
                  text: 'Groove',
                  value: 'groove'
                },
                {
                  text: 'Ridge',
                  value: 'ridge'
                },
                {
                  text: 'Inset',
                  value: 'inset'
                },
                {
                  text: 'Outset',
                  value: 'outset'
                },
                {
                  text: 'None',
                  value: 'none'
                },
                {
                  text: 'Hidden',
                  value: 'hidden'
                }
              ]
            }
          ]
        }
      ]
    };
  };
<<<<<<< HEAD
  var $_5smvn7byjd08mcom = { makeTab: makeTab };
=======
  var $_fzs5uzc7jducwqzj = { makeTab: makeTab };
>>>>>>> installer

  var doSyncSize = function (widthCtrl, heightCtrl) {
    widthCtrl.state.set('oldVal', widthCtrl.value());
    heightCtrl.state.set('oldVal', heightCtrl.value());
  };
  var doSizeControls = function (win, f) {
    var widthCtrl = win.find('#width')[0];
    var heightCtrl = win.find('#height')[0];
    var constrained = win.find('#constrain')[0];
    if (widthCtrl && heightCtrl && constrained) {
      f(widthCtrl, heightCtrl, constrained.checked());
    }
  };
  var doUpdateSize = function (widthCtrl, heightCtrl, isContrained) {
    var oldWidth = widthCtrl.state.get('oldVal');
    var oldHeight = heightCtrl.state.get('oldVal');
    var newWidth = widthCtrl.value();
    var newHeight = heightCtrl.value();
    if (isContrained && oldWidth && oldHeight && newWidth && newHeight) {
      if (newWidth !== oldWidth) {
        newHeight = Math.round(newWidth / oldWidth * newHeight);
        if (!isNaN(newHeight)) {
          heightCtrl.value(newHeight);
        }
      } else {
        newWidth = Math.round(newHeight / oldHeight * newWidth);
        if (!isNaN(newWidth)) {
          widthCtrl.value(newWidth);
        }
      }
    }
    doSyncSize(widthCtrl, heightCtrl);
  };
  var syncSize = function (win) {
    doSizeControls(win, doSyncSize);
  };
  var updateSize = function (win) {
    doSizeControls(win, doUpdateSize);
  };
  var createUi = function () {
    var recalcSize = function (evt) {
      updateSize(evt.control.rootControl);
    };
    return {
      type: 'container',
      label: 'Dimensions',
      layout: 'flex',
      align: 'center',
      spacing: 5,
      items: [
        {
          name: 'width',
          type: 'textbox',
          maxLength: 5,
          size: 5,
          onchange: recalcSize,
          ariaLabel: 'Width'
        },
        {
          type: 'label',
          text: 'x'
        },
        {
          name: 'height',
          type: 'textbox',
          maxLength: 5,
          size: 5,
          onchange: recalcSize,
          ariaLabel: 'Height'
        },
        {
          name: 'constrain',
          type: 'checkbox',
          checked: true,
          text: 'Constrain proportions'
        }
      ]
    };
  };
<<<<<<< HEAD
  var $_d98gfpc0jd08mcoq = {
=======
  var $_7l1v9ic9jducwqzr = {
>>>>>>> installer
    createUi: createUi,
    syncSize: syncSize,
    updateSize: updateSize
  };

  var onSrcChange = function (evt, editor) {
    var srcURL, prependURL, absoluteURLPattern;
    var meta = evt.meta || {};
    var control = evt.control;
    var rootControl = control.rootControl;
    var imageListCtrl = rootControl.find('#image-list')[0];
    if (imageListCtrl) {
      imageListCtrl.value(editor.convertURL(control.value(), 'src'));
    }
    Tools.each(meta, function (value, key) {
      rootControl.find('#' + key).value(value);
    });
    if (!meta.width && !meta.height) {
      srcURL = editor.convertURL(control.value(), 'src');
<<<<<<< HEAD
      prependURL = $_ff63w1bqjd08mcnz.getPrependUrl(editor);
=======
      prependURL = $_4a5ue9bzjducwqyp.getPrependUrl(editor);
>>>>>>> installer
      absoluteURLPattern = new RegExp('^(?:[a-z]+:)?//', 'i');
      if (prependURL && !absoluteURLPattern.test(srcURL) && srcURL.substring(0, prependURL.length) !== prependURL) {
        srcURL = prependURL + srcURL;
      }
      control.value(srcURL);
<<<<<<< HEAD
      $_ebfwb0brjd08mco4.getImageSize(editor.documentBaseURI.toAbsolute(control.value()), function (data) {
        if (data.width && data.height && $_ff63w1bqjd08mcnz.hasDimensions(editor)) {
          rootControl.find('#width').value(data.width);
          rootControl.find('#height').value(data.height);
          $_d98gfpc0jd08mcoq.updateSize(rootControl);
=======
      $_a0aua8c0jducwqyt.getImageSize(editor.documentBaseURI.toAbsolute(control.value()), function (data) {
        if (data.width && data.height && $_4a5ue9bzjducwqyp.hasDimensions(editor)) {
          rootControl.find('#width').value(data.width);
          rootControl.find('#height').value(data.height);
          $_7l1v9ic9jducwqzr.updateSize(rootControl);
>>>>>>> installer
        }
      });
    }
  };
  var onBeforeCall = function (evt) {
    evt.meta = evt.control.rootControl.toJSON();
  };
  var getGeneralItems = function (editor, imageListCtrl) {
    var generalFormItems = [
      {
        name: 'src',
        type: 'filepicker',
        filetype: 'image',
        label: 'Source',
        autofocus: true,
        onchange: function (evt) {
          onSrcChange(evt, editor);
        },
        onbeforecall: onBeforeCall
      },
      imageListCtrl
    ];
<<<<<<< HEAD
    if ($_ff63w1bqjd08mcnz.hasDescription(editor)) {
=======
    if ($_4a5ue9bzjducwqyp.hasDescription(editor)) {
>>>>>>> installer
      generalFormItems.push({
        name: 'alt',
        type: 'textbox',
        label: 'Image description'
      });
    }
<<<<<<< HEAD
    if ($_ff63w1bqjd08mcnz.hasImageTitle(editor)) {
=======
    if ($_4a5ue9bzjducwqyp.hasImageTitle(editor)) {
>>>>>>> installer
      generalFormItems.push({
        name: 'title',
        type: 'textbox',
        label: 'Image Title'
      });
    }
<<<<<<< HEAD
    if ($_ff63w1bqjd08mcnz.hasDimensions(editor)) {
      generalFormItems.push($_d98gfpc0jd08mcoq.createUi());
    }
    if ($_ff63w1bqjd08mcnz.getClassList(editor)) {
=======
    if ($_4a5ue9bzjducwqyp.hasDimensions(editor)) {
      generalFormItems.push($_7l1v9ic9jducwqzr.createUi());
    }
    if ($_4a5ue9bzjducwqyp.getClassList(editor)) {
>>>>>>> installer
      generalFormItems.push({
        name: 'class',
        type: 'listbox',
        label: 'Class',
<<<<<<< HEAD
        values: $_ebfwb0brjd08mco4.buildListItems($_ff63w1bqjd08mcnz.getClassList(editor), function (item) {
=======
        values: $_a0aua8c0jducwqyt.buildListItems($_4a5ue9bzjducwqyp.getClassList(editor), function (item) {
>>>>>>> installer
          if (item.value) {
            item.textStyle = function () {
              return editor.formatter.getCssText({
                inline: 'img',
                classes: [item.value]
              });
            };
          }
        })
      });
    }
<<<<<<< HEAD
    if ($_ff63w1bqjd08mcnz.hasImageCaption(editor)) {
=======
    if ($_4a5ue9bzjducwqyp.hasImageCaption(editor)) {
>>>>>>> installer
      generalFormItems.push({
        name: 'caption',
        type: 'checkbox',
        label: 'Caption'
      });
    }
    return generalFormItems;
  };
  var makeTab$1 = function (editor, imageListCtrl) {
    return {
      title: 'General',
      type: 'form',
      items: getGeneralItems(editor, imageListCtrl)
    };
  };
<<<<<<< HEAD
  var $_cb4ypxbzjd08mcoo = {
=======
  var $_7tody5c8jducwqzo = {
>>>>>>> installer
    makeTab: makeTab$1,
    getGeneralItems: getGeneralItems
  };

  var url = function () {
<<<<<<< HEAD
    return $_fzdo92btjd08mcob.getOrDie('URL');
=======
    return $_2i7qrnc2jducwqz4.getOrDie('URL');
>>>>>>> installer
  };
  var createObjectURL = function (blob) {
    return url().createObjectURL(blob);
  };
  var revokeObjectURL = function (u) {
    url().revokeObjectURL(u);
  };
<<<<<<< HEAD
  var $_6ebpqhc2jd08mcoz = {
=======
  var $_6zhyoscbjducwqzw = {
>>>>>>> installer
    createObjectURL: createObjectURL,
    revokeObjectURL: revokeObjectURL
  };

  var Factory = tinymce.util.Tools.resolve('tinymce.ui.Factory');

  function XMLHttpRequest () {
<<<<<<< HEAD
    var f = $_fzdo92btjd08mcob.getOrDie('XMLHttpRequest');
=======
    var f = $_2i7qrnc2jducwqz4.getOrDie('XMLHttpRequest');
>>>>>>> installer
    return new f();
  }

  var noop = function () {
  };
  var pathJoin = function (path1, path2) {
    if (path1) {
      return path1.replace(/\/$/, '') + '/' + path2.replace(/^\//, '');
    }
    return path2;
  };
  function Uploader (settings) {
    var defaultHandler = function (blobInfo, success, failure, progress) {
      var xhr, formData;
      xhr = new XMLHttpRequest();
      xhr.open('POST', settings.url);
      xhr.withCredentials = settings.credentials;
      xhr.upload.onprogress = function (e) {
        progress(e.loaded / e.total * 100);
      };
      xhr.onerror = function () {
        failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
      };
      xhr.onload = function () {
        var json;
        if (xhr.status < 200 || xhr.status >= 300) {
          failure('HTTP Error: ' + xhr.status);
          return;
        }
        json = JSON.parse(xhr.responseText);
        if (!json || typeof json.location !== 'string') {
          failure('Invalid JSON: ' + xhr.responseText);
          return;
        }
        success(pathJoin(settings.basePath, json.location));
      };
      formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());
      xhr.send(formData);
    };
    var uploadBlob = function (blobInfo, handler) {
      return new Promise(function (resolve, reject) {
        try {
          handler(blobInfo, resolve, reject, noop);
        } catch (ex) {
          reject(ex.message);
        }
      });
    };
    var isDefaultHandler = function (handler) {
      return handler === defaultHandler;
    };
    var upload = function (blobInfo) {
      return !settings.url && isDefaultHandler(settings.handler) ? Promise.reject('Upload url missing from the settings.') : uploadBlob(blobInfo, settings.handler);
    };
    settings = Tools.extend({
      credentials: false,
      handler: defaultHandler
    }, settings);
    return { upload: upload };
  }

  var onFileInput = function (editor) {
    return function (evt) {
      var Throbber = Factory.get('Throbber');
      var rootControl = evt.control.rootControl;
      var throbber = new Throbber(rootControl.getEl());
      var file = evt.control.value();
<<<<<<< HEAD
      var blobUri = $_6ebpqhc2jd08mcoz.createObjectURL(file);
      var uploader = Uploader({
        url: $_ff63w1bqjd08mcnz.getUploadUrl(editor),
        basePath: $_ff63w1bqjd08mcnz.getUploadBasePath(editor),
        credentials: $_ff63w1bqjd08mcnz.getUploadCredentials(editor),
        handler: $_ff63w1bqjd08mcnz.getUploadHandler(editor)
      });
      var finalize = function () {
        throbber.hide();
        $_6ebpqhc2jd08mcoz.revokeObjectURL(blobUri);
      };
      throbber.show();
      return $_ebfwb0brjd08mco4.blobToDataUri(file).then(function (dataUrl) {
=======
      var blobUri = $_6zhyoscbjducwqzw.createObjectURL(file);
      var uploader = Uploader({
        url: $_4a5ue9bzjducwqyp.getUploadUrl(editor),
        basePath: $_4a5ue9bzjducwqyp.getUploadBasePath(editor),
        credentials: $_4a5ue9bzjducwqyp.getUploadCredentials(editor),
        handler: $_4a5ue9bzjducwqyp.getUploadHandler(editor)
      });
      var finalize = function () {
        throbber.hide();
        $_6zhyoscbjducwqzw.revokeObjectURL(blobUri);
      };
      throbber.show();
      return $_a0aua8c0jducwqyt.blobToDataUri(file).then(function (dataUrl) {
>>>>>>> installer
        var blobInfo = editor.editorUpload.blobCache.create({
          blob: file,
          blobUri: blobUri,
          name: file.name ? file.name.replace(/\.[^\.]+$/, '') : null,
          base64: dataUrl.split(',')[1]
        });
        return uploader.upload(blobInfo).then(function (url) {
          var src = rootControl.find('#src');
          src.value(url);
          rootControl.find('tabpanel')[0].activateTab(0);
          src.fire('change');
          finalize();
          return url;
        });
      }).catch(function (err) {
        editor.windowManager.alert(err);
        finalize();
      });
    };
  };
  var acceptExts = '.jpg,.jpeg,.png,.gif';
  var makeTab$2 = function (editor) {
    return {
      title: 'Upload',
      type: 'form',
      layout: 'flex',
      direction: 'column',
      align: 'stretch',
      padding: '20 20 20 20',
      items: [
        {
          type: 'container',
          layout: 'flex',
          direction: 'column',
          align: 'center',
          spacing: 10,
          items: [
            {
              text: 'Browse for an image',
              type: 'browsebutton',
              accept: acceptExts,
              onchange: onFileInput(editor)
            },
            {
              text: 'OR',
              type: 'label'
            }
          ]
        },
        {
          text: 'Drop an image here',
          type: 'dropzone',
          accept: acceptExts,
          height: 100,
          onchange: onFileInput(editor)
        }
      ]
    };
  };
<<<<<<< HEAD
  var $_4t38hsc1jd08mcou = { makeTab: makeTab$2 };

  function Dialog (editor) {
    var updateStyle = function (editor, rootControl) {
      if (!$_ff63w1bqjd08mcnz.hasAdvTab(editor)) {
=======
  var $_ak89nycajducwqzt = { makeTab: makeTab$2 };

  function Dialog (editor) {
    var updateStyle = function (editor, rootControl) {
      if (!$_4a5ue9bzjducwqyp.hasAdvTab(editor)) {
>>>>>>> installer
        return;
      }
      var dom = editor.dom;
      var data = rootControl.toJSON();
      var css = dom.parseStyle(data.style);
<<<<<<< HEAD
      css = $_ebfwb0brjd08mco4.mergeMargins(css);
      if (data.vspace) {
        css['margin-top'] = css['margin-bottom'] = $_ebfwb0brjd08mco4.addPixelSuffix(data.vspace);
      }
      if (data.hspace) {
        css['margin-left'] = css['margin-right'] = $_ebfwb0brjd08mco4.addPixelSuffix(data.hspace);
      }
      if (data.border) {
        css['border-width'] = $_ebfwb0brjd08mco4.addPixelSuffix(data.border);
=======
      css = $_a0aua8c0jducwqyt.mergeMargins(css);
      if (data.vspace) {
        css['margin-top'] = css['margin-bottom'] = $_a0aua8c0jducwqyt.addPixelSuffix(data.vspace);
      }
      if (data.hspace) {
        css['margin-left'] = css['margin-right'] = $_a0aua8c0jducwqyt.addPixelSuffix(data.hspace);
      }
      if (data.border) {
        css['border-width'] = $_a0aua8c0jducwqyt.addPixelSuffix(data.border);
      }
      if (data.borderStyle) {
        css['border-style'] = data.borderStyle;
>>>>>>> installer
      }
      rootControl.find('#style').value(dom.serializeStyle(dom.parseStyle(dom.serializeStyle(css))));
    };
    function showDialog(imageList) {
      var win, data = {}, imgElm, figureElm;
      var dom = editor.dom;
      var imageListCtrl;
      function onSubmitForm() {
        var figureElm, oldImg;
<<<<<<< HEAD
        $_d98gfpc0jd08mcoq.updateSize(win);
=======
        $_7l1v9ic9jducwqzr.updateSize(win);
>>>>>>> installer
        updateStyle(editor, win);
        data = Tools.extend(data, win.toJSON());
        if (!data.alt) {
          data.alt = '';
        }
        if (!data.title) {
          data.title = '';
        }
        if (data.width === '') {
          data.width = null;
        }
        if (data.height === '') {
          data.height = null;
        }
        if (!data.style) {
          data.style = null;
        }
        data = {
          src: data.src,
          alt: data.alt,
          title: data.title,
          width: data.width,
          height: data.height,
          style: data.style,
          caption: data.caption,
          class: data.class
        };
        editor.undoManager.transact(function () {
          if (!data.src) {
            if (imgElm) {
              var elm = dom.is(imgElm.parentNode, 'figure.image') ? imgElm.parentNode : imgElm;
              dom.remove(elm);
              editor.focus();
              editor.nodeChanged();
              if (dom.isEmpty(editor.getBody())) {
                editor.setContent('');
                editor.selection.setCursorLocation();
              }
            }
            return;
          }
          if (data.title === '') {
            data.title = null;
          }
          if (!imgElm) {
            data.id = '__mcenew';
            editor.focus();
            editor.selection.setContent(dom.createHTML('img', data));
            imgElm = dom.get('__mcenew');
            dom.setAttrib(imgElm, 'id', null);
          } else {
            dom.setAttribs(imgElm, data);
          }
          editor.editorUpload.uploadImagesAuto();
          if (data.caption === false) {
            if (dom.is(imgElm.parentNode, 'figure.image')) {
              figureElm = imgElm.parentNode;
              dom.insertAfter(imgElm, figureElm);
              dom.remove(figureElm);
            }
          }
          if (data.caption === true) {
            if (!dom.is(imgElm.parentNode, 'figure.image')) {
              oldImg = imgElm;
              imgElm = imgElm.cloneNode(true);
              figureElm = dom.create('figure', { class: 'image' });
              figureElm.appendChild(imgElm);
              figureElm.appendChild(dom.create('figcaption', { contentEditable: true }, 'Caption'));
              figureElm.contentEditable = false;
              var textBlock = dom.getParent(oldImg, function (node) {
                return editor.schema.getTextBlockElements()[node.nodeName];
              });
              if (textBlock) {
                dom.split(textBlock, oldImg, figureElm);
              } else {
                dom.replace(figureElm, oldImg);
              }
              editor.selection.select(figureElm);
            }
            return;
          }
<<<<<<< HEAD
          $_ebfwb0brjd08mco4.waitLoadImage(editor, data, imgElm);
=======
          $_a0aua8c0jducwqyt.waitLoadImage(editor, data, imgElm);
>>>>>>> installer
        });
      }
      imgElm = editor.selection.getNode();
      figureElm = dom.getParent(imgElm, 'figure.image');
      if (figureElm) {
        imgElm = dom.select('img', figureElm)[0];
      }
      if (imgElm && (imgElm.nodeName !== 'IMG' || imgElm.getAttribute('data-mce-object') || imgElm.getAttribute('data-mce-placeholder'))) {
        imgElm = null;
      }
      if (imgElm) {
        data = {
          src: dom.getAttrib(imgElm, 'src'),
          alt: dom.getAttrib(imgElm, 'alt'),
          title: dom.getAttrib(imgElm, 'title'),
          class: dom.getAttrib(imgElm, 'class'),
          width: dom.getAttrib(imgElm, 'width'),
          height: dom.getAttrib(imgElm, 'height'),
          caption: !!figureElm
        };
      }
      if (imageList) {
        imageListCtrl = {
          type: 'listbox',
          label: 'Image list',
          name: 'image-list',
<<<<<<< HEAD
          values: $_ebfwb0brjd08mco4.buildListItems(imageList, function (item) {
=======
          values: $_a0aua8c0jducwqyt.buildListItems(imageList, function (item) {
>>>>>>> installer
            item.value = editor.convertURL(item.value || item.url, 'src');
          }, [{
              text: 'None',
              value: ''
            }]),
          value: data.src && editor.convertURL(data.src, 'src'),
          onselect: function (e) {
            var altCtrl = win.find('#alt');
            if (!altCtrl.value() || e.lastControl && altCtrl.value() === e.lastControl.text()) {
              altCtrl.value(e.control.text());
            }
            win.find('#src').value(e.control.value()).fire('change');
          },
          onPostRender: function () {
            imageListCtrl = this;
          }
        };
      }
<<<<<<< HEAD
      if ($_ff63w1bqjd08mcnz.hasAdvTab(editor) || $_ff63w1bqjd08mcnz.hasUploadUrl(editor) || $_ff63w1bqjd08mcnz.hasUploadHandler(editor)) {
        var body = [$_cb4ypxbzjd08mcoo.makeTab(editor, imageListCtrl)];
        if ($_ff63w1bqjd08mcnz.hasAdvTab(editor)) {
          if (imgElm) {
            if (imgElm.style.marginLeft && imgElm.style.marginRight && imgElm.style.marginLeft === imgElm.style.marginRight) {
              data.hspace = $_ebfwb0brjd08mco4.removePixelSuffix(imgElm.style.marginLeft);
            }
            if (imgElm.style.marginTop && imgElm.style.marginBottom && imgElm.style.marginTop === imgElm.style.marginBottom) {
              data.vspace = $_ebfwb0brjd08mco4.removePixelSuffix(imgElm.style.marginTop);
            }
            if (imgElm.style.borderWidth) {
              data.border = $_ebfwb0brjd08mco4.removePixelSuffix(imgElm.style.borderWidth);
=======
      if ($_4a5ue9bzjducwqyp.hasAdvTab(editor) || $_4a5ue9bzjducwqyp.hasUploadUrl(editor) || $_4a5ue9bzjducwqyp.hasUploadHandler(editor)) {
        var body = [$_7tody5c8jducwqzo.makeTab(editor, imageListCtrl)];
        if ($_4a5ue9bzjducwqyp.hasAdvTab(editor)) {
          if (imgElm) {
            if (imgElm.style.marginLeft && imgElm.style.marginRight && imgElm.style.marginLeft === imgElm.style.marginRight) {
              data.hspace = $_a0aua8c0jducwqyt.removePixelSuffix(imgElm.style.marginLeft);
            }
            if (imgElm.style.marginTop && imgElm.style.marginBottom && imgElm.style.marginTop === imgElm.style.marginBottom) {
              data.vspace = $_a0aua8c0jducwqyt.removePixelSuffix(imgElm.style.marginTop);
            }
            if (imgElm.style.borderWidth) {
              data.border = $_a0aua8c0jducwqyt.removePixelSuffix(imgElm.style.borderWidth);
>>>>>>> installer
            }
            data.borderStyle = imgElm.style.borderStyle;
            data.style = editor.dom.serializeStyle(editor.dom.parseStyle(editor.dom.getAttrib(imgElm, 'style')));
          }
<<<<<<< HEAD
          body.push($_5smvn7byjd08mcom.makeTab(editor, updateStyle));
        }
        if ($_ff63w1bqjd08mcnz.hasUploadUrl(editor) || $_ff63w1bqjd08mcnz.hasUploadHandler(editor)) {
          body.push($_4t38hsc1jd08mcou.makeTab(editor));
=======
          body.push($_fzs5uzc7jducwqzj.makeTab(editor, updateStyle));
        }
        if ($_4a5ue9bzjducwqyp.hasUploadUrl(editor) || $_4a5ue9bzjducwqyp.hasUploadHandler(editor)) {
          body.push($_ak89nycajducwqzt.makeTab(editor));
>>>>>>> installer
        }
        win = editor.windowManager.open({
          title: 'Insert/edit image',
          data: data,
          bodyType: 'tabpanel',
          body: body,
          onSubmit: onSubmitForm
        });
      } else {
        win = editor.windowManager.open({
          title: 'Insert/edit image',
          data: data,
<<<<<<< HEAD
          body: $_cb4ypxbzjd08mcoo.getGeneralItems(editor, imageListCtrl),
          onSubmit: onSubmitForm
        });
      }
      $_d98gfpc0jd08mcoq.syncSize(win);
    }
    function open() {
      $_ebfwb0brjd08mco4.createImageList(editor, showDialog);
=======
          body: $_7tody5c8jducwqzo.getGeneralItems(editor, imageListCtrl),
          onSubmit: onSubmitForm
        });
      }
      $_7l1v9ic9jducwqzr.syncSize(win);
    }
    function open() {
      $_a0aua8c0jducwqyt.createImageList(editor, showDialog);
>>>>>>> installer
    }
    return { open: open };
  }

  var register = function (editor) {
    editor.addCommand('mceImage', Dialog(editor).open);
  };
<<<<<<< HEAD
  var $_6je65lbnjd08mcno = { register: register };
=======
  var $_3u9u7ubwjducwqyh = { register: register };
>>>>>>> installer

  var hasImageClass = function (node) {
    var className = node.attr('class');
    return className && /\bimage\b/.test(className);
  };
  var toggleContentEditableState = function (state) {
    return function (nodes) {
      var i = nodes.length, node;
      var toggleContentEditable = function (node) {
        node.attr('contenteditable', state ? 'true' : null);
      };
      while (i--) {
        node = nodes[i];
        if (hasImageClass(node)) {
          node.attr('contenteditable', state ? 'false' : null);
          Tools.each(node.getAll('figcaption'), toggleContentEditable);
        }
      }
    };
  };
  var setup = function (editor) {
    editor.on('preInit', function () {
      editor.parser.addNodeFilter('figure', toggleContentEditableState(true));
      editor.serializer.addNodeFilter('figure', toggleContentEditableState(false));
    });
  };
<<<<<<< HEAD
  var $_tvj4zc6jd08mcp4 = { setup: setup };
=======
  var $_fc10d3cfjducwr02 = { setup: setup };
>>>>>>> installer

  var register$1 = function (editor) {
    editor.addButton('image', {
      icon: 'image',
      tooltip: 'Insert/edit image',
      onclick: Dialog(editor).open,
      stateSelector: 'img:not([data-mce-object],[data-mce-placeholder]),figure.image'
    });
    editor.addMenuItem('image', {
      icon: 'image',
      text: 'Image',
      onclick: Dialog(editor).open,
      context: 'insert',
      prependToContext: true
    });
  };
<<<<<<< HEAD
  var $_aixks2c7jd08mcp6 = { register: register$1 };

  PluginManager.add('image', function (editor) {
    $_tvj4zc6jd08mcp4.setup(editor);
    $_aixks2c7jd08mcp6.register(editor);
    $_6je65lbnjd08mcno.register(editor);
=======
  var $_o3zg3cgjducwr05 = { register: register$1 };

  PluginManager.add('image', function (editor) {
    $_fc10d3cfjducwr02.setup(editor);
    $_o3zg3cgjducwr05.register(editor);
    $_3u9u7ubwjducwqyh.register(editor);
>>>>>>> installer
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
