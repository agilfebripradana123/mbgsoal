<div class="row">
	<div class="col-sm-3">
		<h2 class="text-center"></h2>
	</div>
	<div class="col-sm-6"><br><br>
		<h2 class="text-center">Pendaftaran Pengguna Baru</h2><br><br>
		<form action="#" id="form_pendaftaran">
			<div class="row mb-3 form-group">
				<label for="inputEmail3" class="col-sm-4 col-form-label">Nama Pengguna</label>
				<div class="col-sm-8">
					<input type="input" name="nama_user" class="form-control">
					<span class="help-block"></span>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputEmail3" class="col-sm-4 col-form-label">Username</label>
				<div class="col-sm-8">
					<input type="input" name="username" class="form-control">
					<span class="help-block"></span>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputPassword3" class="col-sm-4 col-form-label">Password</label>
				<div class="col-sm-8">
					<input type="password" name="password" class="form-control">
					<span class="help-block"></span>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputPassword3" class="col-sm-4 col-form-label">Ketik Ulang Password</label>
				<div class="col-sm-8">
					  <input type="password"  name="password_ulang" class="form-control">
					  <span class="help-block"></span>
				</div>
			</div>
			<div class="d-grid gap-2">
				 <button type="button" class="btn btn-danger form-control" id="btnSave" onclick="daftar()">Mendaftar</button>
			</div>
		</form>
	</div>
	<div class="col-sm-3">
		
	</div>
</div>
		
<script src="<?=base_url();?>assets/js/jquery-1.12.4.min.js"></script>
   
<script type="text/javascript">		
$(document).ready(function() {
	$("input").change(function(){
		$(this).parent().parent().removeClass('is-invalid');
		$(this).next().empty();
	});	 
});

function daftar()
{  
    $.ajax({
        url : "<?php echo site_url('pendaftaran/simpan_pendaftaran')?>",
        type: "POST",
        data: $('#form_pendaftaran').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) 
            {	
				window.location = "<?=base_url('login');?>";
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('is-invalid'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
            $('#btnSave').text('Mendaftar');
            $('#btnSave').attr('disabled',false);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('data error, Error Login');
            $('#btnSave').text('Mendaftar');
            $('#btnSave').attr('disabled',false);
        }
    });
}
</script>