<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');
}
echo CHtml::css('.control-label{
        float:left;
        text-align: right;
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
        padding: 5px;
    }
    thead th {
    background: none;
    color: #000;
    }

    .judulcontent{
      text-align: center;
      font-weight: bold;
      font-size: 14pt;
    }
}
');
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint');
}
?>
<div class="judulcontent">RINCIAN STOCK OPNAME BAHAN MAKANAN</div>
<br/>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
  <tr>
      <td width="150px">No. Stock Opname</td>
      <td  width="5px">:</td>
      <td><?php echo $model->nostokopnamegizi; ?></td>
  </tr>
  <tr>
      <td>Tanggal Stock Opname</td>
      <td>:</td>
      <td><?php echo $format->formatDateTimeForUser($model->tglstokopnamegizi); ?></td>
  </tr>
  <?php if(isset($model->formuliropnamegizi_id)){ ?>
  <tr>
      <td>No. Formulir Opname</td>
      <td>:</td>
      <td><?php echo $model->formuliropnamegizi->noformulir; ?></td>
  </tr>
  <tr>
      <td>Tanggal Formulir Opname</td>
      <td>:</td>
      <td><?php echo $format->formatDateTimeForUser($model->formuliropnamegizi->tglformulir); ?></td>
  </tr>
  <?php } ?>

</table>
<br/>
<table style = "width:100%;">
    <thead>
        <tr>
            <th class = "border">No.</th>
            <th class = "border">Tgl. Periksa</th>
            <th class = "border">Kelompok Bahan Makanan</th>
            <th class = "border">Nama Bahan Makanan</th>
            <th class = "border">Harga Netto (Rp)</th>
            <th class = "border">HPP (Rp)</th>
            <th class = "border">Total Nilai Persediaan (Rp)</th>
            <th class = "border">Harga Jual (Rp)</th>
            <th class = "border">Stock Sistem</th>
            <th class = "border">Stock Fisik</th>
            <th class = "border">Selisih</th>
            <th class = "border">Kondisi Barang</th>
        </tr>
    </thead>
    <?php $total = 0; ?>
    <tbody>
        <?php
            foreach($modDetails as $i=>$obat){
                $total  += $obat->totalnilaipersediaan;
        ?>
        <tr>
            <td  class = "border"><?php echo ($i+1); ?></td>
            <td class = "border"><?php echo (!empty($obat->tglperiksafisik) ? MyFormatter::formatDateTimeForUser($obat->tglperiksafisik) : ""); ?></td>
            <td  class = "border"><?php echo $obat->bahanmakanan->kelbahanmakanan; ?></td>
            <td  class = "border"><?php echo $obat->bahanmakanan->namabahanmakanan; ?></td>
            <td  class = "border" style="text-align:right;"><?php  echo $format->formatNumberForPrint($obat->bahanmakanan->harganettobahan,2); ?></td>
            <td  class = "border" style="text-align:right;" ><?php  echo $format->formatNumberForPrint($obat->bahanmakanan->hpp,2); ?></td>
            <td  class = "border" style="text-align:right;" ><?php  echo $format->formatNumberForPrint($obat->totalnilaipersediaan,2); ?></td>
            <td  class = "border" style="text-align:right;" ><?php  echo $format->formatNumberForPrint($obat->bahanmakanan->hargajualbahan,2); ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->volume_sistem,2)." ".$obat->bahanmakanan->satuanbahan; ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->volume_fisik,2)." ".$obat->bahanmakanan->satuanbahan; ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->jmlselisihstok,2)." ".$obat->bahanmakanan->satuanbahan; ?></td>
            <td  class = "border"><?php echo $obat->kondisibarang ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td class = "border" style="font-weight: bold; text-align: right;" colspan="6">Total</td>
            <td class = "border" style="text-align: right;"><?php echo $format->formatNumberForPrint($total,2); ?></td>
            <td class = "border" colspan="5">&nbsp;</td>
        </tr>
    </tfoot>
</table>
<?php
if (isset($_GET['frame'])){
    echo "<br>";

    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));


   echo"&nbsp;"; echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));
?>
    <script type='text/javascript'>
    /**
     * print
     */
    function print(caraPrint){
        stokopname_id = '<?php echo isset($model->stokopnamegizi_id) ? $model->stokopnamegizi_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&stokopnamegizi_id='+stokopname_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
    }
    </script>
<?php
}else{ ?>
<table width="100%" style="margin-top:20px;">
<tr>
    <td width="100%" align="left" align="top">
        <table width="100%">
            <tr>
              <td width="35%" align="center">
                <br/>
                  <div>Petugas 1</div>
                  <div style="margin-top:60px;"><?php echo ($model->petugas1_id)?PegawaiM::model()->findByPk($model->petugas1_id)->NamaLengkap:""; ?></div>
              </td>
                <td width="30%" align="center">
                  <br/>
                    <div>Petugas 2</div>
                    <div style="margin-top:60px;"><?php echo ($model->petugas2_id)?PegawaiM::model()->findByPk($model->petugas2_id)->NamaLengkap:""; ?></div>
                </td>
                <td width="35%" align="center">
                    <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                    <div>Mengetahui</div>
                    <div style="margin-top:60px;"><?php echo ($model->mengetahui_id)?PegawaiM::model()->findByPk($model->mengetahui_id)->NamaLengkap:""; ?></div>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
<?php }
