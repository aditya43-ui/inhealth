<div class="panel panel-gradient">
    <div class="panel-heading" c>
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Tarif Ambulans</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Tarif Ambulans' => array('admin'),
            'Tambah',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model, 'modDaftartindakan' => $modDaftartindakan)); ?>
    </div>
</div>