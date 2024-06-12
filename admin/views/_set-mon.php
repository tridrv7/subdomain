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
                <button class="btn btn-sm btn-outline-primary waves-effect waves-themed text-capitalize ml-2 getCek" data-toggle="modal">
				cek terakhir update
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
                            <th>Oganisasi Perangkat Daerah</th>
                            <th>Website</th>
                            <th>Tanggal Cek</th>
                            <th>Terakhir Update</th>
                            <th>Setting</th>
                        </tr>
                    </thead>
                </table>
                <!-- datatable end -->
            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="_modalMonitoring" tabindex="-1" role="dialog" aria-labelledby="_modalMonitoring" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="_mTitle">Title Modal</h5>
                    </div>
                    <form id="_mForm" enctype="multipart/form-data">
                        <div class="modal-body">
							<div class="row">
								<div class="col-sm-12">
									<div id="_mAttr">
									</div>
									<div class="form-group">
										<label class="form-label">Nama</label>
										<input type="text" class="form-control text-capitalize" id="nmskpd" name="nmskpd" autocomplete="off" placeholder="Nama OPD">
									</div>
									<div class="form-group">
										<label class="form-label">Nomenklatur</label>
										<input type="text" class="form-control" id="kdskpd" name="kdskpd" autocomplete="off" placeholder="Nomenklatur">
									</div>
									<div class="form-group">
										<label class="form-label">Website</label>
										<input type="text" class="form-control" id="website" name="website" autocomplete="off" placeholder="Website">
									</div>
									<div class="form-group">
									  <label class="form-label">Dinas Naungan</label>
										<select name="prskpd" class="select2 form-control w-100" id="prskpd">
											<option style="padding-bottom: 0;" value="0">Utama</option>
											<?=inOpt('kdskpd, nmskpd', 'mast_skpd', 'prskpd=0', '', '1')?>
										</select>
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

        <!-- Modal Confirm--->
        <div class="modal modal-alert fade" id="_modalConfirm" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        Modal text description...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm waves-effect waves-themed" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-themed" id="_mBtnConfirm">Untitle</button>
                    </div>
                </div>
            </div>
        </div>                
        <!-- Modal Cek--->
        <div class="modal modal-alert fade" id="_modalCheck" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        Modal text description...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm waves-effect waves-themed" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-themed" id="_mBtnCheck">Untitle</button>
                    </div>
                </div>
            </div>
        </div>                


        <script>
            $(document).ready(function(){				
				
                // ----------------------------------------------------------------------------------------------------
                // initialize datatable
                $('#_table').dataTable(
                {
                    processing: true,
                    serverSide: true,
                    ajax: 'controllers/_pset-mon.php?_act=5',
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
                                    				'<a class="dropdown-item getHapus <?=$_de_class?>" href="javascript:void(0)" id="'+row[0]+'" _title="Hapus Data" chg="0"><i class="fal fa-trash-alt"></i> Hapus</a>'+
												'</div>'+
											'</div>';
								}else{
                                    var btn='<a class="btn btn-outline-primary btn-sm rounded-circle btn-icon waves-effect waves-themed getHapus" href="javascript:void(0)"  id="'+row[0]+'" _title="Aktifkan Data" chg="1"><i class="fal fa-ban"></i></a>';
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

                    $('#_modalMonitoring').modal('show');
                    // reset form
                    $('#_modalMonitoring #_mForm')[0].reset();
                    $('#_modalMonitoring #_mTitle').html(mTitle);
                    $('#_modalMonitoring #_mAttr').html('<input type="hidden" class="form-control" id="idskpd" name="idskpd" autocomplete="off">');
                    $("#_modalMonitoring #_mForm").attr("_act","1");
                    
					
                    // initialize select2
                    $('#prskpd').select2({
                        dropdownParent: $('#_modalMonitoring'),
                        placeholder: "Pilih Sub Kategori",
                        allowClear: true,
                    });
                    $('#prskpd').val('').trigger('change');
                });

                // Proses Simpan Data
                $('#btnSimpan').click(function(){
                    // Validasi form input
                    if ($('#nmskpd').val()==''){
                        // focus ke input tanggal
                        $("#nmskpd").focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Nama Kategori tidak boleh kosong');
                    }
                    else if ($('#kdskpd').val()==""){
                        // focus ke input nama_barang
                        $( "#kdskpd" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Deskripsi Kategori tidak boleh kosong');
                    } 
                    else if ($('#website').val()==""){
                        // focus ke input nama_barang
                        $( "#website" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('website tidak boleh kosong');
                    } 
                    else if ($('#prskpd').val()==null){
                        // focus ke input nama_barang
                        $( "#prskpd" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Sub Kategori tidak boleh kosong');
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
                            url  : "controllers/_pset-mon.php",
                            data : data,
                            contentType: false,
                            processData: false,
                            success: function(result){
                                // ketika sukses menyimpan data
                                setTimeout(function(){
                                    //button Loading close
                                    $('#btnSimpan').loadButton('off');
                                    alert(result);
									/*
                                    //result
                                    if (result==="sukses") {
                                        // tutup modal tambah data transaksi
                                        $('#_modalMonitoring').modal('hide');
                                        // tampilkan pesan sukses simpan data
                                        toastr['success']('Data berhasil disimpan');

                                        // tampilkan data transaksi
                                        var table = $('#_table').DataTable(); 
                                        table.ajax.reload( null, false );
                                    } else {
                                        // tampilkan pesan gagal simpan data
                                        toastr["error"]('Data tidak berhasil disimpan');
                                        //toastr["error"](result);
                                    }
									*/
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
					var idskpd = $(this).attr('id');

					$('#_mTitle').html('Ubah Data Sub Kategori');
					$('#_mAttr').html('<input type="hidden" class="form-control" id="idskpd" name="idskpd" autocomplete="off" value="'+idskpd+'">');
					$("#_mForm").attr("_act","2");

					$('#prskpd').select2({
						dropdownParent: $('#_modalMonitoring'),
					});
					
					$.ajax({
						type : "GET",
						url  : "controllers/_pset-mon.php?_act=4",
						data : {idskpd:idskpd},
						dataType : "JSON",
						success: function(result){
							// tampilkan modal ubah data transaksi
							$('#_modalMonitoring').modal('show');
							
							// tampilkan data transaksi
							$('#idskpd').val(result.idskpd);
							$('#nmskpd').val(result.nmskpd);
							$('#kdskpd').val(result.kdskpd);
							$('#website').val(result.website);
							$('#prskpd').val(result.prskpd).trigger('change');
							
						}
					});
                });			

                
                // Hapus Data ==========================================================================================
                // ----------------------------------------------------------------------------------------------------
				$('#_table tbody').on( 'click', '.getHapus', function (){
                    var varIDGet = $(this).attr('id');
                    var vGet = $(this).attr('chg');

					var vConfirm = '<form id="_mForm" enctype="multipart/form-data">'+
										'<input type="hidden" id="idskpd" name="idskpd" value="'+varIDGet+'">'+
                                        '<input type="hidden" id="_active" name="_active" value="'+vGet+'">'+
									'<form>';

                    $('#_modalConfirm').modal('show');
                    if(vGet=="0"){//hapus data
                        $('#_modalConfirm .modal-body').html('Akun ini akan dihapus?'+vConfirm);
                        $('#_mBtnConfirm').html('Hapus');
                    } else if(vGet=="1"){//aktifkan data
                        $('#_modalConfirm .modal-body').html('akun ini akan diaktifkan?'+vConfirm);
                        $('#_mBtnConfirm').html('Aktifkan');
                    }
					
					
				});

				$('#_mBtnConfirm').click(function(){
					//button Loading open
					$(this).loadButton('on', {
						loadingText: 'Proses Data...',
					});

					var data = new FormData($('#_modalConfirm #_mForm')[0]);
					data.append('_act', '3');

					$.ajax({
						type : "POST",
						url  : "controllers/_pset-mon.php",
						data : data,
						contentType: false,
						processData: false,
						success: function(result){     
							// ketika sukses menyimpan data
							setTimeout(function(){
								//button Loading close
								$('#_mBtnConfirm').loadButton('off');

								//result
								if (result==="sukses") {
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

									// tampilkan pesan gagal simpan data
									toastr["error"]('Data tidak berhasil Hapus');
								}
							}, 1000);
						}
					});
					return false;
				});
                // ====================================================================================================
                
				// Proses Synchronize All Data ==================================================================================
				$('.getCek').click(function(){

					$('#_modalCheck').modal('show');
					$('#_modalCheck .modal-body').html('Cek Update Website OPD?');
					$('#_mBtnCheck').html('Lanjutkan');

				});
				
				$('#_mBtnCheck').click(function(){
					//button Loading open
					$(this).loadButton('on', {
						loadingText: 'Proses Data...',
					});

					$.ajax({
						type : "POST",
						url  : "controllers/_pset-mon.php?_act=6",
						contentType: false,
						processData: false,
						success: function(result){
							// ketika sukses menyimpan data
							setTimeout(function(){
								//button Loading close
								$('#_mBtnCheck').loadButton('off');

								//result
								if (result==="sukses") {
									// tutup modal tambah data transaksi
									$('#_modalCheck').modal('hide');
									// tampilkan pesan sukses simpan data
									toastr["success"]('Cek Update Website berhasil');

									// tampilkan data transaksi
									var table = $('#_table').DataTable(); 
									table.ajax.reload( null, false );
								} else {
									// tutup modal tambah data transaksi
									$('#_modalCheck').modal('hide');

									// tampilkan pesan gagal simpan data
									toastr["error"]('Cek Update Website tidak berhasil');
								}
							}, 1000);
						}
					});
					return false;
				});
				
				
				
				
            });
            
        </script>

