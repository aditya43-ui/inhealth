<?php
/**
 * perbaikan format Laporan
 * BMB-295
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>10));  
?>
<div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 15%;float:right;margin-right:30px;margin-top:-40px;text-align:center;'>
                <span style='font-size:9pt;text-align:center;'><B>PURCHASE RECEIVED REPORT</B></span><br></div>
  
<div id="div_detail">
<?php
    $criteria2 = new CDbCriteria;
	if(!empty($idFaktur)){
		$criteria2->addCondition("t.fakturpembelian_id = ".$idFaktur);		
	}
    
    $model = GFFakturpembelianT::model()->findAll($criteria2);
    $supplier_temp = "";
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
                        <td>Receiving :</td>
                        <td>Date :</td>
                        <td>Purchase Order :</td>
                    </tr>
                    <tr>
                        <td>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 100%;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$noterima."</B></span><br>
                            </div>
                            
                            <br>
                        </td>
                        <td>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 100%;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$tglterima."</B></span><br>
                            </div>
                            <br>
                        </td>
                        <td>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 100%;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".(!empty($nopermintaan) ? $nopermintaan : "-")."</B></span><br>
                            </div>
                            <br>
                        </td>
                    </tr>
                    
                    <tr>                        
                        <td>Faktur / Surat :</td>
                        <td>Date : </td>
                        <td>Due Date :</td>
                    </tr>
                    <tr>
                        <td>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 100%;float:left;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$nofaktur."</B></span><br>
                            </div>
                        </td>
                        <td>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 100%;float:left;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$tglfaktur."</B></span><br>
                            </div>
                        </td>
                        <td>                                                        
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:5px; width: 100%;float:left;margin-left:3px;'>
                                <span style='font-size:9pt'><B>".$tgljatuhtempo."</B></span><br>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='3'>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan=3 style='font-size:9pt;'><b> Nama Supplier: $supplier </b></td>
                    </tr>
                    <tr>
                        <td colspan=3 style='font-size:9pt;'><b> Alamat Supplier: $alamat </b></td>
                    </tr>
                    <tr><td colspan='3'>";
                echo "<table width='100%' border='1'>
                            <tr style='font-weight:bold;border-bottom:1px solid #000;' bgcolor='#C0C0C0'>
                                <td align='center'>Kode</td>
                                <td align='center'>Nama</td>
                                <td align='center'>Satuan</td>
                                <td align='center'>Jumlah</td>
                                <td align='center'>Harga (Rp)</td>
                                <td align='center'>Bruto (Rp)</td>
                                <td align='center'>Keringanan %</td>
                                <td align='center'>Ppn %</td>
								<td align='center'>Pph %</td>
                                <td align='center'>Netto</td>
                                <td align='center'>Keterangan</td>
                            </tr>";
            
            $format = new MyFormatter();
            $criteria = new CDbCriteria;
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
                     sum(((fakturpembelian_t.totalpajakppn)/(penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima))*100) as ppn,
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
			
			if(!empty($_GET['GFFakturpembelianT']['supplier_id'])){
				if(!empty($idFaktur)){
					$criteria->addCondition("fakturpembelian_t.supplier_id = ".$_GET['GFFakturpembelianT']['supplier_id']);		
				}
			}
            if (isset($_GET['GFFakturpembelianT']['nofaktur']))
                $criteria->compare('LOWER(fakturpembelian_t.nofaktur)',strtolower($_GET['GFFakturpembelianT']['nofaktur']),true);
			if(!empty($idFaktur)){
				$criteria->addCondition("fakturpembelian_t.fakturpembelian_id = ".$idFaktur);		
			}
//            $criteria->addBetweenCondition('fakturpembelian_t.tglfaktur',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('fakturpembelian_t.create_ruangan',Yii::app()->user->ruangan_id);
            
            $totHarga = 0;
            $totBruto = 0;
            $totDiscount = 0;
            $totPpn = 0;
			$totPph = 0;
            $totNetto = 0;
            $totBayar = 0;
            $totSisa = 0;
			
			
			$criteria3 = new CDbCriteria;
			if(!empty($idFaktur)){
				$criteria3->addCondition("fakturpembelian_id = ".$idFaktur);		
			}
            $detail = FakturdetailT::model()->findAll($criteria3);
			
            foreach($detail as $key=>$details){
                    $harga = $details->hargasatuan;
                    //$bruto = $details->total_bruto;
					$bruto = $details->jmlterima * $harga;
                    $discount = $details->persendiscount;
                    $ppn = $details->persenppnfaktur;
					$pph = $details->persenpphfaktur;
					$materai = $details->fakturpembelian->biayamaterai;
                    //$netto = $details->total_netto;
					$netto = $bruto + ($bruto * ($ppn/100)) + ($bruto * ($pph/100)) - $details->jmldiscount;
                    //$bayar = $details->total_bayar;					
					$bayar = !empty($details->fakturpembelian->bayarkesupplier->tandabuktikeluar_id)?$details->fakturpembelian->bayarkesupplier->tandabuktikeluar->jmlkaskeluar:0;
                    //$sisa = $details->total_sisa;
					
                    
                    
                    $totHarga += $harga;
                    $totBruto += $bruto;
                    //$totDiscount += $details->total_discount;
					$totDiscount += $details->jmldiscount;
                    $totPpn += ($bruto * ($ppn/100));
					$totPph += ($bruto * ($pph/100));
                    $totNetto += $netto;
                    $totBayar = $bayar;
                    $totSisa = ($totNetto+$materai) - $totBayar;
                    echo "<tr>
                              <td width='150px;'>".$details->obatalkes->obatalkes_kode."</td>
                              <td width='280px;'>".$details->obatalkes->obatalkes_nama."</td>
                              <td width='220px;'>".$details->obatalkes->satuanbesar->satuanbesar_nama."</td>
                              <td width='70px;' style='text-align:center'>".$details->jmlterima."</td>
                              <td width='70px;' style='text-align:right'>".number_format($harga,0,"",".")."</td>
                              <td width='70px;' style='text-align:right'>".number_format($bruto,0,"",".")."</td>
                              <td width='70px;' style='text-align:right'>".number_format($discount,0,"",".")."</td>
                              <td width='70px;' style='text-align:right'>".number_format($ppn,0,"",".")."</td>
							  <td width='70px;' style='text-align:right'>".number_format($pph,0,"",".")."</td>
                              <td width='70px;' style='text-align:right'>".number_format($netto,0,"",".")."</td>
                              <td width='70px;' style='text-align:right'>-</td>
                          </tr>";
            }
            
                    echo "<tfoot style='background-color:#ffffff;'>
                            <div>
                                <table align=right>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Total : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totBruto,0,"",".")."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Keringanan : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totDiscount,0,"",".")."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Ppn : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totPpn,0,"",".")."</td>
                                    </tr>
									<tr>
                                        <td colspan=7 style='text-align:right'>Pph : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totPph,0,"",".")."</td>
                                    </tr>
									<tr>
                                        <td colspan=7 style='text-align:right'>Meterai : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($materai,0,"",".")."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Total Transaksi : </td>
                                        <td width='150px;' style='text-align:right'>".number_format(($totNetto+$materai),0,"",".")."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Bayar : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totBayar,0,"",".")."</td>
                                    </tr>
                                    <tr>
                                        <td colspan=7 style='text-align:right'>Sisa : </td>
                                        <td width='150px;' style='text-align:right'>".number_format($totSisa,0,"",".")."</td>
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
?>
</div>    