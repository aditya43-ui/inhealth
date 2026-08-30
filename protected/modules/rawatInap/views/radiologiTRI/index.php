<?php
$this->breadcrumbs = array(
    'Radiologi',
);

//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">RADIOLOGI</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-radiologi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Radiologi
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
        <div class="row" hidden>
            <div class="control-group">
                <?php echo $form->dropDownListRow($modKirimKeUnitLain, 'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqKunjungan')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">

                <div id="form-caripemeriksaan" class="col-sm-12 form-horizontal" style="margin-bottom: 17px;">
                    <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>

                    <div class="row">
                        <div class="control-group" style="float:left;">
                            <?php echo CHtml::activeLabel($modPemeriksaanRad, 'jenispemeriksaanrad_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeDropDownList($modPemeriksaanRad, 'jenispemeriksaanrad_nama', CHtml::listData(JenispemeriksaanradM::model()->findAll(array(
                                    'condition' => 'jenispemeriksaanrad_aktif = true',
                                    'order' => 'jenispemeriksaanrad_urutan',
                                )), 'jenispemeriksaanrad_nama', 'jenispemeriksaanrad_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();", 'placeholder' => 'Nama Jenis Pemeriksaan Radiologi',)); ?>
                            </div>
                        </div>
                        <div class="control-group" style="float:left;">
                            <?php echo CHtml::activeLabel($modPemeriksaanRad, 'pemeriksaanrad_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modPemeriksaanRad, 'pemeriksaanrad_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();", 'placeholder' => 'Nama Pemeriksaan Radiologi', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanRad();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="formInputTab">
                    <?php echo $form->errorSummary($modKirimKeUnitLain, $modPasienMasukPenunjang); ?>
                    <div class="row">
                        <div class="daftar-pemeriksaan">
                            <table style="width: 100%; border: none; margin: 17px 0;" class="tbl-periksa">
                                <tr>
                                    <td>
                                        <div id="formPeriksaRad">
                                            <?php
                                            $jenisPeriksa = '';
                                            foreach ($modPeriksaRad as $i => $pemeriksaan) {
                                                $ceklist = false;
                                                if ($jenisPeriksa != $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama) {
                                                    echo ($jenisPeriksa != '') ? "</div></div></div></div>" : "";
                                                    $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                                                    echo "<div class='col-sm-3'>";
                                                    echo "<div class='panel panel-success'>";
                                                    echo "<div class='panel-heading'>"
                                                        .    "  <div class='panel-title'>" . $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama . "</div>";
                                                    echo "</div>";
                                                    echo "<div class='panel-body boxtindakan'  style=''>";
                                                    echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanRad[]", $ceklist, array(
                                                        'value' => $pemeriksaan->pemeriksaanrad_id,
                                                        'onclick' => "inputperiksa(this);"
                                                    ));
                                                    $pemeriksaanrad_kode = '';
                                                    if(!empty($pemeriksaan->pemeriksaanrad_kode)) {
                                                        $pemeriksaanrad_kode = $pemeriksaan->pemeriksaanrad_kode;
                                                    }
                                                    echo "<span>" . $pemeriksaan->pemeriksaanrad_nama . ' - ' . $pemeriksaanrad_kode ."</span></label><br>";
                                                } else {
                                                    $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                                                    echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanRad[]", $ceklist, array(
                                                        'value' => $pemeriksaan->pemeriksaanrad_id,
                                                        'onclick' => "inputperiksa(this);"
                                                    ));
                                                    $pemeriksaanrad_kode = '';
                                                    if(!empty($pemeriksaan->pemeriksaanrad_kode)) {
                                                        $pemeriksaanrad_kode = $pemeriksaan->pemeriksaanrad_kode;
                                                    }
                                                    echo "<span>" . $pemeriksaan->pemeriksaanrad_nama . ' - ' . $pemeriksaanrad_kode ."</span></label><br>";
                                                }
                                            }
                                            echo "</div></div></div></div>";
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td>
                                    <div class="col-sm-6">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <i class="glyphicon glyphicon-file"></i> Form <b>Perujuk</b>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                                                            ?></p>-->

                                                <?php echo CHtml::hiddenField('deposit', $modDeposit, array()); ?>
                                                <div class="control-group">
                                                    <label class="control-label required" for="RIPasienKirimKeUnitLainT_tgl_kirimpasien">
                                                        Tanggal Permintaan
                                                        <span class="required">*</span>
                                                    </label>
                                                    <?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                                    <div class="controls">
                                                        <?php
                                                        $this->widget('MyDateTimePicker', array(
                                                            'model' => $modKirimKeUnitLain,
                                                            'attribute' => 'tgl_kirimpasien',
                                                            'mode' => 'datetime',
                                                            'options' => array(
                                                                'dateFormat' => Params::DATE_FORMAT,
                                                                //                                                        'maxDate' => 'd',
                                                            ),
                                                            'htmlOptions' => array('readonly' => true, 'class' => 'col-sm-8'),
                                                        )); ?>
                                                    </div>
                                                </div>
                                                <?php echo $form->dropDownListRow(
                                                    $modKirimKeUnitLain,
                                                    'pegawai_id',
                                                    CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                                                );
                                                ?>
                                                    <?php
            echo $form->dropDownListRow(
                    $modKirimKeUnitLain, 'ppds_id', CHtml::listData($modKirimKeUnitLain->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
            );
            ?>
         
                                                <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Catatan', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                                                <div class='control-group'>
                                                    <?php echo CHtml::label("Cyto <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cito'), array('class' => 'control-label required')) ?>
                                                    <div class='controls'>
                                                    <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cito', array('0'=>'Biasa','1'=>'Cyto'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3')); ?>
                                                    </div>
                                                </div>
                                                <div classs="control-group">
                                                    <label class="control-label"></label>
                                                    <div class="controls">
                                                        <?php echo $form->checkBox($modKirimKeUnitLain, 'isbayarkekasirpenunjang', array('onkeyup' => "return $(this).focusNextInputField(event);", 'title' => "Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel' => 'tooltip')) ?>
                                                        <label>Bayar ke Kasir</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Radiologi <?php echo isset($modJenisTarif) ? "- " . $modJenisTarif->jenistarif->jenistarif_nama : ""; ?></b>
                                                </div>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <div class="block-tabel">
                                                    <table id="tblFormPemeriksaanRad" class="table table-bordered table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th>Jenis Pemeriksaan</th>
                                                                <th>Pemeriksaan</th>
                                                                <!--<th>Tarif</th>-->
                                                                <th>Jumlah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!--<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>-->
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered table-condensed">
                                                        <tr>
                                                            <td width="70%" style="text-align: right;">
                                                                <!--Total Biaya Pemeriksaan-->
                                                            </td>
                                                            <td><?php echo CHtml::hiddenField('periksaTotal', '', array('class' => 'span2', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-actions">
                        <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekInput();', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
                        );
                        ?>
                        <?php

                        if (isset($_GET['pasienkirim_id'])) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                        } else {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
                        }
                        ?>
                        <?php
                        $content = $this->renderPartial('../tips/tips', array(), true);
                        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                        $idPasienKirimKeUnitLain = isset($_GET['pasienkirim_id']) ? $_GET['pasienkirim_id'] : null;
                        $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
                        $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
                        $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPermintaan(idPasienKirimKeUnitLain)
{
    window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD); ?>


<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions', ['modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran]); ?>
<script>
       $(document).ready(function() {
           var pemeriksaanrad = jQuery('#<?php echo CHtml::activeId($modPemeriksaanRad, 'jenispemeriksaanrad_nama') ?>');	
           jQuery(pemeriksaanrad).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function searchPemeriksaanRAD() {
            $('#rjpasien-laboratorium-t-form input[name*="jenispemeriksaanrad_nama"]').each(function() {
            });
    }

   

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


    function searchPegawai() {
            $('#rjpasien-laboratorium-t-form input[name*="pegawai_id"]').each(function() {
            });
    }



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


    function searchPegawai() {
            $('#rjpasien-laboratorium-t-form input[name*="ppds_id"]').each(function() {
            });
    }
    
    </script>
    