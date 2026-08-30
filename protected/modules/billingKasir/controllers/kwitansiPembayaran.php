<?php
// echo CHtml::css('.control-label{
//         float:left; 
//         text-align: left; 
//         width:160px;
//         color:black;
//         padding-right:10px;
//         font-size: 11pt;
//         font-family: tahoma;
//     }
//     table{
//         font-size:11px;
//     }
// ');

$format = new MyFormatter();
?>
<style>
  /*td, div{
        font-size: 11pt;
        font-family: tahoma;
    }
    td .uang{
        text-align: right;
    }
    td .total{
        border-top: 1px solid #000000;
        text-align: right;
        font-weight: bold;
    }
    td .totalSeluruh{
        border-bottom: 1px solid #000000;
        text-align: right;
        font-weight: bold;
    }*/

  .grid {
    font-size: 11px;
    font-family: tahoma;
  }

  .catatan {
    font-size: 9px;
    text-align: left;
  }
</style>
<div align="center"><b>KUITANSI</b></div> <br />
<table cellspacing=0 width="100%" border="0" class="grid">
  <!--    <tr>
        <td colspan="3" height="100px">
            <?php // echo $this->renderPartial('application.views.headerReport.headerDefault'); 
            ?>
        </td>
    </tr>-->
  <tr>
    <td width="20%">No. Kuitansi</td>
    <td width="2%">:</td>
    <td align="left"><?php echo $model->nobuktibayar; ?></td>
  </tr>
  <tr>
    <td>Sudah Terima Dari</td>
    <td>:</td>
    <td><?php echo $model->darinama_bkm; ?></td>
  </tr>
  <tr>
    <td>Banyak Uang</td>
    <td>:</td>
    <td><?php echo $format->formatNumberTerbilang($model->jmlpembayaran) . ' rupiah'; ?></td>
  </tr>
  <tr>
    <td>Untuk Pembayaran</td>
    <td>:</td>
    <td><?php echo $model->sebagaipembayaran_bkm; ?> Tanggal <?php echo date('d/m/Y'); ?></td>
  </tr>
  <tr>
    <td>Nama Pasien</td>
    <td>:</td>
    <?php if (empty($model->pendaftaran_id)) { ?>
      <td><?php echo $model->bayaruangmuka->pendaftaran->pasien->nama_pasien; ?> - No. RM : <?php echo $model->bayaruangmuka->pendaftaran->pasien->no_rekam_medik ?></td>
    <?php } else { ?>
      <td><?php echo $model->pembayaran->pendaftaran->pasien->nama_pasien; ?> - No. RM : <?php echo $model->pembayaran->pendaftaran->pasien->no_rekam_medik ?></td>
    <?php } ?>
  </tr>
  </tbody>
</table>
<table cellspacing=0 width="100%" border="0" class="grid">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="50%" align="center">
        <div style="border:1px solid #000000;width:200px;padding:10px;" class="uang"><b>
            Rp <?php echo number_format($model->jmlpembayaran, 0, '', '.'); ?>,-
          </b></div>
      </td>
      <td align="center" class="tandatangan">
        <div>Tasikmalaya,
          <?php
          $format = new CustomFormat();
          $tgl = $model->tglbuktibayar;
          $tglBayar = explode(" ", $tgl);
          $tanggal = $tglBayar[0];
          $bulan = $tglBayar[1];
          $tahun = $tglBayar[2];
          $tglBayar = $tanggal . " " . $bulan . " " . $tahun;
          // $tgls = $format->formatDateMediumForDB($tglBayar);
          $tgls = $tglBayar;
          // echo $tgls;
          echo $tgls;
          ?>
        </div>
        <div>Petugas RS,</div>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
        <div>&nbsp;</div>

        <div>
          <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
          <b><?php echo $pegawai->nama_pegawai; ?></b>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <br>
        <div class="catatan">Catatan : Untuk pembayaran melalui Cheque/Bilyet Giro (BG)<br>
          belum dianggap lunas apabila Cheque/Bilyet Giro (BG) belum diuangkan<br>
          <i>*Kwitansi ini sah bila ada tandatangan petugas dan cap*</i>
        </div>
      </td>
    </tr>
  </tbody>
</table>
</td>
</tr>
<!--    <tr>
        <td colspan="3" style="border-bottom:1px solid #000000;">&nbsp;</td>
    </tr>-->
<!--    <tr>
        <td colspan="3">Printed at <?php // echo date("d/m/y h:m:s");
                                    ?></td>
    </tr>        -->
</table>