<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <!-- Page Heading -->
        <div class="col-md-12 text-center">
            <h1 class="h4 mb-2 text-gray-800"><i class="pt-3 fa fa-comments fa-fw"></i>Topik : <?= $konseling['topik'] ?></h1>
            <hr class="sidebar-divider">
        </div>

        <!-- DataTales Example -->
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="mt-2 font-weight-bold text-primary">Pengajuan : <?= mediumdate_indo(date($konseling['tgl_pengajuan'])); ?>
                        <a href="<?= base_url('admin/konseling') ?>" class="p-2 badge badge-danger float-right"><i class="fa fa-angle-double-left"></i> Kembali</a>
                    </h6>
                </div>
                <div class="card-header py-3 alert alert-secondary">
                    <p><b>Solusi :</b> <?= $konseling['solusi'] ?></p>
                </div>
                <?= $this->session->flashdata('message') ?>
                <div class="card-body">
                    <div class="overflow-auto" id="scrollTop" style="max-height: 400px;">
                        <ul class="chat-list list-unstyled">

                            <?php foreach ($balas_konseling->result() as $a) : ?>
                                <?php $peng = $this->db->get_where('karyawan', ['id' => $a->id_peng])->row_array(); ?>
                                <?php $san = $this->db->get_where('siswa', ['id' => $a->id_siswa])->row_array(); ?>
                                <?php if ($a->pengirim == 'siswa') : ?>
                                    <li style="margin-right:65px" class="clearfix chat-element media">
                                        <a class="float-left">
                                            <h1> <i class="fa fa-user-circle"></i></h1>
                                        </a>
                                        <div class="media-body">
                                            <div class="speech-box">
                                                <strong><b><?= $san['nama'] ?></b> <span class="float-right badge badge-info">siswa</span></strong>
                                                <p><?= $a->balasan ?></p>
                                                <small class="text-info"><?= $a->tgl ?>, <?= $a->waktu ?></small>
                                            </div>

                                        </div>

                                    </li>

                                <?php elseif ($a->id_peng == $user['id']) : ?>
                                    <li class="clearfix chat-element right media">

                                        <div class="media-body">
                                            <div class="speech-box">
                                                <strong><b><?= $peng['nama'] ?></b> <span class="float-right badge badge-success">Admin</span></strong>
                                                <p><?= $a->balasan ?></p>
                                                <small class="text-info"><?= $a->tgl ?>, <?= $a->waktu ?></small>
                                            </div>
                                        </div>
                                        <a class="float-right mr-2">
                                            <img src="<?= base_url('assets/') ?>img/profile.png" width="50%" alt="" class="rounded-circle">
                                        </a>
                                    </li>
                                <?php else : ?>
                                    <?php if ($a->pengirim == 'Karyawan') : ?>
                                        <li style="margin-right:65px" class="clearfix chat-element left media">
                                            <a class="float-left">
                                                <img src="<?= base_url('assets/') ?>img/profile.png" width="50%" alt="" class="rounded-circle">
                                            </a>
                                            <div class="media-body">
                                                <div class="speech-box">
                                                    <strong><b><?= $peng['nama'] ?></b> <span class="float-right badge badge-info">Admin</span></strong>
                                                    <p><?= $a->balasan ?></p>
                                                    <small class="text-info"><?= $a->tgl ?>, <?= $a->waktu ?></small>
                                                </div>
                                            </div>

                                        </li>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <br />
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $konseling['id'] ?>">
                        <input type="hidden" name="nama" value="<?= $user['id'] ?>">
                        <div class="row form-inline">
                            <div class="col-md-12 input-group">
                                <input type="text" class="form-control" name="balasan" id="balasan" autofocus>
                                <button type="submit" id="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#scrollTop').stop().animate({
        scrollTop: $('#scrollTop')[0].scrollHeight
    });
</script>