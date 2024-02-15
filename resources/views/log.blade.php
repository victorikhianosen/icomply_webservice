<!DOCTYPE html>
<html>

<head>
    <title>Laravel Log Viewer</title>
    <style>
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }

        .content-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 50px;
            /* Adjust the space above the content as needed */
            margin-bottom: 50px;
            /* Adjust the space below the content as needed */
        }

        /* If you need additional spacing specifically above the h1 or below the select */
        h1 {
            margin-bottom: 20px;
            /* Space below the h1 */
        }

        select {
            margin-top: 20px;
            /* Space above the select, if needed */
        }
    </style>
</head>
@php

@endphp

<body>
    <div class="content-center">
        <h1>Laravel Log Viewer</h1>
        <select id="logDate" onchange="loadLog()">
            <option value="">Select a date</option>
            @foreach($dates as $date)
            <option value="{{ $date }}">{{ $date }}</option>
            @endforeach
        </select>
    </div>
    <div id="logContent" style="width: 100%; overflow: auto;"></div>
    <script>
        var link = "<?php echo $link; ?>";
    
      function loadLog() {
        var date = document.getElementById("logDate").value;
        if (!date) {
          document.getElementById("logContent").innerHTML = "";
          return;
        }
        
        var fetchUrl = link + "/api/logs/" + date; // Add a forward slash before "api/logs"
        
        fetch(fetchUrl)
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            console.log(fetchUrl)
            return response.text();
          })
          .then(text => {
            highlightAndDisplayLog(text);
          })
          .catch(error => {
            console.error("Failed to fetch log:", error);
            document.getElementById("logContent").innerHTML = "<p>Error loading log content.</p>";
          });
      }
      
      function highlightAndDisplayLog(logText) {
        // Regular expression to match dates and times in the format [YYYY-MM-DD HH:MM:SS]
        var regex = /(\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\])/g;
    
        // Replace matched dates and times with highlighted version
        var highlightedText = logText.replace(regex, '<span class="highlight">$1</span>');
        // Update the log content with highlighted dates and times
        document.getElementById("logContent").innerHTML = highlightedText;
      }
    </script>
</body>

</html>