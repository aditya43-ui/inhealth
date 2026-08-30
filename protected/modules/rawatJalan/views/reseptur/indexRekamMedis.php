<!--<legend class="rim2">Reseptur Pasien</legend>-->
<?php
$this->breadcrumbs=array(
	'Reseptur',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<style type="text/css">
	.integer-decimal{
		text-align: right;
	}
    .row{
        margin-bottom: 10px;
    }
</style>
<?php
$dokter = false;
$kelompokpegawai_id = PegawaiM::model()->findByPk(LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id)->kelompokpegawai_id;
if ($kelompokpegawai_id === Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP || Yii::app()->user->id == Params::LOGINPEMAKAI_ID_ADMIN) {
    $dokter = true;

}

// if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_BKIA) {
//     if ($kelompokpegawai_id === Params::KELOMPOKPEGAWAI_ID_BIDAN) { //kelompokpegawai_m bidan
//         $dokter = true;
//     }
// }
$carabayar_id = !empty($modAdmisi) ? $modAdmisi->carabayar_id : $modPendaftaran->carabayar_id;
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjreseptur-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#therapiobat_nama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
             'class'=>'form-iframe'
                             ),
)); 


$sukses = isset($_GET['sukses'])?$_GET['sukses']:'tak de';
echo CHtml::hiddenField('sukses', $sukses);

?>
<div class="row">
    <div class="col-sm-12">
        <?php 
        // if (!empty($this->modSMS)) {
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'list-alergiobat',
                'content' => array(
                    'content-list-alergiobat' => array(
                        'header' => '<b>Riwayat Alergi Obat</b>',
                        'isi' => $this->renderPartial($this->path_view . "_listAlergiObat", array(
                            'modAnamnesa' => $modAnamnesa,
                            'modPasien' => $modPasien
                        ), true),
                        'active' => false,
                    ),
                ),
            ));
        // }
        ?>
    </div>
</div> 

<?php 
$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);
$kelPegawaippds = PpdsM:: model()->findByPk($pegawai->ppds_id);
if ($kelPegawai !== null) {

if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {

    $urlPrintRecordTerakhir=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
    $urlPrintResep=  Yii::app()->createAbsoluteUrl('farmasiApotek/InformasiPasienResep/printResepDokter&id='.$modReseptur->reseptur_id);
    $js = <<< JSCRIPT
    function printRecordTerakhir(caraPrint)
    {
        window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
    function printResep(caraPrint)
    {
        window.open("${urlPrintResep}&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
    JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
    $this->renderPartial($this->path_view.'_jsFunctions', array('modReseptur'=>$modReseptur,'modReseptur'=>$modReseptur));
?>
<div class="row">
    <div class="col-sm-12">
        <?php
        // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-penjualanresep',
            'content' => array(
                'content-list-penjualanresep' => array(
                    'header' => '<b>Riwayat Resep Ditebus Pasien</b>',
                    'isi' => $this->renderPartial($this->path_view . "_gridDaftarPenjualan2", array(
                        'modPenjualanResep' => $modPenjualanResep,
                    ), true),
                    'active' => false,
                ),
            ),
        ));
        // }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php 
        // if (!empty($this->modSMS)) {
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'list-rujukankeluar',
                'content' => array(
                    'content-list-rujukankeluar' => array(
                        'header' => '<b>Riwayat Resep Asli Dokter</b>',
                        'isi' => $this->renderPartial($this->path_view . "_listResep2", array(
                            "modRiwayatResep" => $modRiwayatResep,
                            'modRiwatReseptur' => $modRiwatReseptur,
                            'dokter'=>$dokter,
                        ), true),
                        'active' => true,
                    ),
                ),
            ));
        // }
        ?>
    </div>
</div> 

<?php }else{ ?>


<div class="row">
    <div class="col-sm-12">
        <?php
        // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-penjualanresep',
            'content' => array(
                'content-list-penjualanresep' => array(
                    'header' => '<b>Riwayat Resep Ditebus Pasien</b>',
                    'isi' => $this->renderPartial($this->path_view . "_gridDaftarPenjualan", array(
                        'modPenjualanResep' => $modPenjualanResep,
                    ), true),
                    'active' => false,
                ),
            ),
        ));
        // }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php 
        // if (!empty($this->modSMS)) {
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'list-rujukankeluar',
                'content' => array(
                    'content-list-rujukankeluar' => array(
                        'header' => '<b>Riwayat Resep Asli Dokter</b>',
                        'isi' => $this->renderPartial($this->path_view . "_listResep", array(
                            "modRiwayatResep" => $modRiwayatResep,
                            'modRiwatReseptur' => $modRiwatReseptur,
                            'dokter'=>$dokter,
                        ), true),
                        'active' => true,
                    ),
                ),
            ));
        // }
        ?>
    </div>
