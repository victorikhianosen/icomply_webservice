<form id="uploadForm">
    <div>
        <label for="queryStringInput">Query String API Key:</label>
        <input type="text" id="queryStringInput" name="queryStringApiKey">
    </div>
    <div>
        <label for="fileInput">File API Key:</label>
        <input type="text" id="fileInput" name="fileApiKey">
    </div>
    <div>
        <label for="queryInput">Query String:</label>
        <input type="text" id="queryInput" name="query">
    </div>
    <div>
        <label for="fileInput">File:</label>
        <input type="file" id="fileInput" name="file">
    </div>
    <button type="submit">Submit</button>
</form>
<script>
    document.getElementById('uploadForm').addEventListener('submit', function (e) {
  e.preventDefault(); // Prevent form submission

  var form = e.target;
  var queryStringApiKey = form.elements.queryStringApiKey.value;
  var fileApiKey = form.elements.fileApiKey.value;
  var query = form.elements.query.value;
  var file = form.elements.file.files[0];

  var formData = new FormData();
  formData.append('queryStringApiKey', queryStringApiKey);
  formData.append('fileApiKey', fileApiKey);
  formData.append('query', query);
  formData.append('file', file);

  fetch('/api/send-request', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    if (response.ok) {
      return response.json(); // Parse the JSON response
    } else {
      throw new Error('Request failed.');
    }
  })
  .then(data => {
    console.log(data); // Handle the response data
    alert('Request submitted successfully.');
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred during the request.');
  });
});
</script>