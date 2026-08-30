<?php

/**
 * - digunakan untuk Admin Teknisi Peralatan
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Teknisi Peralatan</b></div>
    </div>
    <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'Teknisi Peralatan'=>array('index'),
					'Tambah',
				);
				$arrMenu = array();
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'modSertifikat'=>$modSertifikat)); ?>
				<?php echo $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model,'modSertifikat'=>$modSertifikat)); ?>
            </div>
        </div>
    </div>
