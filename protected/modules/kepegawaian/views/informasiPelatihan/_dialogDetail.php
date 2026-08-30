<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRencanaDetail',
    'options'=>array(
        'title'=>'Detail Rencana Pelatihan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>500,
		'zIndex'=>1002,
        'resizable'=>true,
    ),
));
?>

<iframe id="frameRencanaDetail" name="frameRencanaDetail" style="overflow-x:scroll; width: 100%; height: 400px; border: none;"></iframe>

<?php $this->endWidget(); ?>