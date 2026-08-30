<?php
$modAntri = new AntrianT('searchDialog');
$modAntri->default = 'kosong';
if(isset($_GET['AntrianT'])){
    $modAntri->attributes = $_GET['AntrianT']; 
    $modAntri->default = isset($_GET['AntrianT']['default'])?$_GET['AntrianT']['default']:null;
    $modAntri->ruangan_nama = isset($_GET['AntrianT']['ruangan_nama'])?$_GET['AntrianT']['ruangan_nama']:null;
    $modAntri->modelantrian_nama = isset($_GET['AntrianT']['modelantrian_nama'])?$_GET['AntrianT']['modelantrian_nama']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-list-antrian-grid',
	'dataProvider'=>$modAntri->searchRiwayatPanggil(),
        'filter' => $modAntri,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            [
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data){
            
                    $res['antrian_id'] = $data->antrian_id;
                    $res['loket_id'] = $data->loket_id;
                    $res['modelantrian_id'] = $data->modelantrian_id;
                    $res['noantrian'] = $data->noantrian;
                    $res = json_encode($res);
                            
                    return CHtml::Link("<i class='icon-form-check'></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectAsuransi",
                        "onClick" => "                            
                            setAntrianLoket(".$res.")
                        "));
                }
            ],
            'barcode',
            // [
            //     'header' => 'No Antrian',
            //     'type' => 'raw',
            //     'value' => function ($data){
            //         if($data->modelantrian_id == 1 ) {
            //             echo $res['noantrian'] = $data->modelantrian_singkatan;
            //     }else if($data->modelantrian_id == 2 ){
            //         echo $res['noantrian'] = $data->ruangan_singkatan;
            //     }else{
            //         echo $res['noantrian'] = $data->ruangan_singkatan;
                    
            //     }
            // }
            //],
            [
                'header' => 'No. Antrian',
                'name' => 'noantrian',
                'value' => function ($data) {
                    if($data->modelantrian_nama == 'PASIEN UMUM') {

                        $no_split = explode("-", $data->noantrian);

                        $singkatan = $no_split[0];

                        if(!empty($data->modelantrian_id)) {

                            $singkatan = $data->modelantrian->modelantrian_singkatan;

                        }
                        return $singkatan . "-" . $no_split[1];
                    } else {
                        return $data->noantrian;
                    }
                }
            ],
            [
                'header' => 'Poliklinik',
                'name' => 'ruangan_nama'
            ],
            [
                'header' => 'Kunjungan',
                'name' => 'jenis_kunjungan',
                'filter' => CHtml::activeDropDownList($modAntri, 'jenis_kunjungan', LookupM::getItemsUrutan('jeniskunjunganantrian'), ['empty'=>'-- Pilih --'])
            ],
            [
                'header' => 'Pembayaran',
                'name' => 'modelantrian_nama'                
            ],            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));


$jscript = <<< JS
    var refreshGridNoAntrian = () => {
        $.fn.yiiGridView.update('daftar-list-antrian-grid', {
            data: {
                'AntrianT[default]':''
            }
        });
    }
        
    function setAntrianLoket(data) {
    
        $("#cari_loket_id").val(data.modelantrian_id).change();
        setTimeout(function(){
            $("#namaLoket").val(data.loket_id);
        }, 500);    

        setTimeout(function(){
            setFormAntrian('',data.antrian_id);
        }, 1000);    

        $("#list_no_antrian").val(data.noantrian);
        
        $("#dialogListAntrian").dialog("close");
    }
JS;

Yii::app()->clientScript->registerScript('list-antrian-dialog',$jscript, CClientScript::POS_HEAD);