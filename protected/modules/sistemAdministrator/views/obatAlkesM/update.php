<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Ubah <strong>Obat Alkes</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'Obat Alkes'=>array('admin'),
					$model->obatalkes_id=>array('view','id'=>$model->obatalkes_id),
					'Update',
				);

				$arrMenu = array();
				//array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Obat Alkes ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>

				<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modObatAlkesDetail'=>$modObatAlkesDetail,'modObatSupplier'=>$modObatSupplier,'modTherapiObat'=>$modTherapiObat, 'modUbahHarga'=>$modUbahHarga, 'modZatAktif'=>$modZatAktif, 'modMinimalStok'=>$modMinimalStok, 'minimalStokDet'=>$minimalStokDet)); ?>
            </div>
        </div>
    </div>
</div>