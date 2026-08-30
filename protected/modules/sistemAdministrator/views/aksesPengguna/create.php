<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Akses Pemakai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Akses Pengguna' => array('admin'),
            'Create',
        );
        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model, 'modPeran' => $modPeran)); ?>
    </div>
</div>

<?php $this->renderPartial('_jsFunctions', array()); ?>