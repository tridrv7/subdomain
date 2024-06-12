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
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <!-- datatable start -->
                    <form id="_mForm" enctype="multipart/form-data">
                        <div class="modal-body">
							<div class="row">
								<div class="col-sm-8">
									<div id="_mAttr">
									</div>
									<div class="form-group">
										<label class="form-label">Nama Dinas/Badan</label>
										<input type="text" class="form-control text-capitalize" id="prof_lnm" name="prof_lnm" autocomplete="off" placeholder="Nama Organisasi Perangkat Daerah">
									</div>
									<div class="form-group">
										<label class="form-label">Singkatan Dinas/Badan</label>
										<input type="text" class="form-control text-capitalize" id="prof_snm" name="prof_snm" autocomplete="off" placeholder="Singkatan Organisasi Perangkat Daerah">
									</div>
									<div class="form-group">
										<label class="form-label">Alamat</label>
										<textarea class="form-control" id="prof_addr" name="prof_addr" placeholder="Alamat Organisasi Perangkat Daerah" rows="3"></textarea>
									</div>
									<div class="form-row">
										<div class="col-md-6 mb-3">
											<label class="form-label">Telp</label>
											<input type="text" class="form-control" id="prof_telp" name="prof_telp" autocomplete="off" placeholder="Telepon">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Fax</label>
											<input type="text" class="form-control" id="prof_fax" name="prof_fax" autocomplete="off" placeholder="Faximil">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6 mb-3">
											<label class="form-label">E-Mail</label>
											<input type="text" class="form-control" id="prof_mail" name="prof_mail" autocomplete="off" placeholder="Email OPD">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Password Email</label>
											<input type="text" class="form-control" id="prof_pwd" name="prof_pwd" autocomplete="off" placeholder="Password Email OPD">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6 mb-3">
											<label class="form-label">Maps</label>
											<input type="text" class="form-control" id="prof_maps" name="prof_maps" autocomplete="off" placeholder="Peta Lokasi OPD (Examp : https://maps.app.goo.gl/ApfoGANMsh6Zwuop7)">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Survey Kepuasan Mayarakat</label>
											<input type="text" class="form-control" id="prof_skm" name="prof_skm" autocomplete="off" placeholder="Link Survey Kepuasan Mayarakat OPD">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-8 mb-3">
											<label class="form-label">Deskripsi Dinas/Badan</label>
											<textarea class="form-control" id="prof_desk" name="prof_desk" placeholder="Post Content" rows="3"></textarea>
										</div>
										<div class="col-md-4 mb-3">
											<label class="form-label">Style Web</label>
											<select name="prof_sty" id="prof_sty">
											  <option value="template-1">Style 1</option>
											  <option value="template-2">Style 2</option>
											</select>
										</div>
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
                <!-- datatable end -->
            </div>
        </div>



        <script>
            // Class definition
            var controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            }

			$("#prof_sty").select2({
				minimumResultsForSearch: Infinity,
				placeholder: "Pilih Style Tampilan Web",
				allowClear: true
			});
			
            $(document).ready(function(){
                // initiate plugin ====================================================================================
				/*------------start ------------*/
				$("#_mForm").attr("_act","1");

				// reset form
				$.ajax({
					type : "GET",
					url  : "controllers/_ppage-profil.php",
					data : {_act:4},
					dataType : "JSON",
					success: function(result){
						//tampilkan data transaksi 
						$('#prof_lnm').val(result.prof_lnm);
						$('#prof_snm').val(result.prof_snm);
						$('#prof_addr').val(result.prof_addr);
						$('#prof_fax').val(result.prof_fax);
						$('#prof_telp').val(result.prof_telp);
						$('#prof_mail').val(result.prof_mail);
						$('#prof_pwd').val(result.prof_pwd);
						$('#prof_maps').val(result.prof_maps);
						$('#prof_skm').val(result.prof_skm);
						$('#prof_desk').val(result.prof_desk);
						$('#_dropifyForm').html('<label class="form-label">Logo</label>'
													+'<input name="prof_lg" type="file" class="dropify" id="prof_lg" '
														   +'data-height="500" '
														   +'data-allowed-formats="portrait square landscape" '
														   +'data-allowed-file-extensions="jpg png jpeg" '
														   +'data-default-file="<?=$_dirProf?>'+result.prof_lg+'"/>');

						$('#prof_lg').dropify({
							messages: {
								'default': 'Drag and drop a image or click',
								'replace': 'Drag and drop or click to replace',
								'remove':  '<i class="fal fa-trash-alt"></i>',
								'error':   'Ooops, something wrong happended.'
							}					
						});
						
						$('#prof_sty').val(result.prof_sty).trigger('change');
					}
				});


      
                // Proses Simpan Data
                $('#btnSimpan').click(function(){

                    // Validasi form input
                    if ($('#prof_lnm').val()==''){
                        // focus ke input tanggal
                        $("#prof_lnm").focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Nama Dinas/Badan tidak boleh kosong');
                    }
					else if ($('#prof_snm').val()=='') {
                        // focus ke input nama_barang
                        $( "#prof_snm" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Singkatan Dinas/Badan tidak boleh kosong');
                    } 
                    else if ($('#prof_addr').val()==''){
                        // focus ke input nama_barang
                        $( "#prof_addr" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Alamat Dinas/Badan tidak boleh kosong');
                    } 
                    else if ($('#prof_mail').val()==''){
                        // focus ke input nama_barang
                        $( "#prof_mail" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('E-mail tidak boleh kosong');
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
                            url  : "controllers/_ppage-profil.php",
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
										$('#_modalPost').modal('hide');
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
                
            });
            
        </script>

