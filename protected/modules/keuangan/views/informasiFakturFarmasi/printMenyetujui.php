<style>
    .border{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<center>
<?php //  echo $this->renderPartial('_headerPrint');  ?>
    <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>'RINCIAN FAKTUR PEMBELIAN OBAT DAN ALKES'));  ?>
</center>
<table class = "table" style = "box-shadow:none;">
   <tr>
        <td width="50%">
            <table  class = "table" style = "box-shadow:none;">
                <tr>
                    <td width="200px">No Permintaan</td>
                    <td> : <?php echo $modFakturPembelian->penerimaanbarang->permintaanpembelian->nopermintaan; ?></td>
                </tr>
                 <tr>
                    <td>No Penerimaan</td>
                    <td> : <?php echo $modFakturPembelian->penerimaanbarang->noterima; ?></td>
                </tr>
                <tr>
                    <td>Tgl. Penerimaan</td>
                    <td> : <?php echo MyFormatter::formatDateTimeForUser($modFakturPembelian->penerimaanbarang->tglterima); ?></td>
                </tr>
                <tr>
                    <td>No Faktur</td>
                    <td> : <?php echo $modFakturPembelian->nofaktur; ?></td>
                </tr>
                <tr>
                    <td>Tgl. Faktur</td>
                    <td> : <?php echo MyFormatter::formatDateTimeForUser($modFakturPembelian->tglfaktur); ?></td>
                </tr>
                <tr>
                    <td>Tgl. Jatuh Tempo</td>
                    <td> : <?php echo (!empty($modFakturPembelian->tgljatuhtempo)? MyFormatter::formatDateTimeForUser($modFakturPembelian->tgljatuhtempo): "-"); ?></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td> : <?php echo $modFakturPembelian->keteranganfaktur; ?></td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table  class = "table" style = "box-shadow:none;">
                <tr>
                    <td width="200px">Total Harga</td>
                    <td> : Rp. <?php echo (!empty($modFakturPembelian->totharganetto)? MyFormatter::formatNumberForPrint($modFakturPembelian->totharganetto, 2): "-"); ?></td>
                </tr>
                 <tr>
                    <td>Total Keringanan</td>
                    <td> : Rp. <?php echo (!empty($modFakturPembelian->jmldiscount)? MyFormatter::formatNumberForPrint($modFakturPembelian->jmldiscount, 2): "-"); ?></td>
                </tr>
                <tr>
                    <td>Total PPN</td>
                    <td> : Rp. <?php echo (!empty($modFakturPembelian->totalpajakppn)? MyFormatter::formatNumberForPrint($modFakturPembelian->totalpajakppn, 2): "-"); ?></td>
                </tr>
                <tr>
                    <td>Total PPh</td>
                    <td> : Rp. <?php echo (!empty($modFakturPembelian->totalpajakpph)? MyFormatter::formatNumberForPrint($modFakturPembelian->totalpajakpph, 2): "-"); ?></td>
                </tr>
                <tr>
                    <td>Total Keseluruhan</td>
                    <td> : Rp. <?php echo (!empty($modFakturPembelian->totalhargabruto)? MyFormatter::formatNumberForPrint($modFakturPembelian->totalhargabruto, 2): "-"); ?></td>
                </tr>
                <tr>
                    <td>Jumlah Uang Muka</td>
                    <td> : Rp. <?php echo (!empty($modFakturPembelian->jmluangmukabeli)? MyFormatter::formatNumberForPrint($modFakturPembelian->jmluangmukabeli, 2): "-"); ?></td>
                </tr>
                <tr>
                    <td>Total Harga Netto</td>
                    <td> : Rp. <?php echo (!empty($modFakturPembelian->totalhutangusaha)? MyFormatter::formatNumberForPrint($modFakturPembelian->totalhutangusaha, 2): "-"); ?></td>
                </tr>
            </table>
        </td>
        </tr>
