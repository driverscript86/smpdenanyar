
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="col-md-12 text-center">
        <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-list fa-fw"></i><?= $title ?></h1>
        <hr />
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transaksi Bulanan

                        <div class="float-right">
                            <a href="<?= base_url('payout?n=' . $payment['period_period_id'] . '&r=' . $student['nis']) ?>" class="btn btn-block btn-danger btn-sm"><i class="fa fa-random"></i> &nbsp;Kembali</a>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('messageKet') ?>
                    <table class="table table-hover table-striped table-bordered" id="mytable">
                        <tbody>
                            <?php foreach ($bulan as $row) : ?>
                                <tr>
                                    <td class="text-left"><b><?= $row['month_name']; ?></b></td>
                                    <input type="hidden" name="bulan_id[]" value="<?= $row['bulan_id'] ?>">
                                    <td class="<?= ($row['bulan_status'] == 1) ? 'danger' : 'success' ?> text-center">
                                        <a href="<?= ($row['bulan_status'] == 0) ? site_url('payout/pay/' . $row['payment_payment_id'] . '/' . $row['student_student_id'] . '/' . $row['bulan_id']) : site_url('payout/not_pay/' . $row['payment_payment_id'] . '/' . $row['student_student_id'] . '/' . $row['bulan_id']) ?>" 
                                        onclick="return confirm('<?= ($row['bulan_status'] == 0) ? 'Anda Akan Melakukan Pembayaran bulan ' . $row['month_name'] . '?' : 'Anda Akan Menghapus Pembayaran bulan ' . $row['month_name'] . '?' ?>')" 
                                        class="btn btn-xs btn-<?= ($row['bulan_status'] == 1) ?  'success' : 'danger' ?>">
                                        <b><?= ($row['bulan_status'] == 1) ? '(' . pretty_date($row['bulan_date_pay'], 'd/m/y', false) . ')' : number_format($row['bulan_bill'], 0, ',', '.') ?></b></a>
                                    </td>
                                    <td class="<?= ($row['bulan_status'] == 1) ? 'success' : 'danger' ?> text-center">
                                        <a style="color:white;" data-toggle="modal" data-target="#addDesc<?= $row['bulan_id'] ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit margin-r-5"></i> <b>Tambah Keterangan</b></a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="addDesc<?= $row['bulan_id'] ?>" role="dialog">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tambah Keterangan</h4>
                                            </div>
                                            <?= form_open('payout/update_pay_desc/', array('method' => 'post')); ?>
                                            <div class="modal-body">
                                                <input type="hidden" name="bulan_id" value="<?= $row['bulan_id'] ?>">
                                                <input type="hidden" name="student_student_id" value="<?= $row['student_student_id'] ?>">
                                                <input type="hidden" name="student_nis" value="<?= $row['nis'] ?>">
                                                <input type="hidden" name="period_period_id" value="<?= $row['period_period_id'] ?>">
                                                <input type="hidden" name="payment_payment_id" value="<?= $row['payment_payment_id'] ?>">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Keterangan *</label>
                                                        <input type="text" required="" name="bulan_pay_desc" value="<?= $row['bulan_pay_desc'] ?>" class="form-control" placeholder="Keterangan">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save margin-r-5"></i> <b>SIMPAN DATA</b></button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i><b> TUTUP</b></button>
                                            </div>
                                        </div>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Identitas
                        <?php if($user['role_id'] == '1' && $user['role_id'] == '5') : ?>
                        <div class="float-right">
                            <a href="<?= base_url('manage/jenis_pembayaran/edit_payment_bulan/' . $row['payment_payment_id'] . '/' . $row['student_student_id']) ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-edit"></i><b>&nbsp;Edit Tarif Pembayaran</b></a>
                        </div>
                        <?php endif ?>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Jenis Pembayaran</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?= $payment['pos_name'] . ' - T.P ' . $payment['period_start'] . '/' . $payment['period_end'] ?>" readonly="">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Tahun Pelajaran</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?= $payment['period_start'] . '/' . $payment['period_end'] ?>" readonly="">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Tipe Pembayaran</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?= ($payment['payment_type'] == 'BULAN' ? 'Bulanan' : 'Bebas') ?>" readonly="">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">NIS</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly="" value="<?= $student['nis'] ?>">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly="" value="<?= $student['nama'] ?>">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Kelas</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly="" value="<?= $student['class_name'] ?>">
                        </div>
                    </div>
                    <br>
                    <?php if(!empty($student['id_majors'])) : ?>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 control-label">Program Jurusan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly="" value="<?= $student['majors_name'] ?>">
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>