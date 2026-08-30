<?php $linkHalaman = CustomFunction::getUrlByMenuID(828); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Presensi
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Presensi' => array('index'),
        );
        $arrMenu = array();
        //    array_push($arrMenu,array('label'=>' Presensi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        $this->menu = $arrMenu;
        ?>
        <?php echo $this->renderPartial('_form', array('model' => $model, 'modPegawai' => $modPegawai)); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <!--/div-->
    </div>
</div>