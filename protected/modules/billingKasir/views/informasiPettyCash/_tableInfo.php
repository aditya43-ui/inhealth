<style>
    .glyphicon:empty {
        width: 2em;
    }
</style>
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kpinfohukumanpoinpeg-v-grid',
    'dataProvider' => $model->searchInformasi(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'filter' => false,
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'headerHtmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'name' => 'pengajuanpetty_tgl',
            'value' => 'MyFormatter::formatDateTimeForUser($data->pengajuanpetty_tgl)'
        ),
        array(
            'name' => 'pengajuanpetty_no',
        ),
        array(
            'header' => 'Yang Mengajukan',
            'type' => 'raw',
            'value' => '$data->namaLengkapMengajukan'
        ),
        array(
            'header' => 'Yang Memeriksa',
            'type' => 'raw',
            'value' => '$data->namaLengkapKeuangan'
        ),
        array(
            'header' => 'Yang Mengetahui',
            'name' => 'atasan_nama',
            'type' => 'raw',
            //'value' => '$data->namaLengkapAtasan'
            'value' => function($data) {
                //if (empty($data->diketahuiatasan_tgl)){
                //	return CHtml::link($data->namaLengkapAtasan. "<i class='icon-form-check'>",'javascript:;',array('rel'=>'tooltip','title'=>'Klik ikon ini, jika Anda ingin menyetujui pengajuan ini', 'data-html'=>true,"id"=>"$data->pengajuanpetty_id","onclick"=>"ApproveByPegawai(".$data->pengajuanpetty_id.",'atasan',".$data->atasan_id.")"));
                //}else{
                //return $data->namaLengkapAtasan.'/<br> '.MyFormatter::formatDateTimeForUser($data->diketahuiatasan_tgl);
                return $data->namaLengkapAtasan;
                //	}
            }
        ),
        array(
            'header' => 'Yang Menyetujui',
            'type' => 'raw',
            'value' => '$data->yangMenyetujui($data->pengajuanpetty_id)',
        ),
        array(
            'header' => 'Untuk',
            'type' => 'raw',
            'value' => '$data->untukPengeluaran($data->jenispengeluaran_id)',
        ),     
        array(
            'header' => 'Yang Menerima',
            'type' => 'raw',
            'value' => '$data->namapenerima',
        ),  
        array(
            'header' => 'Terima Kas',
            'type' => 'raw',
            'value' => function($data){
                        return CHtml::link("<i class='icon-form-bayar'></i>",Yii::app()->createUrl("billingKasir/PenerimaanUmumBK/Index",array("id"=>$data->pengajuanpetty_id)),array('rel'=>'tooltip','title'=>'Klik ikon ini, jika Anda ingin melakukan penerimaan kas', 'data-html'=>true,"id"=>"$data->pengajuanpetty_id","target"=>"frameApprove", "onclick"=>"window.parent.$('#dialogApprove').dialog('open');"));        
                    }
        ),   
         
    ),
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
));
?>                   