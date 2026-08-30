<?php
    if($caraPrint == 'EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $data['judulLaporan'] .'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
    }
    
    echo $this->renderPartial('application.views.headerReport.headerLaporan',
        array(
            'judulLaporan'=>$data['judulLaporan'],
            'periode'=>$data['periode']
        )
    );
?>
<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrintHemodialisa();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableHemodialisa();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableTrans',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tanggal Transaksi',
                    'type'=>'raw',
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tgl_tindakan))',
                    'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align: right; font-weight: bold;'),
                    'footer'=>'Total (Rp)',
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>number_format($model->getSumTarifTindakanHemodialisa(),0,",","."),
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                     'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>number_format($model->getSumTotalSubsidiHemodialisa(),0,",","."),
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
                ),
                array(
                    'header'=>'Tanggungan P3',
                    'name'=>'TotalSubsidi',
                    'type'=>'raw',
                    'value'=>'number_format($data->TotalSubsidi,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
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