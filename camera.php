<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hello there !</title>
    <style>
        .camera-box{
            display: none;
            width: auto;
            height: auto;
        }
        #my_camera{
            box-sizing: border-box;
            overflow: hidden;
        }
        video { 
            width: 100%;
        }
        #results{
            width: auto;
            height: auto;
        }
        #results img{
            width: auto;
        }
    </style>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container-50">
            <div class="box">
                <button id="openCamera" class="btn-1">Click Here to open camera</button>
                <div class="camera-box">
                    <div id="my_camera" style="margin: 0 auto;"></div><br>
                    <div class="center">
                        <button class="btn-1" onclick="take_snapshot()">Take Snapshot</button>
                        <button class="btn-1" id="closeCamera">Close</button>
                    </div>
                </div>
            </div>
            <div class="box">
                <div id="results">Your captured image will appear here...</div>
            </div>
        </div>
    <!-- webcamjs  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
    <script language="JavaScript">
        // menampilkan kamera dengan menentukan ukuran, format dan kualitas 
        Webcam.set({
            width: 600,
            height: 420,
            image_format: 'jpeg',
            jpeg_quality: 90,
            flip_horiz: true
        });

        $(document).ready(function(){
            $("#openCamera").click(function(){
                $(".camera-box").show();
                $("#openCamera").hide();
                Webcam.attach('#my_camera');
            });

            $("#closeCamera").click(function(){
                $(".camera-box").hide();
                $("#openCamera").show();
                Webcam.reset('#my_camera');
            })
        });
    </script>
	<!-- Code to handle taking the snapshot and displaying it locally -->
	<script language="JavaScript">
		function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				document.getElementById('results').innerHTML = 
					'<h2>Here is your image:</h2>' + 
					'<img src="'+data_uri+'"/>';
			} );
		}
	</script>
    </div>
</body>
</html>