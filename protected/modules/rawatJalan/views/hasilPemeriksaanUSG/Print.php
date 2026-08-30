<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
?>

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

    .tab_header {
        width: 100%;
    }

    .tab_header td {
        vertical-align: top;
    }

     .tab_oa {
        width: 100%;
        border-collapse: collapse;
    }

    .tab_oa th, .tab_oa td {
        border: 1px solid black;
        padding: 2px;
    }

    .tab_layout td {
        vertical-align: top;
    }

    .padding2{
      padding: 2px;
    }

    .font-bold{
        font-weight: bold;
    }
    .infopasienheader{
      font-size: 10pt !important;
    }
    .fa{
      font-size: 12pt;
    }
</style>


<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Hasil Pemeriksaan USG-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');
}
$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

?>
<div class="pull-right" style="font-weight:bold">RM.PP.01a REV 02</div>
<br>
<?php echo $this->renderPartial($this->path_view.'_headerSurat',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
<br/><br/>

<table class="tab_header">
   <tr>
       <td width="200px">Tanggal dan Jam Pemeriksaan</td>
       <td>
           : <?php echo MyFormatter::formatDateTimeForUser($model->tgl_pemeriksaan); ?> WIB
       </td>
   </tr>
   <tr>
       <td>Trimester</td>
       <td>
           : <?php echo CustomFunction::Romawi($model->trimesterkehamilan); ?>
       </td>
   </tr>
   <tr>
       <td>Jumlah Janin</td>
       <td>
           : <?php echo (($model->jumlahjanin_ket=='Lainnya')?$model->jumlahjanin_ket .", ".$model->jumlahjanin : $model->jumlahjanin_ket); ?>
       </td>
   </tr>
</table>
<br/>
<?php
    if(count($modDetail) >0){
        foreach ($modDetail as $i => $detail){
          if ($i > 0){
            echo "<br/>";
          }
        ?>
        <?php if($model->trimesterkehamilan == 1){ ?>
          <fieldset style="border: 1px solid black; padding-left:10px">
            <legend style="color: black; padding-left:5px !important">Hasil Pemeriksaan Janin Ke-<?php echo $detail->janinke; ?></legend>
            <div style="padding: 5px;">
              <table class="tab_header" width="100%">
                 <tr>
                     <td width="200px" class="padding2">1. Kantong Kehamilan</td>
                     <td width="10px" class="padding2">:</td>
                     <td class="padding2">
                         <span class="<?php echo ((!empty($detail->kantongkehamilan) && ($detail->kantongkehamilan=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                         <span class="<?php echo ((!empty($detail->kantongkehamilan) && ($detail->kantongkehamilan=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                     </td>
                 </tr>
                 <tr>
                     <td class="padding2">2. Fetal Echo</td>
                     <td class="padding2">:</td>
                     <td class="padding2">
                       <span class="<?php echo ((!empty($detail->fetalecho) && ($detail->fetalecho=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                       <span class="<?php echo ((!empty($detail->fetalecho) && ($detail->fetalecho=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                     </td>
                 </tr>
                 <tr>
                   <td class="padding2">3. Pulsasi</td>
                   <td class="padding2">:</td>
                     <td class="padding2">
                       <span class="<?php echo ((!empty($detail->pulsasi) && ($detail->pulsasi=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                       <span class="<?php echo ((!empty($detail->pulsasi) && ($detail->pulsasi=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                     </td>
                 </tr>
                 <tr>
                   <td class="padding2">4. Letak Kehamilan</td>
                   <td class="padding2">:</td>
                     <td class="padding2">
                       <span class="<?php echo ((!empty($detail->letakkehamilan) && ($detail->letakkehamilan=='Intra Uteri'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Intra Uteri
                       <span class="<?php echo ((!empty($detail->letakkehamilan) && ($detail->letakkehamilan=='Ektra Uteri'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ektra Uteri
                     </td>
                 </tr>
                 <tr>
                   <td class="padding2" valign="top">5. Biometri</td>
                   <td class="padding2" valign="top">:</td>
                     <td class="padding2">
                       <table width="100%" class="tablefont">
                            <tr>
                                <td width="50px">GS</td>
                                <td width="10px">:</td>
                                <td width="80px">
                                  <?php echo (!empty($detail->biometri_gs)? MyFormatter::formatNumberForPrint($detail->biometri_gs, 2): 0); ?> cm
                                </td>

                                <td width="50px">BPD</td>
                                <td width="10px">:</td>
                                <td>
                                  <?php echo (!empty($detail->biometri_bpd)? MyFormatter::formatNumberForPrint($detail->biometri_bpd, 2): 0); ?> cm
                                </td>
                            </tr>
                            <tr>
                                <td width="50px">CRL</td>
                                <td width="10px">:</td>
                                <td width="80px">
                                  <?php echo (!empty($detail->biometri_crl)? MyFormatter::formatNumberForPrint($detail->biometri_crl, 2): 0); ?> cm
                                </td>

                                <td width="50px">FL</td>
                                <td width="10px">:</td>
                                <td>
                                  <?php echo (!empty($detail->biometri_fl)? MyFormatter::formatNumberForPrint($detail->biometri_fl, 2): 0); ?> cm
                                </td>
                            </tr>
                        </table>
                     </td>
                 </tr>
                 <tr>
                   <td class="padding2">6. Patologi</td>
                   <td class="padding2">:</td>
                     <td class="padding2">
                         <?php echo $detail->patologi; ?>
                     </td>
                 </tr>
              </table>
            </div>
            <table class="tab_header" width="100%">
              <tr>
                <td width="50px" class="padding2" valign="top">
                  Kesimpulan
                </td>
                <td class="padding2">
                : Gravid <?php echo $detail->gravid; ?> minggu, Jantung Janin <?php echo $detail->denyutjantungjanin; ?> kali/menit dan taksiran melahirkan pada <?php echo (!empty($detail->taksiranmelahirkan)? date('d',strtotime($detail->taksiranmelahirkan)).' '.MyFormatter::getMonthId(date('m',strtotime($detail->taksiranmelahirkan))).' '.date('Y',strtotime($detail->taksiranmelahirkan)):""); ?>
                 Secara keseluruhan  <?php echo $detail->kondisijaninkeseluruhan; ?>
                  </td>
              </tr>
             </table>
             <br/>
          </fieldset>
        <?php }else{ ?>
          <fieldset style="border: 1px solid black; padding-left:10px">
            <legend style="color: black; padding-left:5px !important">Hasil Pemeriksaan Janin Ke-<?php echo $detail->janinke; ?></legend>
            <div style="padding: 5px;">
              <table class="tab_header" width="100%">
                <tr>
                    <td width="50%">
                      <table class="tab_header" width="100%">
                        <tr>
                            <td width="200px" class="padding2">1. Presentasi</td>
                            <td width="10px" class="padding2">:</td>
                            <td class="padding2">
                                <?php echo $detail->presentasi_janin; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="padding2">2. Bunyi Jantung</td>
                            <td class="padding2">:</td>
                            <td class="padding2">
                              <span class="<?php echo ((!empty($detail->bunyijantung) && ($detail->bunyijantung=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                              <span class="<?php echo ((!empty($detail->bunyijantung) && ($detail->bunyijantung=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                            </td>
                        </tr>
                        <tr>
                          <td class="padding2">3. Jenis Kelamin</td>
                          <td class="padding2">:</td>
                            <td class="padding2">
                              <?php echo $detail->jeniskelamin; ?>
                            </td>
                        </tr>
                        <tr>
                          <td class="padding2">4. Biometri</td>
                          <td class="padding2">:</td>
                            <td class="padding2">
                              <table width="100%" class="tablefont">
                                   <tr>
                                       <td width="50px">BPD</td>
                                       <td width="10px">:</td>
                                       <td>
                                         <?php echo (!empty($detail->biometri_bpd)? MyFormatter::formatNumberForPrint($detail->biometri_bpd, 2): 0); ?> cm
                                       </td>
                                   </tr>
                                   <tr>
                                       <td width="50px">AC</td>
                                       <td width="10px">:</td>
                                       <td>
                                         <?php echo (!empty($detail->biometri_ac)? MyFormatter::formatNumberForPrint($detail->biometri_ac, 2): 0); ?> cm
                                       </td>
                                   </tr>
                                   <tr>
                                       <td width="50px">FL</td>
                                       <td width="10px">:</td>
                                       <td>
                                          <?php echo (!empty($detail->biometri_fl)? MyFormatter::formatNumberForPrint($detail->biometri_fl, 2): 0); ?> cm
                                       </td>
                                   </tr>
                               </table>
                            </td>
                        </tr>
                        <tr>
                          <td class="padding2" valign="top">5. Taksiran Berat Janin</td>
                          <td class="padding2" valign="top">:</td>
                            <td class="padding2">
                                      <?php echo (!empty($detail->taksiranberatjanin)? MyFormatter::formatNumberForPrint($detail->taksiranberatjanin, 2): 0); ?> gram
                            </td>
                        </tr>
                      </table>
                    </td>
                    <td width="50%">
                      <table class="tab_header" width="100%">
                        <tr>
                            <td width="200px" class="padding2">6. Jumlah Air Ketuban</td>
                            <td width="10px" class="padding2">:</td>
                            <td class="padding2">
                                <span class="<?php echo ((!empty($detail->jml_air_ketuban) && ($detail->jml_air_ketuban=='< 5 cm'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> < 5 cm
                                <span class="<?php echo ((!empty($detail->jml_air_ketuban) && ($detail->jml_air_ketuban=='> 5 cm'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> > 5 cm
                            </td>
                        </tr>
                        <tr>
                            <td class="padding2">7. Insertio Plasenta</td>
                            <td class="padding2">:</td>
                            <td class="padding2">
                              <span class="<?php echo ((!empty($detail->insertio_plasenta) && ($detail->insertio_plasenta=='Karpus'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Karpus
                              <span class="<?php echo ((!empty($detail->insertio_plasenta) && ($detail->insertio_plasenta=='SBR (Segmen Bawah Rahim)'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> SBR (Segmen Bawah Rahim)
                            </td>
                        </tr>
                        <tr>
                          <td class="padding2">8. Tali Pusat</td>
                          <td class="padding2">:</td>
                            <td class="padding2">
                              <?php echo $detail->talipusat; ?>
                            </td>
                        </tr>
                        <tr>
                          <td class="padding2">9. Taksiran Persalinan</td>
                          <td class="padding2">:</td>
                            <td class="padding2">
                              <?php echo (!empty($detail->taksiranmelahirkan)? date('d',strtotime($detail->taksiranmelahirkan)).' '.MyFormatter::getMonthId(date('m',strtotime($detail->taksiranmelahirkan))).' '.date('Y',strtotime($detail->taksiranmelahirkan)):""); ?>
                            </td>
                        </tr>
                        <tr>
                          <td class="padding2" valign="top">10. Patologi</td>
                          <td class="padding2" valign="top">:</td>
                            <td class="padding2">
                              <?php echo $detail->patologi; ?>
                            </td>
                        </tr>
                      </table>
                    </td>
                </tr>
              </table>
            </div>
            <table class="tab_header" width="100%">
              <tr>
                <td width="50px" class="padding2" valign="top">
                  Kesimpulan
                </td>
                <td class="padding2">
                : Gravid <?php echo $detail->gravid; ?> minggu, Jantung Janin <?php echo $detail->denyutjantungjanin; ?> kali/menit dan taksiran melahirkan pada <?php echo (!empty($detail->taksiranmelahirkan)? date('d',strtotime($detail->taksiranmelahirkan)).' '.MyFormatter::getMonthId(date('m',strtotime($detail->taksiranmelahirkan))).' '.date('Y',strtotime($detail->taksiranmelahirkan)):""); ?>
                 Secara keseluruhan  <?php echo $detail->kondisijaninkeseluruhan; ?>
                  </td>
              </tr>
             </table>
             <br/>
          </fieldset>
        <?php } ?>
<?php }
} ?>

<br/><br/>
<table width="100%">
	<tr>
            <td style="width:70%; text-align: left;" colspan="2">
            </td>
            <td style="width:30%; text-align: left;" colspan="2" >
        <center>Lubuk Basung, <?php echo date('d').' '. MyFormatter::getMonthId(date('m')).' '.date('Y'); ?><br />Dokter Pemeriksa
                <br><br><br><br><br><br>
                <?php
                echo $model->dokterpemeriksa->namaLengkap; ?>
                </center>
            </td>
	</tr>
</table>
