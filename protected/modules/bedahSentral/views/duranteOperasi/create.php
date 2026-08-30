<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Durante Operasi
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

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'status' => $status)); ?>
    </div>
</div>