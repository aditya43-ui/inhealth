
<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Gambar Tubuh', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/rawatInap/gambarTubuhRI/admin')),            		
        array('label'=>'Bagian Tubuh', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rawatInap/anatomiTubuhRI/admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),
    ),
));
?>