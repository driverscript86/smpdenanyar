
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Point Referral</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user['jumlah_reff'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Invoice</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $inv ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Belum Invoice</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $non_inv ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?></h1>
                    <div class="col-md-7">
                        <div class="form-group row mb-4">
                            <label class="col-lg-10 control-label">Link Referral Kamu</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input style="font-weight:bold" type="text" class="form-control" value="<?= base_url('rs?id=') . $user['kode_reff'] ?>" readonly="">
                                    <button data-toggle="tooltip" title="Salin Referral" class="btn btn-primary btn-sm" id="clipboard" data-ref="<?= base_url('rs?id=') . $user['kode_reff'] ?>"><i class="fa fa-copy"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= $this->session->flashdata('message') ?>
                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Siswa</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Nomor HP</th>
                                    <th scope="col">Tanggal Daftar</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($ppdb as $d) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= $d['email'] ?></td>
                                        <td><?= $d['no_hp'] ?></td>
                                        <td><?= mediumdate_indo(date($d['date_created'])); ?></td>
                                        <td><?php if ($d['inv'] !== 1) : ?>
                                                <span class="badge badge-danger">Belum Invoice</span>
                                            <?php elseif ($d['inv'] == 1) : ?>
                                                <span class="badge badge-success">Sudah Invoice</span>
                                            <?php endif ?>
                                        </td>
                                    </tr>

                                <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

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
