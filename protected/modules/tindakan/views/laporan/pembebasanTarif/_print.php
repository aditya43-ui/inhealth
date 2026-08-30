<?php
$itemCssClass = 'table table-striped table-condensed';
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 10));
if ($caraPrint != 'GRAFIK') {
    //$this->renderPartial('penerimaanKasir/_table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $dataProv = $model->searchLaporanPrint();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)) {
        $sort = false;
        $dataProv = $model->searchLaporanPrint();
        $template = "{items}";
        if ($caraPrint == "EXCEL") {
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }

        echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass = 'table border';
    }
?>
<?php $this->widget($table, array(
        'id' => 'tableLaporan',
        'dataProvider' => $dataProv,
        'enableSorting' => $sort,
        'template' => $template,
        'itemsCssClass' => $itemCssClass,
        'columns' => array(
            array(
                'header' => 'No.',
                'type' => 'raw',
                'value' => '$row+1'
            ),
            array(
                'header' => 'Tanggal Pembebasan',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembebasan)'
            ),
            array(
                'header' => 'Tanggal Pelayanan',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
            ),
            array(
                'header' => 'No. Pendaftaran',
                'type' => 'raw',
                'value' => '$data->no_pendaftaran'
            ),
            array(
                'header' => 'No. Rekam Medik',
                'type' => 'raw',
                'value' => '$data->no_rekam_medik'
            ),
            array(
                'header' => 'Nama Pasien',
                'type' => 'raw',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),
            array(
                'header' => 'Ruangan Pelayanan',
                'type' => 'raw',
                'value' => '$data->ruangan_nama'
            ),
            array(
                'header' => 'Uraian Tindakan',
                'type' => 'raw',
                'value' => '$data->daftartindakan_nama'
            ),
            array(
                'header' => 'Jumlah Tarif (Rp)',
                'type' => 'raw',
                'value' => 'number_format(($data->tarif_satuan * $data->qty_tindakan),0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;')
            ),
            array(
                'header' => 'Komponen Tarif',
                'type' => 'raw',
                'value' => '$data->komponentarif_nama'
            ),
            array(
                'header' => 'Jumlah Pembebasan (Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->jmlpembebasan,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;')
            ),
            array(
                'header' => 'Nama Dokter',
                'type' => 'raw',
                'value' => '$data->dokterLengkap'
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
} else if ($caraPrint == 'GRAFIK') {
    echo $this->renderPartial('_grafik', array('model' => $model, 'data' => $data, 'caraPrint' => $caraPrint), true);
}

?>

<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="50%">
            <label style='float:left;'>Petugas : <?php echo $data['nama_pegawai']; ?></label>

        </td>
        <td width="50%">

            <!--<label style='float:right;'>Tanggal Print : <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>-->

        </td>
    </tr>
</table>