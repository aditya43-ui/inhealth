<style type="text/css">
    .nav-tabs>.active>a,
    .nav-tabs>.active>a:hover,
    .nav-tabs>li>a {
        cursor: pointer;
    }

    .integer {
        text-align: right;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>
<?php
$this->breadcrumbs = array(
    'Laboratorium',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'currency' => 'PHP',
    'config' => array(
        'symbol' => 'Rp ',
        //        'showSymbol'=>true,
        //        'symbolStay'=>true,
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '.',
        'precision' => 0,
    )
));

$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.number',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '.',
        'precision' => 0,
    )
));
?>

<!--<legend class="rim2">Laboratorium</legend>-->
<?php
//$modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS; //sudah dideklarasikan di controller
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-laboratorium-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id'),
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
    //'onsubmit'=>'cekInput();'
    ),
        //'onsubmit'=>'return requiredCheck(this);'),
        ));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Laboratorium Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div class="block-tabel">
            <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
        </div>
    </div>
</div>
<br/>
<style>
    input {
        font-family: FontAwesome;
    }

    #cari_modul{
        font-family: FontAwesome !important;
    }
</style>


<div class="antirow">

    <div class="row">
        <?php echo $form->errorSummary($modKirimKeUnitLain); ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
        

        $sukses = isset($_GET['sukses'])?$_GET['sukses']:'';
        echo CHtml::hiddenField('sukses', $sukses);
        
        ?></p>-->
        <span hidden><?php echo $form->dropDownListRow($modKirimKeUnitLain, 'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'reqKunjungan')); ?></span>
        <div class="col-sm-12">
            <div class="tab-pane active" id="tabs-basic">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="tabes">
                        <li class="active" onClick="tab1(this)" id="klinik"><a data-toggle="tab">Patologi Klinik</a></li>
                        <!-- <li onClick="tab1(this)" id="anatomi"><a data-toggle="tab">Anatomi</a></li> -->
                    </ul>
                    <div class="row">
    <div class="col-sm-12" style="margin: 20px;">


    <div id="form-caripemeriksaan" class="col-sm-12 form-horizontal" style="margin-bottom: 17px;">
    <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>

    <div class="row">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanLab, 'jenispemeriksaanlab_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPemeriksaanLab, 'jenispemeriksaanlab_nama', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array(
                    'condition' => 'jenispemeriksaanlab_aktif = true',
                    'order' => 'jenispemeriksaanlab_urutan',
                )), 'jenispemeriksaanlab_nama', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Jenis Pemeriksaan Lab',)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanLab, 'pemeriksaanlab_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanLab, 'pemeriksaanlab_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Pemeriksaan Lab', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanLab();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
            </div>
        </div>
    </div>
