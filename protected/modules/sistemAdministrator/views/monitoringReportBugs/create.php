<div class="white-container">
    <legend class="rim2">Tambah <b>Monitoring Error dan Bugs</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sareportbugs Rs' => array('index'),
        'Create',
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
</div>