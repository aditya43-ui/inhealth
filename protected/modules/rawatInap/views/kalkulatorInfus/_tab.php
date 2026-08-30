
<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Berdasarkan Waktu Habis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/rawatInap/kalkulatorInfus/waktuHabis&tab=frame&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Berdasarkan Tingkat Tetesan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rawatInap/kalkulatorInfus/tingkatTetesan')),            		
        array('label'=>'Dosis Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rawatInap/kalkulatorInfus/dosisObat')),            		
    ),
));
?>