</div>
                    <div class="tab-content biru daftar-pemeriksaan">
                        
                        <div class="white tab-pane" id="tab1-klinik">
                            <!--<legend class="rim">PATOLOGI KLINIK</legend>-->

                            <table>
                                <tr>
                                    <td>
                                        <div id="formPeriksaLabShow" class="">

                                        </div>
                                        <div id="formPeriksaLab" class="show ">
                                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                            <?php
                                            foreach ($modJenisPeriksaLab as $i => $jenisPeriksa) {
                                                $ceklist = false;
                                                $patologi = $jenisPeriksa->jenispemeriksaanlab_kelompok;
                                                if ($patologi == Params::PATOLOGI_KLINIK) {

                                                    $cekperiksa = '';

                                                    foreach ($modPeriksaLab as $j => $pemeriksaan) {
                                                        if ($jenisPeriksa->jenispemeriksaanlab_id == $pemeriksaan->jenispemeriksaanlab_id) {
                                                            $cekperiksa .= '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                                'value' => $pemeriksaan->pemeriksaanlab_id,
                                                                'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_KLINIK . ");"
                                                            ));
                                                            $cekperiksa .= "<span>" . $pemeriksaan->pemeriksaanlab_nama ." - " . $pemeriksaan->pemeriksaanlab_kode ?? '' ."</span></label><br>";
                                                        }
                                                    }

                                                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                                        'id' => 'tabel-riwayatanamnesa',
                                                        'content' => array(
                                                            'content-detailanamnesa' => array(
                                                                'header' => '<h6>' . $jenisPeriksa->jenispemeriksaanlab_nama .  '</h6>',
                                                                'isi' => $cekperiksa,
                                                                'active' => false,
                                                            ),
                                                        ),
                                                    ));
                                                    ?>
                                                    
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="white tab-pane" id="tab1-anatomi">
                            <!--<legend class="rim">PATOLOGI ANATOMI</legend>-->
                            <table>
                                <tr>
                                    <td>
                                        <div id="formPeriksaLab2">
                                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                            <?php
                                            foreach ($modJenisPeriksaLab as $i => $jenisPeriksa) {
                                                $ceklist = false;
                                                $patologi = $jenisPeriksa->jenispemeriksaanlab_kelompok;
                                                if ($patologi != Params::PATOLOGI_KLINIK) {
                                                    ?>
                                                    <div class="boxtindakan" style="margin-bottom: 17px;">
                                                        <div class="panel panel-success">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    <h6><?php echo $jenisPeriksa->jenispemeriksaanlab_nama; ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php
                                                                foreach ($modPeriksaLab as $j => $pemeriksaan) {
                                                                    if ($jenisPeriksa->jenispemeriksaanlab_id == $pemeriksaan->jenispemeriksaanlab_id) {
                                                                        echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                                            'value' => $pemeriksaan->pemeriksaanlab_id,
                                                                            'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_KLINIK . ");"
                                                                        ));
                                                                        echo "<span>" . $pemeriksaan->pemeriksaanlab_nama ." - " . $pemeriksaan->pemeriksaanlab_kode ?? '' ."</span></label><br>";
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
                    Tanggal Permintaan
                    <span class="required">*</span>
                </label>
                <?php $date = (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RJ) ? 'date' : 'datetime'; ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modKirimKeUnitLain,
                        'attribute' => 'tgl_kirimpasien',
                        'mode' => $date,
                        'options' => array(
                            // 'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => '+6m',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3'),
                    ));
                    ?>
                </div>
            </div>
          <td>
              <?php 
                             $modKirimKeUnitLain->pegawai_id = Yii::app()->user->getState('pegawai_id') ?? "";
                               echo $form->dropDownListRow(
                                        $modKirimKeUnitLain,
                                        "pegawai_id",
                                        CHtml::listData(RJPegawaiM::model()->findAll(), "pegawai_id", "nama_pegawai"),
                                        array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)",'empty' => '-- Pilih --', 'class' => 'span2',
                                            "disabled" => "disabled"
                                        )
                                    );
                                    ?>
                                </td>
          <?php
            echo $form->dropDownListRow(
                    $modKirimKeUnitLain, 'ppds_id', CHtml::listData($modKirimKeUnitLain->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
            );
            ?>
         

         
         <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Catatan Dokter', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?>
            
            <div class='control-group'>
                <?php echo CHtml::label("Cyto <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cyto'), array('class' => 'control-label required')) ?>
                <div class='controls'>
                <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cyto', array('0'=>'Biasa','1'=>'Cyto'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3', 'disabled'=> 'disabled')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($modKirimKeUnitLain, 'isbayarkekasirpenunjang', array('onkeyup' => "return $(this).focusNextInputField(event);", 'title' => "Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel' => 'tooltip')) ?>
                    <label>Bayar ke Kasir</label>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Laboratorium <?php echo isset($modJenisTarif) ? "- " . $modJenisTarif->jenistarif->jenistarif_nama : ""; ?></b>
                    </div>
                </div>
                <?php 
                    $hidden = "";
                    if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
                        $hidden = "hidden";
                    }
                ?>
                <div class="panel-body table-responsive">
                    <div class="block-tabel">
                        <table id="tblFormPemeriksaanLab" class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>Jenis Pemeriksaan</th>
                                    <th>Pemeriksaan</th>
                                    <!--<th>Tarif</th>-->
                                    <th>Jumlah</th>
                                    <th class="is_tanggungan" <?= $hidden ?>>Tanggungan</th>
                                    <th>Cyto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--<tr id="trPeriksaLabKosong"><td colspan="5"></td></tr>-->
                            </tbody>
                        </table>
                        <table class="table bordered table-striped table-condensed">
                            <tr>
                                <td width="70%" style="text-align: right;">
                                    <!--Total Biaya Pemeriksaan-->
                                </td>
                                <td><?php echo CHtml::hiddenField('periksaTotal', '', array('class' => 'span2 integer', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekInput();', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
    );
    ?>
    <?php
    if (isset($_GET['pasienkirim_id'])) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    } else {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
    }
    ?>
    <?php
    $idPasienKirimKeUnitLain = isset($_GET['pasienkirim_id']) ? $_GET['pasienkirim_id'] : null;
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
    $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
    $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
    $js = <<< JSCRIPT
		function print(caraPrint){
			window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
		}
		function printRiwayat(caraPrint){
			window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
		}
		function printPermintaan(idPasienKirimKeUnitLain){
			window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
		}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>
<?php $this->endWidget(); ?>

<?php
$ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
$instalasi_id = $ruangan->instalasi_id;
$isinotifikasi = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
?>

<?php $this->renderPartial($this->path_view.'_jsFunction', ['modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modKirimKeUnitLain' => $modKirimKeUnitLain])?>
<script>
       $(document).ready(function() {
           var pegawai = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'pegawai_id') ?>');	
           jQuery(pegawai).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();


       });


       $(document).ready(function() {
           var ppds = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ppds_id') ?>');	
           jQuery(ppds).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();


       });


       $(document).ready(function() {
           var jenis = jQuery('#<?php echo CHtml::activeId($modPemeriksaanLab, 'jenispemeriksaanlab_nama') ?>');	
           jQuery(jenis).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();


       });


    function searchDokter() {
            $('#rjpasien-laboratorium-t-form input[name*="pegawai_id"]').each(function() {
            });
    }

    function searchPPDS() {
            $('#rjpasien-laboratorium-t-form input[name*="ppds_id"]').each(function() {
            });
    }

    function searchPerawat() {
            $('#rjpasien-laboratorium-t-form input[name*="jenispemeriksaanlab_nama"]').each(function() {
            });
    }
    </script>