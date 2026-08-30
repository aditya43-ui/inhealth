<?php
	$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$template = "{summary}\n{items}\n{pager}";

$itemCss = 'table table-striped table-bordered table-condensed';
if (isset($caraPrint)){
	$itemCss = 'table border';
	$template = "{items}\n{pager}";
	if ($caraPrint == 'EXCEL'){
		 $table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

  $provider = $model2->searchStokBahanMakanan();
  
  if (isset($caraPrint)){
	  $provider->pagination = false;
  }
  
  $prov2 = clone $provider;
  $criteria = clone $prov2->criteria;
  $criteria->select = "sum(qty_masuk) as qty_masuk, sum(qty_keluar) as qty_keluar, satuanbahan";
  $criteria->group = $criteria->order = "satuanbahan";
  
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
    if ($pilihTgl == 'true'){
            if (!empty($model2->tgl_awal) && !empty($model2->tgl_akhir)) {

              $tgl_awal = $model2->tgl_awal;
              $tgl_akhir = $model2->tgl_akhir;
              $provider->criteria->addBetweenCondition('t.tgltransaksi::date', $tgl_awal, $tgl_akhir);
              $prov2->criteria->addCondition("t.tgltransaksi::date <= '".$tgl_akhir."'");
              $provLokal->criteria->addCondition("t.tgltransaksi::date < '".$tgl_awal."'");
              $arrb = explode("-", $tgl_awal);

              $arrb[1] = (int)$arrb[1];
              $arrb[0] = (int)$arrb[0];
              $arrb[1]--;
              if ($arrb[1] == 0) {
                      $arrb[1] = 12;
                      $arrb[0]--;
              }
              $bulan = MyFormatter::getMonthId($arrb[1])." ".$arrb[0];
            }
    }
    
  foreach ($prov2->data as $item) {
	  $stok_in += $item->qty_masuk;
	  $stok_out += $item->qty_keluar;
	  $satuan = $item->satuanbahan;
  }
  
  foreach ($provLokal->data as $item) {
	  $stok_in_0 += $item->qty_masuk;
	  $stok_out_0 += $item->qty_keluar;
  }
  
  $stok_total = $stok_in - $stok_out;
  
  ?>

		<?php
		  $this->widget($table,array(
			'id'=>'informasi-grid',
			'dataProvider'=>$provider,
				'template'=>$template,
				'itemsCssClass'=>$itemCss,
			'columns'=>array(
                            array(
                                          'header'=>'Tgl. Transaksi',
                                          //'name'=>'create_time',
                                          'type'=>'raw',
                                          'value'=>'MyFormatter::formatDateTimeForUser($data->tgltransaksi)',
                                          'htmlOptions'=>array('style'=>'text-align:right;'),
                                          'footerHtmlOptions'=>array(
                                                    'colspan'=>3,
                                                    'style'=>'text-align:right;font-style:italic;'
                                          ),
                                          'footer'=>'Jumlah Stok',
                                  ),
                                array(
                                        'header'=>'Jenis Transaksi',
                                        'type'=>'raw',
                                        'value'=>'$data->keteranganTransaksi',
                                        'htmlOptions'=>array('style'=>'text-align:right;'),
                                ),
                                array(
                                        'header'=>'No. Transaksi',
                                        'type'=>'raw',
                                        'value'=>'$data->noTransaksi',
                                        'htmlOptions'=>array('style'=>'text-align:right;'),
                                ),
                                array(
                                        'header'=>'Stok Masuk',
                                        'type'=>'raw',
                                        'value'=>'$data->qty_masuk." ".$data->satuanbahan',
                                        'htmlOptions'=>array('style'=>'text-align:right;'),
                                        'footer'=>$stok_in." ".$satuan. '<input type="hidden" id="in_0" value="'.$stok_in_0.'">',
                                        'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;')
                                ),
                                array(
                                        'header'=>'Stok Keluar',
                                        'type'=>'raw',
                                        'value'=>'$data->qty_keluar." ".$data->satuanbahan',
                                        'htmlOptions'=>array('style'=>'text-align:right;'),
                                        'footer'=>$stok_out." ".$satuan. 
                                        '<input type="hidden" id="out_0" value="'.$stok_out_0.'">'.
                                        '<input type="hidden" id="bulan_0" value="'.$bulan.'">'.
                                        '<input type="hidden" id="total_0" value="'.$stok_total.'">'.
                                        '<input type="hidden" id="satuan_0" value="'.$satuan.'">',
                                        'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;')
                                  ),
			),
				'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"}); hitungTotalStok();}',
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
	
	$('#informasi-grid tbody tr:last').after('<tr><td colspan="3" style="text-align:right;font-style:italic;">Stok Akhir</td><td colspan="2" style="text-align:right;font-style:italic;">'+stokAkhir+' '+satuan+'</td></tr>');
}	
	
function cariKartuStok() {
	$.fn.yiiGridView.update('informasi-grid', {data: $("#informasi-search").serialize()});
}
	
	
/**
  tambah footer pada gridview untuk hitung stok akhir
*/
hitungTotalStok();

</script>