</div> 
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Resep</div>
                <div class="panel-title pull-right">
                    <?php echo $form->checkBox($modReseptur, 'kirim_sms_pasien'); ?> <label>Kirim SMS Pasien</label>
                </div>
            </div>
            <div class="panel-body" id="form-dataresep">
                <?php $this->renderPartial($this->path_view.'_formDataResep', array('form'=>$form,'modReseptur'=>$modReseptur,'modPendaftaran'=>$modPendaftaran, 'dokter' => $dokter, 'modRiwayatResepPertama'=>$modRiwayatResepPertama)); ?>
            </div>
        </div>
        <?php 
        // if (!empty($this->modSMS)) {
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'list-riwayatcppt',
                'content' => array(
                    'content-list-riwayatcppt' => array(
                        'header' => '<b>Riwayat CPPT</b>',
                        'isi' => $this->renderPartial($this->path_view . "_listCPPT", array(
                            "modCPPT" => $modCPPT,
                        ), true),
                        'active' => false,
                    ),
                ),
            ));
        // }
        ?>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <div id="judul_racikan" hidden>
                        Data Obat (Racikan)
                    </div>
                    <div id="judul_non_racikan">
                        Data Obat (Non Racikan) <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'terapiobat_reset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk me-refresh form obat non racik')); ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?php
                    if(!isset($_GET['sukses'])){
                        $this->renderPartial($this->path_view.'_formInputObat',array('modPendaftaran'=>$modPendaftaran,'form'=>$form,'modReseptur'=>$modReseptur));
                    }
                ?>
            </div>
        </div>
    </div>
