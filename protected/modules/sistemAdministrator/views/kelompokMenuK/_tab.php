<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
                array('label'=>'Kelompok Menu', 'url'=>'', 'active'=>true),
                array('label'=>'Menu', 'url'=>array('/sistemAdministrator/menuModulK', 'modul_id'=>isset($_REQUEST['modul_id']) ? $_REQUEST['modul_id'] : null)),
                
       
    ),
));