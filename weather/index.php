<?php
$connect = mysqli_connect("localhost","----","------")or die(mysqli_error());
$db = "----";
$a = mysqli_query($connect, "SELECT * FROM $db.`RaspberryPiWeatherLog` WHERE `Datum` LIKE '".date("Y-m-d")."%'");
if (!$a) {
	printf("Error: %s\n", mysqli_error($connect));
	exit();
}
$hom = array();
$parat = array();
$harmatp = array();
$idok = array();

while($b = mysqli_fetch_array($a)) {
	array_push($hom, $b['Homerseklet']);
	array_push($parat, $b['Paratartalom']);
	array_push($harmatp, $b['Harmatpont']);
	$mikor = $b['Datum'];
	$mikor = explode(" ", $mikor);
	$mikor = explode(":", $mikor[1]);
	array_push($idok, $mikor[0].":".$mikor[1]);
}


$datah = json_encode($hom);
$datai = json_encode($idok);
$dataha = json_encode($harmatp);
$datap = json_encode($parat);
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>Időjárás</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="favicon.ico">

        <!--Google Font link-->
        <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">


        <link rel="stylesheet" href="assets/css/swiper.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/iconfont.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <link rel="stylesheet" href="assets/css/bootsnav.css">
		<script src="assets/js/Chart.min.js"></script>



        <!--For Plugins external css-->
        <!--<link rel="stylesheet" href="assets/css/plugins.css" />-->
        <!--Theme custom css -->
        <link rel="stylesheet" href="assets/css/style.css">

        <!--Theme Responsive css-->
        <link rel="stylesheet" href="assets/css/responsive.css" />

        <script src="assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>

    <body data-spy="scroll" data-target=".navbar-collapse">


        <!-- Preloader -->
        <div id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_four"></div>
                </div>
            </div>
        </div><!--End off Preloader -->


        <div class="culmn">
            <!--Home page style-->


            <nav class="navbar navbar-default bootsnav navbar-fixed white no-background">
                <div class="container">  

                    <!-- Start Atribute Navigation -->
                    <div class="attr-nav">
                    </div>        
                    <!-- End Atribute Navigation -->


                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="#brand">
                            <img src="assets/images/logo.png" class="logo logo-display" alt="">
                            <img src="assets/images/footer-logo.png" class="logo logo-scrolled" alt="">
                        </a>

                    </div>
                    <!-- End Header Navigation -->

                    <!-- navbar menu -->
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-center">
                            <li><a href="#home">Főoldal</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>   
            </nav>
            <section id="home">
                <div class="container">
                    <div class="row">
                        <div class="main_drag roomy-50">
                            <div class="col-md-12">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide" style="background-image:url(assets/images/dragma.png)"></div>
										<?php
										$files = scandir('assets/images/drags/', SCANDIR_SORT_DESCENDING);
										if($files[0] && $files[0] != '.' && $files[0] != '..') echo '<div class="swiper-slide" style="background-image:url(assets/images/drags/'.$files[0].')"></div>';
										if($files[1] && $files[1] != '.' && $files[1] != '..') echo '<div class="swiper-slide" style="background-image:url(assets/images/drags/'.$files[1].')"></div>';
										if($files[2] && $files[2] != '.' && $files[2] != '..') echo '<div class="swiper-slide" style="background-image:url(assets/images/drags/'.$files[2].')"></div>';
										if($files[3] && $files[3] != '.' && $files[3] != '..') echo '<div class="swiper-slide" style="background-image:url(assets/images/drags/'.$files[3].')"></div>';
										?>
                                    </div>
                                    <!-- If we need navigation buttons -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- scroll up-->
            <div class="scrollup">
                <a href="#"><i class="fa fa-chevron-up"></i></a>
            </div><!-- End off scroll up -->
            
			
			<section id="screen_area2" class="screen_area">
                <div class="container">
                    <div class="row">
                        <div class="main_screen">
                            <div class="col-md-8 col-md-offset-2 col-sm-12">
                                <div class="head_title text-center">
                                    <h2>Mai nap</h2>
									<canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas><script>new Chart(document.getElementById("chartjs-0"),{"type":"line","data":{"labels":<?php echo $datai;?>,"datasets":[{"label":"Hőmérséklet","data":<?php echo $datah; ?>,"fill":false,"borderColor":"rgb(75, 192, 192)","lineTension":0.1},{"label":"Páratartalom","data":<?php echo $datap; ?>,"fill":false,"borderColor":"rgb(66, 244, 95)","lineTension":0.1},{"label":"Harmatpont","data":<?php echo $dataha; ?>,"fill":false,"borderColor":"rgb(194, 66, 244)","lineTension":0.1}]},"options":{}});</script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
			
			 <section id="screen_area" class="screen_area">
                <div class="container">
                    <div class="row">
                        <div class="main_screen">
                            <div class="col-md-8 col-md-offset-2 col-sm-12">
                                <div class="head_title text-center">
                                    <h2>Bővebben</h2>
                                    <h5>Válassz egy napot!<br><select name="napok" id="napok">
  <option value="none" ></option>
  <option value="<?php echo date("Y-m-d"); ?>" >Ma</option>
  <?php
	$files = scandir('assets/images/drags/', SCANDIR_SORT_DESCENDING);
	foreach($files as $v) {
		if($v == '.' || $v == '..') continue;
		else {
			$v = explode("drag", $v);
			$v = explode(".png", $v[1]);
			$ev = substr($v[0], 0, 4);
			$ho = substr($v[0], 4, 2);
			$nap = substr($v[0], 6, 2);
			echo '<option value="'.$ev.'-'.$ho.'-'.$nap.'" >'.$ev.'-'.$ho.'-'.$nap.'</option>';
		}
	}
  ?>
