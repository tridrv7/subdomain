<?PHP
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
require '../config/checkPriv.php';
?>


        <div class="panel-hdr">
            <!--
            <h2>
                Example <span class="fw-300"><i>Table</i></span>
            </h2>
            -->
            <h2><?PHP echo str_replace("-"," ",$_REQUEST['title']);?></h2>
            <div class="panel-toolbar">
                <button type="button" class="btn btn-sm btn-outline-primary waves-effect waves-themed btnTambah <?=$_cr_class?>" data-toggle="modal" _title="Tambah Data <?=str_replace("-"," ",$_REQUEST['title'])?>">
                    <span class="fal fa-file-plus mr-1"></span> Tambah
                </button>
                <!--
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                -->
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <!-- datatable start -->
                <table id="_table" class="table table-bordered table-hover table-striped w-100">
                    <thead class="bg-primary-600">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Publish</th>
                            <th>Setting</th>
                        </tr>
                    </thead>
                </table>
                <!-- datatable end -->
            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="_modalPost" tabindex="-1" role="dialog" aria-labelledby="_modalPost" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="_mTitle">Title Modal</h5>
                    </div>

                    <form id="_mForm" enctype="multipart/form-data">
                        <div class="modal-body">
							<div class="row">
								<div class="col-sm-8">
									<div id="_mAttr">
									</div>
									<div class="form-group">
										<label class="form-label">Judul</label>
										<input type="text" class="form-control text-capitalize" id="post_judul" name="post_judul" autocomplete="off" placeholder="Judul">
									</div>
									<div class="form-group">
										<!--
										<input type="text" class="form-control" id="post_desk" name="post_desk" autocomplete="off">
										-->
										<textarea class="form-control" id="post_desk" name="post_desk" placeholder="Post Content" rows="25"></textarea>
									</div>
									
									<!--start view FileUpload-->									
									<div class="form-group" id="_vTableFile">
									</div>
									<!--end view FileUpload-->
									
								</div>
								<div class="col-sm-4">
									<div class="form-group" id="_dropifyForm">
									</div>
									<div class="form-group">
										<label class="form-label" for="datepicker-modal-2">Publish</label>
									  <div class="input-group">
										<div class="input-group-prepend">
												<span class="input-group-text fs-xl"><i class="fal fa-calendar"></i></span>
										  </div>
										  <input name="post_publish" type="text" class="form-control datepick" id="post_publish" placeholder="Select a date Publish" aria-describedby="datepicker-modal-2" aria-label="date">
										</div>
									</div>
									<div class="form-group">
										<div id="fileUpload" class="dropzone"></div>
									</div>
								</div>
							</div>							
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm waves-effect waves-themed" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-info btn-sm waves-effect waves-themed" id="btnSimpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Alert --->
        <div class="modal modal-alert fade" id="_modalConfirm" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        Modal text description...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm waves-effect waves-themed" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-themed" id="_mBtnConfirm">Hapus Data</button>
                    </div>
                </div>
            </div>
        </div>                


        <script>
            // Class definition
            var controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            }


			
            $(document).ready(function(){
                // initiate plugin ====================================================================================
				/*------------start ------------*/
				$('#post_desk').summernote({
					height: 300,                 // set editor height
					minHeight: null,             // set minimum height of editor
					maxHeight: null,             // set maximum height of editor
					focus: true,                  // set focus to editable area after initializing summernote
				});
				
				// initialize Dropzone
				var fileDrop = new Dropzone('div#fileUpload', {
					addRemoveLinks: true,
					autoProcessQueue: false,
					uploadMultiple: true,
					parallelUploads: 100,
					maxFiles: 10,
					paramName: 'file',
					acceptedFiles: ".rar,.zip,.pdf,.png,.jpg,.jpeg",
					clickable: true,
					url: 'dynamic',
				});
				fileDrop.on("complete", function(file) {
					fileDrop.removeFile(file);
				});
				
				
                // ----------------------------------------------------------------------------------------------------
                // initialize datatable
                $('#_table').dataTable(
                {
                    processing: true,
                    serverSide: true,
                    ajax: 'controllers/_ppage-publik.php?_act=5&ka_id=<?=$_REQUEST['ka']?>',
                    columnDefs: [ 
						{
							targets: 0,
							visible: false,
						},
                        {
                            targets: -1,
                            title: '<i class="fal fa-cogs"></i>',
                            orderable: false,
                            render: function(data, type, row)
                            {
								if(data==1){
									var btn='<div class="dropdown <?=$_upde_class?>">'+
												'<a href="ui_dropdowns.html#" class="btn btn-outline-primary btn-sm rounded-circle btn-icon waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
													'<i class="fal fa-ellipsis-v-alt"></i>'+
												'</a>'+
												'<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: top, left; top: 36px; left: 0px;">'+
													'<a class="dropdown-item getUbah <?=$_up_class?>" href="javascript:void(0)" id="'+row[0]+'"><i class="fal fa-pen-square"></i> Ubah Data</a>'+
													'<a class="dropdown-item getHapus <?=$_de_class?>" href="javascript:void(0)" id="'+row[0]+'"><i class="fal fa-trash-alt"></i> Hapus</a>'+
												'</div>'+
											'</div>';
								}else{
									var btn='<a class="btn btn-outline-primary btn-sm rounded-circle btn-icon waves-effect waves-themed" href="javascript:void(0)"><i class="fal fa-ban"></i></a>';
								}

								return btn;
                            },
                        },
                    ],
					order: [[2, 'desc']],
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
      
                // Simpan Data ========================================================================================
                // ----------------------------------------------------------------------------------------------------
                // Tampikan Form Tambah Data
                $('.btnTambah').click(function(reload){
                    var mTitle = $(this).attr('_title');

                    $('#_modalPost').modal('show');                    
                    // reset form
                    $('#_modalPost #_mForm')[0].reset();
                    $('#_modalPost #_mTitle').html(mTitle);
                    $('#_modalPost #_mAttr').html('<input type="hidden" class="form-control" id="ka_id" name="ka_id" value="<?=$_REQUEST['ka']?>" autocomplete="off">');
                    $("#_modalPost #_mForm").attr("_act","1");
                    
					$('#post_desk').summernote('reset');
					
                    // initialize dropify
                    $('#_modalPost #_dropifyForm').html('<label class="form-label">Gambar</label>'
														+'<input name="post_img" type="file" class="dropify" id="post_img" '
															   +'data-height="200" data-show-remove="false" '
															   +'data-allowed-formats="portrait square landscape" '
															   +'data-allowed-file-extensions="jpg png jpeg" />');
					$('#post_img').dropify({
						messages: {
							'default': 'Drag and drop a image or click',
							'replace': 'Drag and drop or click to replace',
							'remove':  '<i class="fal fa-trash-alt"></i>',
							'error':   'Ooops, something wrong happended.'
						}					
					});				

                    // initialize datepicker
					$('.datepick').datepicker(
					{
						todayHighlight: true,
						orientation: "bottom left",
						format:'yyyy-mm-dd',
						templates: controls
					});
					
					('#_vTableFile').html('');
                });

                // Proses Simpan Data
                $('#btnSimpan').click(function(){

                    // Validasi form input
                    if ($('#post_judul').val()==''){
                        // focus ke input tanggal
                        $("#post_judul").focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Judul tidak boleh kosong');
                    }
					else if ($('#post_desk').summernote('isEmpty')) {
                        // focus ke input nama_barang
                        $( "#post_desk" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Content tidak boleh kosong');
                    } 
                    else if ($('#post_publish').val()==""){
                        // focus ke input nama_barang
                        $( "#post_publish" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Tanggal Publish tidak boleh kosong');
                    } 
					else if(($("#_mForm").attr('_act')=='1') && ($('#post_img').val()=='')){
                        // focus ke input nama_barang
                        $( "#post_img" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Gambar tidak boleh kosong');
                    } 
                    // jika semua data sudah terisi, jalankan perintah simpan data
                    else{
                        $(this).loadButton('on', {
                            loadingText: 'Simpan Data...',
                        });
						
                        var data = new FormData($('#_mForm')[0]);
                        data.append('_act', $("#_mForm").attr('_act'));

                        $.ajax({
                            type : "POST",
                            url  : "controllers/_ppage-publik.php",
                            data : data,
                            contentType: false,
                            processData: false,
                            success: function(result){
                                // ketika sukses menyimpan data
								//var json_obj = $.parseJSON(result);
								//alert(result);
								var json_obj = JSON.parse(result);
								setTimeout(function(){
									
                                    //button Loading close
                                    $('#btnSimpan').loadButton('off');
                                    //result
                                    if (json_obj.stats=='sukses') {
                                        // tutup modal tambah data transaksi
                                        $('#_modalPost').modal('hide');
                                        // tampilkan pesan sukses simpan data
                                        toastr['success']('Data berhasil disimpan');
								
										var fileDrop = Dropzone.forElement("div#fileUpload");
										fileDrop.options.url = 'controllers/_ppage-publik.php?_act=6&post_id='+json_obj.msgErrors;
										fileDrop.processQueue();
								
										
                                        // tampilkan data transaksi
                                        var table = $('#_table').DataTable(); 
                                        table.ajax.reload( null, false );
                                    } else {
                                        // tampilkan pesan gagal simpan data
                                        //toastr["error"]('Data tidak berhasil disimpan');
                                        toastr["error"](json_obj.msgErrors);
                                    }
                                }, 1000);
                            }
                        });
                        return false;
                    }
                });
                // ====================================================================================================
                
                
                // Ubah Data ==========================================================================================
                // ----------------------------------------------------------------------------------------------------
                // Tampilkan Form Ubah Data
                $('#_table tbody').on( 'click', '.getUbah', function (){
					var post_id = $(this).attr('id');

					$('#_mTitle').html('Ubah Data Sub Kategori');
					$('#_mAttr').html('<input type="hidden" class="form-control" id="post_id" name="post_id" autocomplete="off" value="'+post_id+'"><input type="hidden" class="form-control" id="ka_id" name="ka_id" value="<?=$_REQUEST['ka']?>" autocomplete="off">');
					$("#_mForm").attr("_act","2");
					
                    // initialize datepicker
					$('.datepick').datepicker(
					{
						todayHighlight: true,
						orientation: "bottom left",
						format:'yyyy-mm-dd',
						templates: controls
					});
										
					$.ajax({
						type : "GET",
						url  : "controllers/_ppage-publik.php?_act=4",
						data : {post_id:post_id,ka_id:<?=$_REQUEST['ka']?>},
						dataType : "JSON",
						success: function(result){
							// tampilkan modal ubah data transaksi
							$('#_modalPost').modal('show');
							
							// tampilkan data transaksi
							$('#post_id').val(result.post_id);
							$('#post_judul').val(result.post_judul);
							$('#post_desk').summernote('code', result.post_desk);
							$('#post_publish').val(result.post_publish);
							$('#_modalPost #_dropifyForm').html('<label class="form-label">Gambar2</label>'
														+'<input name="post_img" type="file" class="dropify" id="post_img" '
															   +'data-height="200" data-show-remove="false" '
															   +'data-allowed-formats="portrait square landscape" '
															   +'data-allowed-file-extensions="jpg png jpeg" '
															   +'data-default-file="<?=$_dirPost?>'+result.post_img+'"/>');
							
							$('#post_img').dropify({
								messages: {
									'default': 'Drag and drop a image or click',
									'replace': 'Drag and drop or click to replace',
									'remove':  '<i class="fal fa-trash-alt"></i>',
									'error':   'Ooops, something wrong happended.'
								}					
							});
							
							//table file
							$('#_vTableFile').html('<table id="_tableFile'+result.post_id+'" class="table table-bordered table-hover table-striped w-100">'
														+'<thead>'
															+'<tr>'
																+'<th>ID</th>'
																+'<th>Post</th>'
																+'<th>File</th>'
																+'<th>Setting</th>'
															+'</tr>'
														+'</thead>'
													+'</table>');
							$('#_tableFile'+result.post_id).dataTable(
							{
								processing: true,
								serverSide: true,
								ajax: 'controllers/_ppage-publik.php?_act=8&post_id='+result.post_id,
								columnDefs: [ 
									{
										targets: 0,
										visible: false,
									},
									{
										targets: 1,
										visible: false,
									},
									{
										targets: -1,
										title: '<i class="fal fa-cogs"></i>',
										orderable: false,
										render: function(data, type, row)
										{
											if(data==1){
												var btn='<a class="dropdown-item getHapusFile" href="javascript:void(0)" gID="'+row[0]+'" gPS="'+row[1]+'" gNM="'+row[2]+'"><i class="fal fa-trash-alt"></i></a>';
											}else{
												var btn='<a class="btn btn-outline-primary btn-sm rounded-circle btn-icon waves-effect waves-themed" href="javascript:void(0)"><i class="fal fa-ban"></i></a>';
											}
			
											return btn;
										},
									},
								],
								responsive: true,
								lengthChange: false,
								dom:
									"<'row mb-3'>" +
									"<'row'<'col-sm-12'tr>>" +
									"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							});
      
							
							
						}
					});
                });			

                
                // Hapus Data ==========================================================================================
                // ----------------------------------------------------------------------------------------------------
				$('#_table tbody').on( 'click', '.getHapus', function (){
					var varIDGet = $(this).attr('id');

					var vConfirm = '<form id="_mForm" enctype="multipart/form-data">'+
										'<input type="hidden" id="post_id" name="post_id" value="'+varIDGet+'">'+
										'<input type="hidden" id="ka_id" name="ka_id" value="<?=$_REQUEST['ka']?>">'+
										'<input type="hidden" id="_act" name="_act" value="3">'+
									'<form>';

					$('#_modalConfirm').modal('show');
					$('#_modalConfirm .modal-body').html('Data ini akan dihapus?'+vConfirm);
					$('#_mBtnConfirm').html('Hapus');
				});

				$('#_mBtnConfirm').click(function(){
					//button Loading open
					$(this).loadButton('on', {
						loadingText: 'Hapus Data...',
					});

					var data = new FormData($('#_modalConfirm #_mForm')[0]);

					$.ajax({
						type : "POST",
						url  : "controllers/_ppage-publik.php",
						data : data,
						contentType: false,
						processData: false,
						success: function(result){  
							// ketika sukses menyimpan data
							var json_obj = $.parseJSON(result);
							setTimeout(function(){
								//button Loading close
								$('#_mBtnConfirm').loadButton('off');

								//result
								if (json_obj.stats==="sukses") {
									if(json_obj.msgErrors==="tb_post"){
										// tutup modal tambah data transaksi
										$('#_modalConfirm').modal('hide');
										// tampilkan pesan sukses simpan data
										toastr["success"]('Data berhasil Hapus');
	
										// tampilkan data transaksi
										var table = $('#_table').DataTable(); 
										table.ajax.reload( null, false );
									} else {
										// tutup modal tambah data transaksi
										$('#_modalConfirm').modal('hide');
										// tampilkan pesan sukses simpan data
										toastr["success"]('File berhasil Hapus');
	
										// tampilkan data transaksi
										var tablei = $('#_tableFile'+json_obj.msgErrors).DataTable(); 
										tablei.ajax.reload( null, false );
									}
								} else {
									// tutup modal tambah data transaksi
									$('#_modalConfirm').modal('hide');

									// tampilkan pesan gagal simpan data
									toastr["error"]('Data tidak berhasil Hapus');
								}
							}, 1000);
						}
					});
					return false;
				});
                // ====================================================================================================
                
				
                // Hapus Data ==========================================================================================
                // ----------------------------------------------------------------------------------------------------
				$('#_modalPost').on( 'click', '.getHapusFile', function (){
					var varIDGet = $(this).attr('gID');
					var varPSGet = $(this).attr('gPS');
					var varNMGet = $(this).attr('gNM');
					var varADGet = $(this).attr('gAD');

					var vConfirm = '<form id="_mForm" enctype="multipart/form-data">'+
										'<input type="hidden" id="gID" name="gID" value="'+varIDGet+'">'+
										'<input type="hidden" id="gPS" name="gPS" value="'+varPSGet+'">'+
										'<input type="hidden" id="gNM" name="gNM" value="'+varNMGet+'">'+
										'<input type="hidden" id="gAD" name="gAD" value="'+varADGet+'">'+
										'<input type="hidden" id="_act" name="_act" value="7">'+
									'<form>';

					$('#_modalConfirm').modal('show');
					$('#_modalConfirm .modal-body').html('File '+varNMGet+' akan dihapus?'+vConfirm);
					$('#_mBtnConfirm').html('Hapus');
				});

                // ====================================================================================================
                
            });
            
        </script>

