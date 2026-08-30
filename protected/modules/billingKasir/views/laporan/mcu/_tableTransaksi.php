<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = false;
    $dataProvider = $model->searchTableMcu();
    $template = "{summary}\n{items}\n{pager}";
    ?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableTrans',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-responsive table-bordered table-striped table-condensed',
            'mergeColumns' => array('no_rekam_medik'),
            'columns'=>array(
                array(
                    'header'=>'Tanggal Transaksi',
                    'type'=>'raw',
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tgl_tindakan))',
                    'footerHtmlOptions' => array('colspan' => 5, 'style' => 'text-align: right; font-weight: bold;'),
                    'footer'=>'Total (Rp)',
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                ),
//                array(
//                    'header'=>'No. Transaksi',
//                    'type'=>'raw',
//                    'value'=>'$data->tindakanpelayanan_id',
//                ),
                
//                array(
//                    'header'=>'Nama Tindakan',
//                    'type'=>'raw',
//                    'value'=>'$data->daftartindakan_nama',
//                ),
//                array(
//                    'header'=>'Jumlah',
//                    'type'=>'raw',
//                    'value'=>'number_format($data->qty_tindakan)',
//                ),
//                array(
//                    'header'=>'Biaya Pasien',
//                    'type'=>'raw',
//                    'value'=>'number_format($data->tarif_satuan)',
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                ),
                array(
                    'header'=>'Asal',
                    'type'=>'raw',
                    'value'=>'empty($data->rujukan_id) ? ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS())->nama_rumahsakit : "Rujukan"',
                    
                ),
                array(
                    'header'=>'Biaya Pasien',
                    'name'=>'tarif_tindakan',
                    'type'=>'raw',
                    'value'=>'number_format($data->tarif_tindakan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>number_format($model->getSumTarifTindakanMcu(),0,",","."),
                ),
                array(
                    'header'=>'Tanggungan P3',
                    'name'=>'TotalSubsidi',
                    'type'=>'raw',
                    'value'=>'number_format($data->TotalSubsidi,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>number_format($model->getSumTotalSubsidiMcu(),0,",","."),
                ),
//                array(
//                    'header'=>'Iur Biaya',
//                    'type'=>'raw',
//                    'value'=>'number_format($data->iurbiaya_tindakan)',
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                ),
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
    