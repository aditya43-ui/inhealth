
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
//        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo $this->renderPartial($this->path_view.'grid/_grid_pegawai',['model'=>$model]);

$this->endWidget();


$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogLokasi',
    'options'=>array(
        'title'=>'Daftar Lokasi',
        'autoOpen'=>false,
//        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo $this->renderPartial($this->path_view.'grid/_grid_lokasi',['model'=>$model,'pencarian'=>!empty($pencarian)?$pencarian:'']);

$this->endWidget();
?>

