<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <!-- Page Heading -->
        <div class="col-md-12 text-center">
            <h1 class="h4 mb-2 text-gray-800">Pengaturan</h1>
            <hr class="sidebar-divider">
        </div>

        <!-- DataTales Example -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Pengaturan Akun</h6>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('message') ?>
                    <form action="<?= base_url('admin/setting') ?>" method="post">
                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                        <?php if($user['role_id'] !== '1') : ?>
                            <div class="form-group row mb-4">
                                <label class="col-lg-10 control-label">Link Referral</label>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input style="font-weight:bold" type="text" class="form-control" value="<?= base_url('rs?id=') . $user['kode_reff'] ?>" readonly="">
                                        <button data-toggle="tooltip" title="Salin Referral" class="btn btn-primary btn-sm" id="clipboard" data-ref="<?= base_url('rs?id=') . $user['kode_reff'] ?>"><i class="fa fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" value="<?= $user['email']; ?>" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['nama']; ?>">
                            <?= form_error('siswa', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea type="text" class="form-control" name="alamat"><?= $user['alamat']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Nomor Hp</label>
                            <input type="number" class="form-control" name="no_hp" value="<?= $user['telp']; ?>">
                        </div>

                        <button type="reset" class="btn btn-danger btn-rd5" onclick="document.getElementById('InputID').value = ''">Ulangi</button>
                        <button type="submit" name="kirim" class="btn btn-primary btn-rd5">Submit</button>
                    </form>
                </div>
            </div>
        </div>


        <!-- DataTales Example -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Ganti Password</h6>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('messagepp') ?>
                    <form action="<?= base_url('admin/edit_pass') ?>" method="post">
                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                        <div class="form-group">
                            <label for="old_password">Password Lama</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" onfocus=this.value=''>
                            <?= form_error('old_password', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="password1">Password Baru</label>
                            <input type="password" class="form-control" id="password1" name="password1" onfocus=this.value=''>
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="password2">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password2" name="password2" onfocus=this.value=''>
                            <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <button type="reset" class="btn btn-danger btn-rd5" onclick="document.getElementById('InputID').value = ''">Ulangi</button>
                        <button type="submit" name="kirim" class="btn btn-primary btn-rd5">Ganti Password</button>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.container-fluid -->

<script type="text/javascript">
$(document).ready(function(){
    $('#clipboard').on("click", function(){
        value = $(this).data('ref');
 
        var $temp = $("<input>");
          $("body").append($temp);
          $temp.val(value).select();
          document.execCommand("copy");
          $temp.remove();
          
          // Use notify.js to display a notification
          $(alert("URL Sudah Tercopy!", "success"));
          
    })
})
</script>