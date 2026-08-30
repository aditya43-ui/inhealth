<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogListAntrian',
    'options' => array(
        'title' => 'Daftar No Antrian Hari ini',
        'autoOpen' => false,
        //'position'=>['top',20] ,
        'modal' => true,
        'width' => 650,
        'height' => 400,
        'resizable' => false,
    ),
));
$this->renderPartial('grid/_listAntrian2',[]);
$this->endWidget();


?>


