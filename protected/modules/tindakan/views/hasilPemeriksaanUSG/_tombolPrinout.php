<div style="float:right;">
<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
		'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		'buttons'=>array(
			array('label'=>'Print', 'icon'=>MyIcon::getIcons('cetak'), 'url'=>'javascript:void(0)', 'htmlOptions'=>array('onclick'=>'printRiwayat('.$model->pemeriksaanusgpasien_id.','.$model->pendaftaran_id.',"PRINT")')),
                        array('label'=>'', 'items'=>array(
                                array('label'=>'PDF', 'icon'=>MyIcon::getIcons('pdf'), 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat('.$model->pemeriksaanusgpasien_id.','.$model->pendaftaran_id.',"PDF")')),
                                array('label'=>'Excel','icon'=>MyIcon::getIcons('excel'), 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat('.$model->pemeriksaanusgpasien_id.','.$model->pendaftaran_id.',"EXCEL")')),
                        )),
		),
	)); ?>
</div>