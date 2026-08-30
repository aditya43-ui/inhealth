<style>
.glyphicon:empty {
    width: 2em;
}
</style>
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
            'header' => 'Tgl. Pengajuan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->pengajuanpetty_tgl)'
        ),
        array(
            'header' => 'No. Pengajuan',
            'type' => 'raw',
            'value' => '$data->pengajuanpetty_no',
        ),
        array(
            'header' => 'Ruangan',
             'type' => 'raw',
            'value' => '$data->ruangan_nama',
        ),
        array(
            'header' => 'Kategori',
            'type' => 'raw',
            'value' => '$data->pengajuanpetty_kategori'
        ),
        array(
            'header' => 'Alasan Pengajuan',
            'type' => 'raw',
            'value' => '$data->pengajuanpetty_untuk'
        ),
        array(
            'header' => 'Pegawai yang Mengajukan',
            'type' => 'raw',
            'value' => '$data->namaLengkapMengajukan'
        ),
        array(
            'header'=>'Pegawai Mengetahui',
            'type'=>'raw',
            'value' => function($data){
                $dataDialog = 'myAlert("Hanya '.(isset($data->atasan_id)? $data->namaLengkapAtasan : "-").' yang bisa mengakses");';
                if($data->atasan_id==Yii::app()->user->getState('pegawai_id')){
                   $dataDialog = "$('#dialogMengetahui').dialog('open');";
                }
                $html = (isset($data->atasan_id)? $data->namaLengkapAtasan : "-").(isset($data->diketahuiatasan_tgl) ? "<br>".MyFormatter::formatDateTimeForUser($data->diketahuiatasan_tgl) : (!isset($data->atasan_id)? "" : (!isset($data->atasan_id) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Mengetahui', array("pengajuanpetty_id"=>$data->pengajuanpetty_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve Mengetahui", "onclick"=>$dataDialog)))));
                return $html;
            }
        ),
        array(
            'header'=>'Pegawai Menyetujui',
            'type'=>'raw',
            'value'=>function($data){
                $dataDialog = 'myAlert("Hanya '.(isset($data->direktur_id)? $data->namaLengkapDirektur : "-").' yang bisa mengakses");';
                if($data->direktur_id==Yii::app()->user->getState('pegawai_id')){
                   $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                }
               $html = (isset($data->direktur_id)? $data->namaLengkapDirektur : "-").(isset($data->accdirektur_tgl) ? "<br>".MyFormatter::formatDateTimeForUser($data->accdirektur_tgl) : (!isset($data->direktur_id)? "" : ((empty($data->diketahuiatasan_tgl)) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui', array("pengajuanpetty_id"=>$data->pengajuanpetty_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve Menyetujui", "onclick"=>$dataDialog)))));
                return $html;
            },
        ),
        array(
            'header'=>'Status',
            'type'=>'raw',
            'value'=>function($data){
                if ($data->pengajuanpetty_status == Params::STATUS_PETTY_CASH_PENGAJUAN){
                    return CHtml::link($data->pengajuanpetty_status,'javascript:;',array('class'=>'btn btn-success nohover'));
                }else if ($data->pengajuanpetty_status == Params::STATUS_PETTY_CASH_DISETUJUI){
                    return CHtml::link($data->pengajuanpetty_status,'javascript:;',array('class'=>'btn btn-info nohover'));
                }else if ($data->pengajuanpetty_status == Params::STATUS_PETTY_CASH_DITOLAK){
                    return CHtml::link($data->pengajuanpetty_status,'javascript:;',array('class'=>'btn btn-danger nohover'));
                }
            },
        ),

        array(
            'header' => 'Rincian',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => function($data){
                return CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/rincian",array("pengajuanpetty_id"=>$data->pengajuanpetty_id)),array('rel'=>'tooltip','title'=>'Klik ikon ini, jika Anda ingin menampilkan <b>detail pengajuan anggaran operasional</b>', 'data-html'=>true,"id"=>"$data->pengajuanpetty_id","target"=>"frameDetail", "onclick"=>"window.parent.$('#dialogDetail').dialog('open');"));
            }
        ),

    ),
   'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
)); ?>
