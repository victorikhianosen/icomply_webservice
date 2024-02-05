<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>File Upload</title>
        <style>
            body {
                padding: 20px;
            }
        </style>
</head>
<h1>File Upload</h1>
<input type="file" id="fileInput">
{{-- <input type="text" id="queryStringInput" placeholder="Query String"> --}}
<textarea id="queryStringInput" cols="30" rows="10" placeholder="Query String"></textarea>
<button onclick="uploadFile()">Upload</button>
<script>
    function uploadFile() {
            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];

            if (!file) {
                alert('Please select a file.');
                return;
            }

            const queryStringInput = document.getElementById('queryStringInput');
            const queryString = queryStringInput.value;

            const formData = new FormData();
            formData.append('query', queryString);
            formData.append('file', file);

            fetch('https://api.example.com/upload', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    alert('File uploaded successfully.');
                } else {
                    alert('File upload failed.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during the file upload.');
            });
        }
</script>
</body>
</html>