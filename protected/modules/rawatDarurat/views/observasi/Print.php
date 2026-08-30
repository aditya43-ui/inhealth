<style>
    @page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  /* ... the rest of the rules ... */
}
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }
 
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }
    
    p {
        text-align: justify;
    }
    
    
    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }
    
    .padding5{
        padding: 5px;
    }
    

</style>
<?php
if(isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Riwayat Observasi Rawat Inap-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<div class="pull-right" style="font-weight: bold">RM RI. 30a REV 03</div>
<br>
<?php echo $this->renderPartial($this->path_view.'_headerSuratPrint', array('modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modPasienAdmisi'=>$modPasienAdmisi,'jenisobservasi'=>$jenisobservasi)); ?>
<br>
<?php if($jenisobservasi == true){ ?>
<table width="100%" class="borderclass">
    <thead>
        <tr>
            <th class="borderclass" style="padding:10px">Tanggal</th>
            <th class="borderclass">Jam</th>
            <th class="borderclass">TD</th>
            <th class="borderclass">N</th>
            <th class="borderclass">S</th>
            <th class="borderclass">P</th>
            <th class="borderclass">Jenis Cairan</th>
            <th class="borderclass">Jml Tetesan</th>
            <th class="borderclass">Kolf</th>
            <th class="borderclass">Minum/<br />Sonde</th>
            <th class="borderclass">Muntah</th>
            <th class="borderclass">BAK</th>
            <th class="borderclass">BAB</th>
            <th class="borderclass">Catatan</th>
            <th class="borderclass">Nama Petugas</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(count($model)>0){
                foreach ($model as $dataModel){
        ?>
            <tr>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo MyFormatter::formatDateTimeForUser($dataModel->tgl_observasi); ?>
                </td>  
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo $dataModel->jam_observasi; ?>
                </td>  
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo $dataModel->td_sistolic ."/".$dataModel->td_diastolic; ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo $dataModel->detaknadi; ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo MyFormatter::formatNumberForPrint($dataModel->suhutubuh,2); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo $dataModel->pernapasan; ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->cairan_jenis)?$dataModel->cairan_jenis:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->jml_tetesan)?$dataModel->jml_tetesan:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->kolf)?$dataModel->kolf:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->minum_sonde)?$dataModel->minum_sonde:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->muntah)?$dataModel->muntah:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->bak)?$dataModel->bak:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->bab)?$dataModel->bab:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->catatan)?$dataModel->catatan:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (isset($dataModel->petugas)?$dataModel->petugas->namaLengkap:"-"); ?>
                </td>
            </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table>
<?php }else{ ?>
<table width="100%" class="borderclass">
    <thead>
        <tr>
            <th class="borderclass" style="padding:10px">Tanggal</th>
            <th class="borderclass">Jam</th>
            <th class="borderclass">TD</th>
            <th class="borderclass">N</th>
            <th class="borderclass">S</th>
            <th class="borderclass">P</th>
            <th class="borderclass">SpO2</th>
            <th class="borderclass">Jenis Cairan</th>
            <th class="borderclass">Jml Tetesan</th>
            <th class="borderclass">Kolf</th>
            <th class="borderclass">Jumlah Urine</th>
            <th class="borderclass">Bunyi Jantung Anak (BJA)</th>
            <th class="borderclass">Catatan</th>
            <th class="borderclass">Nama Petugas</th>
        </tr>
    </thead>
    <tbody style="margin: 0; ">
        <?php 
            if(count($model)>0){
                foreach ($model as $dataModel){
        ?>
            <tr valign="top">
                <td class="borderrightclass borderleftclass">
                    <?php echo MyFormatter::formatDateTimeForUser($dataModel->tgl_observasi); ?>
                </td>  
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo $dataModel->jam_observasi; ?>
                </td>  
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo $dataModel->td_sistolic ."/".$dataModel->td_diastolic; ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo $dataModel->detaknadi; ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo MyFormatter::formatNumberForPrint($dataModel->suhutubuh,2); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo $dataModel->pernapasan; ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->spo2_nilai)? MyFormatter::formatNumberForPrint($dataModel->spo2_nilai,2):"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->cairan_jenis)?$dataModel->cairan_jenis:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->jml_tetesan)?$dataModel->jml_tetesan:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->kolf)?$dataModel->kolf:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->jml_urine)?$dataModel->jml_urine:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->bunyijantung_anak)?$dataModel->bunyijantung_anak:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (!empty($dataModel->catatan)?$dataModel->catatan:"-"); ?>
                </td>
                <td valign="top"  class="borderrightclass borderleftclass">
                    <?php echo (isset($dataModel->petugas)?$dataModel->petugas->namaLengkap:"-"); ?>
                </td>
            </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table>
<?php } ?>

<p class="pull-right" style="font-weight: bold">2018-2021</p>