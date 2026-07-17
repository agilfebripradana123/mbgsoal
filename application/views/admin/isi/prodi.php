<h3>Daftar Prodi</h3>
<br />
<button class="btn btn-danger" onclick="tambah_prodi()">
	<i class="glyphicon glyphicon-plus"></i> Tambah Prodi
</button>
<button class="btn btn-warning" onclick="reload_table()">
	<i class="glyphicon glyphicon-refresh"></i> Reload
</button>
<br /><br />
<div class="row">
	<div class="col-md-12">
		<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="20">
						<div class="text-center">No</div>
					</th>
					<th width="300px">Nama Fakultas</th>
					<th>Nama Program Studi</th>
					<th width="80px">
						<div class="text-center">Status</div>
					</th>
					<th style="inline-size: 125px">
						<div class="text-center">Tindakan</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<!-- Table body content will be dynamically populated -->
			</tbody>
		</table>
	</div>
</div>

<!-- JavaScript code -->
<script src="<?=base_url(); ?>assets/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    var save_method;
    var table;
	$(document).ready(function() {
    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('admin/ajax_list_prodi')?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [-1],
                "orderable": false
            }
        ]
    });

    $("input").change(function() {
        $(this).parent().parent().removeClass('is-invalid');
        $(this).next().empty();
    });

    $("select").change(function() {
        $(this).parent().parent().removeClass('is-invalid');
        $(this).next().empty();
    });
});
    // Function to add a new program
    function tambah_prodi() {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Fakultas');
		
    }

    // Function to reload table data
    function reload_table() {
        table.ajax.reload(null, false);
    }

		// Function to edit a program
		function edit_prodi(id_prodi) {
			save_method = "update";
			$("#form")[0].reset();
			$(".form-group").removeClass("has-error");
			$(".help-block").empty();
			$.ajax({
				url: "<?php echo site_url('admin/ajax_edit_prodi/')?>/" + id_prodi,
				type: "GET",
				dataType: "JSON",
				success: function (data) {
					$('[name="id_prodi"]').val(data.id_prodi);
					$('[name="id_fakultas"]').val(data.id_fakultas);
					$('[name="nama_prodi"]').val(data.nama_prodi);
					$('[name="status_prodi"]').val(data.status_prodi);
					$("#modal_form").modal("show");
					$(".modal-title").text("Edit Program Studi");
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert("Error getting data from ajax");
				},
			});
		}

		// Function to save program data
		function simpan() {
			$("#btnSave").text("saving...");
			$("#btnSave").attr("disabled", true);
			var url;
			if (save_method == "add") {
				url = "<?php echo site_url('admin/ajax_add_prodi')?>";
			} else {
				url = "<?php echo site_url('admin/ajax_update_prodi')?>";
			}
			$.ajax({
				url: url,
				type: "POST",
				data: $("#form").serialize(),
				dataType: "JSON",
				success: function (data) {
					if (data.status) {
						$("#modal_form").modal("hide");
						reload_table();
						Swal.fire({
							position: "top-middle",
							icon: "success",
							title: "Data telah tersimpan",
							showConfirmButton: false,
							timer: 2000,
						});
					} else {
						for (var i = 0; i < data.inputerror.length; i++) {
							$('[name="' + data.inputerror[i] + '"]')
								.parent()
								.parent()
								.addClass("is-invalid");
							$("[name='" + data.inputerror[i] + "']")
								.next()
								.text(data.error_string[i]);
						}
					}
					$("#btnSave").text("Simpan");
					$("#btnSave").attr("disabled", false);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert("Error adding / updating data");
					$("#btnSave").text("Simpan");
					$("#btnSave").attr("disabled", false);
				},
			});
		}

		// Function to delete a program
		function delete_prodi(id_prodi) {
			Swal.fire({
				title: "Yakin untuk menghapus?",
				text: "Data tidak bisa kembali setelah dihapus!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya, Hapus sekarang!",
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: "<?php echo site_url('admin/ajax_delete_prodi')?>/" + id_prodi,
						type: "POST",
						dataType: "JSON",
						success: function (data) {
							$("#modal_form").modal("hide");
							reload_table();
						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert("Error deleting data");
						},
					});
				}
			});
		}

</script>

<div class="modal fade" id="modal_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fa-5" id="staticBackdroplabel">
					Form Program Studi
				</h1>
				<button
					type="button"
					class="btn-close"
					data-bs-dismiss="modal"
					aria-label="Close"
				></button>
			</div>
			<div class="modal-body">
				<form action="" id="form" class="form-horizontal">
					<div class="form-group">
						<input type="hidden" value="" name="id_prodi" />
						<label class="form-label">Nama Program Studi</label>
						<input
							type="text"
							class="form-control"
							name="nama_prodi"
							placeholder="Nama Program Studi"
						/>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label class="form-label">Fakultas</label>
						<select name="id_fakultas" class="form-control">
							<option value="">Pilih Fakultas</option>
							<!-- Loop through fakultas options -->
							<?php foreach ($fakultas as $fak) { ?>
							<option value="<?php echo $fak->id_fakultas; ?>">
								<?php echo $fak->nama_fakultas; ?>
							</option>
							<?php } ?>
						</select>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label class="form-label">Status Program Studi</label>
						<select name="status_prodi" class="form-control">
							<option value="">Pilih Status</option>
							<option value="Aktif">Aktif</option>
							<option value="Tidak Aktif">Tidak Aktif</option>
						</select>
						<span class="help-block"></span>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button
					type="button"
					id="btnSave"
					onclick="simpan()"
					class="btn btn-primary">
					Simpan
				</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					Batal
				</button>
			</div>
		</div>
	</div>
</div>
