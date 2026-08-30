<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Kelas Pelayanan', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/kelaspelayananM')),
        array('label'=>'Kelas Ruangan', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/kelasruanganM'), 'active'=>true),
    ),
));
?>