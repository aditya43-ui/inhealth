<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Tambah <strong>Bed Triage</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'Bed Triage'=>array('admin'),
					'Tambah',
				);

				$arrMenu = array();
				//array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Obat Alkes ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>

				<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>
