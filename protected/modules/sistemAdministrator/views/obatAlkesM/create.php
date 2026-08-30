<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Tambah <strong>Obat Alkes</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'Obat Alkes'=>array('admin'),
					'Tambah',
				);

				$arrMenu = array();
				//array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Obat Alkes ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>

				<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'modObatAlkesDetail'=>$modObatAlkesDetail, 'modZatAktif'=>array(), 'modMinimalStok'=>$modMinimalStok, 'minimalStokDet'=>$minimalStokDet)); ?>
            </div>
        </div>
    </div>
</div>
