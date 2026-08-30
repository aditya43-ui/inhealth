<?php
$modPegR = new PegawairuanganV('searchDialog');
$modPegR->default = 'kosong';
if(isset($_GET['PegawairuanganV'])){
    $modPegR->attributes = $_GET['PegawairuanganV']; 
    $modPegR->default = isset($_GET['PegawairuanganV']['default'])?$_GET['PegawairuanganV']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-petugas-ruangan-grid',
	'dataProvider'=>$modPegR->searchDialogPegRuangan(),
	'filter'=>$modPegR,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'filter' => CHtml::activeHiddenField($modPegR, 'default'),
                    'value'=>function($data){    
                        $dt = $data->attributes;                        
                        $dt['namaLengkap'] = $data->namaLengkap;                        
                        $res = json_encode($dt);
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                                setPetugasRuangan(".$res.",'','')
                                                return false;"));
                    },
                ),
                'nomorindukpegawai',
                'nama_pegawai',
                [
                    'header' => 'Unit Kerja',
                    'name' => 'namaunitkerja'
                ]
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));