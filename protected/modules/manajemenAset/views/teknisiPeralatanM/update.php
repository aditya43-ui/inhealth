<?php

/**
 * - digunakan untuk Admin Teknisi Peralatan
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"> <i class="far fa-edit"></i>Ubah <strong>Teknisi Peralatan</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'Teknisi Peralatan'=>array('index'),
					$model->teknisiperalatan_id=>array('view','id'=>$model->teknisiperalatan_id),
					'Ubah',
				);
				$arrMenu = array();   
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model,'modSertifikat'=>$modSertifikat)); ?>
                <?php echo $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model,'modSertifikat'=>$modSertifikat)); ?>
            </div>
        </div>
    </div>
