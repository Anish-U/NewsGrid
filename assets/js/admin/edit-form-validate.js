var editForm = document.getElementById('edit_form');
var imgPreview = document.getElementById('image_preview');
var imgInp = document.getElementById('article_img');
var articleTitle = document.getElementById('article_title');
var articleDesc = document.getElementById('article_desc');
var descError = document.getElementById('error-desc');
var titleError = document.getElementById('error-title');

let titleRegx = new RegExp(/^[-@.,?\/#&+\w\s:;\’\'\"\`]{30,500}$/);

editForm.addEventListener("keyup", function (e) {
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

editForm.addEventListener("submit", function (e) {
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

imgInp.addEventListener("change", function () {
  var file = this.files[0];

  if (file) {
    var reader = new FileReader();
    reader.addEventListener("load", function () {
      imgPreview.setAttribute("src", this.result);
    });
    reader.readAsDataURL(file);
  }
});