</table>
<hr/>
<table id="tableObatAlkes" class = "table" style = "box-shadow:none;">
    <thead class="border">
            <th class="border" style="text-align: center;">No.</th>
            <th class="border" style="text-align: center;">Kode</th>
            <th class="border" style="text-align: center;">Nama Obat & Alkes</th>            
            <th class="border" style="text-align: center;">Jumlah Terima</th>
            <th class="border" style="text-align: center;">Harga Satuan (Rp)</th>
            <th class="border" style="text-align: center;">Keringanan</th>
            <th class="border" style="text-align: center;">Keringanan (Rp.)</th>            
            <th class="border" style="text-align: center;">PPN (%)</th>
            <th class="border" style="text-align: center;">PPN (Rp.)</th>
            <th class="border" style="text-align: center;">PPh (%)</th>
            <th class="border" style="text-align: center;">PPh (Rp)</th>
            <th class="border" style="text-align: center;">HPP</th>
            <th class="border" style="text-align: center;">Sub Total</th>
        </thead>
		<tbody>
        <?php 
        $total = 0;
        $subtotal = 0;
		$grandTotal = 0;
        $diskon = 0;
        foreach ($modFakturPembelianDetails as $i=>$modObat){ 
            if (!empty($modObat->satuanbesar_id)) {
                if($modObat->kemasanbesar>0){
                    $kemasanJml = ($modObat->jmlterima * $modObat->kemasanbesar);
                }
            }else{
                $kemasanJml = $modObat->jmlterima;
            } 
                
            $jmlQty = ($modObat->harganettofaktur * $kemasanJml);
            $jmlDiskon = round((($jmlQty * $modObat->persendiscount)/100),2);
            $jmlPpn = round(((($jmlQty - $jmlDiskon) * $modObat->persenppnfaktur)/100),2);
            $jmlPph = round(((($jmlQty - $jmlDiskon) * $modObat->persenpphfaktur)/100),2);
            $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph),2);
             $totalTanpaPPn = round(($jmlQty - $jmlDiskon - $jmlPph),2);
             
            $grandTotal +=$totalTanpaPPn
            
        ?>
            <tr class="border" >
                <td class="border" ><?php echo ($i+1)."."; ?></td>
                <td class="border" ><?php echo $modObat->obatalkes->obatalkes_kode; ?></td>
                <td class="border" ><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td class="border"  style="text-align:right;"><?php echo number_format($modObat->jmlterima,2,",",".").' '.(!empty($modObat->satuanbesar_id)?$modObat->obatalkes->satuanbesar->satuanbesar_nama:$modObat->obatalkes->satuankecil->satuankecil_nama); ?></td>                
                <td class="border"  style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($modObat->harganettofaktur,2,",","."):"hidden"; 
                ?></td>
                <td class="border" style="text-align:right;"><?php echo number_format($modObat->persendiscount,2,",","."); ?></td>
                <td class="border" style="text-align:right;"><?php echo number_format($jmlDiskon,2,",","."); ?></td>
                <td class="border" style="text-align:right;"><?php echo $modObat->persenppnfaktur; ?></td>
                <td class="border" style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($jmlPpn,2,",","."):"hidden"; 
                ?></td>
                <td class="border" style="text-align:right;"><?php echo number_format($modObat->persenpphfaktur,2,",","."); ?></td>
                <td class="border" style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($jmlPph,2,",","."):"hidden"; 
                ?></td>
                <td class="border"  style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($totalAll,2,",","."):"hidden"; 
					?>
                </td>
                <td class="border" style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($totalAll,2,",","."):"hidden"; 
					?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr class="border">
                    <td colspan="12" align="right"><strong>Total</strong></td>
                    <td style="text-align:right;"><strong><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?$format->formatNumberForPrint($subtotal, 2):"Hidden"; ?></strong></td>
            </tr>
        </tfoot>
</table>
<br>
<table width="100%">
    <tr> 
		<td>&nbsp;</td>
        <td align="center" width="30%"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".date('d M Y'); ?></td>
    </tr>
</table>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
                <table width="100%">
                        <tr>
                                <td width="35%" align="center">	
                                    <div>Penerima Faktur</div>
                                    <div style="margin-top:60px;">
                                        .........................
                                    </div>
                                </td>
                                <td width="30%" align="center">
                                    <div>Petugas Keuangan</div>
                                    <div style="margin-top:60px;">
                                        <?php echo Yii::app()->user->getState('nama_pegawai'); ?>
                                    </div>
                                </td>
                                <td width="35%" align="center">
                                        <div>Yang Mengetahui</div>
                                        <div style="margin-top:60px;"><?php
                                        $modAppr = ApprovalotorisasiM::model()->find();
                                        $pegawainame = "";
                                        $peg = PegawaiM::model()->findByPk($modFakturPembelian->pegawaimenyetujuikeuangan_id);

                                        if(isset($peg)){
                                            $pegawainame = $peg->namaLengkap;
                                        }
                                        if(isset($modAppr)){
                                            $sumber = "";
                                            $penerimaan = PenerimaanbarangT::model()->findByPk($modFakturPembelian->penerimaanbarang_id);
                                            if(isset($penerimaan)){
                                                $permintaan = PermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id'=>$penerimaan->permintaanpembelian_id));

                                                if(isset($permintaan)){
                                                    $sumber = $permintaan->sumberdana_id;
                                                }
                                            }

                                            if($sumber == Params::SUMBERDANA_ID_PT){
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
<br /><br />
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
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter" ><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>
     <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter" >Print Date : <?php echo date('d M Y H:i:s'); ?></td></tr>
        
</table>
