"use strict";

window.addEventListener("load", function() {
	let hide = document.getElementById("hide");
	
	hide.addEventListener("click", function() {
		let hidden = document.getElementById("hidden");
		
		hidden.classList.toggle("hidden");
	}, false);
	
	$('.carousel').carousel({
		  interval: 2000
		})
}, false);
