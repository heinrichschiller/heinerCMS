"use strict";

$(function() {
    $(".clickable-row").click(function() {
        var href = $(this).data("href");

        if(href) {
            window.location = href;
        }
    });
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
