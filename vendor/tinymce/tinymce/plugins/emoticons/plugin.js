(function () {
var emoticons = (function () {
  'use strict';

  var PluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var Tools = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var emoticons = [
    [
      'cool',
      'cry',
      'embarassed',
      'foot-in-mouth'
    ],
    [
      'frown',
      'innocent',
      'kiss',
      'laughing'
    ],
    [
      'money-mouth',
      'sealed',
      'smile',
      'surprised'
    ],
    [
      'tongue-out',
      'undecided',
      'wink',
      'yell'
    ]
  ];
  var getHtml = function (pluginUrl) {
    var emoticonsHtml;
    emoticonsHtml = '<table role="list" class="mce-grid">';
    Tools.each(emoticons, function (row) {
      emoticonsHtml += '<tr>';
      Tools.each(row, function (icon) {
        var emoticonUrl = pluginUrl + '/img/smiley-' + icon + '.gif';
        emoticonsHtml += '<td><a href="#" data-mce-url="' + emoticonUrl + '" data-mce-alt="' + icon + '" tabindex="-1" ' + 'role="option" aria-label="' + icon + '"><img src="' + emoticonUrl + '" style="width: 18px; height: 18px" role="presentation" /></a></td>';
      });
      emoticonsHtml += '</tr>';
    });
    emoticonsHtml += '</table>';
    return emoticonsHtml;
  };
<<<<<<< HEAD
  var $_auj709a8jd08mchq = { getHtml: getHtml };
=======
  var $_a9n7cvahjducwqrg = { getHtml: getHtml };
>>>>>>> installer

  var insertEmoticon = function (editor, src, alt) {
    editor.insertContent(editor.dom.createHTML('img', {
      src: src,
      alt: alt
    }));
  };
  var register = function (editor, pluginUrl) {
<<<<<<< HEAD
    var panelHtml = $_auj709a8jd08mchq.getHtml(pluginUrl);
=======
    var panelHtml = $_a9n7cvahjducwqrg.getHtml(pluginUrl);
>>>>>>> installer
    editor.addButton('emoticons', {
      type: 'panelbutton',
      panel: {
        role: 'application',
        autohide: true,
        html: panelHtml,
        onclick: function (e) {
          var linkElm = editor.dom.getParent(e.target, 'a');
          if (linkElm) {
            insertEmoticon(editor, linkElm.getAttribute('data-mce-url'), linkElm.getAttribute('data-mce-alt'));
            this.hide();
          }
        }
      },
      tooltip: 'Emoticons'
    });
  };
<<<<<<< HEAD
  var $_e18nc0a7jd08mchp = { register: register };

  PluginManager.add('emoticons', function (editor, pluginUrl) {
    $_e18nc0a7jd08mchp.register(editor, pluginUrl);
=======
  var $_9iops5agjducwqrf = { register: register };

  PluginManager.add('emoticons', function (editor, pluginUrl) {
    $_9iops5agjducwqrf.register(editor, pluginUrl);
>>>>>>> installer
  });
  function Plugin () {
  }

  return Plugin;

}());
})();
