var dropdownbutton = document.getElementsByClassName("dropdown_button");
for (var i = 0; i < dropdownbutton.length; i++) {
	var thisDropdownbutton = dropdownbutton[i];
thisDropdownbutton.addEventListener("click", function() {
	var dropdown = document.getElementById(this.dataset.dropdown);
	dropdown.classList.toggle("show");
}, false);
document.addEventListener("click", function() {
  var dropdown = document.getElementById(this.dataset.dropdown);
  dropdown.classList.remove("show");
}, false);
}
