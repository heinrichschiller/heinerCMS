"use strict";

$(document).ready(function() {
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
        "Confirm" : function() {
          window.location.href = targetUrl;
        },
        "Cancel" : function() {
          $(this).dialog("close");
        }
      }
    });

    $("#dialog").dialog("open");
  });