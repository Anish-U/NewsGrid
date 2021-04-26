var imgPreview = document.getElementById('image_preview');

var articleImage = document.getElementById('article_img');
var addForm = document.getElementById('add_form');
var articleTitle = document.getElementById('article_title');
var articleDesc = document.getElementById('article_desc');
var articleCategory = document.getElementById('category');

var descError = document.getElementById('error-desc');
var titleError = document.getElementById('error-title');
var imgError = document.getElementById('error-img');
var catError = document.getElementById('error-cat');

var titleRegx = new RegExp(/^[-@.,?\/#&+\w\s:;\’\'\"\`]{30,500}$/);

articleImage.addEventListener("change", function () {
  var file = this.files[0];

  if (file) {
    var reader = new FileReader();
    reader.addEventListener("load", function () {
      imgPreview.setAttribute("src", this.result);
    });
    reader.readAsDataURL(file);
  }
});

addForm.addEventListener("keyup", function (e) {
  var image = document.getElementById('article_img');
  if (articleDesc.value == '' || articleDesc.value == null) {
    e.preventDefault();
    descError.innerHTML = "Description cannot be empty !";
  }
  else if (articleDesc.value.length < 1000) {
    e.preventDefault();
    descError.innerHTML = "Description should be of minimum of 1000 characters long";
  }
  else {
    descError.innerHTML = "";
  }

  if (image.validity.valueMissing) {
    e.preventDefault();
    imgError.innerHTML = "Please Select an Image";
  } else {
    imgError.innerHTML = "";
  }

  if (articleCategory.value == "0") {
    e.preventDefault();
    catError.innerHTML = "Please Select a Category";
  } else {
    catError.innerHTML = "";
  }

  if (articleTitle.value == '' || articleTitle.value == null) {
    e.preventDefault();
    titleError.innerHTML = "Title cannot be empty !";
  }
  else if (!titleRegx.test(articleTitle.value)) {
    e.preventDefault();
    titleError.innerHTML = "Article should contain minimum of 30 alphanumeric characters long"
  }
  else {
    titleError.innerHTML = "";
  }
});

addForm.addEventListener("submit", function (e) {
  if (articleDesc.value == '' || articleDesc.value == null) {
    e.preventDefault();
    descError.innerHTML = "Description cannot be empty !";
  }
  else if (articleDesc.value.length < 1000) {
    e.preventDefault();
    descError.innerHTML = "Description should be of minimum of 1000 characters long";
  }
  else {
    descError.innerHTML = "";
  }

  if (articleImage.validity.valueMissing) {
    e.preventDefault();
    imgError.innerHTML = "Please Select an Image";
  } else {
    imgError.innerHTML = "";
  }

  if (articleCategory.value == "0") {
    e.preventDefault();
    catError.innerHTML = "Please Select a Category";
  } else {
    catError.innerHTML = "";
  }

  if (articleTitle.value == '' || articleTitle.value == null) {
    e.preventDefault();
    titleError.innerHTML = "Title cannot be empty !";
  }
  else if (!titleRegx.test(articleTitle.value)) {
    e.preventDefault();
    titleError.innerHTML = "Article should contain minimum of 30 alphanumeric characters long"
  }
  else {
    titleError.innerHTML = "";
  }
});

addForm.addEventListener("change", function (e) {
  if (articleDesc.value == '' || articleDesc.value == null) {
    e.preventDefault();
    descError.innerHTML = "Description cannot be empty !";
  }
  else if (articleDesc.value.length < 1000) {
    e.preventDefault();
    descError.innerHTML = "Description should be of minimum of 1000 characters long";
  }
  else {
    descError.innerHTML = "";
  }

  if (articleImage.validity.valueMissing) {
    e.preventDefault();
    imgError.innerHTML = "Please Select an Image";
  } else {
    imgError.innerHTML = "";
  }

  if (articleCategory.value == "0") {
    e.preventDefault();
    catError.innerHTML = "Please Select a Category";
  } else {
    catError.innerHTML = "";
  }

  if (articleTitle.value == '' || articleTitle.value == null) {
    e.preventDefault();
    titleError.innerHTML = "Title cannot be empty !";
  }
  else if (!titleRegx.test(articleTitle.value)) {
    e.preventDefault();
    titleError.innerHTML = "Article should contain minimum of 30 alphanumeric characters long"
  }
  else {
    titleError.innerHTML = "";
  }
});

