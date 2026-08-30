<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Detail Pemeriksaan</b></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sapemeriksaanlabdet Ms' => array('index'),
            'Create',
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>