<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-cog fa-fw"></i> Payment Gateway</h1>
            <hr />
        </div>

        <div class="col-lg-7 offset-lg-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Update Payment Gateway</h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>

                    <?php foreach ($payment as $d) : ?>

                        <form action="<?= base_url('admin/payment') ?>" method="post">
                            <div class="form-group row mb-4">
                                <label class="col-lg-10 control-label">Link Callback</label>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input style="font-weight:bold" type="text" class="form-control" value="<?= base_url('callback') ?>" readonly="">
                                        <button data-toggle="tooltip" title="Salin Link" class="btn btn-primary btn-sm" id="clipboard" data-ref="<?= base_url('callback') ?>"><i class="fa fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kode Merchant</label>
                                <input type="hidden" id="id" name="id" value="<?= $d['id']; ?>">
                                <input type="text" class="form-control" id="kode_merchant" name="kode_merchant" value="<?= $d['kode_merchant']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="api_key">Api Key</label>
                                <input type="text" class="form-control" id="api_key" name="api_key" value="<?= $d['api_key']; ?>">
                                <?= form_error('api_key', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Private Key</label>
                                <input type="text" class="form-control" name="private_key" value="<?= $d['private_key']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="mode">Mode</label>
                                <select class="form-control" id="mode" name="mode">
                                    <?php if ($d['mode'] == 'Production') : ?>
                                        <option value="<?= $d['mode']; ?>"><?= $d['mode']; ?></option>
                                        <option value="Sandbox">Sandbox</option>
                                    <?php elseif ($d['mode'] == 'Sandbox') : ?>
                                        <option value="<?= $d['mode']; ?>"><?= $d['mode']; ?></option>
                                        <option value="Production">Production</option>
                                    <?php endif ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-rd5">Submit</button>
                        </form>

                    <?php endforeach ?>

                </div>
            </div>
        </div>

    </div>
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