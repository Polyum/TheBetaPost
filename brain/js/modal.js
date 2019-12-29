// Les liens pour ouvrir et fermer une modal
var link = document.getElementsByClassName("linkOpen");
for (var i = 0; i < link.length; i++) {
	var thisLink = link[i];
thisLink.addEventListener("click", function() {
	var modalclose = document.getElementById(this.dataset.closemodal);
	var modalopen = document.getElementById(this.dataset.openmodal);
	modalclose.style.display = "none";
	modalopen.style.display = "block";
}, false);
}


// Fermer une modal (x)
var span = document.getElementsByClassName("buttonClose");

for (var i = 0; i < span.length; i++) {
  var thisSpan = span[i];
  thisSpan.addEventListener("click", function(){

    var modaltoclose = document.getElementById(this.dataset.close);
    modaltoclose.style.display = "none";

	}, false);

}

// Ouvrir une modal
var btn = document.getElementsByClassName("buttonOpen");

for (var i = 0; i < btn.length; i++) {
  var thisBtn = btn[i];
  thisBtn.addEventListener("click", function(){

    var modal = document.getElementById(this.dataset.modal);
    modal.style.display = "block";

	}, false);

}
