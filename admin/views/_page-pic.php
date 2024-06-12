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
                            <th>Deskripsi</th>
                            <th>Setting</th>
                        </tr>
                    </thead>
                </table>
                <!-- datatable end -->
            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="_modalGal" tabindex="-1" role="dialog" aria-labelledby="_modalGal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
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
										<input type="text" class="form-control text-capitalize" id="ga_judul" name="ga_judul" autocomplete="off" placeholder="Judul">
									</div>
									<div class="form-group">
										<label class="form-label">Deskripsi</label>
										<textarea class="form-control form-control-sm" id="ga_desk" name="ga_desk" rows="5" placeholder="images title" maxlength="200"></textarea>
										<span class="badge border border-secondary text-secondary p-1 position-absolute pos-right mr-3">
											<div id="the-count">
												<span id="current">0</span>
												<span id="maximum">/ 200</span>
											</div>										
										</span>
									</div>
									
								</div>
								<div class="col-sm-4">
									<div class="form-group" id="_dropifyForm">
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
				
				// ----------------------------------------------------------------------------------------------------
                // initialize datatable
                $('#_table').dataTable(
                {
                    processing: true,
                    serverSide: true,
                    ajax: 'controllers/_ppage-pic.php?_act=5&ka_id=<?=$_REQUEST['ka']?>',
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
									var btn='<div class="dropdown <?=$_upde_class?>">'+
												'<a href="ui_dropdowns.html#" class="btn btn-outline-primary btn-sm rounded-circle btn-icon waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
													'<i class="fal fa-ellipsis-v-alt"></i>'+
												'</a>'+
												'<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: top, left; top: 36px; left: 0px;">'+
													'<a class="dropdown-item getUbah <?=$_up_class?>" href="javascript:void(0)" id="'+row[0]+'"><i class="fal fa-pen-square"></i> Ubah Data</a>'+
													'<a class="dropdown-item getHapus <?=$_de_class?>" href="javascript:void(0)" id="'+row[0]+'"><i class="fal fa-trash-alt"></i> Hapus</a>'+
												'</div>'+
											'</div>';

								return btn;
                            },
                        },
                    ],
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

                    $('#_modalGal').modal('show');                    
                    // reset form
                    $('#_modalGal #_mForm')[0].reset();
                    $('#_modalGal #_mTitle').html(mTitle);
                    $('#_modalGal #_mAttr').html('<input type="hidden" class="form-control" id="ka_id" name="ka_id" value="<?=$_REQUEST['ka']?>" autocomplete="off">');
                    $("#_modalGal #_mForm").attr("_act","1");
                    					
					//initialize textarea
					$('#_modalGal #ga_desk').keyup(function() {
						var characterCount = $(this).val().length,
						  current = $('#_modalGal #current'),
						  maximum = $('#_modalGal #maximum'),
						  theCount = $('#_modalGal #the-count');
						
						current.text(characterCount);
	
						/*This isn't entirely necessary, just playin around*/
						if (characterCount >= 175) {
							maximum.css('color', '#8f0001');
							current.css('color', '#8f0001');
							theCount.css('font-weight','bold');
						} else {
							maximum.css('color','#666');
							theCount.css('font-weight','normal');
						}
					});
					
                    // initialize dropify
                    $('#_modalGal #_dropifyForm').html('<label class="form-label">Gambar</label>'
														+'<input name="ga_img" type="file" class="dropify" id="ga_img" '
															   +'data-height="200" data-show-remove="false" '
															   +'data-allowed-formats="landscape" '
															   +'data-allowed-file-extensions="jpg png jpeg" />');
					$('#ga_img').dropify({
						messages: {
							'default': 'Drag and drop a image or click',
							'replace': 'Drag and drop or click to replace',
							'error':   'Ooops, something wrong happended.'
						}					
					});				
					
                });

                // Proses Simpan Data
                $('#btnSimpan').click(function(){

                    // Validasi form input
                    if ($('#ga_judul').val()==''){
                        // focus ke input nama_barang
                        $( "#ga_judul" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Judul tidak boleh kosong');
                    } 
                    else if ($('#ga_desk').val()==''){
                        // focus ke input nama_barang
                        $( "#ga_desk" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Deskripsi tidak boleh kosong');
                    } 
					else if(($("#_mForm").attr('_act')=='1') && ($('#ga_img').val()=='')){
						// focus ke input nama_barang
						$( "#ga_img" ).focus();
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
                            url  : "controllers/_ppage-pic.php",
                            data : data,
                            contentType: false,
                            processData: false,
                            success: function(result){
                                // ketika sukses menyimpan data
                                setTimeout(function(){
                                    //button Loading close
                                    $('#btnSimpan').loadButton('off');
                                    
									//result
									if (result.trim().length===0) {
										// tutup modal tambah data transaksi
										$('#_modalGal').modal('hide');
										// tampilkan pesan sukses simpan data
										toastr['success']('Data berhasil disimpan');

										// tampilkan data transaksi
										var table = $('#_table').DataTable(); 
										table.ajax.reload( null, false );
									} else {
										// tampilkan pesan gagal simpan data
										//toastr["error"]('Data tidak berhasil disimpan');
										toastr['error'](result);
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
					var ga_id = $(this).attr('id');

					$('#_modalGal #_mTitle').html('Ubah Data Banner');
					$('#_modalGal #_mAttr').html('<input type="hidden" class="form-control" id="ga_id" name="ga_id" autocomplete="off" value="'+ga_id+'"><input type="hidden" class="form-control" id="ka_id" name="ka_id" value="<?=$_REQUEST['ka']?>" autocomplete="off">');
					$("#_modalGal #_mForm").attr("_act","2");

					
					$.ajax({
						type : "GET",
						url  : "controllers/_ppage-pic.php?_act=4",
						data : {ga_id:ga_id,ka_id:<?=$_REQUEST['ka']?>},
						dataType : "JSON",
						success: function(result){
							// tampilkan modal ubah data transaksi
							$('#_modalGal').modal('show');
							
							// tampilkan data transaksi
							$('#ga_id').val(result.ban_id);
							$('#ga_judul').val(result.ban_title);
							$('#ga_desk').val(result.ban_desk);
							
							//initialize textarea
							$('#_modalGal #ga_desk').keyup(function() {
								var characterCount = $(this).val().length,
								  current = $('#_modalGal #current'),
								  maximum = $('#_modalGal #maximum'),
								  theCount = $('#_modalGal #the-count');
								
								current.text(characterCount);
			
								/*This isn't entirely necessary, just playin around*/
								if (characterCount >= 175) {
									maximum.css('color', '#8f0001');
									current.css('color', '#8f0001');
									theCount.css('font-weight','bold');
								} else {
									maximum.css('color','#666');
									theCount.css('font-weight','normal');
								}
							});
							
							$('#_modalGal #_dropifyForm').html('<label class="form-label">Gambar2</label>'
														+'<input name="ga_img" type="file" class="dropify" id="ga_img" '
															   +'data-height="200" data-show-remove="false" '
															   +'data-allowed-formats="landscape" '
															   +'data-allowed-file-extensions="jpg png jpeg" '
															   +'data-default-file="<?=$_dirGalery?>'+result.ban_img+'"/>');
							$('#ga_img').dropify({
								messages: {
									'default': 'Drag and drop a image or click',
									'replace': 'Drag and drop or click to replace',
									'remove':  '<i class="fal fa-trash-alt"></i>',
									'error':   'Ooops, something wrong happended.'
								}					
							});
														
						}
					});
                });			

                
                // Hapus Data ==========================================================================================
                // ----------------------------------------------------------------------------------------------------
				$('#_table tbody').on( 'click', '.getHapus', function (){
					var varIDGet = $(this).attr('id');

					var vConfirm = '<form id="_mForm" enctype="multipart/form-data">'+
										'<input type="hidden" id="ga_id" name="ga_id" value="'+varIDGet+'">'+
										'<input type="hidden" id="ka_id" name="ka_id" value="<?=$_REQUEST['ka']?>">'+
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
					data.append('_act', '3');

					$.ajax({
						type : "POST",
						url  : "controllers/_ppage-pic.php",
						data : data,
						contentType: false,
						processData: false,
						success: function(result){     
							// ketika sukses menyimpan data
							setTimeout(function(){
								//button Loading close
								$('#_mBtnConfirm').loadButton('off');

								//result
								if (result.trim().length===0) {
									// tutup modal tambah data transaksi
									$('#_modalConfirm').modal('hide');
									// tampilkan pesan sukses simpan data
									toastr['success']('Data berhasil disimpan');

									// tampilkan data transaksi
									var table = $('#_table').DataTable(); 
									table.ajax.reload( null, false );
								} else {
									// tampilkan pesan gagal simpan data
									//toastr["error"]('Data tidak berhasil disimpan');
									toastr['error'](result);
								}
							}, 1000);
						}
					});
					return false;
				});
                // ====================================================================================================
                
            });
            
        </script>

