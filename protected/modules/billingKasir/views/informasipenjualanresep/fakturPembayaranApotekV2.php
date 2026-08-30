<?php // $this->renderPartial('application.views.headerReport.headerDefault',array('colspan'=>10)); ?>
<!--<div style="height: 3cm;"></div>-->
<style>
    th, td, div{
        font-family: Arial;
        font-size: 9pt;
    }
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
        width: 50%;
    }
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
    }
    
    body{
        color:black;
    }

    .data tr td{
        text-align:right;
        padding-left:300px;
        font-size: 17px;
        font-family: "Arial Narrow";
    }
    .font th{
        font-size:15px;
    }
    .identitas{
        line-height: 12px;
        font-family: "Arial Narrow" !important;
    }
</style>
<?php
$format = new MyFormatter;
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find(); 

$admisi = null;
if (!empty($modPenjualan->pendaftaran_id)) {
    $admisi = PasienadmisiT::model()->findByAttributes(array(
        'pendaftaran_id'=>$modPenjualan->pendaftaran_id,
    ));
}
$str = $modPenjualan->NoFaktur;
$c = explode("-",$str); 
?>
<?php if(!empty($caraPrint)){
    ?>

<table width="100%">
    <thead class="data">
        <tr>
             <td>
                <?php echo $data->nama_rumahsakit;?>
                <!-- <div align="right" class="header">
                    
                    <?php
                    //echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div> -->
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $data->alamatlokasi_rumahsakit;?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo "Telp. 0".$data->no_telp_profilrs." (Hunting) Fax. 0".$data->no_telp_profilrs;?>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
    <?php
} ?>
<div class="judulcontent" style="text-align: center; font-weight: bold;">INVOICE</div>
                    <div style="text-align: center;font-weight: bold;"> <?php echo (empty($modPenjualan->NoFaktur)) ? "- Belum Lunas -" : $c[0]."-".$c[1]."SA".$c[2];?></div>
<!-- <table width="100%"><tr><td> -->
<table class="identitas" width="100%">
                        <tr>
                            <td>Atas Nama</td>
                            <td>: <?php
                                if(!empty($modPenjualan->pasienpegawai_id))
                                    echo $modPegawaiDokter->nomorindukpegawai." - ".$modPegawaiDokter->gelardepan." ".$modPegawaiDokter->nama_pegawai.", ".$modPegawaiDokter->gelarbelakang_nama;
                                else if (!empty($modPenjualan->pasieninstalasiunit_id))
                                    echo $modInstalasi->instalasi_nama;
                                else
                                    echo $pasien->nama_pasien;
                                ;?>
                            </td>
                            <td>No MR</td>
                            <td>: <?php echo $pasien->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:   <?php
                                    if(!empty($modPenjualan->pasienpegawai_id)){
                                        echo ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS())->nama_rumahsakit;
                                        if(!empty($modPegawaiDokter->alamat_pegawai))
                                            echo "/".$modPegawaiDokter->alamat_pegawai;
                                    }else if(!empty($modPenjualan->pasieninstalasiunit_id)){
                                        // if($modInstalasi->instalasi_lokasi == "GRT")
                                            echo ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS())->nama_rumahsakit;
                                        // else{
                                        //     echo "Holding PT. KAH";
                                        // }
                                    }
                                    else
                                        echo $pasien->alamat_pasien;
                                    ?>
                            </td>
                            <td>No Registrasi</td>
                            <td>: <?php echo $modPenjualan->noresep;?> </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Tanggal</td>
                            <td>: <?php echo date('d/m/Y H:i', strtotime($modPenjualan->tglresep)); ;?></td>
                        </tr>
                        <tr>
                            <td>Penanggung</td>
                            <td>:<?php echo $modPenanggungjawab == null ? '-':$modPenanggungjawab->nama_pj ; ?></td>
                            <td>No Polis</td>
                            <td>: <?php echo !empty($modAsuransi)?$modAsuransi->nokartuasuransi:'-'; ?></td>
                        </tr>
                        <tr>
                            <td>Penjamin</td>
                            <td>: <?php echo $penjamin == NULL ? '-':$penjamin->penjamin_nama;  ?></td>
                            <td>Asal Perusahaan</td>
                            <td>: <?php echo empty($modAsuransi) ? '-':  $modAsuransi->namaperusahaan; ?></td>
                        </tr>
                        
                    </table>
