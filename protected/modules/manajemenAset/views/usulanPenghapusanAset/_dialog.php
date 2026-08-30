<?php

//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAset',
    'options' => array(
        'title' => 'Daftar Aset',
        'autoOpen' => false,        
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

echo $this->renderPartial('grid/_daftar_aset',[], true);

$this->endWidget();
?>


