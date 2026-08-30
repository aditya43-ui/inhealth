<style>
    table{
        font-size: 11px;
    }
</style>
<?php 
$format = new MyFormatter();
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
    <tr>
        <td colspan="3">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefaultLab'); ?>
        </td><br/><br/>
    </tr>
</table>
<div align="center"><b>KWITANSI</b></div> <br/>
            <table align="center" cellspacing=0 width="100%">
              
                    <tr>
                        <td width="15%"> Nama Pasien</td>
                        <td width="2%" align="center">:</td>
                        <td align="left" colspan='4'><?php echo $modTandaBukti->pembayaran->pendaftaran->pasien->nama_pasien; ?></td>
                    </tr>
                    <tr>
                        <td> Alamat</td>
                        <td  align="center">:</td>
                        <td><?php echo $modTandaBukti->pembayaran->pendaftaran->pasien->alamat_pasien; ?></td>
                        <td> No. Lab</td>
                        <td  align="center">:</td>
                        <td><?php echo $modTandaBukti->pembayaran->pendaftaran->no_pendaftaran; ?></td>
                    </tr>
                    <tr>
                        <td> Umur</td>
                        <td  align="center">:</td>
                        <td><?php echo $modTandaBukti->pembayaran->pendaftaran->umur; ;?></td>
                        <td> Tgl. Pembayaran</td>
                        <td  align="center">:</td>
                        <td><?php echo $modTandaBukti->pembayaran->tglpembayaran; ;?></td>
                    </tr>
            </table><br/>
            <table align="center" cellspacing=0 width="100%">
                <tr>
                    <td width="15%"> Sudah Terima Dari</td>
                    <td width="2%">:</td>
                    <td align="left"><?php echo $modTandaBukti->darinama_bkm;?></td>
                </tr>
                <tr>
                    <td> Banyak Uang</td>
                    <td>:</td>
                    <td><?php echo $format->formatNumberTerbilang($modTandaBukti->jmlpembayaran);?></td>
                </tr>
                <tr>
                    <td> Untuk Pembayaran</td>
                    <td>:</td>
                    <td><?php echo $modTandaBukti->sebagaipembayaran_bkm;?></td>
                </tr>
            </table><br/>
            <table frame="void" align="left" cellspacing="0" cols="11" rules="none" border="0" width="100%">
                    <tr>
                        <td width="50%" align="center">
                            <div align="center">
                                <div align="center" style="border:0px solid #000000;width:200px;padding:10px;float:left;margin-left:-35px;">
                                    <b>Jumlah Rp <?php echo number_format($modTandaBukti->jmlpembayaran,0,'','.');?></b>
                                </div>                                
                            </div>
                        </td>
                        <td align="center" width="30%">
                            <div align="center">
                                <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".$modTandaBukti->tglbuktibayar;?></div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>
                                    <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                                    <b>(<?php echo $pegawai->nama_pegawai; ?>)</b>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-bottom:1px solid #000000;border-bottom-style:dotted">&nbsp;</td>
                    </tr>     
            </table>

<?php if (isset($caraPrint)) { ?>
<?php  }else{

        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//      $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printKwitansi');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$idPasienadmisi = ((isset($modBayar->pasienadmisi_id)) ? $modBayar->pasienadmisi_id : null);
$idPembayaranPelayanan = $modBayar->pembayaranpelayanan_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&pendaftaran_id=${pendaftaran_id}&idPasienadmisi=${idPasienadmisi}&idPembayaranPelayanan=${idPembayaranPelayanan}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
}?>
