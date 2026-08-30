<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,        
        'modal' => true,
        'width' => 1100,
        'height' => 450,
        'resizable' => false,
    ),
));

$this->renderPartial($this->pathView_umum_asuransi."grid/_listPasien",[]);

$this->endWidget();