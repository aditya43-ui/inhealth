<?php
$pencarian = !empty($pencarian)?$pencarian:'';

$modLok = new LokasiasetM;
if(isset($_GET['LokasiasetM'])){
    $modLok->attributes = $_GET['LokasiasetM'];  
    $modLok->ruangan_nama = isset($_GET['LokasiasetM']['ruangan_nama'])?$_GET['LokasiasetM']['ruangan_nama']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'lokasi-m-grid',
	'dataProvider'=>$modLok->search(),
	'filter'=>$modLok,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) use ($model, &$pencarian){                            
                                                    
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "                                                                                    
                                        if ('".$pencarian."' == '' ){
                                            if ('".$data->ruangan_nama."' != ''){
                                                $('#".CHtml::activeId($model, 'lokasi_id')."').val(".$data->lokasi_id.");
                                                $('#".CHtml::activeId($model, 'lokasiaset_namalokasi')."').val('".$data->lokasiaset_namalokasi."');
                                                $('#".CHtml::activeId($model, 'ruangan_nama')."').val('".trim($data->ruangan_nama)."');
                                                $('#".CHtml::activeId($model, 'ruangan_id')."').val(".$data->ruangan_id.");
                                                $('#dialogLokasi').dialog('close');                                                
                                            }else{
                                                toastr.warning('Ruangan pada master lokasi aset belum diset','Perhatian');
                                            }                                        
                                        }else{                                        
                                            $('#".CHtml::activeId($model, 'lokasi_id')."').val(".$data->lokasi_id.");
                                            $('#".CHtml::activeId($model, 'lokasiaset_namalokasi')."').val('".$data->lokasiaset_namalokasi."');
                                            $('#dialogLokasi').dialog('close');
                                        }
                                        return false;"
                            ));
                    },
                ),
                [
                    'header' => 'Kode Lokasi',
                    'name' => 'lokasiaset_kode'
                ],
                [
                    'header' => 'Nama Lokasi',
                    'name' => 'lokasiaset_namalokasi'
                ],                
                [
                    'header' => 'Kode Lokasi',
                    'name' => 'kode_internal'
                ],
                [
                    'header' => 'Ruangan',
                    'name' => 'ruangan_nama'
                ],
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));