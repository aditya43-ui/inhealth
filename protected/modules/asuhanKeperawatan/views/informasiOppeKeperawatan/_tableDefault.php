<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'informasiasuhankeperawatan-grid',
    'dataProvider' => $modDefault->search(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
	array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
	),
        'nama_perawat',
        'nip_perawat',
        array(
            'header' => 'Indikator OPPE',
            'type' => 'raw',
            'value' => function($data){
                    if(!empty($data->indikatoroppekeperawatan_id)){
                        $cekdata = IndikatoroppekeperawatanM::model()->findByPk($data->indikatoroppekeperawatan_id);
                        if(!empty($cekdata)){
                            echo !empty($cekdata->nama_indikator) ? $cekdata->nama_indikator : '';
                        }
                    }
            },
        ),
        array(
            'header' => 'Bulan Pencatatan',
            'type' => 'raw',
            'value' => function ($data){
                if(!empty($data->periodebulan)){
                    echo MyFormatter::getMonthId(date('m', strtotime($data->periodebulan))).date(' Y', strtotime($data->periodebulan));
                }
            },
        ),
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function ($data){
                if(strtolower($data->nama_indikator) == strtolower('Kepatuhan Asesmen')){
                    echo CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailAsesmen",array("oppeasesmen_id"=>$data->oppekeperawatan_id,"frame"=>true)),
                        array("class"=>"",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk detail asesmen",
                                "target"=>"frameDetail",
                                "onclick"=>"$('#dialogDetail').dialog('open');",
                        ));
                }else if(strtolower($data->nama_indikator) == strtolower('Bimbingan')){
                    echo CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailBimbingan",array("oppebimbingan_id"=>$data->oppekeperawatan_id,"frame"=>true)),
                        array("class"=>"", 
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk detail jumlah bimbingan",
                                "target"=>"frameDetail",
                                "onclick"=>"$('#dialogDetail').dialog('open');",
                        ));
                }else if(strtolower($data->nama_indikator) == strtolower('Caring')){
                    echo CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailCaring",array("oppecaring_id"=>$data->oppekeperawatan_id,"frame"=>true)),
                        array("class"=>"",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk detail caring",
                                "target"=>"frameDetail",
                                "onclick"=>"$('#dialogDetail').dialog('open');",
                        ));
                }else if(strtolower($data->nama_indikator) == strtolower('Clinical care')){
                    echo CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailClinical",array("oppeclinicalcare_id"=>$data->oppekeperawatan_id,"frame"=>true)),
                        array("class"=>"",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk detail clinical care",
                                "target"=>"frameDetail",
                                "onclick"=>"$('#dialogDetail').dialog('open');",
                        ));
                }else if(strtolower($data->nama_indikator) == strtolower('Kehadiran')){
                    echo CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailKehadiran",array("oppekehadiran_id"=>$data->oppekeperawatan_id,"frame"=>true)),
                        array("class"=>"",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk detail Kehadiran",
                                "target"=>"frameDetail",
                                "onclick"=>"$('#dialogDetail').dialog('open');",
                        ));
                }else if(strtolower($data->nama_indikator) == strtolower('Pelatihan dan Workshop')){
                    echo CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailPelatihan",array("oppepelatihan_id"=>$data->oppekeperawatan_id,"frame"=>true)),
                        array("class"=>"",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk detail pelatihan dan workshop",
                                "target"=>"frameDetail",
                                "onclick"=>"$('#dialogDetail').dialog('open');",
                        ));
                }else if(strtolower($data->nama_indikator) == strtolower('Presentase Perilaku')){
                    echo CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailPerilaku",array("oppeperilaku_id"=>$data->oppekeperawatan_id,"frame"=>true)),
                        array("class"=>"", 
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk detail kepatuhan perilaku",
                                "target"=>"frameDetail",
                                "onclick"=>"$('#dialogDetail').dialog('open');",
                        ));
                }
            }, 
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'value' => function ($data) { 
                if(strtolower($data->nama_indikator) == strtolower('Kepatuhan Asesmen')){
                    echo CHtml::link("<i class='entypo-pencil'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/informasiOppeKeperawatan/ubah",array("id"=>$data->oppekeperawatan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data", "onclick"=>"myAlert('Coming Soon'); return false;"));
                }else if(strtolower($data->nama_indikator) == strtolower('Bimbingan')){
                    echo CHtml::link("<i class='entypo-pencil'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/informasiOppeKeperawatan/ubah",array("id"=>$data->oppekeperawatan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data", "onclick"=>"myAlert('Coming Soon'); return false;"));
                }else if(strtolower($data->nama_indikator) == strtolower('Caring')){
                    echo CHtml::link("<i class='entypo-pencil'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/informasiOppeKeperawatan/ubah",array("id"=>$data->oppekeperawatan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data", "onclick"=>"myAlert('Coming Soon'); return false;"));
                }else if(strtolower($data->nama_indikator) == strtolower('Clinical care')){
                    echo CHtml::link("<i class='entypo-pencil'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/informasiOppeKeperawatan/ubah",array("id"=>$data->oppekeperawatan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data", "onclick"=>"myAlert('Coming Soon'); return false;"));
                }else if(strtolower($data->nama_indikator) == strtolower('Kehadiran')){
                    echo CHtml::link("<i class='entypo-pencil'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/informasiOppeKeperawatan/ubah",array("id"=>$data->oppekeperawatan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data", "onclick"=>"myAlert('Coming Soon'); return false;"));
                }else if(strtolower($data->nama_indikator) == strtolower('Pelatihan dan Workshop')){
                    echo CHtml::link("<i class='entypo-pencil'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/informasiOppeKeperawatan/ubah",array("id"=>$data->oppekeperawatan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data", "onclick"=>"myAlert('Coming Soon'); return false;"));
                }else if(strtolower($data->nama_indikator) == strtolower('Presentase Perilaku')){
                    echo CHtml::link("<i class='entypo-pencil'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/informasiOppeKeperawatan/ubah",array("id"=>$data->oppekeperawatan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data", "onclick"=>"myAlert('Coming Soon'); return false;"));
                }
            }, 
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>