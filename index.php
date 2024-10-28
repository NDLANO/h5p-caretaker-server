<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>H5P Caretaker Reference Client</title>
  <link rel="stylesheet" href="node_modules/h5p-caretaker-client/styles/main.css" />
  <script type="module" src="node_modules/h5p-caretaker-client/index.js"></script>
</head>
<body class="h5p-caretaker">

  <header class="header">
    <h1 class="title main-color">H5P Caretaker</h1>
    <select class="select-language" name="language" id="select-language">
      <option value="de">Deutsch</option>
      <option value="en" selected="selected">English</option>
    </select>
  </header>

  <main class="page" data-upload-endpoint="./upload.php">
    <p class="main-color">Take care of your H5P</p>
    <h2 class="title">Check your H5P file for improvements</h2>
    <p>
      Upload your H5P file and uncover accessibility issues, missing information and best practices that can help you
      improve youe H5P content.
    </p>

    <div class="dropzone">
      <!-- Will be filled by dropzone.js -->
    </div>

    <div class="output">
      <!-- Will be filled by main.js -->
    </div>

  </main>

</body>
</html>