</div> 
<div class="row formInputTab">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <strong>Reseptur</strong></div>
            </div>
            <div class="panel-body table-responsive" style="overflow-x: auto;max-width: 100%">
                <div class="block-tabel">
                    <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                        <thead>
                            <tr>
                                <th>Resep</th>
                                <th>R ke</th>
                                <th>Kode / Nama Obat</th>
                                <!-- <th>Obat Lain</th> -->
                                <th>Jumlah Permintaan</th>
                                <th>Sediaan</th>
                                <th>Permintaan Dosis Racikan</th>
                                <th>Jumlah</th>
                                <th hidden>Harga Satuan (Rp.)</th>
                                <th hidden>Total Embalase (Rp)</th>
                                <th hidden>Biaya Administrasi (Rp.)</th>
                                <th hidden>Total Biaya Administrasi (Rp.)</th>
                                <th hidden>Keringanan (%)</th>
                                <th hidden>Keringanan (Rp.)</th>
                                <th hidden>PPN (%)</th>
                                <th hidden>PPN (Rp.)</th>
                                <th hidden>Subtotal (Rp.)</th>
                                <th>Signa</th>
                                <th>Cara Penggunaan Obat</th>
                                <th>Keterangan</th>
                                <th>Batal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(count((array)$modResepturDetail) > 0){
                                foreach($modResepturDetail AS $i=> $modDetail){
                                    $modDetail->qty_reseptur = is_numeric($modDetail->qty_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->qty_reseptur, 2) : $modDetail->qty_reseptur;
                                    $modDetail->permintaan_dosis = is_numeric($modDetail->permintaan_dosis) ? MyFormatter::formatNumberForPrint($modDetail->permintaan_dosis, 2) : $modDetail->permintaan_dosis;
                                    $modDetail->hargasatuan_reseptur = is_numeric($modDetail->hargasatuan_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargasatuan_reseptur, 2) : $modDetail->hargasatuan_reseptur;
                                    $modDetail->hargajual_reseptur = is_numeric($modDetail->hargajual_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargajual_reseptur, 2) : $modDetail->hargajual_reseptur;
                                    if ($modDetail->is_permitaandosispecahan == true) {
                                        $modDetail->permintaan_temp = $modDetail->permintaandosis_pembilang . " / " . $modDetail->permintaandosis_penyebut;
                                    } else {
                                        $modDetail->permintaan_temp = $modDetail->permintaan_reseptur;
                                    }
                                    
                                    echo $this->renderPartial($this->path_view.'_rowDetail',array('modResepturDetail'=> $modDetail));
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot hidden>
                            <tr>
								<td colspan="6" style="text-align: right;"><b>Jasa Pelayanan Farmasi</b></td>
								<td><?php echo $form->textField($modReseptur, 'jasapelayanan_farmasi', array('class' => 'span2 integer-decimal', 'readonly' => false, 'onkeyup' => 'hitungTotal(this);')); ?></td>
								<td colspan="6"></td>
							</tr>
                            <tr>
                                <td colspan="6" style="text-align: right;"><b>Total</b></td>
                                <td><?php echo CHtml::textfield('totalHargaReseptur',0,array('class'=>'span2 integer-decimal','readonly'=>true)); ?></td>
                                <td colspan="6"></td>
                            </tr>
                    </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
        $content = $this->renderPartial($this->path_view.'tips/tipsReseptur',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>
<?php } ?>
<?php }else{?>
   <?php if ((!empty($kelPegawaippds->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {

$urlPrintRecordTerakhir=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
$urlPrintResep=  Yii::app()->createAbsoluteUrl('farmasiApotek/InformasiPasienResep/printResepDokter&id='.$modReseptur->reseptur_id);
$js = <<< JSCRIPT
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printResep(caraPrint)
{
    window.open("${urlPrintResep}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
$this->renderPartial($this->path_view.'_jsFunctions', array('modReseptur'=>$modReseptur,'modReseptur'=>$modReseptur));
?>
<div class="row">
<div class="col-sm-12">
    <?php
    // if (!empty($this->modSMS)) {
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'list-penjualanresep',
        'content' => array(
            'content-list-penjualanresep' => array(
                'header' => '<b>Riwayat Resep Ditebus Pasien</b>',
                'isi' => $this->renderPartial($this->path_view . "_gridDaftarPenjualan2", array(
                    'modPenjualanResep' => $modPenjualanResep,
                ), true),
                'active' => false,
            ),
        ),
    ));
    // }
    ?>
</div>
</div>
<div class="row">
<div class="col-sm-12">
    <?php 
    // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-rujukankeluar',
            'content' => array(
                'content-list-rujukankeluar' => array(
                    'header' => '<b>Riwayat Resep Asli Dokter</b>',
                    'isi' => $this->renderPartial($this->path_view . "_listResep2", array(
                        "modRiwayatResep" => $modRiwayatResep,
                        'modRiwatReseptur' => $modRiwatReseptur,
                        'dokter'=>$dokter,
                    ), true),
                    'active' => true,
                ),
            ),
        ));
    // }
    ?>
</div>
</div> 

<?php }else{ ?>


<div class="row">
<div class="col-sm-12">
    <?php
    // if (!empty($this->modSMS)) {
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'list-penjualanresep',
        'content' => array(
            'content-list-penjualanresep' => array(
                'header' => '<b>Riwayat Resep Ditebus Pasien</b>',
                'isi' => $this->renderPartial($this->path_view . "_gridDaftarPenjualan", array(
                    'modPenjualanResep' => $modPenjualanResep,
                ), true),
                'active' => false,
            ),
        ),
    ));
    // }
    ?>
</div>
</div>
<div class="row">
<div class="col-sm-12">
    <?php 
    // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-rujukankeluar',
            'content' => array(
                'content-list-rujukankeluar' => array(
                    'header' => '<b>Riwayat Resep Asli Dokter</b>',
                    'isi' => $this->renderPartial($this->path_view . "_listResep", array(
                        "modRiwayatResep" => $modRiwayatResep,
                        'modRiwatReseptur' => $modRiwatReseptur,
                        'dokter'=>$dokter,
                    ), true),
                    'active' => true,
                ),
            ),
        ));
    // }
    ?>
