<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
        
        echo "
             <style>
            .table th, .table td{
                border:1px solid #000 !important;
            }
            
            .table tbody + tbody {
                border-top: none;
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
        $itemCssClass='table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }

$ptotal = $model->searchPrint();

$total_rs = 0;
$total_medis = 0;
$total_paramedis = 0;
$total_bhp = 0;
$total_seluruh = 0;

foreach ($ptotal->data as $item) {
    $total_rs += $item->tarif_rsakomodasi;
    $total_medis += $item->tarif_medis;
    $total_paramedis += $item->tarif_paramedis;
    $total_bhp += $item->tarif_bhp;
}   

$total_seluruh = $total_rs + $total_medis + $total_paramedis + $total_bhp;

$this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'mergeHeaders'=>array(
            /*
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Tindakan</p>',
                'start'=>7, //indeks kolom 3
                'end'=>13, //indeks kolom 4
            ),
             * 
             */
            //array(
              //  'name'=>'<p style="margin: 0; text-align: center;">Karcis</p>',
                //'start'=>14, //indeks kolom 3
               // 'end'=>18, //indeks kolom 4
            //),
        ),
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                array(
                    'header'=>'No.',
                    'value' => $row,
                    'footer' => 'Total',
                    'footerHtmlOptions'=>array(
                        'colspan'=>10,
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                array(
                    'header' => 'Tgl. Pembayaran/<br>No. Pembayaran',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglpembayaran)."/<br>".$data->nopembayaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'value'=> '$data->no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pasien',
                    'value'=> '$data->namadepan." ".$data->nama_pasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                
                array(
                    'header'=>'Jenis Penjamin / <br>Penjamin',
                    'name' => 'carabayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
            
                array(
                    'header' => 'Instalasi',
                    'value'=>'$data->instalasi_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Ruangan',
                    'value'=>'$data->ruangan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
					'header'=>'Tindakan',
                    'name' => 'daftartindakan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'$data->daftartindakan_nama',
                ),
//                array(
//                    'name' => 'kelaspelayanan_nama',
//                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
//                ),
                array(
                    'name' => 'tarif_tindakan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_satuan)',
                    'htmlOptions'=>array(
                        'style'=>'text-align: right',
                    ),
                ),
                array(
                    'name' => 'qty_tindakan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'$data->qty_tindakan',
                    'htmlOptions'=>array(
                        'style'=>'text-align: right',
                    ),
                ),
                array(
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'name' => 'tarif_rsakomodasi',
                    'header' => 'Tarif RS',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_rsakomodasi)',
                    'footer'=>MyFormatter::formatNumberForPrint($total_rs),
                    'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
                ),
                array(
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'name' => 'tarif_medis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_medis)',
                    'footer'=>MyFormatter::formatNumberForPrint($total_medis),
                    'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
                ),
                array(
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'name' => 'tarif_paramedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_paramedis)',
                    'footer'=>MyFormatter::formatNumberForPrint($total_paramedis),
                    'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
                ),
                array(
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'name' => 'tarif_bhp',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_bhp)',
                    'footer'=>MyFormatter::formatNumberForPrint($total_bhp),
                    'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
                ),
//                'daftartindakan_nama',
//                'qty_tindakan',
//                'no_pendaftaran',
//                'carabayarPenjamin',
////                'penjamin_nama',
//                'kelaspelayanan_nama',
//                'tarif_rsakomodasi',
//                'tarif_medis',
//                'tarif_paramedis',
//                'tarif_bhp',
                array(
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'name'=>'subtotal',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value'=>'MyFormatter::formatNumberForPrint(($data->tarif_rsakomodasi+$data->tarif_medis+$data->tarif_paramedis+$data->tarif_bhp))',
                    'footer'=>MyFormatter::formatNumberForPrint($total_seluruh),
                    'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
                ),/*
                array(
                    'name' => 'karcisnama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->daftartindakan_nama',
                ),
                array(
                    'name' => 'karcisqty',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->qty_tindakan',
                ),
                array(
                    'name' => 'karcisrs',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->tarif_rsakomodasi',
                ),
                array(
                    'name' => 'karcismedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->tarif_medis',
                ),
                
                array(
                    'name'=>'subtotal',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : "Rp ".MyFormatter::formatNumberForPrint($data->qty_tindakan*($data->tarif_rsakomodasi+$data->tarif_medis))',
                ),*/
//                'subtotal',
//                'profilrs_id',
//                'pasien_id',
//                'no_rekam_medik',
//                'tgl_rekam_medik',
//                'jenisidentitas',
//                'no_identitas_pasien',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>