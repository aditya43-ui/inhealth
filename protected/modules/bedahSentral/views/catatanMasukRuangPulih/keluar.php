<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Keluar Ruang Pulih
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('keluar/_form', array('model' => $model, 'penunjang' => $penunjang, 'masukkamar' => $masukkamar, 'pindahkamar' => $pindahkamar, 'modelNyeri' => $modelNyeri)); ?>

    </div>
</div>