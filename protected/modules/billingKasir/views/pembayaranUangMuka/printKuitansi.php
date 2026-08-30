<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<!--KUITANSI -->
<style>
body {
    letter-spacing: 2px;
}

table,
td,
div {
    font-size: 8pt;
    font-family: Arial;
    vertical-align: top;
}

.catatan {
    font-size: 8pt;
    text-align: left;
}

.uang {
    font-size: 12pt;
    font-weight: bold;
}

.terbilang {
    font-style: italic;
}

.tandatangan {
    text-align: center;
    vertical-align: top;
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
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'pembayaran-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#TandabuktibayarT_darinama_bkm'
)); 

$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

// echo '<pre>'; var_dump($modBayar->attributes); die;

?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<!-- <table class="table table-condensed">
    <tr>
        <td>
            <div class="control-group">
                <label class="control-label">Ubah <?php echo $form->labelEx($modTandaBukti,'darinama_bkm'); ?></label>
                <div class="controls">
                    <?php echo $form->textField($modTandaBukti,'darinama_bkm',array('class'=>'span3', 'title'=>'Tekan tombol Enter untuk melakukan perubahan data')); ?>
                </div>
            </div>
        </td>
    </tr>
</table> -->
<?php $this->endWidget(); ?>
<?php  if(isset($caraPrint)){ ?>
<table width="100%">
    <thead style="height: 75px;">
        <tr>
            <td>
                <table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers table-header hide">

                    <!--<TD width="15%" height="50%">-->
                    <TR>
                        <TD WIDTH="35%" ALIGN="CENTER" VALIGN="MIDDLE">
                        <div align="center" class="nama_profil" style="color: black !important; font-weight: bold; font-size: 12pt;">
                                RSUD Dr. Saiful Anwar Malang<br>Jl. Jaksa Agung Suprapto No. 2 Malang
                            </div>
                        </TD>
                        <TD WIDTH="30%" align="center" style="text-align:center;">
                        <div align="center" style="font-weight: bolder; font-size: 18pt;">
                            KWITANSI
                        </div>
                        </TD>
                        <?php //if (file_exists($path2)): ?>
                        <TD WIDTH="35%" ALIGN="CENTER" VALIGN="MIDDLE">
                            <!-- <img src="<?php //echo $res2 ?> "  class='image_report' style="float:left; max-width: 100px; width:100px;" class='image_report'> -->
                        </TD>
                        <?php //endif; ?>
                    </TR>
                    <tr>
                        <td colspan="3" style="border-top: 1px solid black;"></td>
                    </tr>
                    <TR>
                        <TD ALIGN=CENTER VALIGN=MIDDLE class="" colspan="3">
                            <div align="center">
                                <h3><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h3>
                            </div>
                        </TD>
                    </TR>
                    <TR>
                        <TD ALIGN=CENTER VALIGN=MIDDLE class="" colspan="3">
                            <div align="center">
                                <font color="black"><?php echo (isset($periode) ? $periode : '') ?></font>
                            </div>
                        </TD>
                    </TR>

                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <?php } ?>

                    <table width="100%">
                        <?php

    //pembulatan
    $jmlpembulatan = $modTandaBukti->jmlpembulatan;
    /*
    if ($modTandaBukti->jmlpembulatan != 0) {
        $konfig_pembulatan = Yii::app()->user->getState('pembulatanhargakasir');
        if($konfig_pembulatan > 0){
            $jmlpembulatan = $konfig_pembulatan - (($modTandaBukti->jmlpembayaran) % $konfig_pembulatan);
            if($konfig_pembulatan == $jmlpembulatan){
                $jmlpembulatan = 0;
            }
        }
    }
     *
     */

    $nobuktibayar = $modBayar->nouangmuka;
    if(!empty($nobuktibayar)) {
        $nobuktibayar = substr($nobuktibayar, 9, 5);
    }
    $slippage = "No Bukti Pembayaran Uang Muka : ".$nobuktibayar;
    $ru = "";
    if (!empty($modPendaftaran->pasienadmisi_id)) $ru = " RAWAT INAP";
    else if (!empty($modPendaftaran->instalasi)) $ru = " ".strtoupper($modPendaftaran->instalasi->instalasi_nama);
    else $ru = empty($modBayar->ruanganpelakhir) ? " " : (" ".strtoupper($modBayar->ruanganpelakhir->instalasi->instalasi_nama));

    $jenis = "";
    if (!empty($modAngsuran)) {
        $jenis = " ANGSURAN ";
    }

    if (isset($caraPrint)){ ?>

                        <TR>
                            <TD colspan="3"
                                style="font-size: 12pt !important; border-bottom: 1px solid white; text-align: center !important;">
                                <?php echo ((isset($slippage)) ? $slippage : null); ?>
                            </TD>
                        </TR>
                        <?php } $format = new MyFormatter(); ?>
                        <tr>
                            <td align="center" valig="middle" colspan="3">
                                <table align="center" cellspacing=0 width="100%" class="tab_kuitansi">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" align="center">
                                                <div align="center" class="judulcontent"
                                                    style="font-size:15pt;text-decoration: underline;"><br>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                        // var_dump($modTandaBukti->attributes); die;
                                        $bayar_td = $modTandaBukti->sebagaipembayaran_bkm;

                                        /*
                                        if(!empty($modAlokasiDet)) {
                                            if(count($modAlokasiDet) > 1) {
                                                $bayar_td = $modAlokasiDet[0]->daftartindakan->daftartindakan_nama . ', DLL';
                                            } else {
                                                $bayar_td = $modAlokasiDet[0]->daftartindakan->daftartindakan_nama;
                                            }
                                        }
                                        */
                                        ?>
                                        <!--tr>
                        <td width="20%">No. Kuitansi</td>
                        <td width="2%">:</td>
                        <td align="left"><?php echo $modTandaBukti->nobuktibayar;?></td>
                    </tr-->
                                        <tr>
                                            <td>Sudah Terima Dari</td>
                                            <td>:</td>
                                            <td><?php echo $modTandaBukti->darinama_bkm;?></td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Uang</td>
                                            <td>:</td>
                                            <td class="terbilang">
                                                <?php
                            $totalBayar = $modTandaBukti->bank_nominal + $modTandaBukti->uangditerima - $modTandaBukti->uangkembalian;
                                if($totalBayar == 0)
                                {
                                    echo '-';
                                }else{

                                    echo 'Rp. ' . strtoupper($format->formatNumberForPrint($totalBayar, 2));
                                }
                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dengan Huruf<br/>&nbsp;</td>
                                            <td>:</td>
                                            <td class="terbilang">
                                                <?php
                                if($totalBayar == 0)
                                {
                                    echo '-';
                                }else{

                                    echo strtoupper($format->formatNumberTerbilang($totalBayar)) . ' RUPIAH';
                                }
                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Untuk Pembayaran<br/>&nbsp;</td>
                                            <td>:</td>
                                            <td><?php echo $bayar_td;?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Pasien</td>
                                            <td>:</td>
                                            <td><?php echo $modPendaftaran->pasien->nama_pasien;?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>No. RM / No. Billing</td>
                                            <td>:</td>
                                            <td><?php echo $modPendaftaran->pasien->no_rekam_medik;?> /
                                                <?php echo $modPendaftaran->no_pendaftaran;?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?>
                                            </td>
                                        </tr>

                                        <?php /*
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->pasien->nama_pasien; ?> - No.
                                        RM :
                                        <?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->pasien->no_rekam_medik ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Penjamin</td>
                            <td>:</td>
                            <td><?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->carabayar->carabayar_nama; ?>
                                - Penjamin :
                                <?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->penjamin->penjamin_nama ?>
                            </td>
                        </tr> */ ?>
    </tbody>
