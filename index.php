<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Subir Archivo</title>
	<script src="js/jquery-1.9.1.js"></script>
</head>
<body>
	<center>
		<h3>Upload File Ajax Multiple</h3>
	    <input id="upload_file" type="file" multiple onchange="readSize(this)"/>
	    <button onclick="uploadExecute()">Subir Archivo</button>
		<br>
		Progress: <progress value="0"></progress>		
		<ul id='filesAdj' style="list-style:none;"></ul>

		<hr>

		<div id="resultsList"></div>
	</center>
	<script>
		var file, formData;
		function readSize(){
			$("#filesAdj").html("");
			file = document.getElementById("upload_file").files;

			formData = new FormData();
			for( var i=0;i<=file.length-1;i++ ){
				// console.log(file[i].name +" "+file[i].size);
				$("#filesAdj").append("<li>"+file[i].name +" "+file[i].size+"</li>");
				formData.append("uploaded_file[]", file[i]);
			}
            formData.append("enctype",'multipart/form-data');
		    // if (file.size > 1024) {
		    //     alert('max upload size is 1k');
		    // }
		}
		function uploadExecute(){
			
		    $.ajax({
		        // Dirección del archivo a ejecutar en el servidor
		        url: 'upload_file.php',
		        type: 'POST',
		        data: formData, //adjuntamos el paquete
		        cache: false,
		        contentType: false,
		        processData: false,

		        // Configuración Personalizada XMLHttpRequest
		        xhr: function() {
		            var myXhr = $.ajaxSettings.xhr();
		            if (myXhr.upload) {
		                // Obtenemos Progresivamente el nivel de carga del archivo
		                myXhr.upload.addEventListener('progress', function(e) {
		                    if (e.lengthComputable) {
		                    	console.log(e.loaded);
		                    	//Actualizamos la etiqueta PROGRESS segun su nivel de carga del archivo
		                        $('progress').attr({
		                            value: e.loaded,
		                            max: e.total,
		                        });
		                    }
		                } , false);
		            }
		            return myXhr;
		        },success: function(data, status, xhr) {
		        	//Imprimimos Resultados del archivo "upload_file.php" desde el servidor
				    $("#resultsList").html(data);
				}
		    }).done(function() {
		    	//Mensaje que indica que se a finalizado
			    console.log("Upload finished.");
			});
		}
	</script>
</body>
</html>