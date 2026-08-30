<!--<div class="white-container">
    <legend class="rim2">Ubah <b>Jam Kerja</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jam Kerja</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Kpjamkerja Ms' => array('index'),
            $model->jamkerja_id => array('view', 'id' => $model->jamkerja_id),
            'Update',
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
        <!--</div>-->
    </div>
</div>