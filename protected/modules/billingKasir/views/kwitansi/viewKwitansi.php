<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<!--KUITANSI-->
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
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'pembayaran-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#TandabuktibayarT_darinama_bkm'
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<!--<table class="table table-condensed">
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
</table>-->
<?php $this->endWidget(); ?>

<table style="width: 100%; border: none;">
        <tr>
            <td colspan="3">
                <?php 
                $ru = "";
                if (!empty($modPendaftaran->pasienadmisi_id)) $ru = " RAWAT INAP";
                else $ru = " ".strtoupper($modPendaftaran->instalasi->instalasi_nama);
                $slippage = "No Kuitansi : ".$modTandaBukti->nobuktibayar;
                echo $this->renderPartial('application.views.headerReport.headerDefaultKwitansi', array('noKwitansi'=>$slippage)); ?>
            </td>
        </tr>
    <tr>
        <td align="center" valign="middle" colspan="3">
            <table align="center" cellspacing=0 width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            <div align="center" style="font-size:15pt;text-decoration: underline;"><b>KUITANSI<?php echo $ru; ?></b></div>
                        </td>
                    </tr> 
                    <?php /*
                    <tr>
                        <td width="20%">No. Kuitansi</td>
                        <td width="2%">:</td>
                        <td align="left"><?php echo $modTandaBukti->nobuktibayar;?></td>
                    </tr>
                     * 
                     */ ?>
                    <tr>
                        <td>Sudah Terima Dari</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->darinama_bkm;?></td>
                    </tr>
                    <tr>
                        <td>Uang Sejumlah</td>
                        <td>:</td>
                        <td class="terbilang">
                            <?php
                                if($modTandaBukti->jmlpembayaran == 0)
                                {
                                    echo '-';
                                }else{
                                    echo strtoupper($format->formatNumberTerbilang($modTandaBukti->jmlpembayaran)) . ' RUPIAH';
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->sebagaipembayaran_bkm;?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?></td>
                    </tr>
                    <tr>
                        <td>Poliklinik</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->getRuanganNama($modTandaBukti->pembayaranpelayanan_id);?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?></td>
                    </tr>
                    <?php /*
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->pasien->nama_pasien; ?> - No. RM : <?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->pasien->no_rekam_medik ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Penjamin</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->carabayar->carabayar_nama; ?> - Penjamin : <?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->penjamin->penjamin_nama ?></td>
                    </tr>
                     * 
                     */ ?>
                </tbody>
            </table>
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="60%" align="center">
                            <div style="text-align: center;">
                                <br>
                                <div align="center" style="border:1px solid #000000;width:200px;padding:5px;" class="uang">
                                    Rp <?php echo number_format($modTandaBukti->jmlpembayaran,0,'','.');?>,-
                                </div>
                                <br>
                                <div colspan="2" class="catatan">
                                    LEMBAR I : Pasien<br>
                                    LEMBAR II : Ruangan<br>
                                    LEMBAR III : Arsip Keuangan<br>
                                    <!--
                                    Catatan : untuk pembayaran melalui Cheque / Bilyet Giro (BG)<br>
                                    Belum dianggap lunas apabila Cheque/Bilyet Giro (BG) Belum Diuangkan<br>
                                    <i>*Kuitansi ini sah bila ada tandatangan petugas dan cap <?php echo $data->nama_rumahsakit; ?>*</i>
-->
                                    
                                </div>
                            </div>
                        </td>
                        <td class="tandatangan">

                            <?php echo Yii::app()->user->getState('kecamatan_nama') ?>, 
                            <?php 
	                            echo $format->formatDateTimeId(date('Y-m-d H:i:s'));

                            ?>
                           
                            <br>
                            Petugas Kasir,<br><br><br><br>                           
                            <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                            <b><?php echo empty($pegawai)?"-":$pegawai->nama_pegawai; ?></b><br>
                            <b style="border-top: 1px solid black;">NIP. <?php echo empty($pegawai)?"-":$pegawai->nomorindukpegawai; ?></b>
                               
                            
                            <?php echo CHtml::hiddenField('isprint',$modTandaBukti->isprint); ?>
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
<!--Penambahan Hak akses print RND-3962-->
<?php if (isset($caraPrint)) { ?>
<?php  }else{
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'cekHakPrint('.$modTandaBukti->tandabuktibayar_id.')')); 

        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printKwitansi');
        $urlUpdateDN=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/updateDN');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$idTandaBuktiBayar = $modBayar->tandabuktibayar_id;
