<style>
    .even td {
        border-left: 1px solid #DDDDDD;
    }

    .odd td {
        border-left: 1px solid #DDDDDD;
    }
</style>
<?php
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$data = $model->searchLaporan();
$templates = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $data = $model->searchLaporanPrint();
    $templates = "\n{items}";
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

if ((isset($caraPrint) && $caraPrint == 'EXCEL')) {
    $this->widget($table, array(
        'id' => 'laporan-grid',
        'dataProvider' => $data,
        //'filter'=>$model,
        'template' => $templates,
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'mergeColumns' => array(
            'mobil',
        ),
        'columns' => array(
            array(
                'name' => 'mobil',
                'header' => 'Jenis Kendaraan - No. Polisi',
                'value' => '$data->mobil->jeniskendaraan." - ".$data->mobil->nopolisi',
                'footer' => 'Total'
            ),
            'norekammedis',
            'noidentitas',
            'namapasien',
            'tempattujuan',
            'alamattujuan',
            // 'nomobile',
            // 'notelepon',
            array(
                'header' => 'No. Handphone / Telepon',
                'value' => '$data->nomobile." / ".$data->notelepon',
            ),
            array(
                'header' => $model->getAttributeLabel('supir_id'),
                'value' => '(isset($data->supir->nama_pegawai) ? $data->supir->nama_pegawai : "")',
            ),
            //        array(
            //            'header'=>'Paramedis',
            //            'value'=>'(isset($data->paramedis1->nama_pegawai) ? $data->paramedis1->nama_pegawai : "")."/".(isset($data->paramedis2->nama_pegawai) ? $data->paramedis2->nama_pegawai : "")',
            //        ),
            /*
        array(
            'header'=>$model->getAttributeLabel('paramedis2_id'),
            'value'=>'$data->paramedis2->nama_pegawai',
        ),*/
            //'paramedis1.nama_pegawai',
            //'paramedis1',
            //'KMawalKMakhir',
            array(
                'header' => $model->getAttributeLabel('KMawalKMakhir'),
                'value' => 'number_format($data->kmawal,0,",",".")."/".number_format($data->kmakhir,0,",",".")',
                'filter' => false,
                // 'footer'=>$model->getTotal('kmawal').'/'.$model->getTotal('kmakhir'),
            ),
            array(
                'header' => 'Jumlah KM',
                'name' => 'jumlahkm',
                'value' => 'number_format($data->jumlahkm,0,",",".")',
                'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                //            'footer'=>$model->getTotal('jumlahkm'),
            ),
            array(
                'header' => 'Tarif per KM',
                'name' => 'tarifperkm',
                'value' => 'number_format($data->tarifperkm)',
                'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footer' => $model->getTotal('tarifperkm'),
                'footerHtmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Total Tarif Ambulans',
                'name' => 'totaltarifambulans',
                'value' => 'number_format($data->totaltarifambulans)',
                'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footer' => $model->getTotal('totaltarifambulans'),
                'footerHtmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'tglkembaliambulans',
                'value' => '(isset($data->tglkembaliambulans) ? date("d/m/Y H:i:s",strtotime($data->tglkembaliambulans)) : "-")',
                'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
} else {
    $this->widget($table, array(
        'id' => 'laporan-grid',
        'dataProvider' => $data,
        //'filter'=>$model,
        'template' => $templates,
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'mergeColumns' => array(
            'mobil',
        ),
        'columns' => array(
            array(
                'name' => 'mobil',
                'header' => 'Jenis Kendaraan - No. Polisi',
                'value' => '$data->mobil->jeniskendaraan." - ".$data->mobil->nopolisi',
                'footer' => 'Total'
            ),
            array(
                'header' => 'No. Identitas',
                'type' => 'raw',
                'value' => '$data->noidentitas',
            ),
            array(
                'header' => 'No. Rekam Medik',
                'type' => 'raw',
                'value' => '$data->norekammedis',
            ),
            array(
                'header' => 'Nama Pasien',
                'type' => 'raw',
                'value' => '$data->namapasien',
            ),
            array(
                'header' => 'Tempat Tujuan',
                'type' => 'raw',
                'value' => '$data->tempattujuan',
            ),
            array(
                'header' => 'Alamat Tujuan',
                'type' => 'raw',
                'value' => '$data->alamattujuan',
            ),
            // 'nomobile',
            // 'notelepon',
            array(
                'header' => 'No. Handphone / Telepon',
                'value' => '$data->nomobile." / ".$data->notelepon',
            ),
            array(
                'header' => $model->getAttributeLabel('supir_id'),
                'value' => '(isset($data->supir->nama_pegawai) ? $data->supir->nama_pegawai : "")',
            ),
            //        array(
            //            'header'=>'Paramedis',
            //            'value'=>'(isset($data->paramedis1->nama_pegawai) ? $data->paramedis1->nama_pegawai : "")."/".(isset($data->paramedis2->nama_pegawai) ? $data->paramedis2->nama_pegawai : "")',
            //        ),
            /*
        array(
            'header'=>$model->getAttributeLabel('paramedis2_id'),
            'value'=>'$data->paramedis2->nama_pegawai',
        ),*/
            //'paramedis1.nama_pegawai',
            //'paramedis1',
            //'KMawalKMakhir',
            array(
                'header' => $model->getAttributeLabel('KMawalKMakhir'),
                'value' => 'number_format($data->kmawal,0,",",".")." / ".number_format($data->kmakhir,0,",",".")',
                'htmlOptions' => array('style' => 'text-align:center;'),
                'filter' => false,
                // 'footer'=>$model->getTotal('kmawal').'/'.$model->getTotal('kmakhir'),
            ),
            array(
                'header' => 'Jumlah KM',
                //            'name'=>'jumlahkm',
                'value' => 'number_format($data->jumlahkm,0,",",".")',
                'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;'),
                'footerHtmlOptions' => array('style' => 'text-align:center;'),
                'footer' => MyFormatter::formatNumberForPrint($model->getTotal('jumlahkm')),
            ),
            array(
                'header' => 'Tarif per KM (Rp)',
                //            'name'=>'tarifperkm',
                'value' => 'number_format($data->tarifperkm,0,",",".")',
                'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footer' => MyFormatter::formatNumberForPrint($model->getTotal('tarifperkm')),
                'footerHtmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Total Tarif Ambulans (Rp)',
                //            'name'=>'totaltarifambulans',
                'value' => 'number_format($data->totaltarifambulans,0,",",".")',
                'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footer' => MyFormatter::formatNumberForPrint($model->getTotal('totaltarifambulans')),
                'footerHtmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Tanggal Kembali Ambulans',
                //            'name'=>'tglkembaliambulans',
                'value' => '(isset($data->tglkembaliambulans) ? date("d/m/Y H:i:s",strtotime($data->tglkembaliambulans)) : "-")',
                'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            ),
            /*
        'ruangan_id',
        'batalpakaiambulans_id',
        'mobilambulans_id',
        'pasien_id',
        'pesanambulans_t',
        'pendaftaran_id',
        'noidentitas',
        'kelurahan_nama',
        'rt_rw',
        'namapj',
        'hubunganpj',
        'alamatpj',
        'pelaksana_id',
        'jmlbbmliter',
        'untukkeperluan',
        'create_time',
        'update_time',
        'create_loginpemakai_id',
        'update_loginpemakai_id',
        'create_ruangan',
        */
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
}
?>