<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = false;
    $dataProvider = $model->printRekapTableMcu();
    $template = "{summary}\n{items}\n{pager}";
    
    if($caraPrint == 'EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $data['judulLaporan'] .'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    
    echo $this->renderPartial('application.views.headerReport.headerLaporan',
        array(
            'judulLaporan'=>$data['judulLaporan'],
            'periode'=>$data['periode']
        )
    );    
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableLaporanTrans',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeColumns' => array('no_rekam_medik','nama_pasien'),
            'columns'=>array(
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                    'footerHtmlOptions' => array('colspan' => 5, 'style' => 'text-align: right; font-weight: bold;'),
                    'footer'=>'Total (Rp)',
                ),
                array(
                    'header'=>'Nama',
                    'name'=>'nama_pasien',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                ),                
                array(
                    'header'=>'Tanggal Transaksi',
                    'type'=>'raw',
                    'value'=>'($data->tgl_tindakan == null) ? "-" : date("d/m/Y H:i:s",strtotime($data->tgl_tindakan))',
                ),                
                array(
                    'header'=>'Initial P3',
                    'type'=>'raw',
                    'value'=>'($data->penjamin_nama == "Umum" ? "-" : $data->penjamin_nama)',
                ),
                array(
                    'header'=>'Biaya Pasien',
                    'name'=>'tarif_tindakan',
                    'type'=>'raw',
                    'value'=>'number_format($data->tarif_tindakan,0,",",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>number_format($model->getSumTarifTindakanMcu(),0,",","."),
                ),
                array(
                    'header'=>'Tanggungan P3',
                    'name'=>'TotalSubsidi',
                    'type'=>'raw',
                    'value'=>'number_format(($data->subsidiasuransi_tindakan+$data->subsidipemerintah_tindakan+$data->subsisidirumahsakit_tindakan),0,",",".")',
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
?>
<?php 
    if($caraPrint == 'EXCEL'){
        $this->widget($table,
        array(
            'id'=>'tableLaporanTrans',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeColumns' => array('no_rekam_medik','nama_pasien'),
            'columns'=>array(
                array(
                    'header'=>'No. RM',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                    'footerHtmlOptions' => array('colspan' => 5, 'style' => 'text-align: right; font-weight: bold;'),
                    'footer'=>'Total (Rp)',
                ),
                array(
                    'header'=>'Nama',
                    'name'=>'nama_pasien',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                ),                
                array(
                    'header'=>'Tanggal Transaksi',
                    'type'=>'raw',
                    'value'=>'$data->tgl_tindakan',
                ),                
                array(
                    'header'=>'Initial P3',
                    'type'=>'raw',
                    'value'=>'($data->penjamin_nama == "Umum" ? "-" : $data->penjamin_nama)',
                ),
                array(
                    'header'=>'Biaya Pasien',
                    'name'=>'tarif_tindakan',
                    'type'=>'raw',
                    'value'=>'number_format($data->tarif_tindakan)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_tindakan)'
                ),
                array(
                    'header'=>'Tanggungan P3',
                    'name'=>'TotalSubsidi',
                    'type'=>'raw',
                    'value'=>'number_format($data->subsidiasuransi_tindakan+$data->subsidipemerintah_tindakan+$data->subsisidirumahsakit_tindakan)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(TotalSubsidi)',
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
    }
        
?>