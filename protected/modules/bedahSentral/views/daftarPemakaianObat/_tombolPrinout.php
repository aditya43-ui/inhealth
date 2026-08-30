<div class="form-actions" style="float:right;">
<?php 
    echo CHtml::htmlButton("<span class='entypo-check'></span> Review dan Verifikasi DPJP",['class'=>'btn btn-primary','onclick'=>'panggilVerif();']);
    echo '&nbsp;';
    echo CHtml::htmlButton("<span class='entypo-book'></span> Read Back",['class'=>'btn btn-primary','onclick'=>'readBack();']);
    echo '&nbsp;';
    $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
            array('label'=>'Cetak CPPT Pasien', 'icon'=>MyIcon::getIcons('cetak'), 'url'=>'javascript:void(0)', 'htmlOptions'=>array('onclick'=>'printRiwayat('.$modPendaftaran->pendaftaran_id.',"PRINT")')),
            array('label'=>'', 'items'=>array(
                array('label'=>'PDF', 'icon'=>MyIcon::getIcons('pdf'), 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat('.$modPendaftaran->pendaftaran_id.',"PDF")')),
            )),
        ),
    )); 
?>
</div>