<?php
if (isset($data['caraPrint'])){
    if($data['caraPrint'] == 'EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
        $headerDefault = "";
    }
    
    if($data['caraPrint'] == 'PDF'){
        $headerDefault = $this->renderPartial('application.views.headerReport.headerDefault', array('width'=>1024));
    }
    
    if($data['caraPrint'] == 'PRINT'){
        $headerDefault = $this->renderPartial('application.views.headerReport.headerDefault');
    }
}
?>
<table>
    <tr>
        <td><?php echo $headerDefault; ?></td>
    </tr>
    <tr>
        <td align="center" style="padding: 20px;">
            <div><b><?php echo $data['judulLaporan']; ?></b></div>
            <div>Periode : <?php echo date("d-m-Y", strtotime($model->tgl_awal)); ?> s/d <?php echo date("d-m-Y", strtotime($model->tgl_akhir)); ?></div>
        </td>
    </tr>
    <tr>
        <td>
            <?php
                $dataProvider = null;
                // if($data['filter_tab'] == 'all')
                // {
                    $dataProvider = $model->searchPrint();
                // }

                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id'=>'semua_pencarianpasien_grid',
                    'dataProvider'=>$dataProvider,
                    'template'=>"{items}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                                'header' => 'No.',
                                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                            ),
                        array(
                            'header'=>'Tgl. Retur',
                            'name'=>'tglreturpelayanan',
                            'type'=>'raw',
                            'value'=>'$data->tglreturpelayanan',
                        ),
                        'noreturbayar',
                        'nama_pasien',
                        array(
                            'header'=>'No. RM',
                            'name'=>'no_rekam_medik',
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik',
                        ),
                        'no_pendaftaran',
                        'ruanganakhir_nama',
                        'totalbiayaretur',
                        'keteranganretur',
                        'user_nm_otorisasi',
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                ));
            ?>            
        </td>
    </tr>
</table>