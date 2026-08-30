<div style="margin-top: 17px;">
<?php 
/**
 * view yang digunakan untuk menambahkan tabulasi menu
 * 
 * @author Deni Hamdani <deinhamdani@piindonesia.co.id>
 */
$module = '/'.$this->module->id;

$items = array(        
    array('label'=>'Pengkajian Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'base-tab'=>'/rawatInap/asesmenGiziRI/index', 'tab'=>'/rawatInap/asesmenGiziRI/index', 'class' => 'tabulasi_asuhan')),
    array('label'=>'Rencana Asuhan Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'base-tab'=>'/rawatInap/monitoringGizi/index', 'tab'=>'/rawatInap/monitoringGizi/index', 'class' => 'tabulasi_asuhan')),
    array('label'=>'Catatan Perkembangan Pasien Terintegrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'base-tab'=>'rekamMedis/CPPTRK/index', 'tab'=>'rekamMedis/CPPTRK/index', 'class' => 'tabulasi_asuhan')),
    array('label'=>'Catatan Edukasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'base-tab'=>'rawatInap/AsesmenEdukasi/index&asuhangizi=1', 'tab'=>'rawatInap/AsesmenEdukasi/index&asuhangizi=1', 'class' => 'tabulasi_asuhan')),
    array('label'=>'Skrining Gizi Awal', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'base-tab'=>'rawatJalan/keperawatan/skriningGizi&is_asuhan=1', 'tab'=>'rawatJalan/keperawatan/skriningGizi&is_asuhan=1', 'class' => 'tabulasi_asuhan')),
);

if(Yii::app()->controller->module->id == 'rawatJalan') {
    $items = array(        
        array('label'=>'Catatan Perkembangan Pasien Terintegrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/CPPTRK/index')),
    );}

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=> $items,
));
?>
</div>