</table>
<table frame=void align=left cellspacing=0 cols=11 rules=none border=2 width="100%">
    <tbody>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="60%" align="center">
                <div align="center">
                    <br>
                    <div align="center" style="border:1px solid #000000;width:200px;padding:5px;" class="uang hide">
                        Rp. <?php echo MyFormatter::formatNumberForPrint($totalBayar,2);?>,-
                    </div>
                    <!-- <br> -->

                </div>
            </td>
            <td class="tandatangan">
            </td>
        </tr>
        <tr>
            <td width="60%" align="center" valign="top">
                <div colspan="2" class="catatan">
                    <!-- <table>
                                  <tr>
                                      <td>LEMBAR I </td>
                                      <td>: Pasien</td>
                                  </tr>
                                  <tr>
                                      <td>LEMBAR II </td>
                                      <td>: Ruangan</td>
                                  </tr>
                                  <tr>
                                      <td>LEMBAR III </td>
                                      <td>: Arsip Keuangan</td>
                                  </tr>
                              </table> -->
                    <!--
                              Catatan : untuk pembayaran melalui Cheque / Bilyet Giro (BG)<br>
                              Belum dianggap lunas apabila Cheque/Bilyet Giro (BG) Belum Diuangkan<br>
                              <i>*Kuitansi ini sah bila ada tandatangan petugas dan cap <?php //echo $data->nama_rumahsakit; ?>*</i>
                              -->
                </div>
            </td>
            <td class="tandatangan">

                <?php echo 'MALANG' ?>,
                <?php
                                $format = new MyFormatter();
                                $tgl = $modTandaBukti->tglbuktibayar;
                                $tglBayar = explode(" ",$tgl);
                                $tanggal = date('Y-m-d'); //$tglBayar[0];
								$tgls = Myformatter::formatDateTimeId($tanggal);
								echo $tgls;
                            ?>

                <br>
                Petugas Kasir,<br><br><br><br>
                <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                <b><?php echo empty($pegawai)?"-":$pegawai->nama_pegawai; ?></b>



            </td>
        </tr>
        <tr hidden>
            <td colspan="2">
                Kwitansi ini menjadi sah bila diberi cap dan tanda tangan petugas
            </td>
        </tr>
    </tbody>
</table>

</td>
</tr>
<?php if (!isset($caraPrint)){ ?>
<tr>
    <td colspan="3" style="border-bottom:1px solid white;">&nbsp;</td>
</tr>
<tr>
    <td colspan="3">Printed at <?php echo date("d/m/y h:m:s");?></td>
</tr>
<?php } ?>
</table>
<?php if (isset($caraPrint)) { ?>
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
    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php  }else{
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
//      echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp";
//      echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp";

//      $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printKuitansi');
        $urlUpdateDN=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/updateDN');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$idTandaBuktiBayar = $modBayar->tandabuktibayar_id;
$idPasienadmisi = ((isset($modBayar->pasienadmisi_id)) ? $modBayar->pasienadmisi_id : null);
$idPembayaranPelayanan = $modBayar->pembayaranpelayanan_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    var dariNamaBKM = $('#TandabuktibayarT_darinama_bkm').val();
    var urlUpdateDN = '${urlUpdateDN}&tandabuktibayar_id='+${idTandaBuktiBayar}+'&darinama_bkm='+dariNamaBKM;
    $.post(urlUpdateDN, {tandabuktibayar_id: ${idTandaBuktiBayar}, darinama_bkm:dariNamaBKM}, "json");

    window.open("${urlPrint}&pembayaranpelayanan_id=${idPembayaranPelayanan}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
}?>