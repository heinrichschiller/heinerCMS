"use strict";

$(function() {
    $(".clickable-row").click(function() {
        var href = $(this).data("href");

        if(href) {
            window.location = href;
        }
    });

    $("#selLang").change(function() {
        $("form").submit();
    });
});

$("#btn-preview").click(function() {
    var action = $('form').attr('action')
    var href = $(this).data("href");

    if(href) {
        $('form').attr('action', href);
        $('form').attr('target', '_blank');

        $('form').submit();

        $('form').attr('action', action);
        $('form').removeAttr('target');
    }

});

/*$(document).ready(function() {
    $("#dialog").dialog({
      autoOpen: false,
      modal: true,
      width: 500,
      height: 200
    });
  });

  $(".dialog-confirm").click(function(e) {
    e.preventDefault();
    var targetUrl = $(this).attr("href");

    $("#dialog").dialog({
      buttons : {
        "Bestätigen" : function() {
          window.location.href = targetUrl;
        },
        "Zurück" : function() {
          $(this).dialog("close");
        }
      }
    });

    $("#dialog").dialog("open");
  });*/
