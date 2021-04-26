const loginForm = document.getElementById("login-form");
const signupForm = document.getElementById("signup-form");

const loginEmail = document.getElementById("login-email");
const loginPassword = document.getElementById("login-password");

const signupName = document.getElementById("signup-name");
const signupEmail = document.getElementById("signup-email");
const signupPassword = document.getElementById("signup-password");
const signupConfirmPass = document.getElementById("signup-confirm-password");

const loginError = document.getElementById("login-errors");
const signupError = document.getElementById("signup-errors");

let nameRegx = new RegExp(/^[a-zA-Z ]{4,30}$/);
let emailRegx = new RegExp(/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/);
let passRegx = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/);

loginForm.addEventListener('keyup', function (e) {

  let loginMessages = [];

  // Email Validation
  if (loginEmail.value == '' || loginEmail.value == null) {
    loginMessages.push('Email cannot be empty.');
  }
  if (!emailRegx.test(loginEmail.value)) {
    loginMessages.push('Enter a valid email');
  }

  // Password Validation
  if (loginPassword.value == '' || loginPassword.value == null) {
    loginMessages.push('Password cannot be empty.');
  }
  if (!passRegx.test(loginPassword.value)) {
    loginMessages.push('Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }

  if (loginMessages.length > 0) {
    e.preventDefault();
    signupError.innerHTML = "";
    loginError.innerHTML = loginMessages.join('<br> ');
  }
  else {
    loginError.innerHTML = "";
  }
});

signupForm.addEventListener('keyup', function (e) {
  let signupMessages = [];

  // Name Validation
  if (signupName.value == '' || signupName.value == null) {
    signupMessages.push('Name cannot be empty.');
  }
  if (!nameRegx.test(signupName.value)) {
    signupMessages.push('Name must contain 4 to 30 alphabets only.');
  }

  // Email Validation
  if (signupEmail.value == '' || signupEmail.value == null) {
    signupMessages.push('Email cannot be empty.');
  }
  if (!emailRegx.test(signupEmail.value)) {
    signupMessages.push('Enter a valid email');
  }

  // Password Validation
  if (signupPassword.value == '' || signupPassword.value == null) {
    signupMessages.push('Password cannot be empty.');
  }
  if (!passRegx.test(signupPassword.value)) {
    signupMessages.push('Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }
  if (signupConfirmPass.value == '' || signupConfirmPass.value == null) {
    signupMessages.push('Confirm Password cannot be empty.');
  }
  if (signupPassword.value != signupConfirmPass.value) {
    signupMessages.push('Password do not match.');
  }

  if (signupMessages.length > 0) {
    e.preventDefault();
    loginError.innerHTML = "";
    signupError.innerHTML = signupMessages.join('<br> ');
  }
  else {
    signupError.innerHTML = "";
  }
});

loginForm.addEventListener('submit', function (e) {

  let loginMessages = [];

  // Email Validation
  if (loginEmail.value == '' || loginEmail.value == null) {
    loginMessages.push('Email cannot be empty.');
  }
  if (!emailRegx.test(loginEmail.value)) {
    loginMessages.push('Enter a valid email');
  }

  // Password Validation
  if (loginPassword.value == '' || loginPassword.value == null) {
    loginMessages.push('Password cannot be empty.');
  }
  if (!passRegx.test(loginPassword.value)) {
    loginMessages.push('Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }

  if (loginMessages.length > 0) {
    e.preventDefault();
    signupError.innerHTML = "";
    loginError.innerHTML = loginMessages.join('<br> ');
  }
  else {
    loginError.innerHTML = "";
  }
});

signupForm.addEventListener('submit', function (e) {
  let signupMessages = [];

  // Name Validation
  if (signupName.value == '' || signupName.value == null) {
    signupMessages.push('Name cannot be empty.');
  }
  if (!nameRegx.test(signupName.value)) {
    signupMessages.push('Name must contain 4 to 30 alphabets only.');
  }

  // Email Validation
  if (signupEmail.value == '' || signupEmail.value == null) {
    signupMessages.push('Email cannot be empty.');
  }
  if (!emailRegx.test(signupEmail.value)) {
    signupMessages.push('Enter a valid email');
  }

  // Password Validation
  if (signupPassword.value == '' || signupPassword.value == null) {
    signupMessages.push('Password cannot be empty.');
  }
  if (!passRegx.test(signupPassword.value)) {
    signupMessages.push('Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase.');
  }
  if (signupConfirmPass.value == '' || signupConfirmPass.value == null) {
    signupMessages.push('Confirm Password cannot be empty.');
  }
  if (signupPassword.value != signupConfirmPass.value) {
    signupMessages.push('Password do not match.');
  }

  if (signupMessages.length > 0) {
    e.preventDefault();
    loginError.innerHTML = "";
    signupError.innerHTML = signupMessages.join('<br> ');
  }
  else {
    signupError.innerHTML = "";
  }
});