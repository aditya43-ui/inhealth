<style type="text/css">
    .nav-tabs>.active>a,
    .nav-tabs>.active>a:hover,
    .nav-tabs>li>a {
        cursor: pointer;
    }

    .truncate {
width: 95%;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
}

    .integer {
        text-align: right;
    }
</style>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>
<?php

// var_dump(Yii::app()->controller->module->id); die;

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

<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$pg_loginpps = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));

$modul_id = Yii::app()->user->getState('modul_id');
// $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;

if(!empty($pg_login->kelompokpegawai_id)){
    $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
}
if (!empty($pg_loginpps->kelompokpegawai_id)){
    $readonly = $pg_loginpps->kelompokpegawai_id == 2 && $modul_id != 7;

}

$hide = $readonly ? " hide" : "";
$hidden2 = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");

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
<?php 
$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

if (!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {

 
    $idPasienKirimKeUnitLain = isset($_GET['pasienkirim_id']) ? $_GET['pasienkirim_id'] : null;

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
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Laboratorium Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div class="block-tabel">
            <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
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

<?php }else { ?>

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
<div class="antirow">

    <div class="row">
        <?php echo $form->errorSummary($modKirimKeUnitLain); ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
        

        $sukses = isset($_GET['sukses'])?$_GET['sukses']:'';
        echo CHtml::hiddenField('sukses', $sukses);
        
        ?></p>-->
        <span hidden><?php echo $form->dropDownListRow($modKirimKeUnitLain, 'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'reqKunjungan')); ?></span>
       
        <div class="col-sm-12" <?=$hidden2?>>
            <div class="tab-pane active" id="tabs-basic">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="tabes">
                        <li class="active" onClick="tab1(this)" id="klinik"><a data-toggle="tab">Patologi Klinik</a></li>
                        <!-- <li onClick="tab1(this)" id="anatomi"><a data-toggle="tab">Anatomi</a></li> -->
                    </ul>
            
    <div class="col-sm-12" style="margin: 20px;" <?=$hidden2?>>


    <div id="form-caripemeriksaan" class="col-sm-12 form-horizontal" <?=$hidden2?>>

    <div class="row">
    <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>
            <div class="row" <?=$hidden2?>>
                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Form <b>Perujuk</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <?php echo CHtml::hiddenField('ruangan_id', '', array('readonly' => true)); ?>
                      
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
                                            // 'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'span3'),
                                    )); ?>
                                </div>
                            </div>
                            <?php echo $form->dropDownListRow(
                                $modKirimKeUnitLain,
                                'pegawai_id',
                                CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                            ); ?>
                            <?php
                            echo $form->dropDownListRow(
                                $modKirimKeUnitLain, 'ppds_id', CHtml::listData($modKirimKeUnitLain->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
                            );
                            ?>
                            <?php
                            echo $form->textFieldRow(
                                $modKirimKeUnitLain, 'no_ppds', array( 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")
                            );
                            ?>
         
                            <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Catatan Dokter', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            <div class='control-group'>
                                <?php echo CHtml::label("Cyto <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cito'), array('class' => 'control-label required')) ?>
                                <div class='controls'>
                                <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cito', array('0'=>'Biasa','1'=>'Cyto'), array('onchange'=>'','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3')); ?>
                                </div>
                            </div>
                            <?php $modul = Yii::app()->user->getState('modul_id'); ?>
                            <?php if($modul !== 6):?>
                            <div>
                                <?php echo $form->checkBoxRow($modKirimKeUnitLain, 'isbayarkekasirpenunjang', array('onkeyup' => "return $(this).focusNextInputField(event);", 'title' => "Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel' => 'tooltip')) ?>
                            </div>
                            <?php endif;?>                        
                        </div>
                    </div>
                </div>
       
                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Laboratorium </b>
                            </div>
                        </div>
                <?php 
                    $hidden = "";
                    if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
                        $hidden = "hidden";
                    }
                ?>
                <div class="panel-body table-responsive">
                        <table id="tblFormPemeriksaanLab" class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>Jenis Pemeriksaan</th>
                                    <th>Pemeriksaan</th>
                                    <th>Jumlah</th>
                                    <th>Tarif</th>
                                    <th>Cyto</th>
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!$modKirimKeUnitLain->isNewRecord) {
                                    $det = PermintaankepenunjangT::model()->findAllByAttributes(array(
                                        'pasienkirimkeunitlain_id'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id
                                    ));

                                    foreach ($det as $item) {
                                        echo $this->renderPartial($this->path_view . '_formLoadPemeriksaanLabUpdate', array('item' => $item, 'id_tindakan' => $item->daftartindakan_id, 'paket' => null), true);
                                    }


                                } ?>
                            </tbody>
                        </table>
                        <table class="table bordered table-striped table-condensed">
                            <tr>
                                <td width="80%" style="text-align: right;">
                                    Perkiraan Harga Pemeriksaan
                                </td>
                                <td><?php echo CHtml::textField('periksaTotal', '', array('class' => 'span3 integer', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td>
                            </tr>
                        </table>
            
                        </div>
                    </div>
                </div>
            </div>
        <br><br>
 

    <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>
<?php
 
if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD){ ?>
    <div class="row">
    <div class="control-group" style="float:left;">
    <?php echo CHtml::activeLabel($modPemeriksaanLab, 'jenispemeriksaanlab_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPemeriksaanLab, 'jenispemeriksaanlab_nama', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array(
                    'condition' => 'jenispemeriksaanlab_aktif = true',
                    'order' => 'jenispemeriksaanlab_urutan',
                )), 'jenispemeriksaanlab_nama', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Jenis Pemeriksaan Lab',)); ?>
            </div>
       
            <div class="controls"  style="margin-left:150px;">
            <?php echo CHtml::activeLabel($modPemeriksaanLab, 'jenisform_id', array('class' => 'control-label')); ?>
            <?php
                   $modPemeriksaanLab->jenisform_nama = 3;
                echo CHtml::activeDropDownList($modPemeriksaanLab, 'jenisform_id', CHtml::listData(JenisformM::model()->findAllByAttributes(array('jenisform_id'=>array(4,5,3)), array('condition'=>'jenisform_aktif = true', 'order'=>'jenisform_id')), 'jenisform_id', 'jenisform_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 input_jenisform_id', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Jenis Form Lab',
                'onchange'=>"setInputPilihJenisForm(); updateChecklistPemeriksaanLab();")); ?>
          
          </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanLab, 'pemeriksaanlab_id', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Pemeriksaan Lab', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                <?php echo CHtml::activeTextField($modPemeriksaanLab, 'pemeriksaanlab_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Pemeriksaan Lab', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanLab();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
            </div>
        </div>
        </div>
        <?php } else { ?> 
    <div class="row" <?=$hidden2?>>
    <div class="control-group" style="float:left;">
        <?php echo CHtml::activeLabel($modPemeriksaanLab, 'jenispemeriksaanlab_id', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo CHtml::activeDropDownList($modPemeriksaanLab, 'jenispemeriksaanlab_nama', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array(
                                        'condition' => 'jenispemeriksaanlab_aktif = true',
                                        'order' => 'jenispemeriksaanlab_urutan',
                                    )), 'jenispemeriksaanlab_nama', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Jenis Pemeriksaan Lab',)); ?>
                         </div>
        <?php echo CHtml::activeLabel($modPemeriksaanLab, 'jenisform_id', array('class' => 'control-label', 'style'=>'margin-left:175px;')); ?>
            <div class="controls" style="margin-left: 70px;">
                <?php
                $modPemeriksaanLab->jenisform_id = 1;
                echo CHtml::activeDropDownList($modPemeriksaanLab, 'jenisform_id', CHtml::listData(JenisformM::model()->findAll('jenisform_aktif = true order by jenisform_id'), 'jenisform_id', 'jenisform_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 input_jenisform_id','style'=>'margin-left:-70px;', 
                'onkeyup' => "return $(this).focusNextInputField(event)", 
                'onchange'=>"setInputPilihJenisForm(); updateChecklistPemeriksaanLab();",
                //  "onchange" => "updateChecklistFormLab();",
                 'placeholder' => 'Nama Jenis Form Lab')); ?>
            </div>
        </div>
            <div class="control-group" style="float:left;">
                <?php echo CHtml::activeLabel($modPemeriksaanLab, 'pemeriksaanlab_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php //echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Pemeriksaan Lab', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                    <?php echo CHtml::activeTextField($modPemeriksaanLab, 'pemeriksaanlab_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Pemeriksaan Lab', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanLab();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
                </div>

                <div class="controls"  style="margin-left:80px;">
                <?php echo CHtml::activeLabel($modPendaftaran, 'kelaspelayanan_id', array('class' => 'control-label')); ?>
                <div class="controls"  style="margin-left:0px;">

                    <?php
                        echo CHtml::activeDropDownList($modPendaftaran, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_id in (5, 6)'), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 input_kelaspelayanan_id', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Jenis Form Lab',
                    'onchange'=>"updateChecklistPemeriksaanLab();"));
                    ?>
                </div>
                </div>
            </div>
            <div class="control-group" style="float:left;">
            
            </div>
        </div>
        <?php } ?>
        </div>
      
</div>
 <br><br><br>
<div class="tab-content biru daftar-pemeriksaan" style="height:400px; overflow-y:scroll;" <?=$hidden2?>>
                        
                        <div class="white tab-pane" id="tab1-klinik">
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
                                                    <div class="boxtindakan" style="margin-bottom: -10px;">
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

   
 
    
<div class="form-actions" <?=$hidden2?>>
    <?php
    echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekInput();', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled'=>$modPendaftaran->isPasienPulangAtauTindakLanjut($_GET['konsulpoli_id'] ?? null))
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

<?php } ?>
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

       $(document).ready(function() {
           var jenis = jQuery('#<?php echo CHtml::activeId($modPemeriksaanLab, 'jenisform_nama') ?>');	
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

    function setTrue(obj) {

        var cito = $(obj).is(':checked');

        if(cito) {
            $(obj).closest('td').find('.apa-cito').val("ya");
        } else {
            $(obj).closest('td').find('.apa-cito').val("tidak");
        
        }
    }

    $(document).ready(function () {

        <?php if(Yii::app()->controller->module->id == 'rawatDarurat'): ?>

        setTimeout(() => {

            $('#pemeriksaanlab[value="300"]').prop('checked', true).trigger('click');
            
        }, 5000);

            $('.input_jenisform_id').val(3).change();
        <?php endif;?>
    });
    </script>