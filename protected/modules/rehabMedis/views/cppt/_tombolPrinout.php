<div style="float:right;">
<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
                array('label'=>'Cetak CPPT Pasien', 'icon'=>MyIcon::getIcons('cetak'), 'url'=>'javascript:void(0)', 'htmlOptions'=>array('onclick'=>'printRiwayat('.$modPendaftaran->pendaftaran_id.',"PRINT")')),
                array('label'=>'', 'items'=>array(
                        array('label'=>'PDF', 'icon'=>MyIcon::getIcons('pdf'), 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat('.$modPendaftaran->pendaftaran_id.',"PDF")')),
                )),
        ),
)); ?>
</div>