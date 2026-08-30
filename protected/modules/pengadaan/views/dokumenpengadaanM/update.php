<!--<div class="white-container">-->
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> Ubah <b> Dokumen Pengadaan </b> </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model, 'modDetail' => $modDetail)); ?>
    </div>
</div>
<!--</div>-->