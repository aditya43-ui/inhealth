<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Pekerjaan', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/pekerjaanM') ),
        array('label'=>'Pendidikan', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/pendidikanM'),'active'=>true),
        array('label'=>'Suku', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/sukuM')),
    ),
));
?>
