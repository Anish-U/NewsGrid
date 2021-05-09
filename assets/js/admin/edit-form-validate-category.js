var editForm = document.getElementById("edit_form");
var imgPreview = document.getElementById("image_preview");
var imgInp = document.getElementById("category_img");

var categoryTitle = document.getElementById("category_title");
var categoryDesc = document.getElementById("category_desc");
var categoryColor = document.getElementById("category_color");

var descError = document.getElementById("error-desc");
var titleError = document.getElementById("error-title");
var imgError = document.getElementById("error-img");
var catError = document.getElementById("error-cat");

let titleRegex = new RegExp(/^[-@.,?\/#&+\w\s:;\’\'\"\`]{3,20}$/);

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

editForm.addEventListener("keyup", function (e) {
  if (categoryDesc.value == "" || categoryDesc.value == null) {
    e.preventDefault();
    descError.innerHTML = "Description cannot be empty !";
  } else if (categoryDesc.value.length < 100) {
    e.preventDefault();
    descError.innerHTML =
      "Description should be of minimum of 100 characters long";
  } else {
    descError.innerHTML = "";
  }

  if (categoryColor.value == "0") {
    e.preventDefault();
    catError.innerHTML = "Please Select a Color";
  } else {
    catError.innerHTML = "";
  }

  if (categoryTitle.value == "" || categoryTitle.value == null) {
    e.preventDefault();
    titleError.innerHTML = "Title cannot be empty !";
  } else if (!titleRegex.test(categoryTitle.value)) {
    e.preventDefault();
    titleError.innerHTML =
      "category should contain minimum of 3 alphanumeric characters long";
  } else {
    titleError.innerHTML = "";
  }
});

editForm.addEventListener("change", function (e) {
  if (categoryDesc.value == "" || categoryDesc.value == null) {
    e.preventDefault();
    descError.innerHTML = "Description cannot be empty !";
  } else if (categoryDesc.value.length < 100) {
    e.preventDefault();
    descError.innerHTML =
      "Description should be of minimum of 100 characters long";
  } else {
    descError.innerHTML = "";
  }

  if (categoryColor.value == "0") {
    e.preventDefault();
    catError.innerHTML = "Please Select a Color";
  } else {
    catError.innerHTML = "";
  }

  if (categoryTitle.value == "" || categoryTitle.value == null) {
    e.preventDefault();
    titleError.innerHTML = "Title cannot be empty !";
  } else if (!titleRegex.test(categoryTitle.value)) {
    e.preventDefault();
    titleError.innerHTML =
      "category should contain minimum of 3 alphanumeric characters long";
  } else {
    titleError.innerHTML = "";
  }
});

editForm.addEventListener("submit", function (e) {
  if (categoryDesc.value == "" || categoryDesc.value == null) {
    e.preventDefault();
    descError.innerHTML = "Description cannot be empty !";
  } else if (categoryDesc.value.length < 100) {
    e.preventDefault();
    descError.innerHTML =
      "Description should be of minimum of 100 characters long";
  } else {
    descError.innerHTML = "";
  }

  if (categoryColor.value == "0") {
    e.preventDefault();
    catError.innerHTML = "Please Select a Color";
  } else {
    catError.innerHTML = "";
  }

  if (categoryTitle.value == "" || categoryTitle.value == null) {
    e.preventDefault();
    titleError.innerHTML = "Title cannot be empty !";
  } else if (!titleRegex.test(categoryTitle.value)) {
    e.preventDefault();
    titleError.innerHTML =
      "category should contain minimum of 3 alphanumeric characters long";
  } else {
    titleError.innerHTML = "";
  }
});
