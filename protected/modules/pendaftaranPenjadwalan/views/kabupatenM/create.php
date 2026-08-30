<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Kabupaten</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Kabupaten' => array('admin'),
            'Create',
        );

        $this->widget('bootstrap.widgets.BootAlert');
        echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>