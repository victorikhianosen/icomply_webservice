<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form id="uploadForm">
        <div style="margin: 30px;">
            <label for="queryInput">SQL Query:</label>
            <input type="text" id="queryInput" name="query">
        </div>
        <div style="margin: 30px">
            <label for="fileInput">File:</label>
            <input type="file" id="fileInput" name="file">
        </div>
        <button type="submit">Upload</button>
    </form>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function (e) {
      e.preventDefault(); // Prevent form submission
    
      var form = e.target;
      var query = form.elements.query.value;
      var file = form.elements.file.files[0];
    
      var formData = new FormData();
      formData.append('sql', query);
      formData.append('file', file);
    
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'http://139.59.186.114/icomply_webservice/public/index.php/api/send-request');
      xhr.onload = function () {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          console.log(response); // Handle the response data
          alert('Request submitted successfully.');
        } else {
          console.error('Request failed.');
          alert('An error occurred during the request.');
        }
      };
      xhr.send(formData);
    });
    </script>
</body>
</html>
