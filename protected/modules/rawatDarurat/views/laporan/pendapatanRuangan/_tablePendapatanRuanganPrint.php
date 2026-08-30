<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$sort = true;
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $sort = false;
    $data = $model->searchPrint();
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
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    // 'mergeHeaders'=>array(
    //   array(
    //     'name'=>'<p style="margin: 0; text-align: center;">Tarif</p>',
    //   'start'=>7, //indeks kolom 3
    // 'end'=>12, //indeks kolom 4
    //),
    //),
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'value' => '$row+1'
        ),
        array(
            'name' => 'no_pendaftaran',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'no_rekam_medik',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),

        array(
            'header' => 'Dokter',
            'value' => function ($data) {
                $dokter = PegawaiM::model()->findByPk($data->dokterpemeriksa1_id);

                if (!empty($dokter)) {
                    return $dokter->namaLengkap;
                } else {
                    return '-';
                }
            },
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Jenis Penjamin <br> / Penjamin',
            'type' => 'raw',
            'value' => '$data->carabayar_nama." <br> / ".$data->penjamin_nama',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(

            'header' => 'Kelas Pelayanan',
            'value' => '$data->kelaspelayanan_nama',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-style:italic;'),
            'footer' => 'Jumlah Total',
        ),
        /*array(
                    'name'=>'tarif_satuan',
                    'value'=>'number_format($data->tarif_satuan,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_satuan)',
                ),
                array(
                    'name'=>'tarifcyto_tindakan',
                    'value'=>'"Rp".number_format($data->tarifcyto_tindakan,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarifcyto_tindakan)',
                ),
                array(
                    'name'=>'tarif_rsakomodasi',
                    'value'=>'"Rp".number_format($data->tarif_rsakomodasi,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_rsakomodasi)',
                ),
                array(
                    'name'=>'tarif_medis',
                    'value'=>'"Rp".number_format($data->tarif_medis,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_medis)',
                ),
                array(
                    'name'=>'tarif_paramedis',
                    'value'=>'"Rp".number_format($data->tarif_paramedis,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_paramedis)',
                ),
                array(
                    'name'=>'tarif_bhp',
                    'value'=>'"Rp".number_format($data->tarif_bhp,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_bhp)',
                ),*/
        array(
            'header' => 'Total (Rp)',
            'name' => 'totalTarif',
            'value' => 'number_format($data->totalTarif,0,"",".")',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(totalTarif)',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>