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
</style>
<?php
$format = new MyFormatter;


$admisi = null;
if (!empty($modPenjualan->pendaftaran_id)) {
    $admisi = PasienadmisiT::model()->findByAttributes(array(
        'pendaftaran_id'=>$modPenjualan->pendaftaran_id,
    ));
}
?>
<?php if(!empty($caraPrint)){
    ?>

<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
    <?php
} ?>
<table width="100%"><tr><td>
<table width="100%" >
    <tr>
        <td colspan="2">Kepada Yth.,</td>
    </tr>
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
        <td>: <?php echo $modPenjualan->noresep;?>
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
<table width="100%" border="1">
    <thead style='border:1px solid;'>
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>Kode</th>
        <th style='text-align: center;'>Nama</th>
        <th style='text-align: center;'>Jumlah</th>
        <th style='text-align: center;'>Harga Satuan</th>
        <th style='text-align: center;'>Keringanan</th>
        <th style='text-align: center;'>PPN</th>
        <th style='text-align: center;'>Subsidi Asuransi</th>
        <th style='text-align: center;'>Subsidi Rumah Sakit</th>
        <th style='text-align: center;'>Subsidi Pemerintah</th>
        <th style='text-align: center;'>Tanggungan Pasien</th>
        <th style='text-align: center;'>Subtotal</th>
    </thead>
    <?php
    $no=1;
    $total = 0;
    $totalAdmin = 0;
    $gtotal = 0;
    $uirtotal = 0;
    if (count((array)$obatAlkes) > 0){
        foreach($obatAlkes AS $tampilData):
          $jmlHargaQty = ($tampilData->hargasatuan_oa * $tampilData->qty_oa);
          $jmliuran = $jmlHargaQty - $tampilData->discount + $tampilData->jumlahppn - $tampilData->subsidiasuransi - $tampilData->subsidirs - $tampilData->subsidipemerintah;
          $jmlSubtotal = ($jmlHargaQty - $tampilData->discount + $tampilData->jumlahppn);
        echo "<tr style='border:1px solid;''>
            <td style='text-align:center;'>".$no."</td>
            <td>".$tampilData->obatalkes->obatalkes_kode."</td>
            <td>".$tampilData->obatalkes->obatalkes_nama."</td>
            <td style='text-align: center;' norwap>".number_format($tampilData->qty_oa,0,"",".")."</td>
            <td style='text-align: right;' norwap>Rp. ".MyFormatter::formatNumberForPrint($tampilData->hargasatuan_oa,2)."</td>
            <td style='text-align: right;' norwap>Rp. ".MyFormatter::formatNumberForPrint($tampilData->discount,2)."</td>
            <td style='text-align: right;' norwap>Rp. ".MyFormatter::formatNumberForPrint($tampilData->jumlahppn,2)."</td>
            <td style='text-align: right;' norwap>Rp. ".MyFormatter::formatNumberForPrint($tampilData->subsidiasuransi,2)."</td>
            <td style='text-align: right;' norwap>Rp. ".MyFormatter::formatNumberForPrint($tampilData->subsidirs,2)."</td>
            <td style='text-align: right;' norwap>Rp. ".MyFormatter::formatNumberForPrint($tampilData->subsidipemerintah,2)."</td>
            <td style='text-align: right;' nowrap>Rp. ".MyFormatter::formatNumberForPrint($jmliuran,2)."</td>
            <td style='text-align: right;' nowrap>Rp. ".MyFormatter::formatNumberForPrint($jmlSubtotal,0)."</td>
         </tr>";
        $no++;
        $gtotal += $jmlSubtotal;
        $uirtotal += $jmliuran;
        $total += ($tampilData->qty_oa * $tampilData->hargasatuan_oa);
        $totalAdmin +=  ($tampilData->biayaservice + $tampilData->biayakonseling + $tampilData->biayaadministrasi);//$tampilData->jasadokterresep + << TIDAK DICANTUMKAN KARENA SUDAH TERMASUK KE DALAM OBAT
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
    
    <?php if ($tandabukti->isNewRecord): ?>
    <tr>
        <td style="text-align:right;" colspan = "11">Total Tagihan</td><td style="text-align:right;">Rp. <?php echo MyFormatter::formatNumberForPrint($gtotal,2) ?></td>
    </tr>
    <?php else: ?>
    <tr>
        <!-- <td style="text-align:right;" colspan = "11">Total Tagihan</td><td style="text-align:right;">Rp. <?php //echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembayaran,2) ?></td> -->
        <td style="text-align:left;" colspan = "11">Total Tagihan</td><td style="text-align:right;">Rp. <?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembayaran,0) ?></td>
    </tr>
    <tr>
        <!-- <td style="text-align:right;" colspan = "11">Dibayar Oleh Pasien</td><td style="text-align:right;">Rp. <?php //echo MyFormatter::formatNumberForPrint($tandabukti->pembayaranpelayanan->totaliurbiaya,2) ?></td> -->
        <td style="text-align:left;" colspan = "11">Dibayar Oleh Pasien</td><td style="text-align:right;">Rp. <?php echo MyFormatter::formatNumberForPrint($tandabukti->pembayaranpelayanan->totaliurbiaya,0) ?></td>
    </tr>
    <tr>
    <!-- <td style="text-align:right;" colspan = "11">Jumlah Pembulatan</td><td style="text-align:right;">Rp. <?php //echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan,2, true) ?></td> -->
        <td style="text-align:left;" colspan = "11">Jumlah Pembulatan</td><td style="text-align:right;">Rp. <?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan,0, true) ?></td>
    </tr>
    <tr>
        <!-- <td style="text-align:right;" colspan = "11">Pembayaran Tunai</td><td style="text-align:right;">Rp. <?php //echo MyFormatter::formatNumberForPrint($tandabukti->uangditerima,2) ?></td> -->
        <td style="text-align:left;" colspan = "11">Pembayaran Tunai</td><td style="text-align:right;">Rp. <?php echo MyFormatter::formatNumberForPrint($tandabukti->uangditerima,0) ?></td>
    </tr>
    <tr>
        <!-- <td style="text-align:right;" colspan = "11">Pembayaran Non Tunai</td><td style="text-align:right;">Rp. <?php //echo MyFormatter::formatNumberForPrint($jumlNonTunai,2) ?></td> -->
        <td style="text-align:left;" colspan = "11">Pembayaran Non Tunai</td><td style="text-align:right;">Rp. <?php echo MyFormatter::formatNumberForPrint($jumlNonTunai,0) ?></td>
    </tr>
    <tr>
        <!-- <td style="text-align:right;" colspan = "11">Uang Kembali</td><td style="text-align:right;">Rp. <?php //echo MyFormatter::formatNumberForPrint($tandabukti->uangkembalian,2) ?></td> -->
        <td style="text-align:left;" colspan = "11">Uang Kembali</td><td style="text-align:right;">Rp. <?php echo MyFormatter::formatNumberForPrint($tandabukti->uangkembalian,0) ?></td>
    </tr>
    <?php endif; ?>
    
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
<br>
<?php if(empty($caraPrint)){

}else{
?>
<table width="100%">
    <tr><td class="tandatangan">Penerima</td>
        <td class="tandatangan">Hormat Kami,</td>
    </tr>
    <tr>
        <td class="tandatangan" style="height: 50px;">.........................</td>
        <td class="tandatangan" ><?php echo Yii::app()->user->getState('nama_pegawai'); ?>
    </td></tr>
</table>
<div style="font-size: 9pt;">Print Date: <?php echo RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama.','; // echo Yii::app()->user->getState('nama_pegawai'); ?>
    <?php echo date('d M Y H:i:s'); ?></div>
<?php } ?>
</td></tr></table>
<?php if(!empty($caraPrint)){
    ?>
        </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php } ?>
