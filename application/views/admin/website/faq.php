        <div class="container-fluid">
        
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> Data Faq
                                <div class="float-right">
                                    <a href="" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#modal-xl"><i class="fa fa-plus-circle"></i> Tambah Faq</a>
                                </div>
                            </h1>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?= $this->session->flashdata('message') ?>
                            <?php foreach ($faq as $d) : ?>
                            <div class="card card-primary card-outline">
                                
                                    <div class="card-header">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapse<?= $d['role'] ?>">
                                            <h4 class="card-title">
                                                <?= $d['role'] ?>. <?= $d['pertanyaan'] ?>
                                        </a>
                                        <div class="float-right">
                                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-edit<?= $d['id'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                            <input type="hidden" name="id" id="data<?= $d['id'] ?>" value="<?= $d['id'] ?>">
                                            <button class="btn btn-tool" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>"><i class="fas fa-trash"></i></button>
                                        </div>
                                        </h4>
                                    
                                    </div>
                                    <div id="collapse<?= $d['role'] ?>"
                                        class="collapse <?php if($d['role'] == '1') : ?>show<?php endif ?>"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <?= $d['jawaban'] ?>
                                        </div>
                                    </div>
                            </div>
                            <?php endforeach ?>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <?php foreach ($faq as $d) : ?>
    
                <div class="modal fade" id="modal-edit<?= $d['id'] ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit FAQ</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="<?= base_url('update/faq') ?>">
                                <input type="hidden" id="id" name="id" value="<?= $d['id'] ?>">
                                <div class="modal-body">
    
                                    <div class="form-group">
                                        <label>Pertanyaan</label>
                                        <textarea type="text" class="form-control" id="pertanyaan>" name="pertanyaan" 
                                            placeholder="Pertanyaan" require><?= $d['pertanyaan'] ?></textarea>
                                        <?= form_error('pertanyaan', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </div>
    
                                    <div class="form-group">
                                        <label>Jawaban</label>
                                        <textarea type="text" class="form-control" id="jawaban" name="jawaban" 
                                            placeholder="Jawaban" require><?= $d['jawaban'] ?></textarea>
                                        <?= form_error('jawaban', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </div>
    
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="form-control" id="role" name="role">
                                            <option>- Pilih Role -</option>
                                            <option <?php if($d['role'] == '1'): ?>selected<?php endif ?> value="1">Satu</option>
                                            <option <?php if($d['role'] == '2'): ?>selected<?php endif ?>  value="2">Dua</option>
                                            <option <?php if($d['role'] == '3'): ?>selected<?php endif ?>  value="3">Tiga</option>
                                            <option <?php if($d['role'] == '4'): ?>selected<?php endif ?>  value="4">Empat</option>
                                            <option <?php if($d['role'] == '5'): ?>selected<?php endif ?>  value="5">Lima</option>
                                            <option <?php if($d['role'] == '5'): ?>selected<?php endif ?>  value="6">Enam</option>
                                        </select>
                                        <?= form_error('role', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </div>
    
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                                    <button type="button" class="btn btn-success" type="submit"><i class="fa fa-check"></i> Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--delete Data-->
                <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addNewDataLabel">Hapus Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Anda yakin ingin menghapus data <b><?= $d['pertanyaan'] ?></b></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <a href="<?= base_url('hapus/hapus_faq?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                            </div>

                        </div>
                    </div>
                </div>
                <?php endforeach ?>
    
                <div class="modal fade" id="modal-xl">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah FAQ</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                                <div class="modal-body">
                                <form action="<?= base_url('admin/faq') ?>" method="post">
                                    <div class="form-group">
                                        <label>Pertanyaan</label>
                                        <textarea type="text" class="form-control" id="pertanyaan" name="pertanyaan"
                                            placeholder="Pertanyaan" require></textarea>
                                        <?= form_error('pertanyaan', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </div>
    
                                    <div class="form-group">
                                        <label>Jawaban</label>
                                        <textarea type="text" class="form-control" id="jawaban" name="jawaban"
                                            placeholder="Jawaban" require></textarea>
                                        <?= form_error('jawaban', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </div>
    
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="form-control" id="role" name="role">
                                            <option>- Pilih Role -</option>
                                            <option value="1">Satu</option>
                                            <option value="2">Dua</option>
                                            <option value="3">Tiga</option>
                                            <option value="4">Empat</option>
                                            <option value="5">Lima</option>
                                        </select>
                                        <?= form_error('role', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </div>
    
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                                    <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    
                    </div>
                </div>
                <!-- /.modal -->
            </div>

        </div>