$idPasienadmisi = ((isset($modBayar->pasienadmisi_id)) ? $modBayar->pasienadmisi_id : null);
$idPembayaranPelayanan = $modBayar->pembayaranpelayanan_id;
$js = <<< JSCRIPT
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
}?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'loginDialog',
    'options'=>array(
        'title'=>'Login',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>400,
        'height'=>190,
        'resizable'=>false,
    ),
));?>
<?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal','id'=>'formLogin')); ?>
    <div class="control-group">
        <?php echo CHtml::label('Login Pemakai','username', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('username', '', array()); ?>
            <?php echo CHtml::hiddenField('tandabuktibayar_id', '', array()); ?> 
            <?php echo CHtml::hiddenField('pembayaranpelayanan_id', '', array()); ?> 
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label('Password','password', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::passwordField('password', '', array()); ?>
        </div>
    </div>
    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Login',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                            array('class' => 'btn btn-danger', 'type'=>'submit', 'onclick'=>'cekLogin();return false;')); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}'=>'<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default','onclick'=>"$('#loginDialog').dialog('close');return false",'disabled'=>false)); ?>
    </div> 
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget();?>
<script>
function cekHakPrint(tandabuktibayar_id)
{//function untuk hak akses print RND-3962
    var isprint = $('#isprint').val();
    var caraPrint = 'PRINT';
    
    if (isprint==1){   
        $.post('<?php echo $this->createUrl('CekHakPrint');?>', {tandabuktibayar_id:tandabuktibayar_id}, function(data){
    
            if(data.isprint==true && data.cekAkses==true){
                window.open("<?php echo $this->createAbsoluteUrl('printKwitansi');?>&idPembayaranPelayanan=<?php echo $modBayar->pembayaranpelayanan_id;?>&caraPrint="+caraPrint,"",'location=_new, width=1100px'); 
            }else{
                myAlert('Aksi print kuitansi perlu hak akses khusus, silakan login terlebih dahulu!');
                $('#loginDialog').dialog('open');  
                $('#tandabuktibayar_id').val(tandabuktibayar_id);
                $('#pembayaranpelayanan_id').val(pembayaranpelayanan_id);
            }
        }, 'json');
    }else{
         $.post('<?php echo $this->createUrl('CekHakPrint');?>', {tandabuktibayar_id:tandabuktibayar_id}, function(data){   
            if(data.isprint==true && data.cekAkses==true){
                window.open("<?php echo $this->createAbsoluteUrl('printKwitansi');?>&idPembayaranPelayanan=<?php echo $modBayar->pembayaranpelayanan_id;?>&caraPrint="+caraPrint,"",'location=_new, width=1100px'); 
            }else{
                myAlert('Aksi print kuitansi perlu hak akses khusus, silakan login terlebih dahulu!');
                $('#loginDialog').dialog('open');  
                $('#tandabuktibayar_id').val(tandabuktibayar_id);
                $('#pembayaranpelayanan_id').val(pembayaranpelayanan_id);
            }
        }, 'json');
    }
}

function cekLogin()
{
    var caraPrint = 'PRINT';
    $.post('<?php echo $this->createUrl('CekLoginHakPrint');?>', $('#formLogin').serialize(), function(data){
        if(data.error != '')
            myAlert(data.error);
        $('#'+data.cssError).addClass('error');
        if(data.status=='success'){

        window.open("<?php echo $this->createAbsoluteUrl('printKwitansi');?>&idPembayaranPelayanan=<?php echo $modBayar->pembayaranpelayanan_id;?>&caraPrint="+caraPrint,"",'location=_new, width=1100px'); 
        $('#loginDialog').dialog('close');
            return true;
        }else{
            myAlert(data.status);
        }
    }, 'json');
}

</script>