<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        // array('label'=>'Jenis Penilaian', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'kepegawaian/JenisPenilaian/Admin')),
        array('label'=>'Kompetensi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'kepegawaian/Kompetensi/Admin')),
    	array('label'=>'Indikator Perilaku', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'kepegawaian/IndikatorPerilaku/Admin')),
    	array('label'=>'Kolom Rating', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'kepegawaian/KolomRating/Admin')),
    ),
));
?>