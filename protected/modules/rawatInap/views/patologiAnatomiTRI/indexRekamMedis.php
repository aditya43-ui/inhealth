<?php

/**
 * view utama untuk mengakses menu tabulasi patologi anatomi
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
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
<style>
    input {
        font-family: FontAwesome;
    }

    #cari_modul {
        font-family: FontAwesome !important;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>
<?php
$this->breadcrumbs = array(
    'Patologi Anatomi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'currency' => 'PHP',
    'config' => array(
        'symbol' => 'Rp. ',
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
//$modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-laboratorium-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id'),
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        // 'onsubmit'=>'cekInput();return false;'
    ),
)); ?>

<?php
$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);
$kelPegawaippds = PpdsM::model()->findByPk($pegawai->ppds_id);
if ($kelPegawai !== null) {

    if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {

        $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
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
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Tabel Riwayat <strong>Pemeriksaan Patologi Anatomi Pasien</strong></div>
            </div>
            <div class="panel-body table-responsive" style="overflow-x: auto; max-width: 100%;">

                <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>

            </div>
        </div>

    <?php
    } else {

    ?>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Tabel Riwayat <strong>Pemeriksaan Patologi Anatomi Pasien</strong></div>
            </div>
            <div class="panel-body table-responsive" style="overflow-x: auto; max-width: 100%;">

                <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>

            </div>
        </div>
        <br>
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Form Perujuk</div>
                    </div>
                    <div class="panel-body table-responsive">
                        <p class="help-block">
                            <?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
                        <div class="control-group">
                            <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
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
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'realtime'),
                                )); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo $form->dropDownListRow(
                                $modKirimKeUnitLain,
                                'pegawai_id',
                                CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                            ); ?>
                        </div>

                        <div class="control-group">
                            <?php echo $form->dropDownListRow(
                                $modKirimKeUnitLain,
                                'ppds_id',
                                CHtml::listData($modKirimKeUnitLain->getPPDS(), 'ppds_id', 'ppds_nama'),
                                array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                            ); ?>
                        </div>
                        <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Catatan Dokter', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?>
                        <div class="control-group">
                            <label class="control-label">&nbsp;</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modKirimKeUnitLain, 'isbayarkekasirpenunjang', array('onkeyup' => "return $(this).focusNextInputField(event);", 'title' => "Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel' => 'tooltip')) ?>
                                <label>Bayar ke Kasir</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <?php
            $modul = Yii::app()->user->getState('modul_id');
            ?>
            <div class="col-sm-6">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel Pemeriksaan <strong>Patologi Anatomi
                                <?php echo isset($modJenisTarif) ? "- " . $modJenisTarif->jenistarif->jenistarif_nama : ""; ?></strong>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class="block-tabel">
                            <table id="tblFormPemeriksaanLab" class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Jenis Pemeriksaan</th>
                                        <th>Pemeriksaan</th>
                                        <?php
                                        if (in_array($modul, array(Params::MODUL_ID_RJ, Params::MODUL_ID_RD))) {
                                            echo "<th>Sample Lab</th>";
                                        }
                                        ?>
                                        <th>Jumlah</th>
                                        <!-- <th>Tarif</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $det = PermintaankepenunjangT::model()->findAllByAttributes(array(
                                        'pasienkirimkeunitlain_id' => $modKirimKeUnitLain->pasienkirimkeunitlain_id
                                    ));

                                    foreach ($det as $item) {
                                        $sample = SamplelabM::model()->findByPk($item->samplelab_id) ?? new SamplelabM;
                                        echo $this->renderPartial($this->path_view . '_formLoadPemeriksaanLabUpdate', array('item' => $item, 'id_tindakan' => $item->daftartindakan_id, 'paket' => null, 'sample' => $sample), true);
                                    }


                                    ?>
                                    <!--  <tr id="trPeriksaLabKosong"><td colspan="5"></td></tr>-->
                                </tbody>
                            </table>
                            <!-- <table class="table bordered table-striped table-condensed">
                        <tr>
                            <td width="70%" style="vertical-align:middle;text-align: right;">Total Biaya Pemeriksaan
                            </td>
                            <td><?php //echo CHtml::textField('periksaTotal', '',array('class'=>'span2 integer', 'style'=>'text-align:right;', 'disabled'=>'disabled'));
                                ?>
                            </td>
                        </tr>
                    </table> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <?php echo $form->errorSummary($modKirimKeUnitLain); ?>

            <span hidden><?php echo $form->dropDownListRow($modKirimKeUnitLain, 'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'reqKunjungan')); ?></span>
            <div class="col-sm-12">
                <div class="tab-pane active" id="tabs-basic">
                    <div class="tabbable">


                        <div class="clear"></div>
                        <br>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="control-group" style="float:left;">
                                    <div class="controls">
                                        <label class="control-label">Pemeriksaan Patologi Anatomi</label>
                                        <?php echo CHtml::hiddenfield('kelaspelayanan_id', $modPendaftaran->kelaspelayanan_id) ?>
                                        <?php echo CHtml::textField('periksalab', '', array('class' => 'span3', 'onkeyup' => 'cariTarifLab($("#' . CHtml::activeId($modKirimKeUnitLain, 'ruangan_id') . '"));', 'placeholder' => 'Nama Pemeriksaan Lab', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary btn-cari', 'type' => 'button', "onclick" => 'cariTarifLab($("#' . CHtml::activeId($modKirimKeUnitLain, 'ruangan_id') . '"));', 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <?php echo $form->dropDownListRow($modKirimKeUnitLain, 'samplelab_id', CHtml::listData(SamplelabM::model()->findAll('jenispemeriksaanlab_kelompok = \'Patologi Anatomi\''), 'samplelab_id', 'samplelab_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'sample', 'empty' => '-- Pilih --')); ?>
                            </div>



                            <ul class="nav nav-tabs" id="tabes">
                                <!--<li class="active" onClick="tab1(this)" id="klinik"><a data-toggle="tab">Patologi Klinik</a></li>-->
                                <!--<li onClick="tab1(this)" id="anatomi"><a data-toggle="tab">Anatomi</a></li>-->
                            </ul>
                            <div class="panel-body">
                                <div class="tab-content biru">
                                    <div class="white tab-pane" id="tab1-klinik">
                                        <div style="height:400px;overflow-y: scroll;" id="generate-pemeriksaanlab">
                                            <!--<legend class="rim">PATOLOGI KLINIK</legend>-->
                                            <table width="100%">
                                                <tr>
                                                    <td valign="top">
                                                        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                                                        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                                        <div id="formPeriksaLab">

                                                        </div>
                                                    </td>
                                                    <td valign="top">
                                                    </td>
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
                        $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
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
                <?php } ?>
            <?php } else { ?>
                <?php if ((!empty($kelPegawaippds->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {

                    $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
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
                    <div class="panel panel-success panel-shadow">
                        <div class="panel-heading">
                            <div class="panel-title">Tabel Riwayat <strong>Pemeriksaan Patologi Anatomi Pasien</strong></div>
                        </div>
                        <div class="panel-body table-responsive" style="overflow-x: auto; max-width: 100%;">

                            <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>

                        </div>
                    </div>

                <?php
                } else {

                ?>

                    <div class="panel panel-success panel-shadow">
                        <div class="panel-heading">
                            <div class="panel-title">Tabel Riwayat <strong>Pemeriksaan Patologi Anatomi Pasien</strong></div>
                        </div>
                        <div class="panel-body table-responsive" style="overflow-x: auto; max-width: 100%;">

                            <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>

                        </div>
                    </div>
                    <br>
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <div class="panel panel-success panel-shadow">
                                <div class="panel-heading">
                                    <div class="panel-title">Form Perujuk</div>
                                </div>
                                <div class="panel-body table-responsive">
                                    <p class="help-block">
                                        <?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
                                    <div class="control-group">
                                        <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
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
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions' => array('readonly' => true, 'class' => 'realtime'),
                                            )); ?>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <?php echo $form->dropDownListRow(
                                            $modKirimKeUnitLain,
                                            'pegawai_id',
                                            CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                            array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                                        ); ?>
                                    </div>

                                    <div class="control-group">
                                        <?php echo $form->dropDownListRow(
                                            $modKirimKeUnitLain,
                                            'ppds_id',
                                            CHtml::listData($modKirimKeUnitLain->getPPDS(), 'ppds_id', 'ppds_nama'),
                                            array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                                        ); ?>
                                    </div>
                                    <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Catatan Dokter', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?>
                                    <div class="control-group">
                                        <label class="control-label">&nbsp;</label>
                                        <div class="controls">
                                            <?php echo $form->checkBox($modKirimKeUnitLain, 'isbayarkekasirpenunjang', array('onkeyup' => "return $(this).focusNextInputField(event);", 'title' => "Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel' => 'tooltip')) ?>
                                            <label>Bayar ke Kasir</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <?php
                        $modul = Yii::app()->user->getState('modul_id');
                        ?>
                        <div class="col-sm-6">
                            <div class="panel panel-success panel-shadow">
                                <div class="panel-heading">
                                    <div class="panel-title">Tabel Pemeriksaan <strong>Patologi Anatomi
                                            <?php echo isset($modJenisTarif) ? "- " . $modJenisTarif->jenistarif->jenistarif_nama : ""; ?></strong>
                                    </div>
                                </div>
                                <div class="panel-body table-responsive">
                                    <div class="block-tabel">
                                        <table id="tblFormPemeriksaanLab" class="table table-bordered table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Jenis Pemeriksaan</th>
                                                    <th>Pemeriksaan</th>
                                                    <?php
                                                    if (in_array($modul, array(Params::MODUL_ID_RJ, Params::MODUL_ID_RD))) {
                                                        echo "<th>Sample Lab</th>";
                                                    }
                                                    ?>
                                                    <th>Jumlah</th>
                                                    <!-- <th>Tarif</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $det = PermintaankepenunjangT::model()->findAllByAttributes(array(
                                                    'pasienkirimkeunitlain_id' => $modKirimKeUnitLain->pasienkirimkeunitlain_id
                                                ));

                                                foreach ($det as $item) {
                                                    echo $this->renderPartial($this->path_view . '_formLoadPemeriksaanLabUpdate', array('item' => $item, 'id_tindakan' => $item->daftartindakan_id, 'paket' => null), true);
                                                }


                                                ?>
                                                <!--  <tr id="trPeriksaLabKosong"><td colspan="5"></td></tr>-->
                                            </tbody>
                                        </table>
                                        <!-- <table class="table bordered table-striped table-condensed">
                <tr>
                    <td width="70%" style="vertical-align:middle;text-align: right;">Total Biaya Pemeriksaan
                    </td>
                    <td><?php //echo CHtml::textField('periksaTotal', '',array('class'=>'span2 integer', 'style'=>'text-align:right;', 'disabled'=>'disabled'));
                        ?>
                    </td>
                </tr>
            </table> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <?php echo $form->errorSummary($modKirimKeUnitLain); ?>

                        <span hidden><?php echo $form->dropDownListRow($modKirimKeUnitLain, 'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'reqKunjungan')); ?></span>
                        <div class="col-sm-12">
                            <div class="tab-pane active" id="tabs-basic">
                                <div class="tabbable">


                                    <div class="clear"></div>
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="control-group" style="float:left;">
                                                <div class="controls">
                                                    <label class="control-label">Pemeriksaan Patologi Anatomi</label>
                                                    <?php echo CHtml::hiddenfield('kelaspelayanan_id', $modPendaftaran->kelaspelayanan_id) ?>
                                                    <?php echo CHtml::textField('periksalab', '', array('class' => 'span3', 'onkeyup' => 'cariTarifLab($("#' . CHtml::activeId($modKirimKeUnitLain, 'ruangan_id') . '"));', 'placeholder' => 'Nama Pemeriksaan Lab', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                                                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary btn-cari', 'type' => 'button', "onclick" => 'cariTarifLab($("#' . CHtml::activeId($modKirimKeUnitLain, 'ruangan_id') . '"));', 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php echo $form->dropDownListRow($modKirimKeUnitLain, 'samplelab_id', CHtml::listData(SamplelabM::model()->findAll('jenispemeriksaanlab_kelompok = \'Patologi Anatomi\''), 'samplelab_id', 'samplelab_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'sample', 'empty' => '-- Pilih --')); ?>
                                        </div>



                                        <ul class="nav nav-tabs" id="tabes">
                                            <!--<li class="active" onClick="tab1(this)" id="klinik"><a data-toggle="tab">Patologi Klinik</a></li>-->
                                            <!--<li onClick="tab1(this)" id="anatomi"><a data-toggle="tab">Anatomi</a></li>-->
                                        </ul>
                                        <div class="panel-body">
                                            <div class="tab-content biru">
                                                <div class="white tab-pane" id="tab1-klinik">
                                                    <div style="height:400px;overflow-y: scroll;" id="generate-pemeriksaanlab">
                                                        <!--<legend class="rim">PATOLOGI KLINIK</legend>-->
                                                        <table width="100%">
                                                            <tr>
                                                                <td valign="top">
                                                                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                                                                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                                                    <div id="formPeriksaLab">

                                                                    </div>
                                                                </td>
                                                                <td valign="top">
                                                                </td>
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
                                    $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
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
                            <?php } ?>

                        <?php } ?>
                        <?php $this->endWidget(); ?>

                        <?php
                        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
                        $instalasi_id = $ruangan->instalasi_id;
                        $isinotifikasi = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
                        ?>
                        <script type="text/javascript">
                            $('#tab1-klinik').fadeIn(100);
                            $('#tab1-anatomi').hide();

                            function tab1(obj) {
                                var lab = obj.id;
                                if (lab == 'klinik') {
                                    $('#klinik').attr('class', 'active');
                                    $('#anatomi').removeAttr('class');
                                    $('#tab1-anatomi').fadeOut(100);
                                    $('#tab1-klinik').fadeIn(100);
                                } else {
                                    $('#klinik').removeAttr('class');
                                    $('#anatomi').attr('class', 'active');
                                    $('#tab1-klinik').fadeOut(100);
                                    $('#tab1-anatomi').fadeIn(100);
                                }

                            }

                            //$('#formPeriksaLab').tile({widths : [ 190 ]});
                            /**
                             * 
                             * @param {type} obj
                             * @param {type} ruangan_id = klinik / anatomi
                             * @returns {undefined}
                             */
                            function inputperiksa(obj, ruangan_id) {

                                if ($(obj).is(':checked')) {
                                    var pemeriksaanlab_id = obj.value;
                                    var samplelab_id = $('.sample').val();
                                    //        var kelaspelayanan_id = $('#<?php // echo CHtml::activeId($modKirimKeUnitLain,'kelaspelayanan_id') 
                                                                            ?>').val();
                                    var kelaspelayanan_id =
                                        '<?php echo ($modAdmisi) ? $modAdmisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id; ?>';
                                    var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
                                    jQuery.ajax({
                                        'url': '<?php echo $this->createUrl(Yii::app()->controller->id . '/loadFormPemeriksaanLab') ?>',
                                        'data': {
                                            pemeriksaanlab_id: pemeriksaanlab_id,
                                            kelaspelayanan_id: kelaspelayanan_id,
                                            pendaftaran_id: pendaftaran_id,
                                            ruangan_id: ruangan_id,
                                            samplelab_id: samplelab_id
                                        },
                                        'type': 'post',
                                        'dataType': 'json',
                                        'success': function(data) {
                                            if ($.trim(data.form) == '') {
                                                $(obj).removeAttr('checked');
                                                myAlert(
                                                    'Pemeriksaan belum memilik tarif silahkan hubungi SIMRS untuk memeriksa tarif pemeriksaan tersebut'
                                                );
                                                // checkIni(obj);
                                            }
                                            $('#tblFormPemeriksaanLab #trPeriksaLabKosong').detach();
                                            $('#tblFormPemeriksaanLab > tbody').append(data.form);
                                            $("#tblFormPemeriksaanLab > tbody > tr:last .integer").maskMoney({
                                                "defaultZero": true,
                                                "allowZero": true,
                                                "decimal": ".",
                                                "thousands": ",",
                                                "precision": 0,
                                                "symbol": null
                                            });
                                            $('.integer').each(function() {
                                                this.value = formatNumber(this.value)
                                            });
                                            hitungTotal();

                                            if (obj.value == '352') {
                                                batalPeriksa('563');
                                                $('#formPeriksaLab').find('input[value="563"]').attr('checked', 'checked');
                                                $('#formPeriksaLab').find('input[value="563"]').attr('disabled', 'true');

                                                batalPeriksa('564');
                                                $('#formPeriksaLab').find('input[value="564"]').attr('checked', 'checked');
                                                $('#formPeriksaLab').find('input[value="564"]').attr('disabled', 'true');

                                                hitungTotal();

                                            }
                                        },
                                        'cache': false
                                    });
                                } else {

                                    batalPeriksa(obj.value);
                                    hitungTotal();

                                    //		myConfirm("Apakah anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
                                    //			if(r){
                                    //				batalPeriksa(obj.value);
                                    //				hitungTotal();
                                    //
                                    //				if(obj.value == '352')
                                    //				{
                                    //					$('#formPeriksaLab').find('input[value="563"]').removeAttr('checked');
                                    //					$('#formPeriksaLab').find('input[value="563"]').removeAttr('disabled');
                                    //
                                    //					$('#formPeriksaLab').find('input[value="564"]').removeAttr('checked');
                                    //					$('#formPeriksaLab').find('input[value="564"]').removeAttr('disabled');
                                    //				}
                                    //			}
                                    //			else{
                                    //				$(obj).attr('checked', 'checked');
                                    //			}
                                    //		});
                                }


                            }

                            function batalPeriksa(pemeriksaanlab_id) {
                                $('#tblFormPemeriksaanLab #periksalab_' + pemeriksaanlab_id).detach();
                                //if($('#tblFormPemeriksaanLab tr').length == 1)
                                //$('#tblFormPemeriksaanLab').append('<tr id="trPeriksaLabKosong"><td colspan="4"></td></tr>');
                            }

                            function batalKirim(pasienkirimkeunitlain_id, pendaftaran_id) {
                                myConfirm("Apakah anda akan membatalkan kirim pasien ke Laboratorium?", "Perhatian!", function(r) {
                                    if (r) {
                                        $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                                            pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                                            pendaftaran_id: pendaftaran_id
                                        }, function(data) {
                                            $('#tblListPemeriksaanLab').html(data.result);
                                            myAlert(data.pesan);
                                        }, 'json');
                                    }
                                });
                            }

                            function hitungTotal() {
                                var total = 0;
                                $('.tarif_satuan').each(
                                    function() {
                                        qty = $(this).parents('tr').find('.gty').val();
                                        total_harga = unformatNumber(this.value) * qty;
                                        total += total_harga;
                                    }
                                );

                                $('#periksaTotal').val(formatNumber(total));

                                $("#<?php echo CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim') ?>").blur();
                            }

                            function cekInput() {

                                if (requiredCheck($("#rjpasien-laboratorium-t-form"))) {
                                    var deposit = $('#deposit').val();
                                    var periksaTotal = unformatNumber($('#periksaTotal').val());
                                    var tr = $("#tblFormPemeriksaanLab > tbody > tr").length;

                                    if (tr > 0) {
                                        $('#rjpasien-laboratorium-t-form').submit();

                                    } else {
                                        alert("Tindakan Laboratorium belum dipilih");
                                        return false;
                                    }
                                }


                                return false;
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
                                var periksalab = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'periksalab') ?>');
                                jQuery(periksalab).multiselect({
                                    includeSelectAllOption: false,
                                    buttonClass: "form-control",
                                    maxHeight: 300,
                                    buttonWidth: '182px',
                                    enableCaseInsensitiveFiltering: true
                                }).hide();

                            });


                            function searchDokter() {
                                $('#rjpasien-laboratorium-t-form input[name*="pegawai_id"]').each(function() {});
                            }

                            function searchPPDS() {
                                $('#rjpasien-laboratorium-t-form input[name*="ppds_id"]').each(function() {});
                            }

                            function searchPeriksalab() {
                                $('#rjpasien-laboratorium-t-form input[name*="periksalab"]').each(function() {});
                            }


                            function cariTarifLab(obj) {
                                var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id; ?>;
                                var penjamin_id = <?php echo $modPendaftaran->penjamin_id; ?>;
                                var kelaspelayanan_id = <?php echo $modPendaftaran->kelaspelayanan_id; ?>;
                                var jenistarif_id = <?php echo $modJenisTarif->jenistarif_id; ?>;
                                var ruangan_id = $(obj).val();
                                var pemeriksaanlab_nama = $("#periksalab").val();
                                var count = 0;

                                $("#generate-pemeriksaanlab").addClass("animation-loading");

                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo $this->createUrl('loadTarifLab'); ?>',
                                    data: {
                                        pendaftaran_id: pendaftaran_id,
                                        penjamin_id: penjamin_id,
                                        kelaspelayanan_id: kelaspelayanan_id,
                                        jenistarif_id: jenistarif_id,
                                        ruangan_id: ruangan_id,
                                        periksalab: pemeriksaanlab_nama
                                    },
                                    dataType: "json",
                                    success: function(data) {

                                        var input_ceklis = null;

                                        if (data.sukses == 1) {
                                            $("#formPeriksaLab").html(data.html);
                                            $('.glyphicon-chevron-down').attr('style',
                                                'font-size:18px; margin-top: -30px;');


                                            $("#tblFormPemeriksaanLab > tbody > tr ").each(function() {


                                                input_ceklis = $("#generate-pemeriksaanlab").find(
                                                    'input[id$="pemeriksaanlabid"][value="' +
                                                    $(this).find('.idpemeriksaanlab').val() + '"]');


                                                input_ceklis.prop(
                                                    "checked",
                                                    true);

                                                input_ceklis.parents(".accordion").find(".accordion-heading a").click();
                                            });

                                            if (count > 0) {
                                                $("#tblFormPemeriksaanLab > tbody ").html('');
                                            }
                                        } else {
                                            myAlert(data.pesan);
                                        }

                                        $("#generate-pemeriksaanlab").removeClass("animation-loading");
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log(errorThrown);
                                    }
                                });
                            }

                            $(document).ready(function() {

                                // Notifikasi Pasien
                                <?php
                                if (isset($_GET['smspasien'])) {
                                    if ($_GET['smspasien'] == 0) {
                                ?>
                                        var params = [];
                                        params = {
                                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                                            modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                                            judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                                            isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                                        }; // 16 
                                        insert_notifikasi(params);
                                <?php
                                    }
                                }
                                ?>

                                <?php
                                if (isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)) {
                                ?>
                                    var params = [];
                                    params = {
                                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                                        modul_id: <?php echo Params::MODUL_ID_LAB ?>,
                                        judulnotifikasi: 'Pasien Rujukan',
                                        isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
                                    }; // 16 
                                    insert_notifikasi(params);
                                <?php
                                }
                                ?>

                                // setValidasiCekDisabled($("#rjpasien-laboratorium-t-form"), function() {
                                //     if ($("#tblFormPemeriksaanLab > tbody > tr").length == 0) {
                                //         return false;
                                //     }

                                //     return true;
                                // });
                            });
                        </script>
                        <?php
                        //========= Dialog buat cari DPJP ==========
                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                            'id' => 'dialogDokter',
                            'options' => array(
                                'title' => 'Daftar DPJP',
                                'autoOpen' => false,
                                'modal' => true,
                                'width' => 750,
                                'resizable' => false,
                            ),
                        ));

                        $modPegawai = new PegawairuanganV('searchDialogPegawai');
                        $modPegawai->unsetAttributes();
                        if (isset($_GET['PegawairuanganV']))
                            $modPegawai->attributes = $_GET['PegawairuanganV'];

                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'dokter-m-grid',
                            'dataProvider' => $modPegawai->searchDialogPegawai(),
                            'filter' => $modPegawai,
                            'template' => "{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                ////'pegawai_id',
                                array(
                                    'header' => 'Pilih',
                                    'type' => 'raw',
                                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($modKirimKeUnitLain, 'pegawai_id') . '\').val(\'$data->pegawai_id\');	
						$(\'.pegawai_nama\').val(\'$data->NamaLengkap\');
						$(\'.no_hp_dpjp\').val(\'$data->nomobile_pegawai\');
						$(\'#dialogDokter\').dialog(\'close\');
						return false;"))',
                                ),
                                array(
                                    'header' => 'NIP',
                                    'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
                                    'value' => '$data->nomorindukpegawai',
                                ),
                                array(
                                    'header' => 'Nama Pegawai',
                                    'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
                                    'value' => '$data->nama_pegawai',
                                ),
                                array(
                                    'header' => 'Jabatan',
                                    'name' => 'jabatan_id',
                                    'value' => function ($data) {
                                        $hasil = '';
                                        $j = JabatanM::model()->findByPk($data->jabatan_id);

                                        if (!empty($j)) {
                                            $hasil = $j->jabatan_nama;
                                        }
                                        return $hasil;
                                    },
                                    'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
                                ),
                                array(
                                    'header' => 'Nomor HP Pegawai',
                                    'value' => '$data->nomobile_pegawai'
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));

                        $this->endWidget();
                        //========= Dialog buat cari Petugas ==========
                        ?>
                        <?php
                        //========= Dialog buat cari data PPDS  =========================
                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                            'id' => 'dialogPpds',
                            'options' => array(
                                'title' => 'Pencarian PPDS',
                                'autoOpen' => false,
                                'modal' => true,
                                'width' => 600,
                                'resizable' => false,
                            ),
                        ));

                        $modPpds = new PpdsM();
                        $modPpds->unsetAttributes();
                        if (isset($_GET['PpdsM'])) {
                            $modPpds->attributes = $_GET['PpdsM'];
                        }
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'ppds-m-grid',
                            'dataProvider' => $modPpds->searchData(),
                            'filter' => $modPpds,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'Pilih',
                                    'type' => 'raw',
                                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPpds",
                "onClick" => "$(\"#' . CHtml::activeId($modKirimKeUnitLain, 'ppds_id') . '\").val(\"$data->ppds_id\");
                              $(\"#RIPasienKirimKeUnitLainT_ppds_nama\").val(\"$data->ppds_nama\");   
                              setPpds(\"$data->ppds_id\"); 
                              $(\"#dialogPpds\").dialog(\"close\");    
                              return false;
                    "))',
                                ),
                                array(
                                    'header' => 'NIM',
                                    'name' => 'ppds_nim',
                                    'value' => '$data->ppds_nim',
                                ),
                                array(
                                    'header' => 'Nama PPDS',
                                    'name' => 'ppds_nama',
                                    'value' => '$data->ppds_nama',
                                ),
                                array(
                                    'header' => 'Tahap',
                                    'name' => 'ppds_tahap',
                                    'value' => '$data->ppds_tahap',
                                ),
                                array(
                                    'header' => 'Prodi',
                                    'filter' => CHtml::activeDropDownList($modPpds, 'programstudi_id', CHtml::listData(ProgramstudiM::model()->findAll("programstudi_aktif = TRUE ORDER BY programstudi_nama ASC"), 'programstudi_id', 'programstudi_nama'), array('empty' => '-- Pilih --')),
                                    'value' => function ($data) {
                                        $programstudi_nama = "";
                                        if (!empty($data->programstudi_id)) {
                                            $programstudi_nama = ProgramstudiM::model()->findByPk($data->programstudi_id)->programstudi_nama;
                                        }
                                        return $programstudi_nama;
                                    },
                                ),
                                array(
                                    'header' => 'No. HP',
                                    'value' => function ($data) {
                                        $nomor_hp = "-";
                                        $modAlamat = PpdsalamatM::model()->findByAttributes(array('ppds_id' => $data->ppds_id, 'ppdsalamat_tipe' => Params::TIPE_ALAMAT_PPDS_IDENTITAS));
                                        if (!empty($modAlamat)) {
                                            $nomor_hp = $modAlamat->no_mobile;
                                        }
                                        return $nomor_hp;
                                    }
                                )
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));

                        $this->endWidget();
                        //========= end Search data PPDS =============================
                        ?>
                        <?php
                        echo CHtml::hiddenField("tampungDiagnosa", '', array('class' => 'readonly'));

                        //========= Dialog buat cari Bahan Diet =========================
                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                            'id' => 'dialogDiagnosaMasuk',
                            'options' => array(
                                'title' => 'Daftar Diagnosis 10',
                                'autoOpen' => false,
                                'modal' => true,
                                'width' => 750,
                                'height' => 720,
                                'resizable' => false,
                            ),
                        ));
                        ?>
                        <?php
                        $modDiagnosa = new RIDiagnosaM('searchDialog');
                        $modDiagnosa->unsetAttributes();
                        if (isset($_GET['RIDiagnosaM'])) {
                            $modDiagnosa->attributes = $_GET['RIDiagnosaM'];
                        }
                        $this->widget(
                            'ext.bootstrap.widgets.BootGridView',
                            array(
                                'id' => 'giagnosautama-m-grid',
                                'dataProvider' => $modDiagnosa->searchDiagnosis(),
                                'filter' => $modDiagnosa,
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-bordered table-condensed',
                                'columns' => array(
                                    array(
                                        'header' => 'Pilih',
                                        'type' => 'raw',
                                        'value' => function ($data) {

                                            $attr = CJSON::encode($data->attributes);

                                            return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                                                'class' => 'btn-small',
                                                'id' => 'selectPasien',
                                                'onclick' => "
                                $('#RIPasienKirimKeUnitLainT_diagnosa_id').val('" . $data->diagnosa_id . "');
                                $('#RIPasienKirimKeUnitLainT_diagnosis').val('" . $data->diagnosa_nama . "');
                                $('#dialogDiagnosaMasuk').dialog('close'); return false;"
                                            ));
                                        },
                                    ),
                                    'diagnosa_kode',
                                    array(
                                        'header' => 'Diagnosis',
                                        'name' => 'diagnosa_nama',
                                        'value' => '$data->diagnosa_nama',
                                    ),
                                    array(
                                        'header' => 'Catatan',
                                        'name' => 'diagnosa_namalainnya',
                                        'value' => '$data->diagnosa_namalainnya',
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                            )
                        );
                        $this->endWidget();
                        ?>
                        <script>
                            function setPpds(ppds_id) {
                                var id = ppds_id;
                                $.ajax({
                                    type: 'POST',
                                    data: {
                                        id: id
                                    },
                                    url: '<?php echo $this->createUrl('generatePpds'); ?>',
                                    dataType: "json",
                                    success: function(data) {
                                        if (data.ok != 1) {
                                            toastr.warning(data.msg);
                                            $("#RIPasienKirimKeUnitLainT_nim").val("");
                                            $("#RIPasienKirimKeUnitLainT_nama_prodi").val("");
                                            $("#RIPasienKirimKeUnitLainT_no_hp").val("");
                                            return false;
                                        }
                                        setVal(data.data);
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log(errorThrown);
                                    }
                                });
                            }

                            function setVal(data) {
                                $("#RIPasienKirimKeUnitLainT_nim").val(data.ppds_nim);
                                $("#RIPasienKirimKeUnitLainT_nama_prodi").val(data.programstudi_nama);
                                $("#RIPasienKirimKeUnitLainT_no_hp").val(data.nomor_hp);
                            }

                            function setDialogDiagnosaMasuk(obj) {
                                $('#dialogDiagnosaMasuk').dialog('open');
                                $("#judul").html($(obj).attr('judul_id'));

                                var data_id = $(obj).attr('data_id');

                                $("#tampungDiagnosa").val(data_id);
                            }

                            $('.btn-cari').trigger('click');
                        </script>