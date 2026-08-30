<style>
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
        width: 50%;
    }
    body {
        color: black;
    }

    .tab-header td {
        padding: 2px;
    }

    .tab-detail th {
        font-weight: bold;
    }

    .tab-detail td, .tab-detail th {
        padding: 2px;
        border: 1px solid black;
    }
</style>


<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
    }

}

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
echo CHtml::css('.control-label{
        float:left;
        text-align: right;
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }
');
?>

<table class="tab-header"  width="100%">
    <tr>
        <td width="20%">No. Pendaftaran</td>
        <td width="2%">: </td>
        <td width="36%"><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
        <td width="20%">Tgl. Jatuh Tempo</td>
        <td width="2%">: </td>
        <td width="20%" nowrap><?php echo MyFormatter::formatDateTimeForUser($modPembayaran->tgljatuhtempo); ?></td>
    </tr>
    <tr>
        <td nowrap>No. Rekam Medik</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        <td>Penanggung Jawab</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->penanggungjawabhutang; ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->namadepan.$modPendaftaran->pasien->nama_pasien); ?></td>
        <td>No. KTP</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->noktp_hutang; ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        <td>No. Telp/Mobile</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->notelp_hutang; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        <td nowrap>Jaminan yang ditinggal</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->jaminanygditinggal; ?></td>
    </tr>
    <tr>
        <td>Alamat Pasien</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->alamat_pasien); ?></td>
        <td>Keterangan</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->keteranganberhutang; ?></td>
    </tr>
</table>

<div  class="judulcontent" align="center" style="border-bottom: 1px solid #000000;padding: 10px;margin-bottom: 15px;">
  RINCIAN PEMBAYARAN
</div>
 <table width="100%" style='margin-left:auto; margin-right:auto;' class='tab-detail'>
    <thead>
        <tr>
            <th>No. Pembayaran</th>
            <th>No. Bukti Kas Masuk</th>
            <th>Tanggal Bayar</th>
            <th>Bayar Ke</th>
            <th>Total Tagihan</th>
            <th>Jumlah Pembayaran Angsuran</th>
            <th>Biaya Administrasi</th>
            <th>Biaya Materai</th>
            <th>Total Sisa Tagihan</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $col="";
            foreach ($modRincian as $i => $val) {
                $col.= '<tr>';
                $col.='<td>'.$val['nopembayaran'].'</td>';
                $col.='<td>'.$val['nobuktibayar'].'</td>';
                $col.='<td>'.MyFormatter::formatDateTimeForUser($val['tglbuktibayar']).'</td>';
                $col.='<td style="text-align: right;">'.$val['bayarke'].'</td>';
                $col.='<td style="text-align: right;"> Rp. '.MyFormatter::formatNumberForPrint(($val['totaliurbiaya']),2).'</td>';
                $col.='<td style="text-align: right;"> Rp. '.MyFormatter::formatNumberForPrint($val['jmlbayarangsuran'],2).'</td>';
                $col.='<td style="text-align: right;"> Rp. '.MyFormatter::formatNumberForPrint($val['biayaadministrasi'],2).'</td>';
                $col.='<td style="text-align: right;"> Rp. '.MyFormatter::formatNumberForPrint($val['biayamaterai'],2).'</td>';
                $col.='<td style="text-align: right;"> Rp. '.MyFormatter::formatNumberForPrint($val['sisaangsuran'],2).'</td>';
                $col.='<td style="text-align: center;">'.
                  ((!empty($checkBayarAngsuranKe) && $checkBayarAngsuranKe->bayarke == $val['bayarke'])?
                    CHtml::Link("<i class=\"icon-form-silang\"></i>",
                          'javascript:void(0)',
                  array("onclick"=>"confirmBatal(".$val['bayarangsuranpelayanan_id'].");",
                        "rel"=>"tooltip",
                        "title"=>"Klik untuk membatalkan bayar angsuran",
                  ))
                : "- ")
                  .'</td>';
                $col.= '</tr>';
            }
            echo $col;
        ?>
    </tbody>
</table>

<script type="text/javascript">

function confirmBatal(id) {
  myConfirm("Apakah anda akan melakukan pembatalan bayar angsuran",'Perhatian!',function(r){
      if (r){
        $.post('<?php echo Yii::app()->controller->createUrl("batalAngsuran"); ?>', {id: id},
            function(data){
               if(data.status == 'ok'){
                  if(data.ketPembayaran == 'ok'){
                    $("#dialogRincianPembatalan").dialog("close");
                  }else{
                    window.location.reload();
                  }
               }else{
                 myAlert('Data Gagal di Hapus');
               }
       },"json");
     }
  });

}

</script>
