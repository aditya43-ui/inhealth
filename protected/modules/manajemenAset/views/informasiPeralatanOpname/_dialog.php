
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogBarang',
    'options'=>array(
        'title'=>'Daftar Aset',
        'autoOpen'=>false,
        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo  $this->renderPartial($this->path_view.'grid/_grid_barang',[], true);


$this->endWidget();


$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRuangan',
    'options'=>array(
        'title'=>'Daftar Ruangan',
        'autoOpen'=>false,
        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo  $this->renderPartial($this->path_view.'grid/_grid_ruangan',[], true);


$this->endWidget();


$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogLokasi',
    'options'=>array(
        'title'=>'Daftar Lokasi Aset',
        'autoOpen'=>false,
        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo  $this->renderPartial($this->path_view.'grid/_grid_lokasi',['model'=>$model], true);


$this->endWidget();
?>
