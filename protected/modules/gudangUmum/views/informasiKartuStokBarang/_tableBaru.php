<?php // die;
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$template = "{summary}\n{items}\n{pager}";

$itemCss = 'table table-striped table-bordered table-condensed';
if (isset($caraPrint)) {
    $itemCss = 'table border';
    $template = "{items}\n{pager}";
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

$provider = $model2->searchStokBarang();

//var_dump($model2->searchByObatalkes());die;

if (isset($caraPrint)) {
    $provider->pagination = false;
}

$prov2 = clone $provider;
$criteria = clone $prov2->criteria;
$criteria->select = "sum(qtystok_in) as qtystok_in, sum(qtystok_out) as qtystok_out, barang_satuan";
if (!empty($model2->instalasi_id)) {
    //$criteria->addCondition(" instalasi_id = ".$model2->instalasi_id." ");
}



if (!empty($model2->ruangan_id)) {
    //$criteria->addCondition(" ruangan_id = ".$model2->ruangan_id." ");
}
$criteria->group = $criteria->order = "barang_satuan";

$criteriaLokal = clone $criteria;

$prov2->pagination = false;
$prov2->criteria = $criteria;


$provLokal = clone $prov2;
$provLokal->criteria = $criteriaLokal;

$stok_in = 0;
$stok_out = 0;
$satuan = "";

$stok_in_0 = 0;
$stok_out_0 = 0;
$stok_total = 0;

$bulan = "";

if (!empty($model2->instalasi_id)) {
    //$provider->criteria->addCondition(" instalasi_id = ".$model2->instalasi_id." ");
}

if (!empty($model2->ruangan_id)) {
    //$provider->criteria->addCondition(" ruangan_id = ".$model2->ruangan_id." ");
}
//var_dump($pilihTgl);
if ($pilihTgl == 'true') {
    //var_dump($pilihTgl);
    if (!empty($model2->tgl_awal) && !empty($model2->tgl_akhir)) {

        $tgl_awal = $model2->tgl_awal;
        $tgl_akhir = $model2->tgl_akhir;
        $provider->criteria->addBetweenCondition('t.tgltransaksi::date', $tgl_awal, $tgl_akhir);
        $prov2->criteria->addCondition("t.tgltransaksi::date <= '" . $tgl_akhir . "'");
        $provLokal->criteria->addCondition("t.tgltransaksi::date < '" . $tgl_awal . "'");
        $arrb = explode("-", $tgl_awal);

        $arrb[1] = (int)$arrb[1];
        $arrb[0] = (int)$arrb[0];
        $arrb[1]--;
        if ($arrb[1] == 0) {
            $arrb[1] = 12;
            $arrb[0]--;
        }
        $bulan = MyFormatter::getMonthId($arrb[1]) . " " . $arrb[0];
    }
}

foreach ($prov2->data as $item) {
    $stok_in += $item->qtystok_in;
    $stok_out += $item->qtystok_out;
    $satuan = $item->barang_satuan;
}

foreach ($provLokal->data as $item) {
    $stok_in_0 += $item->qtystok_in;
    $stok_out_0 += $item->qtystok_out;
}

$stok_total = $stok_in - $stok_out;



//var_dump($stok_in, $stok_out); die;


// $provider->pagination=true;
?>

<?php
$this->widget($table, array(
    'id' => 'informasi-grid',
    'dataProvider' => $provider,
    'template' => $template,
    'itemsCssClass' => $itemCss,
    'columns' => array(
        array(
            'header' => 'Tgl. Transaksi',
            //'name'=>'create_time',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgltransaksi)',
            // 'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array(
                'colspan' => 3,
                'style' => 'text-align:right;font-style:italic;'
            ),
            'footer' => 'Jumlah Stok',
        ),
        array(
            'header' => 'Jenis Transaksi',
            'type' => 'raw',
            'value' => '$data->keteranganTransaksi',
            // 'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'No. Transaksi',
            'type' => 'raw',
            'value' => '$data->noTransaksi',
            // 'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        //                            array(
        //							'header'=>'Nama Obat',
        //							'type'=>'raw',
        //							'value'=>'$data->obatalkes_nama',
        ////							'htmlOptions'=>array('style'=>'te;'),
        //						),
        //					  array(
        //						  'header'=>'Tgl. Kedaluwarsa',
        //						  //'name'=>'tglkadaluarsa',
        //						  'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
        //						),
        array(
            'header' => 'Stok Masuk',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint($data->qtystok_in)." ".$data->barang_satuan',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footer' => $stok_in . " " . $satuan . '<input type="hidden" id="in_0" value="' . $stok_in_0 . '">',
            'footerHtmlOptions' => array('style' => 'text-align:right;font-style:italic;')
        ),
        array(
            'header' => 'Stok Keluar',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint($data->qtystok_out)." ".$data->barang_satuan',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footer' => $stok_out . " " . $satuan .
                '<input type="hidden" id="out_0" value="' . $stok_out_0 . '">' .
                '<input type="hidden" id="bulan_0" value="' . $bulan . '">' .
                '<input type="hidden" id="total_0" value="' . $stok_total . '">' .
                '<input type="hidden" id="satuan_0" value="' . $satuan . '">',
            'footerHtmlOptions' => array('style' => 'text-align:right;font-style:italic;')
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); hitungTotalStok();}',
)); ?>

<script>
    function hitungTotalStok() {
        var satuan = $('#satuan_0').val();
        var totStokMasuk = $('#informasi-grid tbody tr td:last').prev('td').html().match(/\d+/);
        var totStokKeluar = $('#informasi-grid tbody tr td:last').html().match(/\d+/);
        var totStokMasuk_0 = $("#in_0").val();
        var totStokKeluar_0 = $("#out_0").val();
        var stokBulan_0 = $("#bulan_0").val();
        var stokAkhir = $("#total_0").val();

        /*if (stokBulan_0.trim() !== "") {
        	$('#informasi-grid tbody:first').prepend(
        			'<tr>' + 
        			'<td colspan="4" style="text-align:right;font-style:italic;">Stok Bulan ' + stokBulan_0 + '</td>' + 
        			'<td style="text-align:right;font-style:italic;">'+totStokMasuk_0+' '+satuan+'</td>' + 
        			'<td style="text-align:right;font-style:italic;">'+totStokKeluar_0+' '+satuan+'</td>' + 
        			'</tr>');
        }*/
        $('#informasi-grid tbody tr:last').after('<tr><td colspan="3" style="text-align:right;font-style:italic;">Stok Akhir</td><td colspan="2" style="text-align:right;font-style:italic;">' + stokAkhir + ' ' + satuan + '</td></tr>');
    }

    function cariKartuStok() {
        $.fn.yiiGridView.update('informasi-grid', {
            data: $("#informasi-search").serialize()
        });
    }


    /**
      tambah footer pada gridview untuk hitung stok akhir
    */
    hitungTotalStok();
</script>