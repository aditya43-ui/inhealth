<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<!--KUITANSI -->
<style>
    body {
        letter-spacing: 2px;
    }
    table, td, div{
        font-size: 8pt;
        font-family: Arial;
    }
    .catatan{
        font-size: 8pt;
        text-align: left;
    }
    .uang{
        font-size: 12pt;
        font-weight: bold;
    }
    .terbilang{
        font-style: italic;
    }
    .tandatangan{
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
)); ?>
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
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial($this->path_view."_headerKuitansiKarcis", array());
                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
<?php } ?>

<?php

    $slippage = "No. : ".$modTandaBukti->nobuktibayar;
    $ru = "";
    if (!empty($modPendaftaran->pasienadmisi_id)) $ru = " RAWAT INAP";
    else if (!empty($modPendaftaran->instalasi)) $ru = " ".strtoupper($modPendaftaran->instalasi->instalasi_nama);
    else $ru = empty($modBayar->ruanganpelakhir) ? " " : (" ".strtoupper($modBayar->ruanganpelakhir->instalasi->instalasi_nama));

    $jenis = "";
    if (!empty($modAngsuran)) {
        $jenis = " ANGSURAN ";
    }

?>
<div align="center" class="judulcontent" style="font-size:15pt;font-weight: bold; text-align: center;"><b>KUITANSI<?php echo $jenis; ?></b></div>

<table width="100%" >
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

    

    if (isset($caraPrint)){ ?>

         <TR>
        <TD colspan="3" style="text-align: right !important;">
            <?php echo ((isset($slippage)) ? $slippage : null); ?>
        </TD>
        </TR>
    <?php } $format = new MyFormatter(); ?>
    <tr>
        <td align="center" valig="middle" colspan="3">
            <table align="center" cellspacing=0 width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            
                        </td>
                    </tr>
                    <!--tr>
                        <td width="20%">No. Kuitansi</td>
                        <td width="2%">:</td>
                        <td align="left"><?php echo $modTandaBukti->nobuktibayar;?></td>
                    </tr-->
                        <td width="300px">Sudah Terima Dari</td>
                        <td>:</td>
                        <td style="font-weight: bold;"><?php echo $modTandaBukti->darinama_bkm; ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Terbilang</td>
                        <td>:</td>
                        <td># 
                            <?php
                            $totalBayar = $modTandaBukti->bank_nominal + $modTandaBukti->uangditerima - $modTandaBukti->uangkembalian;
                                if($totalBayar == 0)
                                {
                                    echo '-';
                                }else{
                                    echo ucwords($format->formatNumberTerbilang($totalBayar)) . ' RUPIAH';
                                }
                            ?> #
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran Tagihan Pasien: </td>
                        <td>:</td>
                        <td style="font-weight: bold;"><?php echo $modPasien->nama_pasien;?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?></td>
                        <td style="text-align: right">No. Reg : <?php echo $modPendaftaran->no_pendaftaran; ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Jumlah Uang (Rp)</td>
                        <td>:</td>
                        <td style="font-weight: bold"><?php echo MyFormatter::formatNumberForPrint($totalBayar);?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <?php /*
                    <tr>
                        <td>Poliklinik/Ruangan</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->getRuanganNama($modTandaBukti->pembayaranpelayanan_id);?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?></td>
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
                    </tr> */ ?>
                </tbody>
            </table>
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    
                        <td class="tandatangan" style="text-align: left;">

                            <?php echo Yii::app()->user->getState('kabupaten_nama') ?>,
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
                </tbody>
            </table>

        </td>
    </tr>
    <?php if (!isset($caraPrint)){ ?>
        <tr>
            <td colspan="3" style="border-bottom:1px solid #000000;">&nbsp;</td>
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
