<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah Jenis Sertifikasi Karyawan<b></b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jenis Sertifikasi Karyawan' => array('admin'),
            'Tambah',
        );

        $arrMenu = array();
        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
       
        <?php echo $this->renderPartial($this->path_view.'_form', array('model' => $model)); ?>
        
    </div>
</div>