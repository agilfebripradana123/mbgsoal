<div class="row">
	<div class="col-2">
		<div id="gambar_tampil"></div>
	</div>
    <div class="col-10">
      <form id="form_update">
		  <div class="row mb-3">
			<label for="inputPassword3" class="col-sm-2 col-form-label">Username</label>
			<div class="col-sm-10">
			 <input type="text" name="id_user" value="<?=$profil->id_user;?>" hidden>
			  <input type="text" class="form-control" name="username" value="<?=$profil->username;?>" readonly>
			  <span class="help-block"></span>
			</div>
		  </div>
		  <div class="row mb-3">
			<label  class="col-sm-2 col-form-label">Nama Pengguna</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" name="nama_user" value="<?=$profil->nama_user;?>">
			  <span class="help-block"></span>
			</div>
		  </div>
		  <div class="row mb-3">
			<label  class="col-sm-2 col-form-label">Photo</label>
			<div class="col-sm-10">
			   <input name="userfile" type="file"><br><small>Support : jpg | png | jpeg | bmp [200px x 250px]</small>
			  <span class="help-block"></span>
			</div>
		  </div>
		  <div class="row mb-3">
			<div class="col-sm-10 offset-sm-2">
				<button type="button" class="btn btn-primary" onclick="update()">Update</button>
			</div>
		  </div>
		</form>
    </div>
  </div>
<script src="<?=base_url();?>assets/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript">		
$(document).ready(function() {
	$("input").change(function(){
		$(this).parent().parent().removeClass('is-invalid');
		$(this).next().empty();
	});	 
	tampilkan_gambar();
});

function tampilkan_gambar()
{
	 $('#gambar_tampil').load('<?php echo base_url('admin/ajax_gambar')?>');
}

function update()
{  
    var data = new FormData($('#form_update')[0]);
	$.ajax({
        url : "<?php echo site_url('admin/update_profil')?>",
		type: "POST",
        data: data,
		mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
            if(data.status) 
            {	
				Swal.fire(
				  'Berhasil',
				  'Update profil berhasil',
				  'success'
				)
				tampilkan_gambar();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('is-invalid'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
            $('#btnSave').text('Update');
            $('#btnSave').attr('disabled',false);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('data error, Error Update');
            $('#btnSave').text('Update');
            $('#btnSave').attr('disabled',false);
        }
   });
}
</script>