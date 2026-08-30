<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Jenis Peralatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo $this->renderPartial('grid/_grid_barang',[], true); 

$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogGedung',
    'options' => array(
        'title' => 'Daftar Gedung',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo $this->renderPartial('grid/_grid_gedung',[], true); 

$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogLokasi',
    'options' => array(
        'title' => 'Daftar Lokasi Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo $this->renderPartial('grid/_grid_lokasi',[], true); 

$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRuangan',
    'options' => array(
        'title' => 'Daftar Ruangan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo $this->renderPartial('grid/_grid_ruangan',[], true); 

$this->endWidget();
?>


