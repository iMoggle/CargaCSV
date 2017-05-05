<!--
* Created by PhpStorm.
* User: Francisco Javier Montiel Morán
* Email: francisco.montiel@enlace.mx
* Date: 17/03/2017
* Time: 04:17 PM
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/layout.css">
</head>
<body>
<div class="container">
    <form id="frm_carga" enctype="multipart/form-data" method="post" action="upload.php">
        <div class="form-group">
            <h3>Carga de archivos bancarios</h3>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12"><span>Selecciona el archivo de movimientos (Banamex / Santander)</span></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label class="btn btn-default" for="in_archivo_selector">
                        <input id="in_archivo_selector" name="file" type="file" style="display:none;"
                               onchange="$('#in_archivo_info').val($(this).val()).show();">
                        Movimientos:
                    </label>
                </div>
                <div class="col-md-10">
                    <label class="sr-only" for="in_archivo_info">Ruta:</label>
                    <input id="in_archivo_info" name="path" class="form-control" type="text" style="display: none;"
                           readonly="readonly">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><span>Selecciona el archivo del Centro de Pagos (Santander)</span></div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-2">
                    <label class="btn btn-default" for="in_archivo_selector2">
                        <input id="in_archivo_selector2" name="file2" type="file" style="display:none;"
                               onchange="$('#in_archivo_info2').val($(this).val()).show();">
                        Centro de Pagos:
                    </label>
                </div>
                <div class="col-md-10">
                    <label class="sr-only" for="in_archivo_info2">Ruta:</label>
                    <input id="in_archivo_info2" name="path" class="form-control" type="text" style="display: none;"
                           readonly="readonly">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><span>Selecciona el archivo de Cargos Automaticos (Santander)</span></div>
        </div>

        <div class="form-group">
            <button name="submit" class="btn btn-primary" type="submit">Subir informacion</button>
        </div>
    </form>
    <div class="form-group">
        <div id="dv_resultado">
        </div>
        <div id="dv_controles">
            <button id="btnToExcel" class="btn btn-primary">Exportar Excel</button>
        </div>
    </div>
</div>

<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="js/jquery.table2excel.min.js"></script>
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
                    $("#resultadostable").tablesorter();
                }
            });
        });
        $("#btnToExcel").click(function () {

            $("#resultadostable").table2excel({
                exclude: ".noExl",
                filename: "ArchivoProcesado" //do not include extension
            });
        });
    });
</script>
</body>
</html>