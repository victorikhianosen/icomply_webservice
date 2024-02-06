<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>
    <form id="uploadForm">
        <div>
            <label for="textInput">Text:</label>
            <input type="text" id="textInput" name="text">
        </div>
        <div>
            <label for="fileInput">File:</label>
            <input type="file" id="fileInput" name="file">
        </div>
        <button type="submit">Upload</button>
    </form>

    <div id="preview"></div>
    <div id="err"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
       $(document).ready(function (e) {
  $("#uploadForm").on('submit', function (e) {
    e.preventDefault();

    var formData = new FormData();
    formData.append("sql", $("#textInput").val());
    formData.append("_token", $('meta[name="csrf-token"]').attr('content')); // Add CSRF token

    var fileInput = $("#fileInput")[0];
    if (fileInput.files.length > 0) {
      formData.append("file", fileInput.files[0]);
    }

    $.ajax({
      url: "http://139.59.186.114/icomply_webservice/public/index.php/api/send-request",
      type: "POST",
      headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Set CSRF token in headers
    },
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $("#err").fadeOut();
      },
      success: function (data) {
        if (data === 'invalid') {
          $("#err").html("Invalid File!").fadeIn();
        } else {
          $("#preview").html(data).fadeIn();
          $("#uploadForm")[0].reset();
        }
      },
      error: function (e) {
        $("#err").html(e).fadeIn();
      }
    });
  });
});
    </script>

</body>

</html>