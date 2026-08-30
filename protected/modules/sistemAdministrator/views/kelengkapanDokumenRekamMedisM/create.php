<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> <?= isset($_GET['id']) ? 'Ubah' : 'Tambah' ?><b> Kelengkapan Dokumen</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Kelengkapan Dokumen Rekam Medis' => array('index'),
            'Tambah',
        );

        $arrMenu = array();
  
        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
        <?php echo $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
       
    </div>
</div>