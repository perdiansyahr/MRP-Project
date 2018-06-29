<!doctype html>
<html>
    <head>
        <title>Serverside Datatables Codeigniter - harviacode</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css') ?>"/>
        <link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css') ?>"/>
        <style>
            .dataTables_wrapper {
                min-height: 500px
            }
            
            .dataTables_processing {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 100%;
                margin-left: -50%;
                margin-top: -25px;
                padding-top: 20px;
                text-align: center;
                font-size: 1.2em;
                color:grey;
            }
        </style>        
    </head>
    <body>
        <div class="container">
            <h2>City Country - Harviacode</h2>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                        <?php echo anchor(site_url('status_view/create'), 'Create', 'class="btn btn-primary"'); ?>
                </div>
                <div class="col-md-4 text-center">
                    <div style="margin-top: 4px"  id="message">
                            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                        <?php echo anchor(site_url('status_view/excel'), 'Excel', 'class="btn btn-primary"'); ?>
                </div>
            </div>
            <table class="table table-bordered table-striped" id="mytable">
                <thead>
                    <tr>
	                  <th width="80px">No</th>
			          <th>Nama</th>
			          <th>Tempat Lahir</th>
			          <th>Tanggal Lahir</th>
			          <th>Jenis Kelamin</th>
			          <th>No. Telp</th>
			          <th>Status</th>
			          <th>Posisi</th>
			          <th>Tanggal Masuk</th>
			          <th>Tanggal Keluar</th>   
			          <th>Action</th> 
                    </tr>
                </thead>
            </table>
        </div>
        
        <!-- Modal Hapus Produk-->
      <form id="add-row-form" action="<?php echo base_url().'index.php/karyawan/delete'?>" method="post">
         <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel">Hapus Produk</h4>
                   </div>
                   <div class="modal-body">
                           <input type="hidden" name="karyawanid" class="form-control" placeholder="Id Karyawan" required>
                                                 <strong>Anda yakin mau menghapus record ini?</strong>
                   </div>
                   <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" id="add-row" class="btn btn-success">Hapus</button>
                   </div>
                    </div>
            </div>
         </div>
     </form>
        
        <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>" ></script>
        <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>" ></script>
        <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
        <script type="text/javascript">


            $(document).ready(function() {
                $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
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
 
                var t = $("#mytable").dataTable({
                    initComplete: function() {
                        var api = this.api();
                        $('#mytable_filter input')
                                .off('.DT')
                                .on('keyup.DT', function(e) {
                                    if (e.keyCode == 13) {
                                        api.search(this.value).draw();
                            }
                        });
                    },
                    "oLanguage": {
                        "sProcessing": "loading..."
                    },
                    "processing": true,
                    "serverSide": true,
                    
                    "ajax": {"url": "karyawan/json", "type": "POST"},
                    "columns": [
                        {
                            data: 'id_karyawan',
                            orderable: 'false'
                        },
                        {data: 'nama'},
                        {data: 'tempat_lahir'},
                        {data: 'tgl_lahir'},
                        {data: 'jenis_kelamin'},
                        {data: 'no_telp'},
                        {data: 'nama_posisi'},
                        {data: 'nama_status'},
                        {data: 'tgl_masuk'},
                        {data: 'tgl_keluar'},
                        {data: 'view'}

                    ],
                    "order": [[1, 'asc']],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
            });
        </script>
    </body>
</html>