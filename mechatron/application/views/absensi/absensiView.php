<div id="page-content-wrapper">
            <div id="page-content">
        <h1 style="font-size:20pt">ABSENSI</h1>
        <br />
        <button class="btn btn-success" onclick="add_absensi()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="width:10px;">No</th>
                    <th>Nama absensi</th>
                    <th>Tanggal</th>
                    <th>Jam masuk</th>
                    <th>Jam keluar</th>
                    <th>Kegiatan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

           
        </table>
    </div>
    </div>

<!--<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>-->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>

<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('absensi/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

    //datepicker
  

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});

function add_absensi()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah absensi'); // Set Title to Bootstrap modal title
}

function edit_absensi(id_absensi)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('absensi/ajax_edit/')?>/" + id_absensi,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id_absensi"]').val(data.id_absensi);
            $('[name="karyawan_id"]').val(data.karyawan_id);
            $('[name="tanggal"]').val(data.tanggal);
            $('[name="jam_masuk"]').val(data.jam_masuk);
            $('[name="jam_keluar"]').val(data.jam_keluar);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit absensi'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('absensi/ajax_add')?>";
    } else {
        url = "<?php echo site_url('absensi/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_absensi(id_absensi)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('absensi/ajax_delete')?>/"+id_absensi,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">absensi Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_absensi"/> 
                    <div class="form-body">
                        <div class="form-group">

                            <label class="control-label col-md-3">Nama karyawan</label>
                            <div class="col-md-9">
                                <input name="karyawan_id" placeholder="Nama karyawan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>

                            <label class="control-label col-md-3">Tanggal</label>
                            <div class="col-md-9">
                                <input name="tanggal" placeholder="Tanggal" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>

                            <label class="control-label col-md-3">Jam masuk</label>
                            <div class="col-md-9">
                                <input name="jam_masuk" placeholder="Jam masuk" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>

                            <label class="control-label col-md-3">Jam keluar</label>
                            <div class="col-md-9">
                                <input name="jam_keluar" placeholder="Jam keluar" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>

                            <label class="control-label col-md-3">Kegiatan</label>
                            <div class="col-md-9">
                                <input name="kegiatan" placeholder="Kegiatan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>

                        </div>
                       
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->