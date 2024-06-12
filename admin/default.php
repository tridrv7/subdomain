<?PHP
require 'config/checkAccess.php';
require '../conf/config.php';
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
        <meta name="description" content="Export">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <!-- base css -->
        <link rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
        <link rel="stylesheet" media="screen, print" href="css/app.bundle.css">
        <link rel="stylesheet" media="screen, print" href="css/mod.bundle.css">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
        <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
                
        <!-- Datatables -->
        <link rel="stylesheet" media="screen, print" href="css/datagrid/datatables/datatables.bundle.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
        <!-- toastr -->
        <link rel="stylesheet" media="screen, print" href="css/notifications/toastr/toastr.css">
        <!-- summernote -->
        <link rel="stylesheet" media="screen, print" href="css/formplugins/summernote/summernote.css">
        <!-- select2 -->
        <link rel="stylesheet" media="screen, print" href="css/formplugins/select2/select2.bundle.css">
        <!-- datepicker -->
		<link rel="stylesheet" media="screen, print" href="css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
        <!-- dropify -->
        <link rel="stylesheet" media="screen, print" href="libs/dropify/css/dropify.min.css">
        <!-- dropzone -->
        <link rel="stylesheet" media="screen, print" href="css/formplugins/dropzone/dropzone.css">
		<!-- style color -->
		<link id="mytheme" rel="stylesheet" href="css/themes/cust-theme-1.css">
		
    </head>
    <body class="mod-bg-1 nav-function-fixed header-function-fixed">
        <!-- DOC: script to save and load page settings -->
        <script>
            /**
             *	This script should be placed right after the body tag for fast execution 
             *	Note: the script is written in pure javascript and does not depend on thirdparty library
             **/
            'use strict';

            var classHolder = document.getElementsByTagName("BODY")[0],
                /** 
                 * Load from localstorage
                 **/
                themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
                {},
                themeURL = themeSettings.themeURL || '',
                themeOptions = themeSettings.themeOptions || '';
            /** 
             * Load theme options
             **/
            if (themeSettings.themeOptions)
            {
                classHolder.className = themeSettings.themeOptions;
                console.log("%c✔ Theme settings loaded", "color: #148f32");
            }
            else
            {
                console.log("Heads up! Theme settings is empty or does not exist, loading default settings...");
            }
            if (themeSettings.themeURL && !document.getElementById('mytheme'))
            {
                var cssfile = document.createElement('link');
                cssfile.id = 'mytheme';
                cssfile.rel = 'stylesheet';
                cssfile.href = themeURL;
                document.getElementsByTagName('head')[0].appendChild(cssfile);
            }
            /** 
             * Save to localstorage 
             **/
            var saveSettings = function()
            {
                themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
                {
                    return /^(nav|header|mod|display)-/i.test(item);
                }).join(' ');
                if (document.getElementById('mytheme'))
                {
                    themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
                };
                localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
                
                //alert(JSON.stringify(themeSettings)); 
                //onclick saving data to database with jquery
                
            }
            /** 
             * Reset settings
             **/
            var resetSettings = function()
            {
                localStorage.setItem("themeSettings", "");
            }

        </script>
		
        <!-- BEGIN Page Wrapper -->
        <div class="page-wrapper">
            <div class="page-inner">
                <!-- BEGIN Left Aside -->
                <?PHP require('components/_Aside.php')?>
                <!-- END Left Aside -->

                <div class="page-content-wrapper">
                    <!-- BEGIN Page Header -->
                    <?PHP require('components/_page-header.php')?>
                    <!-- END Page Header -->

                    <!-- BEGIN Page Content -->
                    <!-- the #js-page-content id is needed for some plugins to initialize -->
                    <main id="js-page-content" role="main" class="page-content">
                        <ol id="breadcrumb" class="breadcrumb breadcrumb-arrow">
                            <?PHP require('components/_breadcrumb.php')?>
                        </ol>
                        <div class="row">
                            <div class="col-xl-12">
                                <div id="panel-1" class="panel">
                                </div>
                            </div>
                        </div>
                    </main>
                    <!-- this overlay is activated only when mobile menu is triggered -->
                    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
                    <!-- END Page Content -->
                    
                    <!-- BEGIN Page Footer -->
                    <?PHP require('components/_page-footer.php')?>
                    <!-- END Page Footer -->
                    
                    <!-- BEGIN Shortcuts -->
                    <!-- modal shortcut -->
                    <div class="modal fade modal-backdrop-transparent" id="modal-shortcut" tabindex="-1" role="dialog" aria-labelledby="modal-shortcut" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-top modal-transparent" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <ul class="app-list w-auto h-auto p-0 text-left">
                                        <li>
                                            <a href="intel_introduction.html" class="app-list-item text-white border-0 m-0">
                                                <div class="icon-stack">
                                                    <i class="base base-7 icon-stack-3x opacity-100 color-primary-500 "></i>
                                                    <i class="base base-7 icon-stack-2x opacity-100 color-primary-300 "></i>
                                                    <i class="fal fa-home icon-stack-1x opacity-100 color-white"></i>
                                                </div>
                                                <span class="app-list-name">
                                                    Home <?=$_SESSION['usNip']?>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="page_inbox_general.html" class="app-list-item text-white border-0 m-0">
                                                <div class="icon-stack">
                                                    <i class="base base-7 icon-stack-3x opacity-100 color-success-500 "></i>
                                                    <i class="base base-7 icon-stack-2x opacity-100 color-success-300 "></i>
                                                    <i class="ni ni-envelope icon-stack-1x text-white"></i>
                                                </div>
                                                <span class="app-list-name">
                                                    Inbox
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="intel_introduction.html" class="app-list-item text-white border-0 m-0">
                                                <div class="icon-stack">
                                                    <i class="base base-7 icon-stack-2x opacity-100 color-primary-300 "></i>
                                                    <i class="fal fa-plus icon-stack-1x opacity-100 color-white"></i>
                                                </div>
                                                <span class="app-list-name">
                                                    Add More
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- END Shortcuts -->
                </div>
            </div>
        </div>
        <!-- END Page Wrapper -->
        <!-- BEGIN Quick Menu -->
        <!-- to add more items, please make sure to change the variable '$menu-items: number;' in your _page-components-shortcut.scss -->
        <nav class="shortcut-menu d-none d-sm-block">
            <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
            <label for="menu_open" class="menu-open-button ">
                <span class="app-shortcut-icon d-block"></span>
            </label>
            <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Scroll Top">
                <i class="fal fa-arrow-up"></i>
            </a>
            <a href="page_login-alt.html" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Logout">
                <i class="fal fa-sign-out"></i>
            </a>
            <a href="#" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left" title="Full Screen">
                <i class="fal fa-expand"></i>
            </a>
            <a href="#" class="menu-item btn" data-action="app-print" data-toggle="tooltip" data-placement="left" title="Print page">
                <i class="fal fa-print"></i>
            </a>
            <a href="#" class="menu-item btn" data-action="app-voice" data-toggle="tooltip" data-placement="left" title="Voice command">
                <i class="fal fa-microphone"></i>
            </a>
        </nav>
        <!-- END Quick Menu -->
        <!-- BEGIN Page Settings -->
        <?PHP require('components/_page-setting.php')?>
        <!-- END Page Settings -->
		
        <!-- BEGIN Modal Sign Out -->
        <div class="modal modal-alert fade" id="_SignOut" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        Modal text description...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm waves-effect waves-themed" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-themed btnConfSignOut">Sign Out</button>
                    </div>
                </div>
            </div>
        </div>                
        <!-- END Modal Sign Out -->

		<div class="modal fade" id="_modalFiles" role="dialog" style="display: none;" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-body">


			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm waves-effect waves-themed" data-dismiss="modal">Tutup</button>
			  </div>
			</div>
		  </div>
		</div>    
		
		
		
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
        <!-- datatble responsive bundle contains: 
	+ jquery.dataTables.js
	+ dataTables.bootstrap4.js
	+ dataTables.autofill.js							
	+ dataTables.buttons.js
	+ buttons.bootstrap4.js
	+ buttons.html5.js
	+ buttons.print.js
	+ buttons.colVis.js
	+ dataTables.colreorder.js							
	+ dataTables.fixedcolumns.js							
	+ dataTables.fixedheader.js						
	+ dataTables.keytable.js						
	+ dataTables.responsive.js							
	+ dataTables.rowgroup.js							
	+ dataTables.rowreorder.js							
	+ dataTables.scroller.js							
	+ dataTables.select.js							
	+ datatables.styles.app.js
	+ datatables.styles.buttons.app.js -->
        <script src="js/datagrid/datatables/datatables.bundle.js"></script>
        <!-- datatbles buttons bundle contains: 
	+ "jszip.js",
	+ "pdfmake.js",
	+ "vfs_fonts.js"	
	NOTE: 	The file size is pretty big, but you can always use the
			build.json file to deselect any components you do not need under "export" -->
        <script src="js/datagrid/datatables/datatables.export.js"></script>
        <script src="js/datagrid/datatables/dataTables.treeGrid.js"></script>
        
        <!-- Dashboard -->
        <script src="js/statistics/peity/peity.bundle.js"></script>
        <script src="js/statistics/flot/flot.bundle.js"></script>
        <script src="js/statistics/easypiechart/easypiechart.bundle.js"></script>
        <!-- toastr -->
        <script src="js/notifications/toastr/toastr.js"></script>
        <!-- select2 -->
        <script src="js/formplugins/select2/select2.bundle.js"></script>
        <!-- datepicker -->
        <script src="js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <!-- dropify -->
        <script src="libs/dropify/js/dropify.min.js"></script>
        <!-- summernote -->
        <script src="js/formplugins/summernote/summernote.js"></script>
        <!-- buttonLoader -->
        <script src="libs/buttonLoader/jquery.loadButton.js"></script>
        <!-- dropzone -->
        <script src="js/formplugins/dropzone/dropzone.js"></script>
        
        <script>
            $(document).ready(function(){
                $('#panel-1').load('views/_dash-analytics.php');
                
                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": true,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": 300,
                  "hideDuration": 100,
                  "timeOut": 5000,
                  "extendedTimeOut": 1000,
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                
                //$('.breadcrumb').load('components/_breadcrumb.php');
                //$('.panel-hdr').load('components/_panel-hdr.php');

                // initialize datatable
                $('#dt-basic-example').dataTable(
                {
                    responsive: true,
                    lengthChange: false,
                    dom:
                        /*	--- Layout Structure 
                        	--- Options
                        	l	-	length changing input control
                        	f	-	filtering input
                        	t	-	The table!
                        	i	-	Table information summary
                        	p	-	pagination control
                        	r	-	processing display element
                        	B	-	buttons
                        	R	-	ColReorder
                        	S	-	Select

                        	--- Markup
                        	< and >				- div element
                        	<"class" and >		- div with a class
                        	<"#id" and >		- div with an ID
                        	<"#id.class" and >	- div with an ID and a class

                        	--- Further reading
                        	https://datatables.net/reference/option/dom
                        	--------------------------------------
                         */
                        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        /*{
                        	extend:    'colvis',
                        	text:      'Column Visibility',
                        	titleAttr: 'Col visibility',
                        	className: 'mr-sm-3'
                        },*/
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            titleAttr: 'Generate PDF',
                            className: 'btn-outline-danger btn-sm mr-1'
                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            titleAttr: 'Generate Excel',
                            className: 'btn-outline-success btn-sm mr-1'
                        },
                        {
                            extend: 'csvHtml5',
                            text: 'CSV',
                            titleAttr: 'Generate CSV',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'copyHtml5',
                            text: 'Copy',
                            titleAttr: 'Copy to clipboard',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-primary btn-sm'
                        }
                    ]
                });

            });
            
            function goPage(ur, title, bread){
                ur = 'views/'+ur+'.php?title='+title+'&bread='+bread;
                
                $("#breadcrumb").load('components/_breadcrumb.php?bread='+bread);
                $('#panel-1').load(ur);
            };
            
            function goPublic(ur, ka, title, bread){
                ur = 'views/'+ur+'.php?ka='+ka+'&title='+title+'&bread='+bread;
                
                $("#breadcrumb").load('components/_breadcrumb.php?bread='+bread);
                $('#panel-1').load(ur);
            };
			
            // Sign Out ==================================================================================
            // ----------------------------------------------------------------------------------------------------
            $('.btnSignOut').click(function(){
				$('#_SignOut').modal('show');
				$('#_SignOut .modal-body').html('Lanjutkan Proses ini?');
			});			
            // ====================================================================================================
			
            // Proses Confirm Hapus Data ==================================================================================
            // ----------------------------------------------------------------------------------------------------
			$('.btnConfSignOut').click(function(){
				//button Loading open
				$(this).loadButton('on', {
					loadingText: 'Sign Out Processing...',
				});

				//var data = new FormData($('#_modalConfirm #_mForm')[0]);

				$.ajax({
					type : "POST",
					url  : "components/_out.php",
					//data : data,
					contentType: false,
					processData: false,
					success: function(result){     
						// ketika sukses menyimpan data
						setTimeout(function(){
							//button Loading close
							$('#btnConfSignOut').loadButton('off');
							
							window.location.replace(result);

						}, 1000);
					}
				});
				return false;
			});
			// ====================================================================================================
			
        </script>
    </body>
</html>
