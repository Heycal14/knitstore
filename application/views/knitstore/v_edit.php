<div class="col-md-12">
    <!-- general form elements disabled -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"> Edit knitstore</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php
            //notifikasi form kosong
            echo validation_errors('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-info"></i>', '</h5> </div>');

            //notifikasi gagal upload gambar
            if (isset($error_upload)) {
                echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-info"></i>' . $error_upload . '</h5> </div>';
            }

            echo form_open_multipart('knitstore/edit/' . $knitstore->id_knitstore) ?>
            <div class="form-group">
                <label>Nama Barang</label>
                <input name="judul" type="text" class="form-control" placeholder="Nama Barang" value="<?= $knitstore->judul ?>">
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control">
                            <option value="<?= $knitstore->id_kategori ?>"><?= $knitstore->nama_kategori ?></option>
                            <?php foreach ($kategori as $key => $value) { ?>
                                <option value="<?= $value->id_kategori ?>"><?= $value->nama_kategori ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>harga knitstore</label>
                        <input name="harga" type="text" class="form-control" placeholder="harga knitstore" value="<?= $knitstore->harga ?>">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>berat knitstore</label>
                        <input name="berat" type="text" class="form-control" placeholder="berat knitstore" value="<?= $knitstore->berat ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi knitstore</label>
                <textarea name="deskripsi" class="form-control" rows="5" placeholder="Deskripsi knitstore"><?= $knitstore->deskripsi ?></textarea>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Gambar knitstore</label>
                        <input type="file" name="gambar" class="form-control" id="preview_gambar">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <img src="<?= base_url('assets/gambar/' . $knitstore->gambar) ?>" id="gambar_load" width="300px">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a href="<?= base_url('knitstore') ?>" class="btn btn-success btn-sm">Kembali</a>
                </div>

                <?php echo form_close() ?>
            </div>
        </div>
    </div>
    <script>
        function bacaGambar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#gambar_load').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#preview_gambar").change(function() {
            bacaGambar(this);
        });
    </script>
