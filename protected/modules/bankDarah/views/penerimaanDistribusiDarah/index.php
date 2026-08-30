    <?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash("success","Data Penerimaan Distribusi Darah berhasil disimpan!");
		}
    ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Penerimaan Distribusi Pelayanan Darah</div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
            'Penerimaan Distribusi Darah'=>array('index'),
            'Tambah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        
        
        <?php 
        if(empty($model->terimadistribusidarah_id)) {
        echo $this->renderPartial($this->path_view.'_form', array(
              'model'=>$model,
              'format'=>$format,
              'distribusidarah_id'=>$distribusidarah_id
            ));
        }else{
        echo $this->renderPartial($this->path_view.'_form', array(
              'model'=>$model,
              'format'=>$format,
              'distribusidarah_id'=>$distribusidarah_id,
             'modDetail'=>$modDetail,
            ));
        } ?>
    </div>
</div>