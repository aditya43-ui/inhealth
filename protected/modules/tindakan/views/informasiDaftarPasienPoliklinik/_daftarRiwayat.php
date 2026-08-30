<?php
$modRiwayat = new CheckjadwalR('search');
// var_dump($modRiwayat);die;
// $modRiwayat->default = 'kosong';
if(isset($_GET['CheckjadwalR'])){
    $modRiwayat->attributes = $_GET['CheckjadwalR']; 
    // $modRiwayat->default = isset($_GET['CheckjadwalR']['default'])?$_GET['CheckjadwalR']['default']:null;
}

// $modRiwayat->pasien_id = $model->pasien_id;
// if($modRiwayat->check_status == true){
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'daftar-riwayat-grid',
        'dataProvider'=>$modRiwayat->search(),	
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            [
                'header' => '<center>Dokter</center>',
                'value' => function($data){
                    $dok = DokterV::model()->findAllByAttributes(array('pegawai_id' => $data->pegawai_id));
                    // var_dump($dok);die;
                    return $dok[0]->namaLengkap;
                }
            ],
            [
                'header' => '<center>IP Segment</center>',
                'value' => '$data->check_ipsegment',
                // 'value' => function($data){
                //     echo CHtml::link("<i class='icon-form-lihat'></i>", 'javascript:;',['onclick'=>'cetak('.$data->ekstubasipasien_id.',"detail")','rel'=>'tooltip', 'title'=>'Lihat persiapan ekstubasi pasien']);
                // },
                'htmlOptions' => [
                    'style' => 'text-align:center;'
                ]
            ],
            [
                'header' => '<center>IP Port</center>',
                'value' => function($data){
                    echo $data->check_port; 
                    //CHtml::link("<i class='fa fa-print'></i>", 'javascript:;',['onclick'=>'cetak('.$data->ekstubasipasien_id.')', 'rel'=>'tooltip', 'title'=>'Cetak persiapan ekstubasi pasien']);
                },
                'htmlOptions' => [
                    'style' => 'text-align:center;'
                ]
            ],
            [
                'header' => '<center>Poliklinik</center>',
                'value' => '$data->check_poliklinik',
                // 'value' => function($data){
                //     echo CHtml::link("<i class='icon-form-sampah'></i>", 'javascript:;',['onclick'=>'hapus('.$data->ekstubasipasien_id.')', 'rel'=>'tooltip', 'title'=>'Hapus persiapan ekstubasi pasien']);
                // },
                'htmlOptions' => [
                    'style' => 'text-align:center;'
                ]
            ],
            [
                'header' => '<center>Checkout</center>',
                // 'value' => '$data->check_poliklinik',
                'value' => function($data){
                    if (!empty($data->checkjadwal_id)){
                        echo CHtml::link("<i class='entypo-logout'></i>", 'javascript:;',['onclick'=>'checkout('.$data->checkjadwal_id.')', 'rel'=>'tooltip', 'title'=>'Checkout Dokter']);   
                    }else{
                        echo "Dokter Sudah Checkout";
                    }
                },
                'htmlOptions' => [
                    'style' => 'text-align:center;'
                ]
            ]
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
// }
