<?php
/*$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
//        array('label'=>'Data Pegawai', 'url'=>$this->createUrl('/kepegawaian/pegawaiM/admin'),),
        array('label'=>'Status Kehadiran', 'url'=>$this->createUrl('/kepegawaian/statuskehadiranM/admin'),'active'=>true),
        array('label'=>'Status Scan', 'url'=>$this->createUrl('/kepegawaian/statusscanM/admin'), ),
       array('label'=>'Jam Kerja', 'url'=>$this->createUrl('/kepegawaian/jamKerja/admin')),
        // array('label'=>'Shift', 'url'=>$this->createUrl('/kepegawaian/shiftM/admin'),),
    ),
)); */
?>

<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Status Kehadiran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/statuskehadiranM/admin&tab=frame')),
    	array('label'=>'Status Scan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/statusscanM/admin')),
        array('label'=>'Jam Kerja', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/jamKerja/admin')),            		
    ),
));
?>