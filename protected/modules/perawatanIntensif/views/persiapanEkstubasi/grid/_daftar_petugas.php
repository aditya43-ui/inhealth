<?php
$modPeg = new PegawairuanganV('searchDialog');
$modPeg->default = 'kosong';
if(isset($_GET['PegawairuanganV'])){
    $modPeg->attributes = $_GET['PegawairuanganV']; 
    $modPeg->namaunitkerja = isset($_GET['PegawairuanganV']['namaunitkerja'])?$_GET['PegawairuanganV']['namaunitkerja']:null;
    $modPeg->default = isset($_GET['PegawairuanganV']['default'])?$_GET['PegawairuanganV']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-petugas-grid',
	'dataProvider'=>$modPeg->searchDialogPegawai(),
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
                    'header' => 'Unit Kerja',
                    'name' => 'namaunitkerja'
                ]
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));