var changePassForm = document.getElementById('change_pass_form');

var oldPassword = document.getElementById('old_password');
var newPassword = document.getElementById('new_password');
var confirmNewPassword = document.getElementById('confirm_new_password');

var oldError = document.getElementById('error-old');
var newError = document.getElementById('error-new');
var confirmError = document.getElementById('error-confirm');
var commonError = document.getElementById('error-common');

var formErrors = document.getElementById("errors");

var passRegx = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/);

changePassForm.addEventListener('keyup', function (e) {

  let errorMessages = [];

  // Old Password Validation
  if (oldPassword.value == '' || oldPassword.value == null) {
    errorMessages.push('Old Password cannot be empty.');
  }
  if (!passRegx.test(oldPassword.value)) {
    errorMessages.push('Old Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }

  // New Password Validation
  if (newPassword.value == '' || newPassword.value == null) {
    errorMessages.push('New Password cannot be empty.');
  }
  if (!passRegx.test(newPassword.value)) {
    errorMessages.push('New Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }
  if (newPassword.value != confirmNewPassword.value) {
    errorMessages.push('Password do not match.');
  }
  if (newPassword.value == oldPassword.value) {
    errorMessages.push('Old and New Password should not be same.');
  }
  if (errorMessages.length > 0) {
    e.preventDefault();
    formErrors.innerHTML = errorMessages.join('<br> ');
  }
  else {
    formErrors.innerHTML = "";
  }
});

changePassForm.addEventListener('submit', function (e) {

  let errorMessages = [];

  // Old Password Validation
  if (oldPassword.value == '' || oldPassword.value == null) {
    errorMessages.push('Old Password cannot be empty.');
  }
  if (!passRegx.test(oldPassword.value)) {
    errorMessages.push('Old Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }

  // New Password Validation
  if (newPassword.value == '' || newPassword.value == null) {
    errorMessages.push('New Password cannot be empty.');
  }
  if (!passRegx.test(newPassword.value)) {
    errorMessages.push('New Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }
  if (newPassword.value != confirmNewPassword.value) {
    errorMessages.push('Password do not match.');
  }
  if (newPassword.value == oldPassword.value) {
    errorMessages.push('Old and New Password should not be same.');
  }
  if (errorMessages.length > 0) {
    e.preventDefault();
    formErrors.innerHTML = errorMessages.join('<br> ');
  }
  else {
    formErrors.innerHTML = "";
  }
});

changePassForm.addEventListener('change', function (e) {

  let errorMessages = [];

  // Old Password Validation
  if (oldPassword.value == '' || oldPassword.value == null) {
    errorMessages.push('Old Password cannot be empty.');
  }
  if (!passRegx.test(oldPassword.value)) {
    errorMessages.push('Old Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }

  // New Password Validation
  if (newPassword.value == '' || newPassword.value == null) {
    errorMessages.push('New Password cannot be empty.');
  }
  if (!passRegx.test(newPassword.value)) {
    errorMessages.push('New Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }
  if (newPassword.value != confirmNewPassword.value) {
    errorMessages.push('Password do not match.');
  }
  if (newPassword.value == oldPassword.value) {
    errorMessages.push('Old and New Password should not be same.');
  }
  if (errorMessages.length > 0) {
    e.preventDefault();
    formErrors.innerHTML = errorMessages.join('<br> ');
  }
  else {
    formErrors.innerHTML = "";
  }
});