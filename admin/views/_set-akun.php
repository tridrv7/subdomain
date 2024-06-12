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
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Last Login</th>
                            <th>Level</th>
                            <th>Setting</th>
                        </tr>
                    </thead>
                </table>
                <!-- datatable end -->
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="_modalFormAkun" tabindex="-1" role="dialog" aria-labelledby="_modalFormAkun" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="_mTitle">Title Modal</h5>
                    </div>

                    <form id="_mForm" enctype="multipart/form-data">
                        <div class="modal-body">
							
									<div id="_mAttr" class="form-group row">
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
                                            <select name="us_roles" class="select2 form-control w-100" id="us_roles">
												<?=inOpt('ro_id, ro_name', 'set_role', '_active=1', '', '1')?>
                                            </select>
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


        <!-- Modal -->
        <div class="modal fade" id="_modalFormData" tabindex="-1" role="dialog" aria-labelledby="_modalFormData" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="_mTitle">Title Modal</h5>
                    </div>

                    <form id="_mForm" enctype="multipart/form-data">
                        <div class="modal-body">
							
									<div id="_mAttr" class="form-group row">
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
										<label class="col-sm-12 col-md-3 col-form-label">Level</label>
										<div class="col-sm-12 col-md-9">
                                            <select name="us_roles" class="select2 form-control w-100" id="us_roles">
												<?=inOpt('ro_id, ro_name', 'set_role', '_active=1', '', '1')?>
                                            </select>
									  </div>
									</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm waves-effect waves-themed" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-info btn-sm waves-effect waves-themed" id="_mBtnData">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="_modalFormPwd" tabindex="-1" role="dialog" aria-labelledby="_modalFormPwd" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="_mTitle">Title Modal</h5>
                    </div>
                    <form id="_mForm" enctype="multipart/form-data">
                        <div class="modal-body">
							
									<div id="_mAttr" class="form-group row">
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
                            <button type="button" class="btn btn-secondary btn-sm waves-effect waves-themed" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-info btn-sm waves-effect waves-themed" id="_mBtnPwd">Update Data</button>
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
                
                //validation email
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                
                // initialize datatable
                $('#_table').dataTable(
                {
                    processing: true,
                    serverSide: true,
                    ajax: 'controllers/_pset-akun.php?_act=5',
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
                                    var btnHead ='<div class="dropdown <?=$_upde_class?>">'+
                                                    '<a href="ui_dropdowns.html#" class="btn btn-outline-primary btn-sm rounded-circle btn-icon waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                                                        '<i class="fal fa-ellipsis-v-alt"></i>'+
                                                    '</a>'+
                                                    '<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: top, left; top: 36px; left: 0px;">';
                                    var btnUp = '<a class="dropdown-item getUbah <?=$_up_class?>" href="javascript:void(0)" id="'+row[0]+'" _title="Ubah Data" chg="1"><i class="fal fa-pen-square"></i> Ubah Data</a>';
                                    var btnPwd = '<a class="dropdown-item getUbah <?=$_up_class?>" href="javascript:void(0)" id="'+row[0]+'" _title="Ubah Password" chg="2"><i class="fal fa-key"></i> Ubah Password</a>';
                                    var btnHps = '<a class="dropdown-item getHapus <?=$_de_class?>" href="javascript:void(0)" id="'+row[0]+'" _title="Hapus Data" chg="0"><i class="fal fa-trash-alt"></i> Hapus</a>';
                                    var btnFoot = '</div>'+
                                                '</div>';
                                    
                                    var btn = btnHead+btnUp+btnPwd+btnHps+btnFoot;
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

                    $('#_modalFormAkun').modal('show');                    
                    // reset form
                    $('#_modalFormAkun #_mForm')[0].reset();
                    $('#_modalFormAkun #_mTitle').html(mTitle);
                    $('#_modalFormAkun #_mAttr').html('');
                    $("#_modalFormAkun #_mForm").attr("_act","1");
                    
                    // initialize select2
                    $('#us_roles').select2({
                        dropdownParent: $('#_modalFormAkun'),
                        placeholder: "Pilih Hak Akses",
                        allowClear: true,
                        minimumResultsForSearch: Infinity
                    });
                    $('#us_roles').val('').trigger('change');                                    
                });

                // Proses Simpan Data
                $('#btnSimpan').click(function(){

                    // Validasi form input
                    if ($('#us_nama').val()==""){
                        // focus ke input nama_barang
                        $( "#us_nama" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Nama tidak boleh kosong');
                    } 
                    else if ($('#us_email').val()==""){
                        // focus ke input nama_barang
                        $( "#us_email" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Email tidak boleh kosong');
                    } 
                    else if(!emailReg.test($('#us_email').val())) {
                        // focus ke input nama_barang
                        $( "#us_email" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Periksa kembali Email');
                    } 
                    else if ($('#us_passwd').val()==""){
                        // focus ke input nama_barang
                        $( "#us_passwd" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Password tidak boleh kosong');
                    } 
                    else if ($('#us_passwd2').val()!=$('#us_passwd').val()){
                        // focus ke input nama_barang
                        $( "#us_passwd2" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Periksa kembali password/password tidak sama');
                    } 
                    else if ($('#us_roles').val()==null){
                        // focus ke input nama_barang
                        $( "#us_roles" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Level tidak boleh kosong');
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
                            url  : "controllers/_pset-akun.php",
                            data : data,
                            contentType: false,
                            processData: false,
                            success: function(result){
                                // ketika sukses menyimpan data
                                setTimeout(function(){
                                    //button Loading close
                                    $('#_mBtnData').loadButton('off');
                                    $('#btnSimpan').loadButton('off');
                                    
									//result
									if (result.trim().length===0) {
										// tutup modal tambah data transaksi
										$('#_modalFormAkun').modal('hide');
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
                    var varIDGet = $(this).attr('id');
                    var vGet = $(this).attr('chg');
                    var mTitle = $(this).attr('_title');

                    // tampilkan modal ubah data transaksi
                    if(vGet=='1'){
                        var modalID = 'Data';
                        var _act = '2';
                        
                        $('#_modalForm'+modalID+' #_mForm #us_roles').select2({
                            dropdownParent: $('#_modalForm'+modalID),
                            minimumResultsForSearch: Infinity
                        });

                        $.ajax({
                            type : "POST",
                            url  : "controllers/_pset-akun.php",
                            data : {us_nip : varIDGet, _act : '4'},
                            dataType : "JSON",
                            success: function(result){
                                if(result.stats==404){
                                    toastr["error"](result.msgErrors);
                                } else {
                                    // tampilkan data transaksi 
                                    //SELECT us_nip, us_nama, us_email, us_roles, us_passwd, us_last, _active, usr_cre, usr_cre_date, usr_chg, usr_chg_date FROM m_users	
                                    $('#_modalForm'+modalID+' #us_nama').val(result.us_nama);
                                    $('#_modalForm'+modalID+' #us_email').val(result.us_email);
                                    $('#_modalForm'+modalID+' #us_roles').val(result.us_roles).trigger('change');
                                }
                            }
                        });
                        
                    } else {
                        var modalID = 'Pwd';
                        var _act = '6';
                    }
                    
                    $('#_modalForm'+modalID+' #_mForm')[0].reset();
                    $('#_modalForm'+modalID+' #_mForm').attr('_act', _act);
                    $('#_modalForm'+modalID+' #_mAttr').html('<input type="hidden" class="form-control" id="us_nip" name="us_nip" value="'+varIDGet+'" autocomplete="off" placeholder="NIP" maxlength="18">');
                    
                    // tampilkan modal ubah data transaksi
                    $('#_modalForm'+modalID).modal('show');
                    $('#_modalForm'+modalID+' #_mTitle').html(mTitle);
                });			

                // Proses Simpan Data
                $('#_mBtnData').click(function(){
                    // Validasi form input
                    if ($('#_modalFormData #us_nama').val()==""){
                        // focus ke input nama_barang
                        $('#_modalFormData #us_nama').focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Nama tidak boleh kosong');
                    } 
                    else if ($('#_modalFormData #us_email').val()==""){
                        // focus ke input nama_barang
                        $('#_modalFormData #us_email').focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Email tidak boleh kosong');
                    } 
                    else if(!emailReg.test($('#_modalFormData #us_email').val())) {
                        // focus ke input nama_barang
                        $('#_modalFormData #us_email').focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Periksa kembali Email');
                    } 
                    else if ($('#_modalFormData #us_roles').val()==null){
                        // focus ke input nama_barang
                        $('#_modalFormData #us_roles').focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']('Pilih Hak Akses User');
                    } 

                    // jika semua data sudah terisi, jalankan perintah simpan data
                    else{
                        //button Loading open
                        $(this).loadButton('on', {
                            loadingText: 'Updating Data...',
                        });
                        
                        var data = new FormData($('#_modalFormData #_mForm')[0]);
                        data.append('_act', $("#_modalFormData #_mForm").attr('_act'));
						
                        $.ajax({
                            type : "POST",
                            url  : "controllers/_pset-akun.php",
                            data : data,
                            contentType: false,
                            processData: false,
                            success: function(result){
                                // ketika sukses menyimpan data
                                setTimeout(function(){
                                    //button Loading close
                                    $('#_mBtnData').loadButton('off');
                                    
									//result
									if (result.trim().length===0) {
										// tutup modal tambah data transaksi
										$('#_modalFormData').modal('hide');
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
                
                
                
                // Proses Simpan Password
                $('#_mBtnPwd').click(function(){
                    // Validasi form input
                    if ($('#us_passwdx').val()==""){
                        // focus ke input nama_barang
                        $( "#us_passwdx" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']("Password tidak boleh kosong")
                    } 
                    else if ($('#us_passwdx2').val()==""){
                        // focus ke input nama_barang
                        $( "#us_passwdx2" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']("Konfirm Password tidak boleh kosong")
                    } 
                    else if ($('#us_passwdx2').val()!=$('#us_passwdx').val()){
                        // focus ke input nama_barang
                        $( "#us_passwdx2" ).focus();
                        // tampilkan peringatan data tidak boleh kosong
                        toastr['warning']("Periksa kembali password/password tidak sama");
                    } 
                    // jika semua data sudah terisi, jalankan perintah simpan data
                    else{
                        //button Loading open
                        $(this).loadButton('on', {
                            loadingText: 'Updating Data...',
                        });
                        
                        var data = new FormData($('#_modalFormPwd #_mForm')[0]);
                        data.append('_act', $("#_modalFormPwd #_mForm").attr('_act'));

                        $.ajax({
                            type : "POST",
                            url  : "controllers/_pset-akun.php",
                            data : data,
                            contentType: false,
                            processData: false,
                            success: function(result){     
                                // ketika sukses menyimpan data
                                setTimeout(function(){
                                    //button Loading close
                                    $('#_mBtnPwd').loadButton('off');
                                    
									//result
									if (result.trim().length===0) {
										// tutup modal tambah data transaksi
										$('#_modalFormPwd').modal('hide');
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
                
                
                // Hapus Data ==========================================================================================
                // ----------------------------------------------------------------------------------------------------
                $('#_table tbody').on( 'click', '.getHapus', function (){
                    var varIDGet = $(this).attr('id');
                    var vGet = $(this).attr('chg');
                    
                    var vConfirm = '<form id="_mForm" enctype="multipart/form-data">'+
                                        '<input type="hidden" id="us_nip" name="us_nip" value="'+varIDGet+'">'+
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
					var lText = '';
					if($('#_active').val()==0){
						lText = 'Hapus';
					} else {
						lText = 'Aktifkan';
					}
					
                    //button Loading open
                    $(this).loadButton('on', {
                        loadingText: lText+' Data...',
                    });

                    var data = new FormData($('#_modalConfirm #_mForm')[0]);
                    data.append('_act', '3');

                    $.ajax({
                        type : "POST",
                        url  : "controllers/_pset-akun.php",
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

