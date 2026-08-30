<?php
$modPeg = new PegawaiV('searchDialog');
$modPeg->default = 'kosong';
if(isset($_GET['PegawaiV'])){
    $modPeg->attributes = $_GET['PegawaiV']; 
    $modPeg->jabatan_nama = isset($_GET['PegawaiV']['jabatan_nama'])?$_GET['PegawaiV']['jabatan_nama']:null;
    $modPeg->default = isset($_GET['PegawaiV']['default'])?$_GET['PegawaiV']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-petugas-grid',
	'dataProvider'=>$modPeg->searchAllPegawai(),
	'filter'=>$modPeg,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'filter' => CHtml::activeHiddenField($modPeg, 'default'),
                    'value'=>function($data){    
                        $dt = $data->attributes;                        
                        $dt['namaLengkap'] = $data->namaLengkap;                        
                        $res = json_encode($dt);
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                                setPetugas(".$res.",'','')
                                                return false;"));
                    },
                ),
                'nomorindukpegawai',
                'nama_pegawai',
                [
                    'header' => 'Jabatan',
                    'name' => 'jabatan_nama'
                ]
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));