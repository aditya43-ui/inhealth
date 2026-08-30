<?php
$this->breadcrumbs = array(
    'Dokumen SSUK' => array('admin'),
    'Ubah',
);
?>
<!--<div class="white-container">-->
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> Ubah <b> Dokumen SSUK </b> </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
<!--</div>-->