<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<style>
    .grid{
        font-size:13px;        
        font-family: tahoma;
        font-weight: bold;
        /*font-family: serif;*/
        
    }
    .catatan{
        font-size:11px;
        text-align: left;
    }

     .judul{
        font-size:16px;
        font-family: tahoma;
    }
    
</style>
<div align="center" class="judul"><b>KUITANSI</b></div> <br>
<table cellspacing=0 width="100%" border="0" class="grid">
    <tbody>
        <tr>
            <td width="20%">No. Kuitansi</td>
            <td width="2%">:</td>
            <td align="left"><?php echo $modTandaBukti->nobuktibayar;?></td>
        </tr>
        <tr>
            <td>Sudah Terima Dari</td>
            <td>:</td>
            <td><?php echo $modTandaBukti->darinama_bkm;?></td>
        </tr>
        <tr>
            <td>Banyak Uang</td>
            <td>:</td>
            <td class="terbilang">
                <?php
                $format = new MyFormatter();
                    if($modTandaBukti->jmlpembayaran == 0)
                    {
                        echo '-';
                    }else{
                        echo strtoupper($format->formatNumberTerbilang($modTandaBukti->jmlpembayaran)) . ' RUPIAH';
                    }
                ?>                
            </td>
        </tr>
        <tr>
            <td>Untuk Pembayaran</td>
            <td>:</td>
            <td><?php echo $modTandaBukti->sebagaipembayaran_bkm;?>  <?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->pasien->nama_pasien; ?> - No. RM : <?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->pasien->no_rekam_medik ?></td>
        </tr>
		<tr>
			<td>Jenis Penjamin</td>
			<td>:</td>
			<td><?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->carabayar->carabayar_nama; ?> - Penjamin : <?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->penjamin->penjamin_nama ?></td>
		</tr>
    </tbody>
</table>
<table cellspacing=0 width="100%" border="0" class="grid">
    <tbody>
        <tr>
            <td width="60%" align="center">
                <div>
                    <br>
                    <div style="border:1px solid #000000;width:200px;padding:10px;" class="uang">
                        <b>Rp <?php echo number_format($modTandaBukti->jmlpembayaran,0,'','.');?>,-</b>
                    </div>
                    <br><br>

                </div>
            </td>
            <td class="tandatangan" align="center">
                <!-->Tasikmalaya, <?php //echo $modTandaBukti->tglbuktibayar;?><br><!-->
                <?php echo Yii::app()->user->getState('kabupaten_nama')?>, <?php echo $modTandaBukti->tglbuktibayar;?><br>
                Petugas RS,<br><br><br><br><br><br>
                <?php $pegawai = LoginpemakaiK::model()->findByPk($modBayar->create_loginpemakai_id); ?>
                <b><?php echo $pegawai->nama_pegawai; ?></b>

            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="catatan">
                    Catatan : untuk pembayaran melalui Cheque / Bilyet Giro (BG)<br>
                    Belum dianggap lunas apabila Cheque/Bilyet Giro (BG) Belum Diuangkan<br>
                    <i>*Kuitansi ini sah bila ada tandatangan petugas dan cap <?php echo $data->nama_rumahsakit; ?>*</i>
                </div>                
            </td>
        </tr>
    </tbody>
</table>