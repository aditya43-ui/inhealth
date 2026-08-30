<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>
<?php
$this->breadcrumbs = array(
    'Laboratorium',
);
$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">LABORATORIUM</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));
?>

<style>

</style>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-laboratorium-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Laboratorium
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Laboratorium Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
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

        <div class="formInputTab">
            <?php echo $form->errorSummary($modKirimKeUnitLain, $modPasienMasukPenunjang); ?>
            <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div hidden>
                <?php echo $form->dropDownListRow($modKirimKeUnitLain, 'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqKunjungan')); ?>
            </div>
            <div class="tab-pane active" id="tabs-basic">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="tabes">
                        <li class="active" onClick="tab1(this)" id="klinik"><a data-toggle="tab">Patologi Klinik</a></li>
                        <!-- <li onClick="tab1(this)" id="anatomi"><a data-toggle="tab">Anatomi</a></li> -->
                    </ul>
                    <div class="col-sm-12" style="margin: 20px;">


            <div id="form-caripemeriksaan" class="col-sm-12 form-horizontal" style="margin-bottom: 17px;">
            <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Form <b>Perujuk</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <?php echo CHtml::hiddenField('ruangan_id', '', array('readonly' => true)); ?>
                            <?php echo CHtml::hiddenField('deposit', $modDeposit, array()); ?>
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
                                <?php echo CHtml::label("Cyto <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cyto'), array('class' => 'control-label required')) ?>
                                <div class='controls'>
                                <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cito', array('0'=>'Biasa','1'=>'Cyto'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3')); ?>
                                </div>
                            </div>
                            <div>
                                <?php echo $form->checkBoxRow($modKirimKeUnitLain, 'isbayarkekasirpenunjang', array('onkeyup' => "return $(this).focusNextInputField(event);", 'title' => "Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel' => 'tooltip')) ?>
                            </div>                        
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
                        <div class="panel-body table-responsive">
                            <table id="tblFormPemeriksaanLab" class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th>Jenis Pemeriksaan</th>
                                        <th>Pemeriksaan</th>
                                        <th>Jumlah</th>
                                        <th>Tarif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--<tr id="trPeriksaLabKosong"><td colspan="4"></td></tr>-->
                                </tbody>
                            </table>
                            <table class="table table-bordered table-condensed">
                                <tr <?php echo Params::HIDDEN_HARGA ?>>
                                    <td width="70%" style="text-align: right;">Total Biaya Pemeriksaan</td>
                                    <td><?php echo CHtml::textField('periksaTotal', '', array('class' => 'span2 integer', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            
<div class="row">

    <div class="control-group" style="float:left;">
        <?php echo CHtml::activeLabel($modPemeriksaanLab, 'jenispemeriksaanlab_id', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo CHtml::activeDropDownList($modPemeriksaanLab, 'jenispemeriksaanlab_nama', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array(
                                        'condition' => 'jenispemeriksaanlab_aktif = true',
                                        'order' => 'jenispemeriksaanlab_urutan',
                                    )), 'jenispemeriksaanlab_nama', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Jenis Pemeriksaan Lab',)); ?>
                         </div>
        <?php echo CHtml::activeLabel($modPemeriksaanLab, 'jenisform_id', array('class' => 'control-label', 'style'=>'margin-left:175px;')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPemeriksaanLab, 'jenisform_nama', CHtml::listData(JenisformM::model()->findAll(), 'jenisform_nama', 'jenisform_nama'), array('empty' => '-- Pilih --', 'class' => 'span3','style'=>'margin-left:-70px;', 
                'onkeyup' => "return $(this).focusNextInputField(event)", 
               // "onchange" => "updateChecklistFormLab();",
                 'placeholder' => 'Nama Jenis Form Lab')); ?>
            </div>

        </div>
    <div class="control-group" style="float:left;">
        <?php echo CHtml::activeLabel($modPemeriksaanLab, 'pemeriksaanlab_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPemeriksaanLab, 'pemeriksaanlab_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Pemeriksaan Lab', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
            <?php // echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Pemeriksaan Lab', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanLab();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
        </div>
    </div>
</div>
</div>
                   <div id="daftar-pemeriksaan">
                   <div class="biru tab-content" style="height: 400px; overflow-y: scroll;">
                        <div class="white tab-pane" id="tab1-klinik">
                            <!--<fieldset class="box" class="tab-pane" id="tab1-klinik">-->
                            <!--<legend class="rim">PATOLOGI KLINIK</legend>-->
                            <table style="width: 88%; margin-left:-7px; margin-top:50px; border: none;">
                                <tr>
                                    <td>
                                        <div id="formPeriksaLab">
                                            <?php foreach ($modJenisPeriksaLab as $i => $jenisPeriksa) {
                                                $ceklist = false;
                                                $patologi = $jenisPeriksa->jenispemeriksaanlab_kelompok;
                                                if ($patologi == Params::PATOLOGI_KLINIK) {
                                            ?>
                                                    <div class="col-sm-3">
                                                        <div class="boxtindakan" style="width: 210px; margin-bottom:-17px;">
                                                            
                                                                <div class="panel-body">
                                                                    <?php

                                                                    $cekperiksa = '';

                                                                    foreach ($modPeriksaLab as $j => $pemeriksaan) {
                                                                        if ($jenisPeriksa->jenispemeriksaanlab_id == $pemeriksaan->jenispemeriksaanlab_id) {
                                                                            $cekperiksa .= '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                                                'value' => $pemeriksaan->pemeriksaanlab_id,
                                                                                'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_KLINIK . ");"
                                                                            ));
                                                                            $cekperiksa .= "<span>" . $pemeriksaan->pemeriksaanlab_nama . " - " . $pemeriksaan->pemeriksaanlab_kode ?? '' ."</span></label><br>";
                                                                        }
                                                                    }


                                                                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                                                        'id' => 'tabel-riwayatanamnesa-' . $i . '-' . $j,
                                                                        'content' => array(
                                                                            'content-detailanamnesa-' . $i . '-' . $j => array(
                                                                                'header' => '<h6>' . $jenisPeriksa->jenispemeriksaanlab_nama .  '</h6>',
                                                                                'isi' => $cekperiksa,
                                                                                'active' => false,
                                                                            ),
                                                                        ),
                                                                    ));
                                                                    ?>
                                                                </div>

                                                        </div>
                                                    </div>
                                            <?php }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <!--</fieldset>-->
                        </div>
                        <div class="tab-pane" id="tab1-anatomi">
                            <!--<legend class="rim">PATOLOGI ANATOMI</legend>-->
                            <div class="white">
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td>
                                            <div id="formPeriksaLab">
                                                <?php foreach ($modJenisPeriksaLab as $i => $jenisPeriksa) {
                                                    $ceklist = false;
                                                    $patologi = $jenisPeriksa->jenispemeriksaanlab_kelompok;
                                                    if ($patologi != Params::PATOLOGI_KLINIK) {
                                                ?>
                                                        <div class="col-sm-4" style="margin-bottom: 17px;">
                                                            <div class="panel panel-success">
                                                                <div class="panel-heading">
                                                                    <div class="panel-title"><?php echo $jenisPeriksa->jenispemeriksaanlab_nama; ?></div>
                                                                </div>
                                                                <div class="panel-body boxtindakan">
                                                                    <?php foreach ($modPeriksaLab as $j => $pemeriksaan) {
                                                                        if ($jenisPeriksa->jenispemeriksaanlab_id == $pemeriksaan->jenispemeriksaanlab_id) {
                                                                            echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                                                'value' => $pemeriksaan->pemeriksaanlab_id,
                                                                                //'onclick' => "inputperiksa(this,".Params::RUANGAN_ID_LAB_ANATOMI.");"));
                                                                                'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_KLINIK . ");"
                                                                            ));
                                                                            echo "<span>" . $pemeriksaan->pemeriksaanlab_nama . "</span></label><br>";
                                                                        }
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php }
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

          
            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'onKeypress' => 'cekInput();', 'onclick' => 'cekInput();')
                ); ?>
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
                $content = $this->renderPartial('../tips/tips', array(), true);
                $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                $idPasienKirimKeUnitLain = isset($_GET['pasienkirim_id']) ? $_GET['pasienkirim_id'] : null;
                $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
                $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
                $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);

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
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
            </div>

        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions', ['modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modKirimKeUnitLain' => $modKirimKeUnitLain])?>
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


    //    $(document).ready(function() {
    //        var jenis = jQuery('#<?php //echo CHtml::activeId($modPemeriksaanLab, 'jenispemeriksaanlab_nama') ?>');	
    //        jQuery(jenis).multiselect({
    //                includeSelectAllOption: false,
    //                buttonClass: "form-control",
    //                maxHeight: 300,
    //                buttonWidth: '182px',
    //                enableCaseInsensitiveFiltering: true
    //        }).hide();


    //    });
    function updateChecklistPemeriksaanLab(){
        var form_index = $('#form_index').val();

        var cek = [];

        $('input:checked').each(function () {

            cek.push($(this).attr("value"));
        });
        $('#daftar-pemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/rawatInap/laboratoriumTRI/SetChecklistPemeriksaanLab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#daftar-pemeriksaan').html(data.content);
            $('#formPeriksaLab').tile({
               widths: [190]
              });

            if($('#klinik').hasClass("active")) {
                $('#anatomi').removeAttr('class');
                $('#tab1-anatomi').fadeOut(100);
                $('#tab1-klinik').fadeIn(100);  

            }
            if($('#anatomi').hasClass("active")) {

            $('#klinik').removeAttr('class');
                $('#tab1-klinik').fadeOut(100);
                $('#tab1-anatomi').fadeIn(100);  
            }

            $.each(cek, function (idx, val) {
                $('input[type="checkbox"][value="' + val + '"]').prop("checked", "checked");
            });
             
            $('#daftar-pemeriksaan').removeClass("animation-loading");

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setChecklistPemeriksaanLabReset(){
    $("#form-caripemeriksaan").find('input, select').val('');
    updateChecklistPemeriksaanLab();
}

    $(document).ready(function() {
        $('#ruangan_id').val('<?php echo Params::RUANGAN_ID_LAB_KLINIK; ?>'); // untuk menandakan antara TAB lab klinik dengan anatomi
       
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
    });

    //    $(document).ready(function() {
    //        var jenis = jQuery('#<?php //echo CHtml::activeId($modPemeriksaanLab, 'jenisform_nama') ?>');	
    //        jQuery(jenis).multiselect({
    //                includeSelectAllOption: false,
    //                buttonClass: "form-control",
    //                maxHeight: 300,
    //                buttonWidth: '182px',
    //                enableCaseInsensitiveFiltering: true
    //        }).hide();


    //    });


    $('.accordion-toggle').attr('style', 'width: 250px;');
    $('.glyphicon-chevron-down').attr('style', 'font-size:16px; margin-top: -30px;');
    $('.accordion-inner').attr('style', 'width: 250px;');


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