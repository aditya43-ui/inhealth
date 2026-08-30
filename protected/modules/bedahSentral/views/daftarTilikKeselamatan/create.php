<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Daftar Tilik Keselamatan Pasien dan Persiapan Mesin
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert');
        }
        ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>

    </div>

</div>