</div>
</div> 
<div class="row">
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data Resep</div>
            <div class="panel-title pull-right">
                <?php echo $form->checkBox($modReseptur, 'kirim_sms_pasien'); ?> <label>Kirim SMS Pasien</label>
            </div>
        </div>
        <div class="panel-body" id="form-dataresep">
            <?php $this->renderPartial($this->path_view.'_formDataResep', array('form'=>$form,'modReseptur'=>$modReseptur,'modPendaftaran'=>$modPendaftaran, 'dokter' => $dokter, 'modRiwayatResepPertama'=>$modRiwayatResepPertama)); ?>
        </div>
    </div>
    <?php 
    // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-riwayatcppt',
            'content' => array(
                'content-list-riwayatcppt' => array(
                    'header' => '<b>Riwayat CPPT</b>',
                    'isi' => $this->renderPartial($this->path_view . "_listCPPT", array(
                        "modCPPT" => $modCPPT,
                    ), true),
                    'active' => false,
                ),
            ),
        ));
    // }
    ?>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <div id="judul_racikan" hidden>
                    Data Obat (Racikan)
                </div>
                <div id="judul_non_racikan">
                    Data Obat (Non Racikan) <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'terapiobat_reset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk me-refresh form obat non racik')); ?>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?php
                if(!isset($_GET['sukses'])){
                    $this->renderPartial($this->path_view.'_formInputObat',array('modPendaftaran'=>$modPendaftaran,'form'=>$form,'modReseptur'=>$modReseptur));
                }
            ?>
        </div>
    </div>
</div>
</div> 
<div class="row formInputTab">
<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Tabel <strong>Reseptur</strong></div>
        </div>
        <div class="panel-body table-responsive" style="overflow-x: auto;max-width: 100%">
            <div class="block-tabel">
                <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                    <thead>
                        <tr>
                            <th>Resep</th>
                            <th>R ke</th>
                            <th>Kode / Nama Obat</th>
                            <th>Obat Lain</th>
                            <th>Permintaan Dosis Racikan</th>
                            <th>Jumlah</th>
                            <th hidden>Harga Satuan (Rp.)</th>
                            <th hidden>Total Embalase (Rp)</th>
                            <th hidden>Biaya Administrasi (Rp.)</th>
                            <th hidden>Total Biaya Administrasi (Rp.)</th>
                            <th hidden>Keringanan (%)</th>
                            <th hidden>Keringanan (Rp.)</th>
                            <th hidden>PPN (%)</th>
                            <th hidden>PPN (Rp.)</th>
                            <th hidden>Subtotal (Rp.)</th>
                            <th>Signa</th>
                            <th>Cara Penggunaan Obat</th>
                            <th>Sediaan</th>
                            <th>Keterangan</th>
                            <th>Batal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(count((array)$modResepturDetail) > 0){
                            foreach($modResepturDetail AS $i=> $modDetail){
                                $modDetail->qty_reseptur = is_numeric($modDetail->qty_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->qty_reseptur, 2) : $modDetail->qty_reseptur;
                                $modDetail->permintaan_dosis = is_numeric($modDetail->permintaan_dosis) ? MyFormatter::formatNumberForPrint($modDetail->permintaan_dosis, 2) : $modDetail->permintaan_dosis;
                                $modDetail->hargasatuan_reseptur = is_numeric($modDetail->hargasatuan_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargasatuan_reseptur, 2) : $modDetail->hargasatuan_reseptur;
                                $modDetail->hargajual_reseptur = is_numeric($modDetail->hargajual_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargajual_reseptur, 2) : $modDetail->hargajual_reseptur;
                                if ($modDetail->is_permitaandosispecahan == true) {
                                    $modDetail->permintaan_temp = $modDetail->permintaandosis_pembilang . " / " . $modDetail->permintaandosis_penyebut;
                                } else {
                                    $modDetail->permintaan_temp = $modDetail->permintaan_reseptur;
                                }
                                
                                echo $this->renderPartial($this->path_view.'_rowDetail',array('modResepturDetail'=> $modDetail));
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot hidden>
                        <tr>
                            <td colspan="6" style="text-align: right;"><b>Jasa Pelayanan Farmasi</b></td>
                            <td><?php echo $form->textField($modReseptur, 'jasapelayanan_farmasi', array('class' => 'span2 integer-decimal', 'readonly' => false, 'onkeyup' => 'hitungTotal(this);')); ?></td>
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align: right;"><b>Total</b></td>
                            <td><?php echo CHtml::textfield('totalHargaReseptur',0,array('class'=>'span2 integer-decimal','readonly'=>true)); ?></td>
                            <td colspan="6"></td>
                        </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<div class="form-actions">
<?php
    $disableSave = false;
    $disableSave = (!empty($_GET['sukses'])) ? true : false;
?>
<?php $disablePrint = ($disableSave) ? false : true; ?>
<?php
    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();','disabled'=>$disableSave,'id'=>'btn_submit')); //formSubmit(this,event)
?>
<?php if(!isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
    $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
    array('class'=>'btn btn-default',
        'onclick'=>'return refreshForm(this);'));
} ?>
<?php
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'printRecordTerakhir(\'PRINT\')')).'&nbsp';
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print Resep',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'printResep(\'PRINT\')'));
?>
<?php
    $content = $this->renderPartial($this->path_view.'tips/tipsReseptur',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
?>
</div>
<?php } ?>

