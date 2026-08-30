<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Dosis Radiasi
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('radiologi.views._ringkasDataPasien', array('modPasienMasukPenunjang' => $penunjang), true); ?>
        <?php echo $this->renderPartial('_form', array(
            'penunjang'=>$penunjang, 'periksa'=>$periksa, 'model'=>$model,
        ), true); ?>
    </div>
</div>