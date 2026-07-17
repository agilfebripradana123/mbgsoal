<h3>Daftar Fakultas</h3>
        <br />
        <button class="btn btn-danger" onclick="tambah_fakultas()"><i class="bi bi-plus-circle-fill"></i> Tambah Fakultas</button>
        <button class="btn btn-warning" onclick="reload_table()"><i class="bi bi-arrow-clockwise"></i> Reload</button>
        <br /><br />
  <div class="row">
    <div class="col-12">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="20"><div class="text-center">No</div></th>
					<th>Nama Fakultas</th>
                    <th width="90px"><div class="text-center">Status</div></th>
                    <th style="inline-size:135px;"><div class="text-center">Tindakan</div></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
  </div>
<script src="<?=base_url();?>assets/js/jquery-1.12.4.min.js"></script>
   
<script type="text/javascript">
var save_method; 
var table;
$(document).ready(function() {
    table = $('#table').DataTable({ 

        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "ajax": {
            "url": "<?php echo site_url('Admin/ajax_fakultas')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false, 
        },
        ],
    });
    $("input").change(function(){
        $(this).parent().parent().removeClass('is-invalid');
        $(this).next().empty();
    });

    $("select").change(function(){
        $(this).parent().parent().removeClass('is-invalid');
        $(this).next().empty();
    });
});

function tambah_fakultas()
{
    save_method = 'add';
    $('#form')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah Fakultas'); 
}

function reload_table()
{
    table.ajax.reload(null,false); 
}

function editFakultas(id_fakultas)
{
    save_method = 'update';
    $('#form')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 

    $.ajax({
        url : "<?php echo site_url('admin/edit_fakultas/')?>/" + id_fakultas,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id_fakultas"]').val(data.id_fakultas);
            $('[name="nama_fakultas"]').val(data.nama_fakultas);
            $('[name="status_fakultas"]').val(data.status_fakultas);
            $('#modal_form').modal('show'); 
            $('.modal-title').text('Edit Fakultas'); 

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function simpan()
{
    $('#btnSave').text('saving...'); 
    $('#btnSave').attr('disabled',true); 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('admin/tambah_fakultas')?>";
    } else {
        url = "<?php echo site_url('admin/update_fakultas')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.status) 
            {
                $('#modal_form').modal('hide');
                reload_table();
				Swal.fire({
				  position: 'top-middle',
				  icon: 'success',
				  title: 'Data telah tersimpan',
				  showConfirmButton: false,
				  timer: 2000
				})
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('is-invalid'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                }
            }
            $('#btnSave').text('simpan'); 
            $('#btnSave').attr('disabled',false); 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('simpan'); 
            $('#btnSave').attr('disabled',false); 
        }
    });
}

function deleteFakultas(id_fakultas)
{
    Swal.fire({
	  title: 'Yakin untuk menghapus??',
	  text: "Data tidak bisa kembali setelah dihapus!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Ya, Hapus sekarang!'
	}).then((result) => {
	  if (result.isConfirmed) {
		  $.ajax({
            url : "<?php echo site_url('admin/hapus_fakultas')?>/"+id_fakultas,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
		Swal.fire(
		  'Hapus!',
		  'File telah berhasil di hapus',
		  'success'
		)
	  }
	})	
}
</script>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">Form Fakultas</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<div class="form-body">
                <form action="#" id="form" class="form-horizontal">
					<div class="mb-3">
							<input type="hidden" value="" name="id_fakultas"/> 
							<label  class="form-label">Nama Fakultas</label>
							<input type="text" class="form-control" name="nama_fakultas" placeholder="Nama Fakultas">
							<span class="help-block"></span>
						  </div>
						  <div class="mb-3">
							<label class="form-label">Status Fakultas</label>
							<select name="status_fakultas" class="form-control">
                                    <option value="">--Pilih Status--</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                                <span class="help-block"></span>
						  </div>
                </form>
				</div>
            </div>
            <div class="modal-footer">
				<button type="button" id="btnSave" onclick="simpan()" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
</div>
</div>