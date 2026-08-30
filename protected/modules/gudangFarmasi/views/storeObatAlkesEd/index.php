<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> Transaksi<b> Store Obat Alkes Expired Date</b></div>
    </div>
    <div class="panel-body">
	<?php
	$this->breadcrumbs = array(
			'Store Obat Alkes Expired Date'=>array('index'),
			'Tambah',
	);

	$this->widget('bootstrap.widgets.BootAlert'); ?>
	
	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'modDetails'=>$modDetails)); ?>
    </div>
</div>

<?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model,'modDetails'=>$modDetails)); ?>