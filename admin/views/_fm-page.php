


                                    <div class="panel-hdr">
                                        <!--
                                        <h2>
                                            Example <span class="fw-300"><i>Table</i></span>
                                        </h2>
                                        -->
                                        <h2><?PHP echo str_replace("-"," ",$_REQUEST['title']);?></h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-sm btn-outline-primary waves-effect waves-themed" data-toggle="modal" data-target="#default-example-modal-lg">
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
                                            <table id="tbFmAkun" class="table table-bordered table-hover table-striped w-100">
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                        <th>NIP</th>
                                                        <th>Position</th>
                                                        <th>Office</th>
                                                        <th>Age</th>
                                                        <th>Start date</th>
                                                        <th>Salary</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <!-- datatable end -->
                                        </div>
                                    </div>


        <!-- start Modal  -->
        <div class="modal fade" id="default-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-transparent-top" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="dropping"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Modal  -->

        <!-- Modal -->
        <div class="modal fade" id="_modalFmAkun" tabindex="-1" role="dialog" aria-labelledby="_modalFmAkun" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Title Modal</h5>
                    </div>

                    <form id="_actionFormFmAkun" enctype="multipart/form-data">
                        <div class="modal-body">
							
									<div id="_actRelFmAkun" class="form-group row">
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Nama</label>
										<div class="col-sm-12 col-md-9">
											<input type="text" class="form-control text-capitalize" id="us_nama" name="us_nama" autocomplete="off" placeholder="Nama">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Email</label>
										<div class="col-sm-12 col-md-9">
											<input type="text" class="form-control" id="us_email" name="us_email" autocomplete="off" placeholder="Email">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Password</label>
										<div class="col-sm-12 col-md-9 input-group" id="passwdShowHide">
											<input type="password" class="form-control" id="us_passwd" name="us_passwd" autocomplete="off" placeholder="Password">
											<div class="input-group-append">
												<a href="javascript:void(0)" class="btn btn-outline-secondary"><i class="icon-copy fa fa-eye-slash" aria-hidden="true"></i></a>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Konfirm Password</label>
										<div class="col-sm-12 col-md-9 input-group" id="passwd2ShowHide">
											<input type="password" class="form-control" id="us_passwd2" name="us_passwd2" autocomplete="off" placeholder="Konfirm Password">
											<div class="input-group-append">
												<a href="javascript:void(0)" class="btn btn-outline-secondary"><i class="icon-copy fa fa-eye-slash" aria-hidden="true"></i></a>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Level</label>
										<div class="col-sm-12 col-md-9">
											<select class="selectpicker form-control" data-style="btn-outline-info" id="us_roles" name="us_roles">
												<option>--Pilih Level--</option>
												<option value="2">Administrator</option>
												<option value="3">Operator JDIH</option>
												<option value="4">Operator Kecamatan</option>
												<option value="5">Operator Desa</option>
												<option value="9">Tidak Berwenang</option>
											</select>											
										</div>
									</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info btn-submit" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="_modalFmAkun1" tabindex="-1" role="dialog" aria-labelledby="_modalFmAkun1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Title Modal</h5>
                    </div>

                    <form id="_actionFormFmAkun1" enctype="multipart/form-data">
                        <div class="modal-body">
							
									<div id="_actRelFmAkun1" class="form-group row">
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Nama</label>
										<div class="col-sm-12 col-md-9">
											<input type="text" class="form-control text-capitalize" id="us_nama1" name="us_nama" autocomplete="off" placeholder="Nama">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Email</label>
										<div class="col-sm-12 col-md-9">
											<input type="text" class="form-control" id="us_email1" name="us_email" autocomplete="off" placeholder="Email">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Level</label>
										<div class="col-sm-12 col-md-9">
											<select class="selectpicker form-control" data-style="btn-outline-info" id="us_roles1" name="us_roles">
												<option>--Pilih Level--</option>
												<option value="2">Administrator</option>
												<option value="3">Operator JDIH</option>
												<option value="4">Operator Kecamatan</option>
												<option value="5">Operator Desa</option>
												<option value="9">Tidak Berwenang</option>
											</select>											
										</div>
									</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info btn-submit" id="btnSimpan1">Simpan</button>
                            <button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="_modalFmAkun2" tabindex="-1" role="dialog" aria-labelledby="_modalFmAkun2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Title Modal</h5>
                    </div>

                    <form id="_actionFormFmAkun2" enctype="multipart/form-data">
                        <div class="modal-body">
							
									<div id="_actRelFmAkun2" class="form-group row">
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Password</label>
										<div class="col-sm-12 col-md-9 input-group" id="passwdShowHide">
											<input type="password" class="form-control" id="us_passwdx" name="us_passwd" autocomplete="off" placeholder="Password">
											<div class="input-group-append">
												<a href="javascript:void(0)" class="btn btn-outline-secondary"><i class="icon-copy fa fa-eye-slash" aria-hidden="true"></i></a>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-3 col-form-label">Konfirm Password</label>
										<div class="col-sm-12 col-md-9 input-group" id="passwd2ShowHide">
											<input type="password" class="form-control" id="us_passwdx2" name="us_passwd2" autocomplete="off" placeholder="Konfirm Password">
											<div class="input-group-append">
												<a href="javascript:void(0)" class="btn btn-outline-secondary"><i class="icon-copy fa fa-eye-slash" aria-hidden="true"></i></a>
											</div>
										</div>
									</div>
							
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info btn-submit" id="btnSimpan2">Simpan</button>
                            <button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
            // initiate plugin ====================================================================================
            // ----------------------------------------------------------------------------------------------------
			$("#passwdShowHide a").on('click', function(event) {
				event.preventDefault();
				if($('#passwdShowHide input').attr("type") == "text"){
					$('#passwdShowHide input').attr('type', 'password');
					$('#passwdShowHide i').addClass( "fa-eye-slash" );
					$('#passwdShowHide i').removeClass( "fa-eye" );
				}else if($('#passwdShowHide input').attr("type") == "password"){
					$('#passwdShowHide input').attr('type', 'text');
					$('#passwdShowHide i').removeClass( "fa-eye-slash" );
					$('#passwdShowHide i').addClass( "fa-eye" );
				}
			});
			$("#passwd2ShowHide a").on('click', function(event) {
				event.preventDefault();
				if($('#passwd2ShowHide input').attr("type") == "text"){
					$('#passwd2ShowHide input').attr('type', 'password');
					$('#passwd2ShowHide i').addClass( "fa-eye-slash" );
					$('#passwd2ShowHide i').removeClass( "fa-eye" );
				}else if($('#passwd2ShowHide input').attr("type") == "password"){
					$('#passwd2ShowHide input').attr('type', 'text');
					$('#passwd2ShowHide i').removeClass( "fa-eye-slash" );
					$('#passwd2ShowHide i').addClass( "fa-eye" );
				}
			});
                
                
                
                // initialize datatable
                $('#tbFmAkun').dataTable(
                {
                    processing: true,
                    serverSide: true,
                    ajax: 'controllers/_pset-akun.php?_actionFmAkun=5',
                    columnDefs: [ 
                    {
                        targets: -1,
                        title: '<i class="fal fa-cogs"></i>',
                        orderable: false,
                        render: function(data, type, row)
                        {
                            if(data==1){
                                var btnplus = "<button type=\"button\" class=\"btn btn-sm btn-outline-default btnHapus\" id="+data+" data=\"0\"><i class=\"icon-copy dw dw-trash\" aria-hidden=\"true\"></i> 1</button>";

                                var btn = "<div class=\"dropdown\"><button type=\"button\" class=\"btn btn-sm btn-outline-default dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-copy dw dw-edit-1\"></i></button><div class=\"dropdown-menu\"><a class=\"dropdown-item getUbahData\" href=\"javascript:void(0)\" id="+data+">Ubah Data</a><a class=\"dropdown-item getUbahPwd\" href=\"javascript:void(0)\" id="+row[0]+">Ubah Password</a></div>"+btnplus+"</div>";
                            }else{
                                var btnplus = '<button class="btn btn-sm btn-primary btn-icon rounded-circle position-relative js-waves-off" data-toggle="dropdown">'+
                                                '<i class="fal fa-cog"></i>'+
                                                '</button>'+
                                                '<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right">'+
                                                    '<button class="dropdown-item"> 2'+data+'</button>'+
                                                    '<button class="dropdown-item">'+row[0]+'</button>'+
                                                '</div>';
                                var btn = btnplus;
                                
                            }
                            return btn;
                            
                            //return data+row[0]+"\n\t\t\t\t\t\t<div class='d-flex demo'>\n\t\t\t\t\t\t\t<a href='javascript:void(0);' class='btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1' title='Delete Record'><i class=\"fal fa-times\"></i></a>\n\t\t\t\t\t\t\t<a href='javascript:void(0);' class='btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1' title='Edit'><i class=\"fal fa-edit\"></i></a>\n\t\t\t\t\t\t\t<div class='dropdown d-inline-block'>\n\t\t\t\t\t\t\t\t<a href='datatables_fixedcolumns.html#' class='btn btn-sm btn-outline-primary btn-icon' data-toggle='dropdown' aria-expanded='true' title='More options'><i class=\"fal fa-plus\"></i></a>\n\t\t\t\t\t\t\t\t<div class='dropdown-menu'>\n\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='javascript:void(0);'>Change Status</a>\n\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='javascript:void(0);'>Generate Report</a>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>";
                        },
                    },
                      /*
                        {
                          "targets": 5, "orderable": false, "searchable": false, "width": '5px', "className": 'right',
                          "render": function(data, type, row) {
                              return data;
                              if(row[6]==1){
                                  var btnplus = "<button type=\"button\" class=\"btn btn-sm btn-outline-default btnHapus\" id="+data+" data=\"0\"><i class=\"icon-copy dw dw-trash\" aria-hidden=\"true\"></i></button>";

                                  var btn = "<div class=\"dropdown\"><button type=\"button\" class=\"btn btn-sm btn-outline-default dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-copy dw dw-edit-1\"></i></button><div class=\"dropdown-menu\"><a class=\"dropdown-item getUbahData\" href=\"javascript:void(0)\" id="+data+">Ubah Data</a><a class=\"dropdown-item getUbahPwd\" href=\"javascript:void(0)\" id="+data+">Ubah Password</a></div>"+btnplus+"</div>";
                              }else{
                                  var btnplus = "<button type=\"button\" class=\"btn btn-sm btn-outline-default btnHapus\" id="+data+" data=\"1\"><i class=\"icon-copy dw dw-ban\" aria-hidden=\"true\"></i></button>";
                                  var btn = btnplus;
                              }
                              return btn;
                          } 
                        } 
                      */
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

                
                // Ubah Data ==========================================================================================
                // ----------------------------------------------------------------------------------------------------
                // Tampilkan Form Ubah Data
                $('#tbFmAkun tbody').on( 'click', '.getUbahPwd', function (){

                    $('#_actionFormFmAkun2')[0].reset();
                    var us_nip = $(this).attr('id');

                    $('#exampleModalLabel2').html('Ubah Password');
                    $('#_actRelFmAkun2').html('<label class="col-sm-12 col-md-3 col-form-label">NIP</label><div class="col-sm-12 col-md-9">'+us_nip+'<input type="hidden" class="form-control" id="us_nip2" name="us_nip" value="'+us_nip+'" autocomplete="off" placeholder="NIP" maxlength="18"></div>');
                    $("#_actionFormFmAkun2").attr("_actFmAkun","6");

                    // tampilkan modal ubah data transaksi
                    $('#_modalFmAkun2').modal('show');

                });			

                // Proses Simpan Data Password
                $('#btnSimpan2').click(function(){
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

                    // Validasi form input
                    if ($('#us_nip2').val()==""){
                        // focus ke input tanggal
                        $("#us_nip2").focus();
                        // tampilkan peringatan data tidak boleh kosong
                        swal("Peringatan!", "NIP tidak boleh kosong", "warning");
                    }
                    else if ($('#us_nip2').val().length!=18){
                        // focus ke input nama_barang
                        $( "#us_nip2" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        swal("Peringatan!", "Periksa Kembali NIP", "warning");
                        //swal("Peringatan!", "Judul "+$('#kate_id').val()+" tidak boleh kosong", "warning");
                    } 
                    else if ($('#us_passwdx').val()==""){
                        // focus ke input nama_barang
                        $( "#us_passwdx" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        swal("Peringatan!", "Password tidak boleh kosong", "warning");
                        //swal("Peringatan!", "Judul "+$('#kate_id').val()+" tidak boleh kosong", "warning");
                    } 
                    else if ($('#us_passwdx2').val()==""){
                        // focus ke input nama_barang
                        $( "#us_passwdx2" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        swal("Peringatan!", "Konfirm Password tidak boleh kosong", "warning");
                        //swal("Peringatan!", "Judul "+$('#kate_id').val()+" tidak boleh kosong", "warning");
                    } 
                    else if ($('#us_passwdx2').val()!=$('#us_passwdx').val()){
                        // focus ke input nama_barang
                        $( "#us_passwdx2" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        swal("Peringatan!", "Periksa kembali password/password tidak sama", "warning");
                        //swal("Peringatan!", "Judul "+$('#kate_id').val()+" tidak boleh kosong", "warning");
                    } 
                    // jika semua data sudah terisi, jalankan perintah simpan data
                    else{
                        var data = new FormData($('#_actionFormFmAkun2')[0]);
                        var _actFmAkun = $("#_actionFormFmAkun2").attr('_actFmAkun');

                        data.append('_actionFmAkun', _actFmAkun);

                        $.ajax({
                            type : "POST",
                            url  : "controllers/processFmAkun.php",
                            data : data,
                            contentType: false,
                            processData: false,
                            success: function(result){     
                                // ketika sukses menyimpan data
                                if (result==="sukses") {
                                    // tutup modal tambah data transaksi
                                    $('#_modalFmAkun2').modal('hide');
                                    // tampilkan pesan sukses simpan data
                                    swal({
                                        text: 'Data berhasil disimpan',
                                        type: 'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    // tampilkan data transaksi
                                    var table = $('#_tableFmAkun').DataTable(); 
                                    table.ajax.reload( null, false );
                                } else {
                                    // tampilkan pesan gagal simpan data
                                    swal({
                                        text: result,
                                        type: 'error',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        });
                        return false;
                    }
                });
                // ====================================================================================================
                
                
                
                
                
                
            });
            
            
            $(function () {
                $('#default-example-modal-lg').on('shown.bs.modal', function() {
                    $('#dropping').summernote({ height: 300, focus: true, dialogsInBody: true });
                }).on('hidden.bs.modal', function () {
                    $('#dropping').summernote('code', '');
                    $('#dropping').summernote('destroy');
                });
            });

        </script>

