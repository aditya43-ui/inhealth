<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'kpinfohukumanpoinpeg-v-grid',
    'dataProvider'=>$model->searchInformasi(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'No.',
            'filter' => false,
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'headerHtmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'name' => 'tanggal_transaksi',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_transaksi)'
        ),
        array(
            'header' => 'Jenis Cuti',
            'value' => '$data->jeniscuti_nama'
        ),
        array(
            'header' => 'Mulai s/d Akhir Cuti',
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglmulaicuti)))." s/d ".MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglakhircuti)))'
        ),
        array(
            'header' => 'Lama Cuti',
            'value' => '$data->lamacuti." Hari"'
        ),
        array(
            'header' => 'Keperluan',
            'value' => '$data->keperluancuti'
        ),
        array(
            'name' => 'pegawai_id',
            'value' => '$data->NamaLengkapPemohon'
        ),
        array(
            'name' => 'pejabatmengetahui',
            'value' => '$data->NamaLengkapMengetahui'
        ),
       array(
            'header' => 'Bagian Kepegawaian',
//            'name' => 'pejabatmenyetujui',
           //'value' => '$data->NamaLengkapMenyetujui'
           'type' => 'raw',
           'value' => function($data){

                $dataDialog = 'myAlert("Hanya '.(isset($data->pejabatmenyetujui)? $data->NamaLengkapMenyetujui : "-").' yang bisa mengakses");';
                if($data->pejabatmenyetujui==Yii::app()->user->getState('pegawai_id')){
                   $dataDialog = "$('#dialogApprove').dialog('open');";
                }
                $html = (isset($data->pejabatmenyetujui)? $data->NamaLengkapMenyetujui : "-").(isset($data->tgl_menyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_menyetujui)." dan status cuti ".$data->status_cuti   :(isset($data->pejabatmenyetujui) ? CHtml::link("<icon class='icon-form-kontrakkarya'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/approve', array("id"=>$data->pegawaicuti_id,"frame"=>true)), array("target"=>"frameApprove","rel"=>"tooltip", "title"=>"Klik ikon ini, jika Anda ingin memproses approve", "onclick"=>$dataDialog)) : ""));
                return $html;
//                if (empty($data->pejabatmenyetujui)){
//                    return CHtml::link("<i class='icon-form-check'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/approve",array("id"=>$data->pegawaicuti_id)),array('rel'=>'tooltip','title'=>'Klik ikon ini, jika Anda ingin memproses approve', 'data-html'=>true,"id"=>"$data->pegawaicuti_id","target"=>"frameApprove", "onclick"=>"window.parent.$('#dialogApprove').dialog('open');"));
//                }else{
//                    return $data->NamaLengkapMenyetujui.'<br>('.$data->status_cuti.')';
//                }
           }
        ),
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function($data){
                return CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("id"=>$data->pegawaicuti_id)),array('rel'=>'tooltip','title'=>'Klik ikon ini, jika Anda ingin menampilkan <b>detail data permohonan cuti</b>', 'data-html'=>true,"id"=>"$data->pegawaicuti_id","target"=>"frameDetail", "onclick"=>"window.parent.$('#dialogDetail').dialog('open');"));
            }
        ),
        array(
            'header' => 'Batal',
            'type'=>'raw',
            'value'=>function($data) {
                    return CHtml::link('<i class="icon-form-silang"></i>', 'javascript::void(0)', array(
                        'rel'=>'tooltip',
                        'title'=>'Klik untuk Pembatalan Cuti.',
                        'onclick'=>'formPembatalanCuti('.$data->pegawaicuti_id.'); return false;',
                    ));
            },
            'htmlOptions'=>array(
                'style'=>'text-align: center',
            ),
        ),
    ),
   'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
)); ?>
