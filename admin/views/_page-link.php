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
                            <th>Link Address</th>
                            <th>Setting</th>
                        </tr>
                    </thead>
                </table>
                <!-- datatable end -->
            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="_modalLin" tabindex="-1" role="dialog" aria-labelledby="_modalLin" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
										<label class="form-label">Nama <?=str_replace("-"," ",$_REQUEST['title'])?></label>
										<input type="text" class="form-control text-capitalize form-control-sm" id="lin_name" name="lin_name" autocomplete="off" placeholder="<?=str_replace("-"," ",$_REQUEST['title'])?>">
									</div>
									<div class="form-group">
										<label class="form-label">Address (http/https)</label>
										<textarea class="form-control form-control-sm" id="lin_addr" name="lin_addr" rows="5" placeholder="http/https"></textarea>
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
                    ajax: 'controllers/_ppage-link.php?_act=5&ka_id=<?=$_REQUEST['ka']?>',
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

                    $('#_modalLin').modal('show');                    
                    // reset form
                    $('#_modalLin #_mForm')[0].reset();
                    $('#_modalLin #_mTitle').html(mTitle);
                    $('#_modalLin #_mAttr').html('<input type="hidden" class="form-control" id="ka_id" name="ka_id" value="<?=$_REQUEST['ka']?>" autocomplete="off">');
                    $("#_modalLin #_mForm").attr("_act","1");
                    					
                    // initialize dropify
                    $('#_modalLin #_dropifyForm').html('<label class="form-label">Gambar</label>'
														+'<input name="lin_img" type="file" class="dropify" id="lin_img" '
															   +'data-height="200" '
															   +'data-allowed-formats="portrait square landscape" '
															   +'data-allowed-file-extensions="jpg png jpeg" />');
					$('#lin_img').dropify({
						messages: {
							'default': 'Drag and drop a image or click',
							'replace': 'Drag and drop or click to replace',
							'remove':  '<i class="fal fa-trash-alt"></i>',
							'error':   'Ooops, something wrong happended.'
						}					
					});				
					
                });

                // Proses Simpan Data
                $('#btnSimpan').click(function(){

                    // Validasi form input
                    if ($('#lin_name').val()==''){
                        // focus ke input tanggal
                        $("#lin_name").focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Judul tidak boleh kosong');
                    }
                    else if ($('#lin_addr').val()==''){
                        // focus ke input nama_barang
                        $( "#lin_addr" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Link layanan tidak boleh kosong');
                    } 
					/*
					else if(($("#_mForm").attr('_act')=='1') && ($('#lin_img').val()=='')){
                        // focus ke input nama_barang
                        $( "#lin_img" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Gambar tidak boleh kosong');
                    } 
					*/
                    // jika semua data sudah terisi, jalankan perintah simpan data
                    else{
                        $(this).loadButton('on', {
                            loadingText: 'Simpan Data...',
                        });
                        
                        var data = new FormData($('#_mForm')[0]);
                        data.append('_act', $("#_mForm").attr('_act'));

                        $.ajax({
                            type : "POST",
                            url  : "controllers/_ppage-link.php",
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
										$('#_modalLin').modal('hide');
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
					var lin_id = $(this).attr('id');

					$('#_mTitle').html('Ubah Data Sub Kategori');
					$('#_mAttr').html('<input type="hidden" class="form-control" id="lin_id" name="lin_id" autocomplete="off" value="'+lin_id+'"><input type="hidden" class="form-control" id="ka_id" name="ka_id" value="<?=$_REQUEST['ka']?>" autocomplete="off">');
					$("#_mForm").attr("_act","2");

					
					$.ajax({
						type : "GET",
						url  : "controllers/_ppage-link.php?_act=4",
						data : {lin_id:lin_id,ka_id:<?=$_REQUEST['ka']?>},
						dataType : "JSON",
						success: function(result){
							// tampilkan modal ubah data transaksi
							$('#_modalLin').modal('show');
							
							// tampilkan data transaksi
							$('#lin_id').val(result.sos_id);
							$('#lin_name').val(result.sos_nm);
							$('#lin_addr').val(result.sos_url);
							$('#_modalLin #_dropifyForm').html('<label class="form-label">Gambar2</label>'
														+'<input name="lin_img" type="file" class="dropify" id="lin_img" '
															   +'data-height="200" '
															   +'data-allowed-formats="portrait square landscape" '
															   +'data-allowed-file-extensions="jpg png jpeg" '
															   +'data-default-file="<?=$_dirLink?>'+result.sos_ic+'"/>');
							$('#lin_img').dropify({
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
										'<input type="hidden" id="lin_id" name="lin_id" value="'+varIDGet+'">'+
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
						url  : "controllers/_ppage-link.php",
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

