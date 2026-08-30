<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi Penerimaan Barang</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_form', array('model'=>$model, 'modDetails'=>$modDetails, 'modBeli'=>$modBeli, 'modDetailBeli'=>$modDetailBeli,'modUangMuka'=>$modUangMuka)); ?>
            </div>
        </div>
    </div>
</div>