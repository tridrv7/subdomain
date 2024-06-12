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
                        <th>Halaman</th>
                        <th>setting</th>
                    </tr>
                </thead>
            </table>
            <!-- datatable end -->
        </div>
    </div>



        <!-- Modal -->
        <div class="modal fade" id="_modalPage" tabindex="-1" role="dialog" aria-labelledby="_modalPage" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="_mTitle">Title Modal</h5>
                    </div>

                    <form id="_mForm">
                        <div class="modal-body">
							
                          <div id="_mAttr">
                            </div>
                          <div class="form-group">
                            <label>Nama</label>
                              <input type="text" class="form-control text-capitalize" id="page_name" name="page_name" autocomplete="off">
                            </div>
                          <div class="form-group">
                            <label>link</label>
                              <input type="text" class="form-control" id="page_addr" name="page_addr" autocomplete="off">
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


        <script type="text/javascript">
		
        $(document).ready(function(){
            // initiate plugin ====================================================================================
            // ----------------------------------------------------------------------------------------------------

            
            // initialize datatable
            $('#_table').dataTable(
            {
                processing: true,
                serverSide: true,
                ajax: 'controllers/_pset-page.php?_act=5',
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
                                                '<a class="dropdown-item getUbah <?=$_up_class?>" href="javascript:void(0)" id="'+row[0]+'" chg="1"><i class="fal fa-pen-square"></i> Ubah Data</a>'+
                                                '<a class="dropdown-item btnHapus <?=$_de_class?>" href="javascript:void(0)" id="'+row[0]+'"><i class="fal fa-trash-alt"></i> Hapus</a>'+
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
            
            // dataTables plugin
            /*
            $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
            {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };
            // ====================================================================================================

            // Tampil Data ========================================================================================
            // ----------------------------------------------------------------------------------------------------
            // datatables serverside processing
            var table = $('#_table').DataTable( {
                "bAutoWidth": false,
                //"scrollY": '58vh',
                "scrollCollapse": true,
                "processing": true,
                "serverSide": true,
                "ajax": 'controllers/_pset-page.php?_act=5',     // panggil file data_transaksi.php untuk menampilkan data transaksi dari database
                "columnDefs": [ 
                    { "targets": 0, "data": null, "orderable": false, "searchable": false, "width": '5px', "className": 'center' },
                    { "targets": 1, "width": '150px', "visible": false, "searchable": false },
                    { "targets": 2, "width": '150px', "className": 'left' },
                    {
                      "targets": 3, "orderable": false, "searchable": false, "width": '5px', "className": 'right',
                      "render": function(data, type, row) {
                          var btn1 = "<a style=\"margin-right:20px\" title=\"Ubah\" class=\"getUbah\" href=\"javascript:void();\" id="+data+"><i class=\"icon-copy dw dw-edit-1\"></i></a>";
                          var btn2 = "<a style=\"margin-right:20px\" title=\"Rules\" class=\"getRules\" href=\"javascript:void()\" id="+data+"><i class=\"micon dw dw-diagram\"></i></a>";
                          var btn3 = "<a title=\"Hapus\" class=\"btnHapus\" href=\"javascript:void()\" id="+data+"><i class=\"icon-copy dw dw-trash\"></i></a>";
                          
                          var btn = btn1+btn2+btn3;
                          return btn;
                      } 
                    } 
                ],
                "order": [[ 1, "DESC" ]],           // urutkan data berdasarkan id_transaksi secara descending
                "iDisplayLength": 10,               // tampilkan 10 data
                "rowCallback": function (row, data, iDisplayIndex) {
                    var info   = this.fnPagingInfo();
                    var page   = info.iPage;
                    var length = info.iLength;
                    var index  = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                }
            } );
            */
            // ====================================================================================================

            // Simpan Data ========================================================================================
            // ----------------------------------------------------------------------------------------------------
            // Tampikan Form Tambah Data
            $('.btnTambah').click(function(reload){
                $('#_modalPage').modal('show');                    
                
                // reset form
                $('#_mForm')[0].reset();
				$("#_mForm").attr("_act","1");
				$('#_mTitle').html($(this).attr('_title'));
				$('#_mAttr').html('');				
            });

            // Proses Simpan Data
            $('#btnSimpan').click(function(){
                // Validasi form input
                // jika tanggal kosong
                if ($('#page_name').val()==""){
                    // focus ke input tanggal
                    $( "#page_name" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Nama Halaman tidak boleh kosong", "warning");
                } else 
                if ($('#page_addr').val()==""){
                    // focus ke input tanggal
                    $( "#page_addr" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Link Halaman tidak boleh kosong", "warning");
                }
                // jika semua data sudah terisi, jalankan perintah simpan data
                else{
					$(this).loadButton('on', {
						loadingText: 'Simpan Data...',
					});
					
                    var data = $('#_mForm').serialize();
					var _act = $("#_mForm").attr('_act');
				
                    $.ajax({
                        type : "POST",
                        url  : "controllers/_pset-page.php?_act="+_act,
                        data : data,
                        success: function(result){
							// ketika sukses menyimpan data
							setTimeout(function(){
								//button Loading close
								$('#btnSimpan').loadButton('off');

								//result
								if (result.trim().length===0) {
									// tutup modal tambah data transaksi
									$('#_modalPage').modal('hide');
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
				
				var page_id = $(this).attr('id');

				$('#_mTitle').html('Ubah Data Page');
				$('#_mAttr').html('<input type="hidden" class="form-control" id="page_id" name="page_id" autocomplete="off" value="'+page_id+'">');
				$("#_mForm").attr("_act","2");

				$.ajax({
                    type : "GET",
                    url  : "controllers/_pset-page.php?_act=4",
                    data : {page_id:page_id},
                    dataType : "JSON",
                    success: function(result){
                        // tampilkan modal ubah data transaksi
                        $('#_modalPage').modal('show');
						
                        // tampilkan data transaksi
                        $('#page_id').val(result.page_id);
                        $('#page_name').val(result.page_name);
                        $('#page_addr').val(result.page_addr);
                    }
                });
            });

            
            // Proses Confirm Hapus Data ==================================================================================
            // ----------------------------------------------------------------------------------------------------
            $('#_table tbody').on( 'click', '.btnHapus', function (){
				var varIDGet = $(this).attr('id');

				var vConfirm = '<form id="_mForm" enctype="multipart/form-data">'+
									'<input type="hidden" id="page_id" name="page_id" value="'+varIDGet+'">'+
								'<form>';

				$('#_modalConfirm').modal('show');
				$('#_modalConfirm .modal-body').html('Data ini akan dihapus?'+vConfirm);
				$('#_mBtnConfirm').html('Hapus');
			});			
            // ====================================================================================================
            
            // Proses Confirm Hapus Data ==================================================================================
            // ----------------------------------------------------------------------------------------------------
			$('#_mBtnConfirm').click(function(){
				//button Loading open
				$(this).loadButton('on', {
					loadingText: 'Hapus Data...',
				});

				var data = new FormData($('#_modalConfirm #_mForm')[0]);
				data.append('_act', '3');

				$.ajax({
					type : "POST",
					url  : "controllers/_pset-page.php",
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
