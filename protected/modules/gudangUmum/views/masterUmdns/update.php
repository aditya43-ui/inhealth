<div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="far fa-edit"></i> Ubah <strong>UMDNS</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'UMDNS'=>array('admin'),
					$model->umdns_id=>array('view','id'=>$model->umdns_id),
					'Ubah',
				);
				$arrMenu = array();   
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
            </div>
        </div>