</select></h5>
                                </div>
                            </div>

                            <!-- Screen01-->
                            <div class="screen01 roomy-50">
                                <div class="col-md-12">
                                    <div class="text-center" id="show">
                                        
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </section>
            
            <footer id="footer" class="footer bg-black">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <nav class="navbar navbar-default bootsnav footer-menu no-background">
                                <div class="container">  

                                    <div class="attr-nav">
                                    </div>        


                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-footer">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                        <a class="navbar-brand" href="#brand"><img src="assets/images/footer-logo.png" class="logo" alt=""></a>
                                    </div>
                                    <!-- End Header Navigation -->

                                    <!-- navbar menu -->
                                    <div class="collapse navbar-collapse" id="navbar-footer">
                                        <ul class="nav navbar-nav navbar-center">
                                            <li><a href="#home">Főoldal</a></li>
                                        </ul>
                                    </div><!-- /.navbar-collapse -->
                                </div>   
                            </nav>
                        </div>
                        <div class="divider"></div>
                        <div class="col-md-12">
                            <div class="main_footer text-center p-top-40 p-bottom-30">
                                <p class="wow fadeInRight" data-wow-duration="1s">
                                    Made with 
                                    <i class="fa fa-heart"></i>
                                    by 
                                    <a target="_blank" href="http://bootstrapthemes.co">Bootstrap Themes</a> 
                                    2016-<?php echo date("Y"); ?>. All Rights Reserved
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>




        </div>

        <!-- JS includes -->

        <script src="assets/js/vendor/jquery-1.11.2.min.js"></script>
		<script type="text/javascript">
  $(document).ready(function(){ 
    $("#napok").change(function(){ 
      var napok = $(this).val(); 
      var dataString = "napok="+napok;

      $.ajax({ 
        type: "POST",
        url: "bovebben.php", 
        data: dataString,
        success: function(result){ 
          $("#show").html(result);
        }
      });

    });
  });
</script>
        <script src="assets/js/vendor/bootstrap.min.js"></script>
		
        <script src="assets/js/jquery.magnific-popup.js"></script>
        <script src="assets/js/jquery.easing.1.3.js"></script>
        <script src="assets/js/swiper.min.js"></script>
        <script src="assets/js/jquery.collapse.js"></script>
        <script src="assets/js/bootsnav.js"></script>



        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/main.js"></script>

    </body>
</html>
