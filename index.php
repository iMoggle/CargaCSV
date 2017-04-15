<?php
?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
</head>
<body>
<div class="container">
    <form id="frm_carga" enctype="multipart/form-data" method="post" action="upload.php">
        <div class="form-group">
            <h3>Carga de archivos bancarios</h3>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-2">
                    <label class="btn btn-default" for="in_archivo_selector">
                        <input id="in_archivo_selector" name="file" type="file" style="display:none;"
                               onchange="$('#in_archivo_info').val($(this).val()).show();">
                        Selecciona un archivo
                    </label>
                </div>
                <div class="col-md-10">
                    <label class="sr-only" for="in_archivo_info">Ruta:</label>
                    <input id="in_archivo_info" name="path" class="form-control" type="text" style="display: none;"
                           readonly="readonly">
                </div>
            </div>
        </div>
        <div class="form-group">
            <button name="submit" class="btn btn-primary" type="submit">Subir informacion</button>
        </div>
        <div class="form-group">
            <div id="dv_resultado">

            </div>
        </div>

    </form>
</div>

<script src="js/jquery-3.2.0.min.js"></script>
<script src="js/bootstrap.js"></script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>-->
<script>
    $(document).ready(function () {
        $("#frm_carga").submit(function (event) {
            event.preventDefault();
            var file_data = $("#in_archivo_selector").prop("files")[0];
            var form_data = new FormData();
            form_data.append("file", file_data);
            $.ajax({
                url: 'upload.php',
                dataType: 'text',
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $("#dv_resultado").html(data);
                    $("#dv_resultadostable").show("slow");
                }
            });
        })
    });
</script>
</body>
</html>