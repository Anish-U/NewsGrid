var changeNameForm = document.getElementById('change_name_form');

var oldName = document.getElementById('old_name');
var newName = document.getElementById('new_name');
var confirmNewName = document.getElementById('confirm_name');

var oldError = document.getElementById('error-old');
var newError = document.getElementById('error-new');
var confirmError = document.getElementById('error-confirm');
var commonError = document.getElementById('error-common');

let nameRegx = new RegExp(/^[a-zA-Z ]{4,30}$/);

changeNameForm.addEventListener("keyup", function (e) {

  if (oldName.value == '' || oldName.value == null) {
    e.preventDefault();
    oldError.innerHTML = "Name cannot be empty";
  }
  else if (!nameRegx.test(oldName.value)) {
    e.preventDefault();
    oldError.innerHTML = "Name must contain 4 to 30 alphabets only.";
  }
  else {
    oldError.innerHTML = "";
  }

  if (newName.value == '' || newName.value == null) {
    e.preventDefault();
    newError.innerHTML = "Name cannot be empty";
  }
  else if (!nameRegx.test(newName.value)) {
    e.preventDefault();
    newError.innerHTML = "Name must contain 4 to 30 alphabets only.";
  }
  else {
    newError.innerHTML = "";
  }

  if (confirmNewName.value == '' || confirmNewName.value == null) {
    e.preventDefault();
    confirmError.innerHTML = "Name cannot be empty";
  }
  else if (!nameRegx.test(confirmNewName.value)) {
    e.preventDefault();
    confirmError.innerHTML = "Name must contain 4 to 30 alphabets only.";
  }
  else {
    confirmError.innerHTML = "";
  }

  if (confirmNewName.value != newName.value) {
    e.preventDefault();
    commonError.innerHTML = "Name do not match.";
  }
  else if (newName.value == oldName.value) {
    e.preventDefault();
    commonError.innerHTML = "Old and new names should not be same.";
  }
  else {
    commonError.innerHTML = "";
  }

});
