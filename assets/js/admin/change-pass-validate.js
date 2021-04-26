var changePassForm = document.getElementById('change_pass_form');

var oldPassword = document.getElementById('old_password');
var newPassword = document.getElementById('new_password');
var confirmNewPassword = document.getElementById('confirm_new_password');

var oldError = document.getElementById('error-old');
var newError = document.getElementById('error-new');
var confirmError = document.getElementById('error-confirm');
var commonError = document.getElementById('error-common');

let passRegx = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/);

changePassForm.addEventListener("keyup", function (e) {

  if (oldPassword.value == '' || oldPassword.value == null) {
    e.preventDefault();
    oldError.innerHTML = "Password cannot be empty";
  }
  else if (!passRegx.test(oldPassword.value)) {
    e.preventDefault();
    oldError.innerHTML = "Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.";
  }
  else {
    oldError.innerHTML = "";
  }

  if (newPassword.value == '' || newPassword.value == null) {
    e.preventDefault();
    newError.innerHTML = "Password cannot be empty";
  }
  else if (!passRegx.test(newPassword.value)) {
    e.preventDefault();
    newError.innerHTML = "Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.";
  }
  else {
    newError.innerHTML = "";
  }

  if (confirmNewPassword.value == '' || confirmNewPassword.value == null) {
    e.preventDefault();
    confirmError.innerHTML = "Password cannot be empty";
  }
  else if (!passRegx.test(confirmNewPassword.value)) {
    e.preventDefault();
    confirmError.innerHTML = "Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.";
  }
  else {
    confirmError.innerHTML = "";
  }

  if (confirmNewPassword.value != newPassword.value) {
    e.preventDefault();
    commonError.innerHTML = "Password do not match.";
  }
  else if (newPassword.value == oldPassword.value) {
    e.preventDefault();
    commonError.innerHTML = "Old and new passwords should not be same.";
  }
  else {
    commonError.innerHTML = "";
  }

});

changePassForm.addEventListener("submit", function (e) {

  if (oldPassword.value == '' || oldPassword.value == null) {
    e.preventDefault();
    oldError.innerHTML = "Password cannot be empty";
  }
  else if (!passRegx.test(oldPassword.value)) {
    e.preventDefault();
    oldError.innerHTML = "Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.";
  }
  else {
    oldError.innerHTML = "";
  }

  if (newPassword.value == '' || newPassword.value == null) {
    e.preventDefault();
    newError.innerHTML = "Password cannot be empty";
  }
  else if (!passRegx.test(newPassword.value)) {
    e.preventDefault();
    newError.innerHTML = "Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.";
  }
  else {
    newError.innerHTML = "";
  }

  if (confirmNewPassword.value == '' || confirmNewPassword.value == null) {
    e.preventDefault();
    confirmError.innerHTML = "Password cannot be empty";
  }
  else if (!passRegx.test(confirmNewPassword.value)) {
    e.preventDefault();
    confirmError.innerHTML = "Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.";
  }
  else {
    confirmError.innerHTML = "";
  }

  if (confirmNewPassword.value != newPassword.value) {
    e.preventDefault();
    confirmError.innerHTML = "Password do not match.";
  }
  else {
    confirmError.innerHTML = "";
  }

});

changePassForm.addEventListener("change", function (e) {

  if (oldPassword.value == '' || oldPassword.value == null) {
    e.preventDefault();
    oldError.innerHTML = "Password cannot be empty";
  }
  else if (!passRegx.test(oldPassword.value)) {
    e.preventDefault();
    oldError.innerHTML = "Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.";
  }
  else {
    oldError.innerHTML = "";
  }

  if (newPassword.value == '' || newPassword.value == null) {
    e.preventDefault();
    newError.innerHTML = "Password cannot be empty";
  }
  else if (!passRegx.test(newPassword.value)) {
    e.preventDefault();
    newError.innerHTML = "Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.";
  }
  else {
    newError.innerHTML = "";
  }

  if (confirmNewPassword.value == '' || confirmNewPassword.value == null) {
    e.preventDefault();
    confirmError.innerHTML = "Password cannot be empty";
  }
  else if (!passRegx.test(confirmNewPassword.value)) {
    e.preventDefault();
    confirmError.innerHTML = "Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.";
  }
  else {
    confirmError.innerHTML = "";
  }

  if (confirmNewPassword.value != newPassword.value) {
    e.preventDefault();
    confirmError.innerHTML = "Password do not match.";
  }
  else {
    confirmError.innerHTML = "";
  }

});