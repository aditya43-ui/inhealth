<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Cara Masuk', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/caramasukM'),),
        array('label'=>'Golongan Umur', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/golonganumurM'),  'active'=>true),
        array('label'=>'Asal Rujukan', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/asalrujukanM')),
    ),
));
?>