<?php 
/**
 * tabulasi grafik, untuk membedakan hasil grafik menjadi batang, pie dan garis
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(

        array('label'=>'Batang', 'url'=>'', 'itemOptions'=>array('onclick'=>'setType(this);', 'type'=>'batang')),
        array('label'=>'Pie', 'url'=>'', 'itemOptions'=>array('onclick'=>'setType(this);', 'type'=>'pie')),
        array('label'=>'Garis', 'url'=>'', 'itemOptions'=>array('onclick'=>'setType(this);', 'type'=>'garis')),
    ),
));
?>