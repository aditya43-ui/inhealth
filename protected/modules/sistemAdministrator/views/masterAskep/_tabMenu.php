<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Diagnosa Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/diagnosakepM/Admin')),
        array('label'=>'Batas Karakteristik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/batasKarakteristik/Admin')),
        array('label'=>'Faktor Risiko', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/faktorRisiko/Admin')),
        array('label'=>'Faktor yang Berhubungan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/faktorHub/Admin')),
        array('label' => 'Tujuan', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'sistemAdministrator/tujuan/Admin')),
        array('label' => 'Kriteria dan Hasil', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'sistemAdministrator/kriteriaHasil/Admin')),
        array('label'=>'Tanda Gejala', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/tandaGejala/Admin')),
        array('label'=>'Intervensi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/intervensi/Admin')),
        array('label'=>'Implementasi Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/implementasikepM/Admin')),
        //array('label'=>'Diagnosa Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/diagnosakeperawatanM/Admin')),
        //array('label'=>'Rencana Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/rencanaKeperawatanM/Admin')),
    	//array('label'=>'Implementasi Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/implementasikeperawatanM/Admin')),
    	
    		
    ),
));
?>