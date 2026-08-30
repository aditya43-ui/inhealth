<?php

/**
 * - digunakan sebagai Admin IPM CHECKLIST
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="far fa-plus-square"></i> Tambah <strong>IPM Checklist</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'IPM Checklist'=>array('admin'),
					'Tambah',
				);
				$arrMenu = array();
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
