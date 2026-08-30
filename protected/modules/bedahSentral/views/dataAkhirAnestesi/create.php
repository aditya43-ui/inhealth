<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Akhir Anestesi</b>
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
        <?php echo $this->renderPartial('_form', array('model' => $model, 'status' => $status)); ?>

    </div>
</div>