<table width="100%" hidden >
    
    <tr>
        <td width="10%">Nama </td>
        <td>:
            <?php
            if(!empty($modPenjualan->pasienpegawai_id))
                echo $modPegawaiDokter->nomorindukpegawai." - ".$modPegawaiDokter->gelardepan." ".$modPegawaiDokter->nama_pegawai.", ".$modPegawaiDokter->gelarbelakang_nama;
            else if (!empty($modPenjualan->pasieninstalasiunit_id))
                echo $modInstalasi->instalasi_nama;
            else
                echo $pasien->nama_pasien;
            ;?>
        </td>
        <td>Tanggal Pembayaran</td>
        <td>: <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));?></td>
    </tr>
    <tr>
        <td>Alamat </td>
        <td style="vertical-align: top;">:
            <?php
            if(!empty($modPenjualan->pasienpegawai_id)){
                echo ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS())->nama_rumahsakit;
                if(!empty($modPegawaiDokter->alamat_pegawai))
                    echo "/".$modPegawaiDokter->alamat_pegawai;
            }else if(!empty($modPenjualan->pasieninstalasiunit_id)){
                // if($modInstalasi->instalasi_lokasi == "GRT")
                    echo ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS())->nama_rumahsakit;
                // else{
                //     echo "Holding PT. KAH";
                // }
            }
            else
                echo $pasien->alamat_pasien;
            ?>
            <?php // echo ", ".$modPenjualan->pendaftaran->pasien->kelurahan->kelurahan_nama;?>
            <?php // echo ", ".$pasien->kecamatan->kecamatan_nama;?>
            <?php // echo ", ".$modPenjualan->pendaftaran->pasien->kabupaten->kabupaten_nama;?>
        </td>
<!--        <td>Umur</td>
        <td>: <?php // echo $modPenjualan->pendaftaran->umur;?> -->
        <td width="20%">No. Pembayaran</td>
        <td>: <?php echo (empty($modPenjualan->NoFaktur)) ? "- Belum Lunas -" : $modPenjualan->NoFaktur; ?></td>
    </tr>
    <tr>
        <td nowrap>Tanggal Resep</td>
        <td>: <?php echo MyFormatter::formatDateTimeForUser($modPenjualan->tglresep);?></td>
    </tr>
    <tr>
        <td>No. Resep</td>
        <td>: 
    </tr>
    <tr>
        <?php if (!empty($admisi) && !empty($admisi->dokterpenerima_id)) :
            $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
            ?>
        <td>Dokter Penerima</td>
        <td>: <?php echo $peg->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <?php if (!empty($admisi) && !empty($admisi->pegawai_id)) :
            $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
            ?>
        <td>Dokter PJP</td>
        <td>: <?php echo $peg->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <?php if (!empty($admisi) && !empty($admisi->dpjp2_id)) :
            $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
            ?>
        <td>Dokter PJP 2</td>
        <td>: <?php echo $peg->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <?php if (!empty($admisi) && !empty($admisi->dpjp3_id)) :
            $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
            ?>
        <td>Dokter PJP 3</td>
        <td>: <?php echo $peg->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
