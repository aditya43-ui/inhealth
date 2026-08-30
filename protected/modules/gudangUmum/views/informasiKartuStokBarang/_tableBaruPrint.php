<?php // die;
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

  $provider = $model2->searchStokBarang();
  
  //var_dump($model2->searchByObatalkes());die;
  
  if (isset($caraPrint)){
	  $provider->pagination = false;
  }
  
  $prov2 = clone $provider;
  $criteria = clone $prov2->criteria;
  $criteria->select = "sum(qtystok_in) as qtystok_in, sum(qtystok_out) as qtystok_out, barang_satuan";
   if (!empty($model2->instalasi_id)){
	//$criteria->addCondition(" instalasi_id = ".$model2->instalasi_id." ");
  }
  
  
  
  if (!empty($model2->ruangan_id)){
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
  
  if (!empty($model2->instalasi_id)){
	//$provider->criteria->addCondition(" instalasi_id = ".$model2->instalasi_id." ");
  }
  
  if (!empty($model2->ruangan_id)){
	//$provider->criteria->addCondition(" ruangan_id = ".$model2->ruangan_id." ");
  }    
  //var_dump($pilihTgl);
	if ($pilihTgl == 'true'){
		//var_dump($pilihTgl);
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

<table class="<?php echo $itemCss ?>">
    <thead>
        <tr>
            <th>Tgl. Transaksi</th>
            <th>Jenis Transaksi</th>
            <th>No. Transaksi</th>
            <th>Stok Masuk</th>
            <th>Stok Keluar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($provider->data as $data): ?>
        <tr>
            <td><?php echo MyFormatter::formatDateTimeForUser($data->tgltransaksi); ?></td>
            <td><?php echo $data->keteranganTransaksi; ?></td>
            <td><?php echo $data->noTransaksi; ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($data->qtystok_in)." ".$data->barang_satuan; ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($data->qtystok_out)." ".$data->barang_satuan; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: right;">Jumlah Stok</td>
            <td style="text-align: right;"><?php echo $stok_in." ".$satuan; ?></td>
            <td style="text-align: right;"><?php echo $stok_out." ".$satuan; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Stok Akhir</td>
            <td colspan="2" style="text-align: right;"><?php echo ($stok_in - $stok_out)." ".$satuan; ?></td>
        </tr>
    </tbody>
</table>

