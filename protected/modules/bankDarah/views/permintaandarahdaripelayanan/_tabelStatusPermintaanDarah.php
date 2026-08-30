<?php
$this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView', array(
    'id' => 'grid-statusterima',
    'dataProvider' => $modRiwayatPermintaanDarah->search(),
    'template' => "{items}",
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row+1',
        ),
        array(
            'header' => 'No formulir permintaan',
            'name' => 'no_permintaandarah',
            'value' => function($data) {
               echo $data->no_permintaan ?? '';
            },
        ),
        array(
            'header' => 'Jenis Darah',
            'value' => function($data) use (&$modPermintaan) {
                $modPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id]);
                if(!empty($modPermintaan)) {
                    foreach ($modPermintaan as $i => $val) {
                        echo $i + 1 . '. ' . $val->jeniskomponendarah->jeniskomponenedarah_nama . '<br><hr>';
                    }
                }
            },
        ),
        array(
            'header' => 'Jumlah',
            'value' => function($data) use (&$modPermintaan) {
               
                if(!empty($modPermintaan)) {
                    foreach ($modPermintaan as $i => $val) {
                        echo $val->qtypermintaan . '<hr>';
                    }
                }
            },
        ),
        array(
            'header' => 'Diambil',
            'value' => function($data) use (&$modPermintaan) {
               
                if(!empty($modPermintaan)) {
                    foreach ($modPermintaan as $i => $val) {
                        echo $val->diambil . '<hr>';
                    }
                }
            },
        ),
        array(
            'header' => 'Dititip',
            'value' => function($data) use (&$modPermintaan) {
               
                if(!empty($modPermintaan)) {
                    foreach ($modPermintaan as $i => $val) {
                        echo $val->dititip . '<hr>';
                    }
                }
            },
        ),
        
        array(
            'header' => 'Progress',
            'value' => function($data) {
                $html = '';
                if($data->is_progressgoldarah === true) {
                    $html = "<a class='btn nohover' style='background-color:blue'> Progress</a>";
                } else if($data->is_progressgoldarah === false && $data->is_progressgoldarah !== null) {
                    $html = "<a class='btn nohover' style='background-color:green'> Done</a>";
                } else {
                    $html = "<a class='btn btn-default nohover'> To Do</a>";
                }

                echo $html;
            },
        ),
        array(
            'header' => 'Lihat',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class='icon-form-lihat'></i>", '#', array("class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Ubah",
                            'onclick' => 'window.parent.myAlert("Cooming Soon")'
                ));
            },
        ),
        array(
            'header' => 'Terima Darah',
            'type' => 'raw',
            'value' => function($data) {
                $modPenyiapan = PenyiapandarahT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id], ['order' => 'penyiapandarah_id desc']);
                if(!empty($modPenyiapan->tgl_terimadarah)) {
                    return  CHtml::Link("SUDAH DITERIMA", 'javascript:;', array("class" => "btn btn-success",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk Ubah",
                            )) 
                            . '<br><hr> Diterima Oleh : ' . '<br><b>' . $modPenyiapan->penerimapermintaan->namaLengkap . '</b><br>' . $modPenyiapan->tgl_terimadarah;
                }
                return CHtml::Link("Terima", '#', array("class" => "btn btn-info",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Ubah",
                            'onclick' => 'cekPenyiapanDarah(' . $data->pasienkirimkeunitlain_id. ')'
                ));
            },
        ),
        array(
            'header' => 'Reaksi Setelah Transfusi',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;  width:80px;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-pencil'></i></span>", 'javascript:;', array(
                            "rel" => "tooltip",
                            "title" => "Klik untuk Ubah",
                            'onclick' => 'openDialog(' . $data->pasienkirimkeunitlain_id. ')',
                ));
            },
        ),
     
       
       
    ),
));
?>