<?php }?>

<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPenjualan',
    'options' => array(
        'title' => 'Detail Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 800,
        'resizable' => false,
        'position' => 'top',
    ),
));

echo '<div id="contentDetailPenjualan"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailresep',
    'options'=>array(
        'title'=>'Detail Reseptur',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailResep"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
$urlPrintRecordTerakhir=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
$urlPrintResep=  Yii::app()->createAbsoluteUrl('farmasiApotek/InformasiPasienResep/printResepDokter&id='.$modReseptur->reseptur_id);
$js = <<< JSCRIPT
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printResep(caraPrint)
{
    window.open("${urlPrintResep}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>

<script type="text/javascript">
	function viewDetailResep(idReseptur,pendaftaran_id)
	{

	$.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {idReseptur: idReseptur, pendaftaran_id: pendaftaran_id}, function(data){
			$('#contentDetailResep').html(data.result);
		}, 'json');
		$('#dialogDetailresep').dialog('open');
	}

    $(document).ready(function(){
        // Notifikasi Pasien
        <?php
            if(isset($_GET['smspasien'])){
                if($_GET['smspasien']==0){
        ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16
            insert_notifikasi(params);
        <?php
                }
            }
        ?>

    <?php if ($dokter == false) { ?>
            $("#field-paketobat :input").attr("readonly", true);
            $("#field-paketobat .add-on").remove();
            $("#field-paketobat .icon-remove").remove();
        <?php } ?>
    });

    function viewDetailPenjualan(idPenjualan, pendaftaran_id) {

        $.post('<?php echo $this->createUrl('ajaxDetailPenjualan') ?>', {
            idPenjualan: idPenjualan,
            pendaftaran_id: pendaftaran_id
        }, function(data) {
            $('#contentDetailPenjualan').html(data.result);
        }, 'json');
        $('#dialogDetailPenjualan').dialog('open');
    }

    function viewDetailResep(idReseptur, pendaftaran_id) {

        $.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {
            idReseptur: idReseptur,
            pendaftaran_id: pendaftaran_id
        }, function(data) {
            $('#contentDetailResep').html(data.result);
        }, 'json');
        $('#dialogDetailresep').dialog('open');
    }
</script>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modReseptur'=>$modReseptur,'modReseptur'=>$modReseptur)); ?>
