<?php 
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>'RINCIAN FAKTUR PEMBELIAN', 'deskripsi'=>"", 'colspan'=>10));
$format = new MyFormatter;
?>
<br>
<style>
 
    body {
        color: black;
        font-size: 10px;
    }
    
    .tab_header, .tab_detail {
        width:100%;
    }
    
    .tab_detail th {
        text-align: center;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 2px;
    }
</style>

<table class='tab_header' style = "border: 0;">
    <tr>
        <td width="50%">
            <table class='tab_header' style = "border: 0;">
                <tr>
                    <td width="200px">No Permintaan</td>
                    <td>
                        : <?php echo $modTerima->pembelianbarang->nopembelian; ?>
                    </td>
                </tr>
                <tr>
                    <td>No Penerimaan</td>
                    <td>
                        : <?php echo $modTerima->nopenerimaan; ?>
                    </td>
                </tr>
                <tr>
                    <td>Tgl. Penerimaan</td>
                    <td>
                       : <?php echo MyFormatter::formatDateTimeForUser($modTerima->tglterima); ?>
                    </td>
                </tr>
                <tr>
                    <td>No Faktur</td>
                    <td>
                        : <?php echo $modTerima->nofaktur; ?>
                    </td>
                </tr>
                <tr>
                    <td>Tgl. Faktur</td>
                    <td>
                        : <?php echo MyFormatter::formatDateTimeForUser($modTerima->tglfaktur); ?>
                    </td>
                </tr>
                <tr>
                    <td>Tgl. Jatuh Tempo</td>
                    <td>
                        : <?php echo (!empty($modTerima->tgljatuhtempo)? MyFormatter::formatDateTimeForUser($modTerima->tgljatuhtempo): "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>
                         : <?php echo $modTerima->keteranganfaktur; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table class='tab_header' style = "border: 0;">
                <tr>
                    <td width="200px">Total Harga</td>
                    <td>
                        : Rp <?php echo (!empty($modTerima->totalharga)? MyFormatter::formatNumberForPrint($modTerima->totalharga,2): "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total Keringanan</td>
                    <td>
                        : Rp <?php echo (!empty($modTerima->discount)? MyFormatter::formatNumberForPrint($modTerima->discount,2): "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total PPN</td>
                    <td>
                       : Rp <?php echo (!empty($modTerima->pajakppn)? MyFormatter::formatNumberForPrint($modTerima->pajakppn,2): "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total PPh</td>
                    <td>
                        : Rp <?php echo (!empty($modTerima->pajakpph)? MyFormatter::formatNumberForPrint($modTerima->pajakpph,2): "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total Keseluruhan</td>
                    <td>
                        : Rp <?php echo (!empty($modTerima->totalkeseluruhan)? MyFormatter::formatNumberForPrint($modTerima->totalkeseluruhan,2): "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Uang Muka</td>
                    <td>
                        : Rp <?php echo (!empty($modTerima->jlmuangmukabeli)? MyFormatter::formatNumberForPrint($modTerima->jlmuangmukabeli,2): "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total Harga Netto</td>
                    <td>
                         : Rp <?php echo (!empty($modTerima->totalhutangusaha)? MyFormatter::formatNumberForPrint($modTerima->totalhutangusaha,2): "-"); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table id="tableObatAlkes" class="tab_detail">
    <thead>
        <th>No.</th>
        <th>Tipe Barang</th>
        <th>Jenis Barang</th>
        <th>Kode Barang/<br>Nama Barang</th>
        <th>Jumlah Terima</th>
        <th>Satuan</th>
        <th>Jumlah Dalam <br>Kemasan </th>
        <th>Harga Satuan (Rp)</th>
        <th>Keringanan (%)</th>
        <th>Keringanan (Rp)</th>
        <th>PPN (%)</th>
        <th>PPN (Rp)</th>
        <th>PPh (%)</th>
        <th>PPh (Rp)</th>
        <th>Subtotal (Rp)</th>
        <th>Kondisi</th>
    </thead>
    <tbody>
    <?php
    $total = 0;     
    $no=1;
   
        foreach($modDetailTerima AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); 
            $jmlQty = ($detail->hargasatuan * $detail->jmlterima);
            $jmlDiskon = round((($jmlQty * $detail->persendiscount)/100),2);
            $jmlPpn = round(((($jmlQty - $jmlDiskon) * $detail->persenppn)/100),2);
            $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph)/100),2);
            $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph),2);
            $totalTanpaPPn = round(($jmlQty - $jmlDiskon - $jmlPph),2);
            $total += $totalTanpaPPn;
        ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $modBarang->barang_type; ?></td>
                <td><?php echo $modBarang->jenisbarangs->jenisbarang_nama; ?></td>
                <td><?php echo $modBarang->barang_kode."/<br>".$modBarang->barang_nama; ?></td>
                <td><?php echo number_format($detail->jmlterima,2,",","."); ?></td>
                <td><?php echo $detail->satuanbeli; ?></td>
                <td><?php echo $detail->jmldalamkemasan; ?></td>
                <td style = "text-align:right;"><?php echo number_format($detail->hargasatuan,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo number_format($detail->persendiscount,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo number_format($jmlDiskon,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo number_format($detail->persenppn,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo number_format($jmlPpn,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo number_format($detail->persenpph,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo number_format($jmlPph,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo number_format($detail->hargabeli,2,",","."); ?></td>
                <td><?php echo $detail->kondisibarang; ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
    ?>
            <tr>
                <td colspan = "14" style = "text-align:right;border-top: 1px solid #000;"><b>Total</b></td>
                <td style = "border-top: 1px solid #000;text-align:right;"><b><?php echo number_format($total,2,",","."); ?></b></td>
                <td></td>
            </tr>
    </tbody>
</table>
<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table style="width: 100%; border: none;">
				<tr>
					<td width="35%" align="center">						
					</td>
					<td width="30%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Yang Mengetahui</div>
						<div style="margin-top:60px;"><?php
                                                $modAppr = ApprovalotorisasiM::model()->find();
                                                $pegawainame = "";
                                                $peg = PegawaiM::model()->findByPk($modTerima->pegawaimenyetujuikeuangan_id);
                                                                             
                                                if(isset($peg)){
                                                    $pegawainame = $peg->namaLengkap;
                                                }
                                                if(isset($modAppr)){
                                                    if($modTerima->sumberdana_id == Params::SUMBERDANA_ID_PT){
                                                        if(!empty($modAppr->managerkeuanganpt_id)){
                                                           $pegawainame = $modAppr->managerkeuanganpt->namaLengkap; 
                                                        }
                                                    }else{
                                                       if(!empty($modAppr->managerkeuangan_id)){
                                                           $pegawainame = $modAppr->managerkeuangan->namaLengkap; 
                                                        } 
                                                    }
                                                } 
                                                
                                                echo $pegawainame; ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
 <?php 
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $alamat=!empty($profil->alamatlokasi_rumahsakit)?$profil->alamatlokasi_rumahsakit:"";
	$motto=!empty($profil->motto)?$profil->motto:"";
        $telp=!empty($profil->no_telp_profilrs)?$profil->no_telp_profilrs:"";
        $email=!empty($profil->email)?$profil->email:"";
        $website=!empty($profil->website)?$profil->website:"";
        $layoutkiri=$alamat."<br>"."Telp:".$telp." Email:".$email." Website:".$website;
?>
<table width="100%" class="footer">
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter"><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>
        
</table>
 