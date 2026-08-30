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
    }
    thead th {
    background: none;
    color: #000;
    }
}
');
if (!isset($_GET['frame'])){
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
}
?>

<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valig="middle" colspan="12">
            <div class="judulcontent"><b><?php echo $judulLaporan ?></b></div>
            <br/>
        </td>
    </tr>
    <tr>
        <td>Jenis Stock Opname</td>
        <td>:</td>
        <td><?php echo $model->jenisstokopname; ?></td>

        <td>Total Nilai Persediaan</td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->totalharga,2); ?></td>
    </tr>
    <tr>
        <td>No. Stock Opname</td>
        <td>:</td>
        <td><?php echo $model->nostokopname; ?></td>


    </tr>
    <tr>
        <td>Tanggal Stock Opname</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->tglstokopname); ?></td>


    </tr>
    <?php if(isset($model->formuliropname_id)){ ?>
    <tr>
        <td>No. Formulir Opname</td>
        <td>:</td>
        <td><?php echo $model->formuliropname->noformulir; ?></td>

        <td>Total Volume</td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->formuliropname->totalvolume); ?></td>
    </tr>
    <tr>
        <td>Tanggal Formulir Opname</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->formuliropname->tglformulir); ?></td>

        <td>Total Harga</td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->totalharga,2); ?></td>
    </tr>
    <?php } ?>
    </table><br/>
<table style = "width:100%;">
    <thead>
        <tr>
            <th class = "border">No.</th>
            <th class = "border">Tgl Periksa</th>
            <th class = "border">Jenis Obat Alkes</th>
            <!-- <th class = "border">Kategori</th>
            <th class = "border">Golongan</th> -->
            <th class = "border">Kode</th>
            <th class = "border">Nama Obat Alkes</th>
            <th class = "border">Harga Netto (Rp)</th>
            <th class = "border">HPP (Rp)</th>
            <th class = "border">Total Nilai Persediaan (Rp)</th>
            <th class = "border">Harga Jual (Rp)</th>
            <th class = "border">Stok Sistem</th>
            <th class = "border">Stok Fisik</th>
            <th class = "border">Selisih</th>

            <th class = "border">Kondisi Barang</th>
        </tr>
    </thead>
    <tbody>
        <?php
          $totalpersediaan = 0;
            foreach($modDetails as $i=>$obat){
              $totalpersediaan += $obat->totalnilaipersediaan;
        ?>
        <tr>
            <td  class = "border"><?php echo ($i+1); ?></td>
            <td  class = "border" style="text-align:center;"><?php echo $format->formatDateTimeId($obat->tglperiksafisik); ?></td>
            <td class = "border"><?php echo (isset($obat->obatalkes->jenisobatalkes->jenisobatalkes_nama) ? $obat->obatalkes->jenisobatalkes->jenisobatalkes_nama : ""); ?></td>
            <td  class = "border"><?php echo $obat->obatalkes->obatalkes_kode; ?></td>
            <td  class = "border"><?php echo $obat->obatalkes->obatalkes_nama; ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->harganetto,2); ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->obatalkes->hpp,2); ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->totalnilaipersediaan,2); ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->jumlahharga,2); ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $obat->volume_sistem." ".$obat->obatalkes->satuankecil->satuankecil_nama; ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $obat->volume_fisik." ".$obat->obatalkes->satuankecil->satuankecil_nama; ?></td>
            <td  class = "border" style="text-align:right;"><?php echo $obat->jmlselisihstok." ".$obat->obatalkes->satuankecil->satuankecil_nama; ?></td>

            <td  class = "border"><?php echo $obat->kondisibarang ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
          <td class = "border" style="text-align: right" colspan="7">Total</td>
          <td class = "border" style="text-align: right"><?php echo $format->formatNumberForPrint($totalpersediaan,2); ?></td>
          <td class = "border" colspan="5"></td>
        </tr>
    </tfoot>
</table>
<?php
if (isset($_GET['frame'])){
    echo "<br>";
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
   echo"&nbsp;"; echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));
?>
    <script type='text/javascript'>
    /**
     * print
     */
    function print(caraPrint){
        stokopname_id = '<?php echo isset($model->stokopname_id) ? $model->stokopname_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&stokopname_id='+stokopname_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
    }
    </script>
<?php
}else{ ?>
<table width="100%" style="margin-top:20px;">
  <tr>
    <td width="35%" align="left" align="top">
    </td>
    <td width="30%" align="left" align="top">
    </td>
    <td width="35%" style="padding-left: 100px" align="left" align="top">
      <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
    </td>
  </tr>
</table>
<table width="100%">
    <tr>
        <td width="35%" align="center">
          <div>Petugas 1</div>
          <div style="margin-top:60px;"><?php echo ($model->petugas1_id)?PegawaiM::model()->findByPk($model->petugas1_id)->NamaLengkap:""; ?></div>

        </td>
        <td width="30%" align="center">
          <div>Petugas 2</div>
          <div style="margin-top:60px;"><?php echo ($model->petugas2_id)?PegawaiM::model()->findByPk($model->petugas2_id)->NamaLengkap:""; ?></div>
        </td>
        <td width="35%" align="center">
            <div>Mengetahui</div>
            <div style="margin-top:60px;"><?php echo ($model->mengetahui_id)?PegawaiM::model()->findByPk($model->mengetahui_id)->NamaLengkap:""; ?></div>
        </td>
    </tr>
</table>
<?php } ?>
<?php
if (!isset($_GET['frame'])){
   ?>
    </div>
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
<?php
}
?>
