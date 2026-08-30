<style>
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    label{
        color: black !important;
    }
    .tablefont td{
          color: black;
          padding: 10px;
      }
</style>
<table width="100%">
  <tr>
    <td width="50%" valign="top">
      <table class="tablefont" width="100%">
        <tr>
          <td width="180px">
            Balance Cairan Tanggal
          </td>
          <td width="5px"> : </td>
          <td>
            <?php echo MyFormatter::formatDateTimeForUser($model->balancecairan_tanggal); ?>
          </td>
        </tr>
        <tr>
          <td>
            Tanggal & Jam Perhitungan
          </td>
          <td> : </td>
          <td>
            <?php echo MyFormatter::formatDateTimeForUser($model->waktu_perhitungan); ?>
          </td>
        </tr>
        <tr>
          <td>
            Petugas Pengisi
          </td>
          <td> : </td>
          <td>
            <?php echo $model->petugaspengisi->namaLengkap; ?>
          </td>
        </tr>
        <tr>
          <td>
            Total Cairan Masuk
          </td>
          <td> : </td>
          <td>
            <?php echo number_format(str_replace(",","",$model->totalcairanmasuk), 3, ',', '.'); ?>
          </td>
        </tr>
        <tr>
          <td>
            Total Cairan Keluar
          </td>
          <td> : </td>
          <td>
            <?php echo number_format(str_replace(",","",$model->totalcairankeluar), 3, ',', '.'); ?>
          </td>
        </tr>
        <tr>
          <td>
            Total IWL
          </td>
          <td> : </td>
          <td>
            <?php echo number_format(str_replace(",","",$model->totaliwl), 3, ',', '.'); ?>
          </td>
        </tr>
      </table>
    </td>
    <td width="50%" valign="top">
      <table class="tablefont" width="100%">
        <tr>
          <td width="180px">
            Balance Cairan Sekarang
          </td>
          <td width="5px"> : </td>
          <td>
            <?php echo number_format(str_replace(",","",$model->balancecairan_sekarang), 3, ',', '.'); ?>
          </td>
        </tr>
        <tr>
          <td>
            Balance Cairan Sebelumnya
          </td>
          <td> : </td>
          <td>
            <?php echo number_format(str_replace(",","",$model->balancecairan_sebelumnya), 3, ',', '.'); ?>
          </td>
        </tr>
        <tr>
          <td>
            Balance Cairan Komulatif
          </td>
          <td> : </td>
          <td>
            <?php echo number_format(str_replace(",","",$model->balancecairan_komulatif), 3, ',', '.'); ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
