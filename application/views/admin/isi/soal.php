<h3>Daftar Soal</h3>
<button class="btn btn-danger" onclick="tambah_soal()"><i class="bi bi-plus-circle-fill"></i> Tambah Soal</button>
<button class="btn btn-warning" onclick="reload_soal()"><i class="bi bi-arrow-clockwise"></i> Reload</button>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="20">
                        <div class="text-center">No</div>
                    </th>
                    <th class="text-center" >Soal</th>
                    <th id="gambar_tampil" class="text-center" width="250px">Gambar</th>
                    <th width="100px">
                        <div class="text-center">Status Soal</div>
                    </th>
                    <th style="inline-size:100px;">
                        <div class="text-center">Tindakan</div>
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<br><br><br>
<script src="<?= base_url(); ?>assets/js/jquery-1.12.4.min.js"></script>

<script type="text/javascript">
    var save_method;
    var table;
    $(document).ready(function () {
        table = $('#table').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('admin/ajax_list_soal') ?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [-1],
                    "orderable": false,
                },
            ],
        });
        $("input").change(function () {
            $(this).parent().parent().removeClass('is-invalid');
            $(this).next().empty();
        });
        
        $("select").change(function () {
            $(this).parent().parent().removeClass('is-invalid');
            $(this).next().empty();
        });
        
    });

    function tambah_soal() {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Soal');
    }
    function reload_soal() {
        table.ajax.reload(null, false);
    }

    function edit_soal(id_soal) {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url: "<?php echo site_url('admin/edit_soal/') ?>/" + id_soal,
            type: "GET",
            dataType: "JSON",
            success: function (data) 
            {
                $('[name="id_soal"]').val(data.id_soal);
                $('[name="soalnya"]').val(data.soalnya);
                $('[name="pilihan_a"]').val(data.pilihan_a);
                $('[name="pilihan_b"]').val(data.pilihan_b);
                $('[name="pilihan_c"]').val(data.pilihan_c);
                $('[name="pilihan_d"]').val(data.pilihan_d);
                $('[name="pilihan_e"]').val(data.pilihan_e);
                $('[name="jawaban"]').val(data.jawaban);
                $('[name="status_soal"]').val(data.status_soal);

                if (!data.gambarnya) {
                    var imagePath = "<?php echo base_url('./assets/gambar'); ?>";
                    $('#existing_image').attr('src', imagePath).show();
                } else {
                    var imagePath = "<?php echo base_url('./assets/gambar'); ?>" + data.gambarnya;
                    $('#existing_image').attr('src', imagePath).show();
                }
                $('[name="gambarnya"]').val("");
                $('#modal_form').modal('show');
                $('.modal-title').text('Edit Soal');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function simpan() {
        $('#btnSave').text('Menyimpan...');
        $('#btnSave').attr('disabled', true);
        var url;
        
        if (save_method == 'add') {
            url = "<?php echo site_url('admin/ajax_add_soal') ?>";
        } else {
            url = "<?php echo site_url('admin/ajax_update_soal') ?>";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($('#form')[0]),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "JSON",
            success: function (data) 
            {
                if (data.status) 
                {
                    $('#modal_form').modal('hide');
                    reload_soal();
                    Swal.fire({
                        position: 'top-middle',
                        icon: 'success',
                        title: 'Data telah tersimpan',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else 
                {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    }
                    
                }
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan pada server!',
                });
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
            }
        });
    }

    function delete_soal(id_soal) {
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
                    url: "<?php echo site_url('admin/ajax_delete_soal') ?>/" + id_soal,
                    type: "POST",
                    dataType: "JSON",
                    success: function (data) {
                        $('#modal_form').modal('hide');
                        reload_soal();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Soal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <div class="mb-3">
                            <input type="hidden" value="" name="id_soal" />
                            <label class="form-label">Soal</label>
                            <input type="text" class="form-control" name="soalnya" placeholder="Soal">
                            <span class="help-block"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilihan A</label>
                            <input type="text" class="form-control" name="pilihan_a" placeholder="Pilihan A">
                            <span class="help-block"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilihan B</label>
                            <input type="text" class="form-control" name="pilihan_b" placeholder="Pilihan B">
                            <span class="help-block"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilihan C</label>
                            <input type="text" class="form-control" name="pilihan_c" placeholder="Pilihan C">
                            <span class="help-block"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilihan D</label>
                            <input type="text" class="form-control" name="pilihan_d" placeholder="Pilihan D">
                            <span class="help-block"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilihan E</label>
                            <input type="text" class="form-control" name="pilihan_e" placeholder="Pilihan E">
                            <span class="help-block"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jawaban</label>
                            <select name="jawaban" class="form-control">
                                <option value="">--Pilih Jawaban--</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Soal</label>
                            <select name="status_soal" class="form-control">
                                <option value="">--Pilih Status--</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar</label><br>
                            <input type="file" class="form-control" id="gambarnya" name="gambarnya"> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="simpan()" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>