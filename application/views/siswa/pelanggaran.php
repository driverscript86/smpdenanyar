<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4 class="mb-5 header-title"><i class="fas fa-list"></i> <?= $title ?>

                    </h4>
                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Pelanggaran</th>
                                    <th scope="col">Point (-)</th>
                                    <th scope="col">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($pelanggaran as $d) : ?>
                                    <?php $pelang = $this->db->get_where('data_pelanggaran', ['id' => $d['id_pelang']])->row_array(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $pelang['nama'] ?></td>
                                        <td><span style="border-radius:25px" class="btn btn-sm btn-rounded btn-danger" disabled><?= $pelang['point'] ?></span></td>
                                        <td><?= mediumdate_indo(date($d['tgl'])); ?></td>
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
</div>
</div>
<!-- /.container-fluid -->