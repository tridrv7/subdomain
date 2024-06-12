<?PHP
require '../conf/config.php';
require '../conf/phpFunction.php';
?>

<!DOCTYPE html>
<!-- 
Template Name:  SmartAdmin Responsive WebApp - Template build with Twitter Bootstrap 4
Version: 4.0.0
Author: Sunnyat Ahmmed
Website: http://gootbootstrap.com
Purchase: https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0
License: You must have a valid license purchased only from wrapbootstrap.com (link above) in order to legally use this theme for your project.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>
            Portal Kabupaten Sidoarjo
        </title>
        <meta name="description" content="Login">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <!-- base css -->
        <link rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
        <link rel="stylesheet" media="screen, print" href="css/app.bundle.css">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
        <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <!-- toastr -->
        <link rel="stylesheet" media="screen, print" href="css/notifications/toastr/toastr.css">
        <!-- Optional: page related CSS-->
        <link rel="stylesheet" media="screen, print" href="css/page-login.css">
		<!-- style color -->
		<link id="mytheme" rel="stylesheet" href="css/themes/cust-theme-1.css">
    </head>
    <body>
        <div class="blankpage-form-field">
            <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
				<?PHP
				if(loadRecText('prof_lg', 'pub_profile', '_active=1')!==''){
					echo '<img src="'.substr($_dirProf,2).loadRecText('prof_lg', 'pub_profile', '_active=1').'" aria-roledescription="logo" style="width: 30px;">';
				} else {
					echo '<img src="img/logo-hijau.png" aria-roledescription="logo">';
				}
				?>
				<span class="page-logo-text mr-1">Portal <?=loadRecText('prof_snm', 'pub_profile', '_active=1')?></span>
            </div>
            <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
				<form id="_log" method="post">
                    <div class="form-group">
                        <label class="form-label" for="username">Email</label>
                        <input name="_pVar1" type="email" class="form-control form-control-sm" id="_pVar1" placeholder="your id or email">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input name="_pVar2" type="password" class="form-control form-control-sm" id="_pVar2" placeholder="password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Captcha</label>
						<div class="row">
							<div class="col-6">
								<h2 id="show_captcha" class="fw-900 font-italic"></h2>
							</div>
							<div class="col-6">
								<input name="math" type="text" class="form-control form-control-sm" id="math" vclass="form-control" />
							</div>
						</div>
					</div>
                    <button type="button" class="btn btn-default float-right" id="login">Sign In</button>
                </form>
            </div>
            <div class="blankpage-footer text-center">
                <a href="<?=$SERVER?>"><strong>Beranda</strong></a> |
                <a href="page_login.html#"><strong>Recover Password</strong></a>
            </div>
        </div>
        <div class="login-footer p-2">
            <div class="row">
                <div class="col col-sm-12 text-center">
                    <i><strong>Info :</strong> You IP Address from 198.164.246.1 | Saturday, March, 2017 at 10.56AM</i>
                </div>
            </div>
        </div>
        <video poster="img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
            <source src="media/video/cc.webm" type="video/webm">
            <source src="media/video/cc.mp4" type="video/mp4">
        </video>
        <!-- base vendor bundle: 
			 DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations 
						+ pace.js (recommended)
						+ jquery.js (core)
						+ jquery-ui-cust.js (core)
						+ popper.js (core)
						+ bootstrap.js (core)
						+ slimscroll.js (extension)
						+ app.navigation.js (core)
						+ ba-throttle-debounce.js (core)
						+ waves.js (extension)
						+ smartpanels.js (extension)
						+ src/../jquery-snippets.js (core) -->
        <script src="js/vendors.bundle.js"></script>
        <script src="js/app.bundle.js"></script>
        <!-- Page related scripts -->
        <!-- toastr -->
        <script src="js/notifications/toastr/toastr.js"></script>
        <!-- buttonLoader -->
        <script src="libs/buttonLoader/jquery.loadButton.js"></script>
		
	<script language="javascript">
	
		$(document).ready(function(){	
			$('#show_captcha').load('components/_captcha.php');

			$('#login').on('click', function(){
				var cekMail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	
				if($('#_pVar1').val()==""){
					// focus ke input tanggal
					$("#_pVar1").focus();
					// tampilkan peringatan data tidak boleh kosong
					toastr['warning']('Email tidak boleh kosong');
					// reload captcha
					$('#show_captcha').load('components/_captcha.php');
				}
				else if(!cekMail.test($('#_pVar1').val())){
					// focus ke input tanggal
					$("#_pVar1").focus();
					// tampilkan peringatan data tidak boleh kosong
					toastr['warning']('Email tidak valid');
					// reload captcha
					$('#show_captcha').load('components/_captcha.php');
				}
				else if($('#_pVar2').val()==""){
					// focus ke input tanggal
					$("#_pVar2").focus();
					// tampilkan peringatan data tidak boleh kosong
					toastr['warning']('Password tidak boleh kosong');
					// reload captcha
					$('#show_captcha').load('components/_captcha.php');
				}
				else if($('#math').val()==""){
					// focus ke input tanggal
					$("#math").focus();
					// tampilkan peringatan data tidak boleh kosong
					toastr['warning']('captcha tidak boleh kosong');
					// reload captcha
					$('#show_captcha').load('components/_captcha.php');
				}
				else{
                    var data = $('#_log').serialize();
					/*
					$(this).loadButton('on', {
						loadingText: 'Checking User ...',
					});
					*/
					$(this).loadButton('on',{
						faClass: 'fal',
						faIcon: 'fa-spinner-third',
						doSpin: true,
						loadingText: 'Checking User ...',
					});					
                    $.ajax({
                        type : "POST",
                        url  : "components/_log.php",
                        data : data,
						dataType : "JSON",
                        success: function(result){
							//toastr['warning'](result.codeErrors);
							
							setTimeout(function(){
								//button Loading close
								$('#login').loadButton('off');

								if (result.codeErrors==555) {
									window.location = 'http://'+result.msgErrors;
									//window.location.replace('http://'+result.msgErrors);
								} else if(result.codeErrors==501) {
									// tampilkan pesan gagal simpan data
									$('#show_captcha').load('components/_captcha.php');
									// focus ke input tanggal
									$("#math").focus();
									// tampilkan peringatan data tidak boleh kosong
									toastr['warning'](result.msgErrors);
								} else {
									// tampilkan pesan gagal simpan data
									$('#show_captcha').load('components/_captcha.php');
									// focus ke input tanggal
									$("#_pVar1").focus();
									// tampilkan peringatan data tidak boleh kosong
									toastr['warning'](result.msgErrors);
								}

							}, 1000);

                        }
                    });
					
					
				}
			});
		});	
		
	</script>
    </body>
</html>
