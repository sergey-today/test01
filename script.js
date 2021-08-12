const inputFile = document.getElementById('form_upload');
const dropZone = document.getElementById('label_form_upload');
const dropZoneText = document.getElementById('label_check_drop');

let fileList;
let fileCheck = true;

function checkDragAndDrop() {
  if (typeof (window.FileReader) == 'undefined') {
    dropZoneText.textContent = 'Нажмите здесь, что бы выбрать файлы.';
  } else {
    dropZoneText.textContent = 'Нажмите, что бы выбрать файлы, или просто перетащите их сюда.';
  }
}

function checkFile() {
  fileCheck = true;
  if (fileList.length > 5) {
    document.querySelectorAll('.upload_img').forEach(e => e.remove());
    dropZoneText.textContent = 'Можно прикрепить до 5 фото, выберите меньшее количество файлов.';
    dropZoneText.classList.remove('opacity');
    inputFile.value = '';
  } else {
    if (fileList.length) {
      for ( var i = 0 ; i < fileList.length ; i++ ) {
            if ((fileList[i].type == 'image/jpeg' || fileList[i].type == 'image/jeg') && fileList[i].size < 1024 * 1024 * 0.3 && fileCheck) {
          fileCheck = true;
        } else {
          document.querySelectorAll('.upload_img').forEach(e => e.remove());
          dropZoneText.textContent = 'Можно загружать только файлы формата .JPG или .JPEG, до 300KB каждый.';
          dropZoneText.classList.remove('opacity');
          fileCheck = false;
          inputFile.value = '';
        }
      }
      if (fileCheck) labelContent();
    } else {
      document.querySelectorAll('.upload_img').forEach(e => e.remove());
      dropZoneText.classList.remove('opacity');
      checkDragAndDrop();
    }
  }
}

function labelContent() {
  checkDragAndDrop();
  document.querySelectorAll('.upload_img').forEach(e => e.remove());
  dropZoneText.classList.add('opacity');
  for ( var i = 0 ; i < fileList.length ; i++ ) {
    let reader = new FileReader()
    reader.readAsDataURL(fileList[i]);
    reader.onload = (e) => {
      dropZone.insertAdjacentHTML(
        'afterbegin', 
        '<div class="upload_img" style="background-image: url('+e.target.result+');"></div>'
      );
    }
  }
}

checkDragAndDrop();

inputFile.addEventListener('input', function() {
  fileList = inputFile.files;
  checkFile();
});

dropZone.addEventListener('click', function() {
  fileList = inputFile.files;
  checkFile();
  document.getElementById('response_div').innerHTML = 'Заполните все поля формы<br>и при необходимости прикрепите фото.';
});

dropZone.ondragover = function() {
  this.classList.add('hover');
  return false;
};

dropZone.ondragleave = function() {
  this.classList.remove('hover');
  return false;
};

dropZone.ondrop = function(e) {
  this.classList.remove('hover');
  e.preventDefault();
  fileList = inputFile.files = e.dataTransfer.files;
  checkFile();
}

document.getElementById('form_submit').addEventListener('click', function() {

  name = document.getElementById('form_name').value.match(/^[a-zа-яё0-9\s-]{1,100}$/ui);
  phone = document.getElementById('form_phone').value.match(/^[0-9\_\-\(\)\+\-\s.]{1,99}$/);
  email = document.getElementById('form_email').value.match(/^[a-z0-9\!\#\$\%\&\*\+\-\/\=\?\_\{\|\}\~\(\)\,\:\@\.]{1,256}$/);

  if (name && phone && email) {

    if (fileCheck) {

      data = new FormData();
      data.append('name',  name);
      data.append('phone', phone);
      data.append('email', email);

      xhr = new XMLHttpRequest();
      xhr.open("POST", "https://sergey.today/tests/test01/handler_post.php");
      xhr.responseType = 'json';
      xhr.send(data);

      xhr.onload = function() {

        if (xhr.response.status === true && fileList) {

          data_files = new FormData();
          data_files.append('user_id', xhr.response.user_id);
          for ( var i = 0 ; i < fileList.length ; i++ ) {
            data_files.append('upload[]', fileList[i]);
          }

          xhr_files = new XMLHttpRequest();
          xhr_files.open("POST", "https://sergey.today/tests/test01/handler_files.php");
          xhr_files.responseType = 'json';
          xhr_files.send(data_files);

          xhr_files.onload = function(){
            document.getElementById('form_div').innerHTML = xhr.response.message;
          }

        } else {

          document.getElementById('form_div').innerHTML = xhr.response.message;

        }

      }

    } else {

      document.getElementById('response_div').innerHTML = '<p id="form_error">Прикрепленные файлы не соответсвуют требованиям,<br>выберите другие.</p>';

    }

  } else {

    document.getElementById('response_div').innerHTML = '<p id="form_error">Для отправки формы нужно заполнить<br>все поля валидными данными.</p>';

  }

});