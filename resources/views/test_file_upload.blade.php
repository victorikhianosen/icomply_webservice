<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <label for="textInput">Text:</label>
        <input type="text" id="textInput" name="text">
    </div>
    <div>
        <label for="fileInput">File:</label>
        <input type="file" id="fileInput" name="file">
    </div>
    <button id="submitButton">Upload</button>

    <div id="preview"></div>
    <div id="err"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var submitButton = document.getElementById("submitButton");

            submitButton.addEventListener("click", function () {
                var formData = new FormData();
                formData.append("sql", document.getElementById("textInput").value);

                var fileInput = document.getElementById("fileInput");
                if (fileInput.files.length > 0) {
                    formData.append("file", fileInput.files[0]);
                }

                fetch("http://139.59.186.114/icomply_webservice/public/index.php/api/send-request", {
                    method: "POST",
                    body: formData
                })
                    .then(function (response) {
                        if (response.ok) {
                            return response.text();
                        } else {
                            throw new Error("Error: " + response.status);
                        }
                    })
                    .then(function (data) {
                        if (data === "invalid") {
                            document.getElementById("err").innerHTML = "Invalid File!";
                            document.getElementById("err").style.display = "block";
                        } else {
                            document.getElementById("preview").innerHTML = data;
                            document.getElementById("preview").style.display = "block";
                            document.getElementById("textInput").value = ""; // Clear text input
                            document.getElementById("fileInput").value = ""; // Clear file input
                            console.log("Upload successful!"); // Display success message in the console
                        }
                    })
                    .catch(function (error) {
                        document.getElementById("err").innerHTML = error.message;
                        document.getElementById("err").style.display = "block";
                    });
            });
        });
    </script>
</body>

</html>