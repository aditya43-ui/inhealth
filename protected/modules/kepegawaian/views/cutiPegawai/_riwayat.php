<?php

$cuti = new PegawaicutiT();
$cuti->unsetAttributes();
$cuti->pegawai_id = $model->pegawai_id;

$prov = $cuti->search();
$prov->criteria->order = "tglmulaicuti desc";
$prov->criteria->addBetweenCondition("create_time::date", date('Y-m-d', strtotime('-5 years')), date('Y-m-d'));

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'riwayatcuti-grid',
    'dataProvider'=>$prov,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                    : ($row+1)',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
            'name'=>'jeniscuti_id',
            'value'=>'!empty($data->jeniscuti_id)?$data->jeniscuti->jeniscuti_nama:""',
        ),
        array(
            'header'=>'Tanggal Mulai',
            'name'=>'tglmulaicuti',
            'value'=>'$data->tglmulaicuti." s/d ".$data->tglakhircuti',
        ),
        array(
            'name'=>'lamacuti',
            'value'=>'$data->lamacuti." Hari"',
        ),
        array(
            'header'=>'No. SK',
            'name'=>'noskcuti',
            'value'=>'$data->noskcuti',
        ),
        array(
            'header'=>'Tgl. SK',
            'name'=>'tglditetapkanskcuti',
            'value'=>'$data->tglditetapkanskcuti',
        ),
        array(
            'header'=>'Keperluan',
            'value'=>'$data->keperluancuti',
        ),
        array(
            'header'=>'Keterangan',
            'value'=>'$data->keterangan',
        ),
        array(
            'header'=>'Pejabat Mengetahui',
            'value'=>'!empty($data->pejabatmengetahui)?$data->pegMengetahui->namaLengkap:""',
        ),
        array(
            'header'=>'Pejabat Menyetujui',
            'value'=>'!empty($data->pejabatmenyetujui)?$data->pegMenyetujui->namaLengkap:""',
        ),
        array(
            'header'=>'Ubah',
            'type'=>'raw',
            'value'=>function($data) {
                if (!empty($data->tgl_menyetujui)){
                    return $data->status_cuti;
                }else{
                    $urlUpdate = $this->createUrl('index',array('pegawai_id'=>$data->pegawai_id,'pegawaicuti_id'=>$data->pegawaicuti_id));
                    return CHtml::link("<i class='glyphicon glyphicon-pencil'></i>",$urlUpdate,array("rel"=>"tooltip","title"=>"Klik untuk Ubah Cuti Pegawai"));
                }
            },
            'htmlOptions'=>array(
                'style'=>'text-align: center',
            ),
        ),
        array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>function($data) {
                if (!empty($data->tgl_menyetujui)){
                    return $data->status_cuti;
                }else{
                    $urlDelete = $this->createUrl('deletePegawaicuti',array('pegawaicuti_id'=>$data->pegawaicuti_id,'pegawai_id'=>$data->pegawai_id));
                    return CHtml::link('<i class="icon-form-sampah"></i>',$urlDelete,array('onclick'=>'hapus(this); return false'));
                }
            },
            'htmlOptions'=>array(
                'style'=>'text-align: center',
            ),
        ),
        
    ),
    
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

?>
