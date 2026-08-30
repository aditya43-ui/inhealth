<?php
/**
 * perbaikan format Laporan
 * BMB-295
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
?>
<div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 15%;float:right;margin-right:30px;margin-top:-40px;text-align:center;'>
                <span style='font-size:9pt;text-align:center;'><B>PURCHASE RECEIVED REPORT</B></span><br></div>
          
<?php if($_GET['filter_tab'] == "rekap"){ ?>  
<div id="div_rekap">                
    <?php
        $criteria2 = new CDbCriteria();
        $format2 = new MyFormatter();

        $criteria2->select ='t.*';
        if(isset($_GET['GFFakturpembelianT']['tgl_awal'])){
            $tgl_awal = $format2->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_awal']);
        }
        if(isset($_GET['GFFakturpembelianT']['tgl_akhir'])){
            $tgl_akhir = $format2->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_akhir']);
        }

        $criteria2->addBetweenCondition('t.tglfaktur',$tgl_awal,$tgl_akhir);
        $model = GFFakturpembelianT::model()->findAll($criteria2);
        $supplier_temp = "";
        if(count((array)$model) > 0){
        foreach($model as $key=>$models){
                 
             if($models->supplier_id){
                    $supplier = $models->supplier->supplier_nama;
                    $supplier_alamat = $models->supplier->supplier_alamat;
                } else{
                    $supplier = '';
                }           
                if($supplier_temp != $supplier)
                {
                echo "                
                    <table width='100%' border='0' style='font-size:small;border-top:1px solid black;border-bottom:1px solid black'>
                        <tr>
                            <td> Nama Supplier </td>
                            <td> : </td>
                            <td> $supplier</td>
                            <td> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> Alamat Supplier </td>
                            <td> : </td>
                            <td> $supplier_alamat </td>
                            <td>  </td>
                            <td>  </td>
                        </tr>
                        </table></br>";
                    echo "<table width='100%' border='1'>
                                <tr style='font-weight:bold;'>
                                    <td align='center'>No. Receiving</td>
                                    <td align='center'>Tanggal</td>
                                    <td align='center'>No. Purchase Order</td>
                                    <td align='center'>No. Faktur</td>
                                    <td align='center'>Tanggal</td>
                                    <td align='center'>Jatuh Tempo</td>
                                    <td align='center'>Bruto</td>
                                    <td align='center'>Keringanan (Rp)</td>
                                    <td align='center'>PPN (Rp)</td>
                                    <td align='center'>Meterai</td>
                                    <td align='center'>Netto</td>
                                    <td align='center'>Bayar</td>
                                    <td align='center'>Sisa</td>
                                </tr>";

                $format = new MyFormatter();
                $criteria = new CDbCriteria;
                 if(isset($_GET['GFFakturpembelianT']['tgl_awal'])){
                    $tgl_awal = $format2->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_awal']);
                }
                if(isset($_GET['GFFakturpembelianT']['tgl_akhir'])){
                    $tgl_akhir = $format2->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_akhir']);
                }
                $term = $supplier;
                $condition  = "supplier_m.supplier_nama ILIKE '%".$term."%' OR supplier_m.supplier_nama ILIKE '%".$term."%'";
                        $criteria->select = 't.nofaktur,t.tglfaktur, t.tgljatuhtempo, t.keteranganfaktur, t.bayarkesupplier_id,t.fakturpembelian_id,
                                         t.create_ruangan,supplier_m.supplier_id,supplier_m.supplier_nama,supplier_m.supplier_alamat,
                                         penerimaanbarang_t.noterima,penerimaanbarang_t.tglterima,permintaanpembelian_t.nopermintaan,
                                         sum(penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima) as total_bruto,
                                         sum(bayarkesupplier_t.totaltagihan) as total_tagihan,
                                         sum(bayarkesupplier_t.jmldibayarkan) as total_bayar,
                                         sum(fakturdetail_t.jmldiscount) as total_discount,
                                         sum(fakturdetail_t.persendiscount) as discountpersen,
                                         sum(t.totalpajakppn) as total_ppn,
                                         sum(t.biayamaterai) as materai,
                                         sum(((penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima)-fakturdetail_t.jmldiscount)+t.totalpajakppn) as total_netto,
                                         (case when (t.bayarkesupplier_id is not null) then sum(bayarkesupplier_t.totaltagihan - bayarkesupplier_t.jmldibayarkan) else sum((((penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima)-fakturdetail_t.jmldiscount)+t.totalpajakppn)-0) end) as total_sisa,
                                         (case when (t.bayarkesupplier_id is not null) then sum(bayarkesupplier_t.totaltagihan) else sum(t.totalhargabruto) end) as total_tagihan
                                        ';
                    $criteria->join = 'LEFT JOIN bayarkesupplier_t ON t.fakturpembelian_id=bayarkesupplier_t.fakturpembelian_id 
                                       LEFT JOIN supplier_m ON supplier_m.supplier_id=t.supplier_id
                                       LEFT JOIN fakturdetail_t ON t.fakturpembelian_id = fakturdetail_t.fakturpembelian_id
                                       LEFT JOIN penerimaanbarang_t ON t.fakturpembelian_id = penerimaanbarang_t.fakturpembelian_id
                                       LEFT JOIN penerimaandetail_t ON penerimaanbarang_t.penerimaanbarang_id = penerimaandetail_t.penerimaanbarang_id
                                       LEFT JOIN permintaanpembelian_t ON penerimaanbarang_t.permintaanpembelian_id = permintaanpembelian_t.permintaanpembelian_id';
                    $criteria->group = 't.nofaktur,t.tglfaktur,t.tgljatuhtempo,t.keteranganfaktur,t.create_ruangan,t.fakturpembelian_id,
                                        supplier_m.supplier_id,supplier_m.supplier_nama,supplier_alamat,t.bayarkesupplier_id,t.fakturpembelian_id,
                                        penerimaanbarang_t.noterima,penerimaanbarang_t.tglterima,permintaanpembelian_t.nopermintaan';
					if(isset($_GET['GFFakturpembelianT']['supplier_id'])){
						if(!empty($idFaktur)){
							$criteria->addCondition("t.supplier_id = ".$_GET['GFFakturpembelianT']['supplier_id']);		
						}
					}
                    $nofaktur = isset($_GET['GFFakturpembelianT']['nofaktur']) ? $_GET['GFFakturpembelianT']['nofaktur'] : "";
                    $criteria->compare('LOWER(t.nofaktur)',strtolower($nofaktur),true);
                    $criteria->addBetweenCondition('t.tglfaktur',$tgl_awal,$tgl_akhir);
//                    $criteria->compare('t.create_ruangan',Yii::app()->user->ruangan_id);
                    $criteria->addCondition($condition);

                $totBruto = 0;
                $totDiscount = 0;
                $totPpn = 0;
                $totMaterai = 0;
                $totNetto = 0;
                $totBayar = 0;
                $totSisa = 0;
                $detail = GFFakturpembelianT::model()->findAll($criteria);
                foreach($detail as $key=>$details){
                        $bruto = $details->total_bruto;
                        $discount = $details->total_discount;
                        $ppn = $details->total_ppn;
                        $materai = $details->materai;
                        $netto = $details->total_netto;
                        $bayar = $details->total_bayar;
                        $sisa = $details->total_sisa;

                        $totBruto += $bruto;
                        $totDiscount += $discount;
                        $totPpn += $ppn;
                        $totMaterai += $materai;
                        $totNetto += $netto;
                        $totBayar += $bayar;
                        $totSisa += $sisa;

                        echo "<tr>
                                  <td width='150px;'>".$details->noterima."</td>
                                  <td width='280px;'>".date("d/m/Y H:i:s", strtotime($details->tglterima))."</td>
                                  <td width='280px;' style=text-align:center;>".(!empty($details->nopermintaan) ? $details->nopermintaan : "-")."</td>
                                  <td width='280px;'>".$details->nofaktur."</td>
                                  <td width='280px;'>".date("d/m/Y H:i:s", strtotime($details->tglfaktur))."</td>
                                  <td width='280px;'>".date("d/m/Y H:i:s", strtotime($details->tgljatuhtempo))."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($bruto)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($discount)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($ppn)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($materai)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($netto)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($bayar)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($sisa)."</td>
                              </tr>";
                }
                        echo "<tr style='background-color:#ffffff;'>
                                  <td colspan=6 style='text-align:right;font-weight:bold;'>Total Supplier : $supplier </td>
                                  <td width='70px;' style='text-align:right'>".number_format($totBruto)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($totDiscount)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($totPpn)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($totMaterai)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($totNetto)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($totBayar)."</td>
                                  <td width='70px;' style='text-align:right'>".number_format($totSisa)."</td>
                              </tr>";
                         echo "</table><br>";
                }

                $supplier_temp = $supplier;
             
        }
    }else{
             echo "<table class='table table-striped table-bordered table-condensed' >
                        <tr>
                            <td style='font-size:large;color:red;'> Data tidak berhasil ditemukan . Silakan ulangi pencarian</td>
                        </tr></table>";
         }
    ?>
</div>
<?php }else{ ?>
<div id="div_detail">
<?php
    $criteria2 = new CDbCriteria();
    $format2 = new MyFormatter();

    $criteria2->select ='t.*';
    if(isset($_GET['GFFakturpembelianT']['tgl_awal'])){
        $tgl_awal = $format2->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_awal']);
    }
    if(isset($_GET['GFFakturpembelianT']['tgl_akhir'])){
        $tgl_akhir = $format2->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_akhir']);
    }
//        echo $tgl_awal; echo $tgl_akhir;exit;
    $criteria2->addBetweenCondition('t.tglfaktur',$tgl_awal,$tgl_akhir);
    $nofaktur = isset($_GET['GFFakturpembelianT']['nofaktur']) ? $_GET['GFFakturpembelianT']['nofaktur'] : "";
    $criteria2->compare('LOWER(t.nofaktur)',strtolower($nofaktur),true);
	if(isset($_GET['GFFakturpembelianT']['supplier_id'])){
		if(!empty($idFaktur)){
			$criteria->addCondition("t.supplier_id = ".$_GET['GFFakturpembelianT']['supplier_id']);		
		}
	}
    $model = GFFakturpembelianT::model()->findAll($criteria2);
    $supplier_temp = "";
    if(count((array)$model) > 0){
    foreach($model as $key=>$models){
         if($models->supplier_id){
                $supplier = $models->supplier->supplier_nama;
                $alamat = $models->supplier->supplier_alamat;
                $nopermintaan = (isset($models->penerimaanbarang)?(isset($models->penerimaanbarang->permintaanpembelian)?$models->penerimaanbarang->permintaanpembelian->nopermintaan:""):"");
                $nofaktur = $models->nofaktur;
                $tglfaktur = $models->tglfaktur;
                $tgljatuhtempo = $models->tgljatuhtempo;
                $noterima = (isset($models->penerimaanbarang)?$models->penerimaanbarang->noterima:"");
                $tglterima = (isset($models->penerimaanbarang)?$models->penerimaanbarang->tglterima:"");
            } else{
                $supplier = '';
            }           
            if($supplier_temp != $supplier)
            {
            echo "                
                <table width='100%' border='0' style='font-size:small;'>
                    <tr>
                        <td>&nbsp;Receiving : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Order : </td>
                    </tr>
                    <tr>
                        <td>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 12%;float:left;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$noterima."</B></span><br>
                            </div>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 12%;float:left;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$tglterima."</B></span><br>
                            </div>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 12%;float:left;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".(!empty($nopermintaan) ? $nopermintaan : "-")."</B></span><br>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Faktur / Surat : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Due Date: </td>
                    </tr>
                    <tr>
                        <td>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 12%;float:left;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$nofaktur."</B></span><br>
                            </div>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 12%;float:left;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$tglfaktur."</B></span><br>
                            </div>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 12%;float:left;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$tgljatuhtempo."</B></span><br>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=7 style='font-size:9pt;'><b> Nama Supplier: $supplier </b></td>
                    </tr>
                    <tr>
                        <td colspan=7 style='font-size:9pt;'><b> Alamat Supplier: $alamat </b></td>
                    </tr>
                    <tr><td>";
                echo "<table width='100%' border='1'>
                            <tr style='font-weight:bold;background-color:#C0C0C0'>
                                <td align='center'>Kode</td>
                                <td align='center'>Nama</td>
                                <td align='center'>Satuan</td>
                                <td align='center'>Jumlah</td>
                                <td align='center'>Harga</td>
                                <td align='center'>Bruto</td>
                                <td align='center'>Keringanan %</td>
                                <td align='center'>Ppn %</td>
                                <td align='center'>Netto %</td>
                                <td align='center'>Keterangan</td>
                            </tr>";
            
            $format = new MyFormatter();
            $criteria = new CDbCriteria;
            if(isset($_GET['GFFakturpembelianT']['tgl_awal'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_awal']);
            }
            if(isset($_GET['GFFakturpembelianT']['tgl_akhir'])){
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_akhir']);
            }
            $term = $supplier;
            $condition  = "supplier_m.supplier_nama ILIKE '%".$term."%' OR supplier_nama ILIKE '%".$term."%'";
            $criteria->select = 'fakturpembelian_t.nofaktur,fakturpembelian_t.tglfaktur, fakturpembelian_t.tgljatuhtempo, 
                     fakturpembelian_t.keteranganfaktur, fakturpembelian_t.bayarkesupplier_id,fakturpembelian_t.fakturpembelian_id,
                     fakturpembelian_t.create_ruangan,supplier_m.supplier_id,supplier_m.supplier_nama,supplier_m.supplier_alamat,
                     sum(penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima) as total_bruto,
                     obatalkes_m.obatalkes_nama,satuanbesar_m.satuanbesar_nama,
                     obatalkes_m.obatalkes_kode,
                     sum(t.jmlterima) as jmlterima,
                     sum(penerimaandetail_t.harganettoper) as hargasatuan,
                     sum(bayarkesupplier_t.totaltagihan) as total_tagihan,
                     sum(bayarkesupplier_t.jmldibayarkan) as total_bayar,
                     sum(t.jmldiscount) as total_discount,
                     sum(fakturpembelian_t.totalpajakppn) as total_ppn,
                     sum(t.persendiscount) as persendiscount,
                     sum(fakturpembelian_t.totalpajakppn) as totalpajakppn,
                     sum(penerimaandetail_t.harganettoper) as harganettoper,
                     sum(penerimaandetail_t.jmlterima) as jmlterima,
                     sum(fakturpembelian_t.biayamaterai) as materai,
                     sum(((penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima)-t.jmldiscount)+fakturpembelian_t.totalpajakppn) as total_netto,
                     (case when (fakturpembelian_t.bayarkesupplier_id is not null) then sum(bayarkesupplier_t.totaltagihan - bayarkesupplier_t.jmldibayarkan) else sum((((penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima)-t.jmldiscount)+fakturpembelian_t.totalpajakppn)-0) end) as total_sisa,
                     (case when (fakturpembelian_t.bayarkesupplier_id is not null) then sum(bayarkesupplier_t.totaltagihan) else sum(fakturpembelian_t.totalhargabruto) end) as total_tagihan
                    ';
            $criteria->join = 'LEFT JOIN fakturpembelian_t ON t.fakturpembelian_id = fakturpembelian_t.fakturpembelian_id
                   LEFT JOIN bayarkesupplier_t ON fakturpembelian_t.fakturpembelian_id=bayarkesupplier_t.fakturpembelian_id 
                   LEFT JOIN supplier_m ON supplier_m.supplier_id=fakturpembelian_t.supplier_id
                   LEFT JOIN penerimaanbarang_t ON fakturpembelian_t.fakturpembelian_id = penerimaanbarang_t.fakturpembelian_id
                   LEFT JOIN penerimaandetail_t ON penerimaanbarang_t.penerimaanbarang_id = penerimaandetail_t.penerimaanbarang_id
                   LEFT JOIN obatalkes_m ON t.obatalkes_id = obatalkes_m.obatalkes_id
                   LEFT JOIN sumberdana_m ON obatalkes_m.sumberdana_id = sumberdana_m.sumberdana_id
                   LEFT JOIN satuanbesar_m ON obatalkes_m.satuanbesar_id = satuanbesar_m.satuanbesar_id
                  ';
            $criteria->group = 'fakturpembelian_t.nofaktur,fakturpembelian_t.tglfaktur,fakturpembelian_t.tgljatuhtempo,fakturpembelian_t.keteranganfaktur,
                    fakturpembelian_t.create_ruangan,fakturpembelian_t.fakturpembelian_id,
                    supplier_m.supplier_id,supplier_m.supplier_nama,supplier_alamat,fakturpembelian_t.bayarkesupplier_id,fakturpembelian_t.fakturpembelian_id,
                    obatalkes_m.obatalkes_nama,obatalkes_m.obatalkes_kode,satuanbesar_m.satuanbesar_nama';
            $supplier_id = isset($_GET['GFFakturpembelianT']['supplier_id']) ? $_GET['GFFakturpembelianT']['supplier_id'] : null;
			if(!empty($supplier_id)){
				$criteria->addCondition('fakturpembelian_t.supplier_id = '.$supplier_id);
			}
            $nofaktur = isset($_GET['GFFakturpembelianT']['nofaktur']) ? $_GET['GFFakturpembelianT']['nofaktur'] : "";
            $criteria->compare('LOWER(fakturpembelian_t.nofaktur)',strtolower($nofaktur),true);
            $criteria->addBetweenCondition('fakturpembelian_t.tglfaktur',$tgl_awal,$tgl_akhir);
//            $criteria->compare('fakturpembelian_t.create_ruangan',Yii::app()->user->ruangan_id);
            
            $totHarga = 0;
            $totBruto = 0;
            $totDiscount = 0;
            $totPpn = 0;
            $totNetto = 0;
            $totBayar = 0;
            $totSisa = 0;
            $detail = FakturdetailT::model()->findAll($criteria);
            foreach($detail as $key=>$details){
                    $harga = $details->hargasatuan;
                    $bruto = $details->total_bruto;
                    $discount = $details->persendiscount;
                    
//                     sum(((fakturpembelian_t.totalpajakppn)/(penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima))*100) as ppn,
                    $totalpajakppn = $details->totalpajakppn;
                    if($totalpajakppn > 0 && $details->harganettofaktur > 0 ){
                        $ppn = (($totalpajakppn) / ($details->harganettofaktur * $details->jmlterima)) * (100);
                    }
                    $ppn = (($details->harganettofaktur * $details->jmlterima)) * (100);
                    if($ppn < 0){
                        $ppn = 0;
                    }
                    $netto = $details->total_netto;
                    $bayar = $details->total_bayar;
                    $sisa = $details->total_sisa;
                    
                    
                    $totHarga += $harga;
                    $totBruto += $bruto;
                    $totDiscount += $details->total_discount;
                    $totPpn += $details->total_ppn;
                    $totNetto += $netto;
                    $totBayar += $bayar;
                    $totSisa += $sisa;
                    echo "<tr>
                              <td width='150px;'>".$details->obatalkes_kode."</td>
                              <td width='280px;'>".$details->obatalkes_nama."</td>
                              <td width='220px;'>".$details->satuanbesar_nama."</td>
                              <td width='70px;' style='text-align:center'>".$details->jmlterima."</td>
                              <td width='70px;' style='text-align:right'>".number_format($harga)."</td>
                              <td width='70px;' style='text-align:right'>".number_format($bruto)."</td>
                              <td width='70px;' style='text-align:right'>".number_format($discount)."</td>
                              <td width='70px;' style='text-align:right'>".number_format($ppn)."</td>
                              <td width='70px;' style='text-align:right'>".number_format($netto)."</td>
                              <td width='70px;' style='text-align:right'>-</td>
                          </tr>";
            }
            
                    echo "<tfoot style='background-color:#ffffff;'>
                            <div>
                                <table align=right>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Total : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totBruto)."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Keringanan : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totDiscount)."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Ppn : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totPpn)."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Total Transaksi : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totNetto)."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Bayar : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totBayar)."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Sisa : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totSisa)."</td>
                                    </tr>
                                </table>
                            </div>
                            <div style='border:0px solid #cccccc;padding:10px; width: 10%;float:right;margin-top:5px;margin-right:60px;'>
                                    <span style='font-size:9pt'><B><p style='margin: 0; text-align: center;'>Purchasing<p style='margin: 0; text-align: center;'></B><br><br><br>
                                    <span style='font-size:9pt'><B><p style='margin: 0; text-align: center;'>MELI<p style='margin: 0; text-align: center;'></B><hr style='height:3px;background:#000000;margin-top:-2px;' />
</div>
                            </div>
                          </tfoot>";
                     echo "</table><br>";
            }
            
            $supplier_temp = $supplier;
    }
      echo "</td></tr></table>";
      }else{
             echo "<table class='table table-striped table-bordered table-condensed' >
                        <tr>
                            <td style='font-size:large;color:red;'> Data tidak berhasil ditemukan . Silakan ulangi pencarian</td>
                        </tr></table>";
         }
?>
</div>    
<?php } ?>    