<?php

?>

<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<form enctype="multipart/form-data" method="post" action="upload.php" >
    <div class="row">
        <div class="col-md-12">
            <input type="file" name="file" id="file"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input value="Subir informacion" name="submit" type="submit">
        </div>
    </div>
</form>

</body>
</html>