</table><br/>
<table width="100%" class="tab_detail">
    <thead class="font" style='border:1px solid;'>
        <th style='text-align: center;'>Tanggal</th>
        <!-- <th style='text-align: center;'>Kode</th> -->
        <th style='text-align: center;'>Deskripsi</th>
        <th style='text-align: center;'>Qty</th>
        <th style='text-align: center;'>Harga</th>
        <th style='text-align: center;'>Keringanan</th>
        <!-- <th style='text-align: center;'>PPN</th>
        <th style='text-align: center;'>Subsidi Asuransi</th>
        <th style='text-align: center;'>Subsidi Rumah Sakit</th>
        <th style='text-align: center;'>Subsidi Pemerintah</th>
        <th style='text-align: center;'>Tanggungan Pasien</th> -->
        <th style='text-align: center;'>Jumlah</th>
    </thead>
    <?php
    $no=1;
    $total = 0;
    $totalAdmin = 0;
    $gtotal = 0;
    $uirtotal = 0;
    $totalsubsidiasuransi = 0;
    $totaldiskon = 0;
    $subtotal = 0;
    if (count((array)$obatAlkes) > 0){
        foreach($obatAlkes AS $tampilData):
          $jmlHargaQty = ($tampilData->hargasatuan_oa * $tampilData->qty_oa);
          $jmliuran = $jmlHargaQty - $tampilData->discount + $tampilData->jumlahppn - $tampilData->subsidiasuransi - $tampilData->subsidirs - $tampilData->subsidipemerintah;
          $jmlSubtotal = ($jmlHargaQty - $tampilData->discount + $tampilData->jumlahppn);
          $modPegawai = PegawaiM::model()->findByPk($tampilData->pegawai_id);
          $modPegawai = !empty($modPegawai->namaLengkap) ? $modPegawai->namaLengkap : null; 
        echo "<tr>
            <td style='text-align:left;'>".$tampilData->tglpelayanan."</td>
            <td>".$tampilData->obatalkes->obatalkes_nama."($modPegawai)"."</td>
            <td style='text-align: center;' nowrap>".MyFormatter::formatNumberForPrint($tampilData->qty_oa)."</td>
            <td style='text-align: right;' nowrap>Rp. ".MyFormatter::formatNumberForPrint($tampilData->hargasatuan_oa)."</td>
            <td style='text-align: right;' nowrap>Rp. ".MyFormatter::formatNumberForPrint($tampilData->discount)."</td>
            <td style='text-align: right;' nowrap>Rp. ".MyFormatter::formatNumberForPrint($jmlSubtotal,0)."</td>
         </tr>";
        $no++;
        $gtotal += $jmlSubtotal;
        $uirtotal += $jmliuran;
        $total += ($tampilData->qty_oa * $tampilData->hargasatuan_oa);
        $totalAdmin +=  ($tampilData->biayaservice + $tampilData->biayakonseling + $tampilData->biayaadministrasi);//$tampilData->jasadokterresep + << TIDAK DICANTUMKAN KARENA SUDAH TERMASUK KE DALAM OBAT
        $totalsubsidiasuransi += $tampilData->subsidiasuransi;
        $totaldiskon += $tampilData->discount;
        $subtotal += $jmlSubtotal;
        endforeach;
    }
    $jumlNonTunai = 0;
      $jenispembayaranT = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$tandabukti->tandabuktibayar_id));
      if(count((array)$jenispembayaranT)>0){
        foreach ($jenispembayaranT as $jnsPemb) {
          $jumlNonTunai += $jnsPemb->jumlahpembayaran;
        }
      }
    ?>
    <tr>
        <td style="text-align:right; font-weight:bold; font-style:italic" colspan="4">Subtotal</td>
        <td style="text-align:right; font-weight:bold; font-style:italic" colspan="3"><?php echo "RP. ".MyFormatter::formatNumberForPrint($subtotal); ?></td>
    </tr>
    <?php //if ($tandabukti->isNewRecord): ?>
    
    <!-- <tr>
        <td style="text-align:right;" colspan = "11">Total Tagihan</td><td style="text-align:right;">Rp. <?php //echo MyFormatter::formatNumberForPrint($gtotal,2) ?></td>
    </tr> -->
    <?php //else: ?>
        <tr style="height: 50px;"></tr>
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="4" style = "border-bottom: 1px solid"></td>
                            </tr>
                            
                            <tr>
                                <td>Terbilang</td>
                                <td >: # <?php echo ucwords(MyFormatter::kataTerbilang($tandabukti->jmlpembayaran));?> #</td>
                                <td colspan="2"style="text-align: right;"> Total(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembayaran) ; ?></td>
                            </tr>
                            <tr style="height: 50px;"></tr>
                            <?php if ($tandabukti->pembayaranpelayanan->totaldiscount != 0): ?>
                                <tr>
                                    <td></td>
                                    <td ></td>
                                    <td colspan="2"style="text-align: right;"> Keringanan Akhir(Rp)</td>
                                    <td style="text-align: left;">:</td>
                                   <td style="text-align: center;"><?php echo MyFormatter::formatNumberForPrint($totaldiskon); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($tandabukti->pembayaranpelayanan->totaldiscount == 0): ?>
                                <tr>
                                <td></td>
                                <td ></td>
                                <td colspan="2"style="text-align: right;">Biaya Admin:</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: right;" ><?php echo MyFormatter::formatNumberForPrint($totalAdmin); ?></td>
                            </tr>
                            <tr hidden>
                                <td></td>
                                <td ></td>
                                <td colspan="2"style="text-align: right;">Pembebasan:</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: center;" ><?php echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi); ?></td>
                            </tr>
                            <tr hidden>
                                <td></td>
                                <td ></td>
                                <td colspan="2"style="text-align: right;">Pembulatan:</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: center;" ><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan); ?></td>
                            </tr>
                            <?php endif; ?>
                            <!-- <tr>
                                <td></td>
                                <td ></td>
                                <td colspan="2"style="text-align: right;"> Disc. Akhir(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: right;" >
                                <?php //echo MyFormatter::formatNumberForPrint($totaldiskon)?>
                                </td>
                            </tr> -->
                            
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="4" style = "border-top: 1px solid"></td>
                            </tr>
    
                            <?php 
                                $modJenis = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$tandabukti->tandabuktibayar_id));
                                // var_dump($modJenis);die;
                                $totalcredit = 0;
                                $totaldebit = 0;
                                $bankdebit = '';
                                $bankcredit = '';
                                $total_pembayaran = 0;
                                // var_dump($modJenis->bankpenerima_id);die;
                                // 
                                // var_dump($bank);die;
                                if (!empty($modJenis)){
                                    foreach($modJenis as $items){
                                        if ($items->jnspembayar_id == 2){
                                            $totaldebit += $items->jumlahpembayaran;
                                            $bank = BankM::model()->findByPk($items->bankpenerima_id);
                                            $bankdebit = $bank->namabank;
                                            
                                            
                                        }
                                        if ($items->jnspembayar_id == 1){
                                            $totalcredit += $items->jumlahpembayaran;
                                            $bank = BankM::model()->findByPk($items->bankpenerima_id);
                                            $bankcredit = $bank->namabank;
                                        }
                                    }
                                }
                                $total_pembayaran = $gtotal + $tandabukti->biayaadministrasi + $tandabukti->jmlpembulatan    ;
                            ?>
                            <tr>
                                <td></td>
                                <td > <?php //echo $subsidiasuransi_tindakan; ?></td>
                                <td colspan="2"style="text-align: right;"> Grand Total(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: right;" ><?php echo MyFormatter::formatNumberForPrint($total_pembayaran); ?></td>
                            </tr>
                            <tr hidden>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="4" style = "border-bottom: 1px solid"></td>
                            </tr>
                            <!-- <tr>
                                <td>Terbilang</td>
                                <td colspan="7">: # <?php //echo MyFormatter::kataTerbilang($tandabukti->jmlpembayaran);?> #</td>
                                <td colspan="2"style="text-align: right;"> Total(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: center;"><?php //echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembayaran) ; ?></td>
                            </tr>
                            <tr style="height: 50px;"></tr>
                            <tr>
                                <td></td>
                                <td colspan="7"></td>
                                <td colspan="4" style = "border-top: 1px solid"></td>
                            </tr> -->
                            
    
    <?php //endif; ?>
    
    <!-- <tr>
        <td style="text-align:right;" colspan = "10">Total Tagihan</td><td style="text-align:right;">Rp. <?php //echo number_format($total,0,"",".") ?></td>
    </tr> -->

<!--
    <tr>
        <td  style="text-align:right;" colspan = "5" >Biaya Racik, dll.</td><td style="text-align:right;">Rp. <?php //echo number_format($totalAdmin,0,"","."); ?></td>
    </tr>
    <?php //if(empty($modPenjualan->NoFaktur)){?>
        <tr>
            <td  style="text-align:right;" colspan = "5" >Total Transaksi</td><td style="text-align:right;">Rp. <?php //echo number_format(($total + $totalAdmin),0,"","."); ?></td>
        </tr>
    <?php //}else{?>
        <?php //if ($tandabukti->biayaadministrasi != 0): ?>
        <tr>
            <td  style="text-align:right;" colspan = "5" >Biaya Administrasi</td><td style="text-align:right;">Rp. <?php //echo number_format($tandabukti->biayaadministrasi,0,"","."); ?></td>
        </tr>
        <?php //endif; ?>

        <?php
        // $diskon = $tandabukti->pembayaranpelayanan->totaldiscount;
        //
        // if ($diskon != 0):
        ?>
        <tr>
            <td  style="text-align:right;" colspan = "5" >Total Diskon</td><td style="text-align:right;">
                <?php
                // if ($tandabukti->jmlpembulatan > 0) {
                //     echo "(Rp. ".number_format(abs($diskon),0,"",".").")";
                // } else {
                //     echo "Rp. ".number_format(abs($diskon),0,"",".");
                // }
                ?>
            </td>
        </tr>
        <?php //endif; ?>
        <tr>
            <td  style="text-align:right;" colspan = "5" >Total Transaksi</td><td style="text-align:right;">Rp. <?php //echo number_format($tandabukti->jmlpembayaran,0,"","."); ?></td>
        </tr>
        <tr>
            <td  style="text-align:right;" colspan = "5" >Jumlah Pembulatan</td><td style="text-align:right;"><?php

            // if ($tandabukti->jmlpembulatan < 0) {
            //     echo "(Rp. ".number_format(abs($tandabukti->jmlpembulatan),0,"",".").")";
            // } else {
            //     echo "Rp. ".number_format(abs($tandabukti->jmlpembulatan),0,"",".");
            // }

            ?></td>
        </tr>
        <tr>
            <td  style="text-align:right;" colspan = "5" >Bayar</td><td style="text-align:right;">Rp. <?php //echo number_format($tandabukti->uangditerima,0,"","."); ?></td>
        </tr>
        <tr>
            <td  style="text-align:right;" colspan = "5" >Kembalian</td><td style="text-align:right;">Rp. <?php //echo number_format($tandabukti->uangkembalian,0,"","."); ?></td>
        </tr> -->
    <?php //} ?>
</table>
<table width = "65%">
    <tr>
        <td></td>
        <?php if($totalsubsidiasuransi != 0){?>
            <td>Jaminan : <?php echo MyFormatter::formatNumberForPrint($totalsubsidiasuransi);?></td>
        <?php }else{?>
        
        <?php }?>
    </tr>
    <tr style="height: 100px; border:1px solid;">
        <td>
            Jenis Penjamin 
        </td>
        <td>
            <?php if(!empty($tandabukti->uangditerima)){?>
                <p><?php echo "Tunai" .":".MyFormatter::formatNumberForPrint($tandabukti->uangditerima - $tandabukti->uangkembalian);?></p>  
            <?php } else{?>
            <?php } ?>
            
            <?php if($totalcredit != 0){?>
                <p> <?php echo "Credit Card "." ".$bankcredit." ".MyFormatter::formatNumberForPrint($totalcredit); ?></p>   
            <?php }else{?>

            <?php }?>
            <?php if($totaldebit != 0){?>
                <p> <?php echo "Debit Card "." ".$bankdebit." ".MyFormatter::formatNumberForPrint($totaldebit); ?></p>   
            <?php }else{?>
            
            <?php }?>
        </td>
    </tr>
</table>
<br>
<?php if(empty($caraPrint)){

}else{
?>
<table width='100%'>
                        <tr hidden>
                            <td></td>
                            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
                        </tr>
                        <tr>
                            <td align='center'>Penerima</td>
                            <td align='center'><?php echo $data->nama_rumahsakit ?> </td>
                        </tr>
                        <tr height='150px'>
                            <td align='center'>(.........................................)</td>
                            <td align='center'>(.........................................)</td>
                        </tr>
                        <tr>
                            <td><?php echo $format->formatDateTimeId(date('Y-m-d')); ?></td>
                            <td align='right'>Kasir <?php echo Yii::app()->user->getState('nama_pegawai'); ?></td>
                        </tr>
                        <tr>
                            <td>
                            <p>- INVOICE INI BERLAKU SEBAGAI KWITANSI</p>
                            </td>
                            
                        </tr>
                    </table>
<div class="">
</div>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php } ?>
