<?php
$this->widget('bootstrap.widgets.BootMenu',
    array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>array(
			array(
                'label' => 'Bagian Tubuh',
                'url' => array(
                    '/sistemAdministrator/bagianTubuh',
                    'modul_id'=>(isset($_REQUEST['modul_id']) ? $_REQUEST['modul_id'] : '')
                )
            ),
			array('label'=>'Gambar Tubuh', 'url'=>'', 'active'=>true),
        )
    )
);