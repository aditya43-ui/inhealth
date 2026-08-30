<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>
<?php
$this->breadcrumbs = array(
    'Radiologi',
);

//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">RADIOLOGI</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));
if (isset($_GET['idPasienKirimKeUnitLain'])) {
    Yii::app()->user->setFlash('success', "Data Rujukan Ke Radiologi berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-radiologi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return validasiCek(this);'),
)); ?>
<legend class="rim">Tabel Riwayat Pemeriksaan Radiologi Pasien</legend>
<?php $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
<div class="control-group">
    <?php // RSPMC-1260 echo $form->dropDownListRow($modKirimKeUnitLain,'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(Params::RUANGAN_ID_RAD), 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'reqKunjungan')); 
    ?>
    <?php echo $form->dropDownListRow($modKirimKeUnitLain, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true'), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqKunjungan')); ?>
</div>

<div class="formInputTab">

    <?php echo $form->errorSummary($modKirimKeUnitLain, $modPasienMasukPenunjang); ?>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <!--<div id="formPeriksaLab">-->
                <?php
                //                        $jenisPeriksa = '';
                //                        foreach($modPeriksaRad as $i=>$pemeriksaan){ 
                //                            $ceklist = false;
                //                            if ($pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_aktif == false) continue;
                //                            if($jenisPeriksa != $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama){
                //                                echo ($jenisPeriksa!='') ? "</div></div></div></div>" : "";                                
                //                                $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                //                                echo "<div class='col-sm-4'>";
                //                                echo "<div class='panel panel-success'>";
                //                                echo "<div class='panel-heading'>"
                //                                .    "  <div class='panel-title'>".$pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama."</div>";
                //                                echo "</div>";
                //                                echo "<div class='panel-body boxtindakan'  style=''>";
                //                                //echo "<h6>".$pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama."</h6>";
                //                                echo '<label class="checkbox inline">'.CHtml::checkBox("pemeriksaanRad[]", $ceklist, array('value'=>$pemeriksaan->pemeriksaanrad_id,
                //                                                                                         'onclick' => "inputperiksa(this);"));
                //                                echo "<span>".$pemeriksaan->pemeriksaanrad_nama."</span></label><br>";
                //                            } else {
                //                                $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                //                                echo '<label class="checkbox inline">'.CHtml::checkBox("pemeriksaanRad[]", $ceklist, array('value'=>$pemeriksaan->pemeriksaanrad_id,
                //                                                                                         'onclick' => "inputperiksa(this);"));
                //                                echo "<span>".$pemeriksaan->pemeriksaanrad_nama."</span></label><br>";
                //                            }
                //                        } echo "</div></div></div></div>";
                ?>
                <!--</div>-->
                <div id="formPeriksaLab">
                    <?php
                    $jenisPeriksa = '';
                    foreach ($modPeriksaRad as $i => $pemeriksaan) {
                        $ceklist = false;
                        if ($jenisPeriksa != $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama) {
                            echo ($jenisPeriksa != '') ? "</div></div></div></div>" : "";
                            $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                            echo "<div class='col-sm-4'>";
                            echo "<div class='panel panel-success'>";
                            echo "<div class='panel-heading'>"
                                .    "  <div class='panel-title'>" . $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama . "</div>";
                            echo "</div>";
                            echo "<div class='panel-body boxtindakan' style=''>";
                            //                                echo "<h6>".$pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama."</h6>";
                            echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanRad[]", $ceklist, array(
                                'value' => $pemeriksaan->pemeriksaanrad_id,
                                'onclick' => "inputperiksa(this);"
                            ));
                            echo CHtml::hiddenField('adaTindakan_' . $pemeriksaan->pemeriksaanrad_id, '', array('readonly' => TRUE, 'class' => 'adaTindakan'));
                            $pemeriksaanrad_kode = '';
                            if(!empty($pemeriksaan->pemeriksaanrad_kode)) {
                                $pemeriksaanrad_kode = $pemeriksaan->pemeriksaanrad_kode;
                            }
                            echo "<span>" . $pemeriksaan->pemeriksaanrad_nama . ' - ' . $pemeriksaanrad_kode . "</span></label><br>";
                        } else {
                            $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                            echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanRad[]", $ceklist, array(
                                'value' => $pemeriksaan->pemeriksaanrad_id,
                                'onclick' => "inputperiksa(this);"
                            ));
                            echo CHtml::hiddenField('adaTindakan_' . $pemeriksaan->pemeriksaanrad_id, '', array('readonly' => TRUE, 'class' => 'adaTindakan'));
                            $pemeriksaanrad_kode = '';
                            if(!empty($pemeriksaan->pemeriksaanrad_kode)) {
                                $pemeriksaanrad_kode = $pemeriksaan->pemeriksaanrad_kode;
                            }
                            echo "<span>" . $pemeriksaan->pemeriksaanrad_nama . ' - ' . $pemeriksaanrad_kode . "</span></label><br>";
                        }
                    }
                    echo "</div></div></div></div>";
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <div class="row">
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('deposit', $modDeposit, array()); ?>
            <?php echo CHtml::hiddenField('pasienkirimkeunitlain_id', '', array()); ?>
            <div class="control-group">
                <label class="control-label required" for="PIPasienKirimKeUnitLainT_tgl_kirimpasien">
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
                        'htmlOptions' => array('readonly' => true),
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
         
            <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('onkeypress' => "return $(this).focusNextInputField(event);")) ?>
            <?php echo $form->checkBoxRow($modKirimKeUnitLain,'isbayarkekasirpenunjang',array('onkeyup'=>"return $(this).focusNextInputField(event);",'title'=>"Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel'=>'tooltip')) 
            ?>
            <div class='control-group'>
                <?php echo CHtml::label("Cyto <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cyto'), array('class' => 'control-label required')) ?>
                <div class='controls'>
                    <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cyto', array('0' => 'Biasa', '1' => 'Cyto'), array('onchange' => 'hitungCyto(this)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span3')); ?>
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
                    <table id="tblFormPemeriksaanRad" class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Jenis Pemeriksaan</th>
                                <th>Pemeriksaan</th>
                                <th>Tarif</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="trPeriksaRadKosong">
                                <td colspan="4"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td width="70%" style="text-align: right;">Total Biaya Pemeriksaan</td>
                            <td><?php echo CHtml::textField('periksaTotal', '', array('class' => 'span2', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--<table style="width: 100%; border: none;">
        <tr>
            <td width="50%">
                <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                        ?></p>

		        <?php // echo CHtml::hiddenField('deposit',$modDeposit,array()); 
                ?>	
		        <?php // echo CHtml::hiddenField('pasienkirimkeunitlain_id','',array()); 
                ?>	
                <div class="control-group">
                    <label class="control-label required" for="PIPasienKirimKeUnitLainT_tgl_kirimpasien">
                    Tanggal Permintaan
                    <span class="required">*</span>
                  </label>
                    <?php // $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
                    ?>
                    <div class="controls">
                            <?php
                            //                                    $this->widget('MyDateTimePicker',array(
                            //                                                    'model'=>$modKirimKeUnitLain,
                            //                                                    'attribute'=>'tgl_kirimpasien',
                            //                                                    'mode'=>'datetime',
                            //                                                    'options'=> array(
                            //                                                        'dateFormat'=>Params::DATE_FORMAT,
                            //                                                        'maxDate' => 'd',
                            //                                                    ),
                            //                                                    'htmlOptions'=>array('readonly'=>true),
                            //                            )); 
                            ?>
                    </div>
                </div>
                <?php // echo $form->dropDownListRow($modKirimKeUnitLain,'pegawai_id', CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                //                                                                array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php // echo $form->textAreaRow($modKirimKeUnitLain,'catatandokterpengirim',array('onkeypress'=>"return $(this).focusNextInputField(event);")) 
                ?>
				<?php // echo $form->checkBoxRow($modKirimKeUnitLain,'isbayarkekasirpenunjang',array('onkeyup'=>"return $(this).focusNextInputField(event);",'title'=>"Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel'=>'tooltip')) 
                ?>
            </td>
            <td width="50%">
        <legend class="rim">Tabel Pemeriksaan Radiologi  <?php // echo isset($modJenisTarif) ? "- ".$modJenisTarif->jenistarif->jenistarif_nama : "" ; 
                                                            ?></legend>
                <table id="tblFormPemeriksaanRad" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Jenis Pemeriksaan</th>
                            <th>Pemeriksaan</th>
                            <th>Tarif</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-condensed">
                    <tr><td width="70%" style="text-align: right;">Total Biaya Pemeriksaan</td><td><?php // echo CHtml::textField('periksaTotal', '',array('class'=>'span2', 'style'=>'text-align:right;', 'disabled'=>'disabled'));
                                                                                                    ?></td></tr>
                </table>
            </td>
        </tr>
    </table>-->

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'onKeypress' => 'cekInput()', 'onclick' => 'cekInput()')
        ); ?>
        <?php
        if (isset($_GET['idPasienKirimKeUnitLain'])) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp";
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
        }
        ?>
        <?php
        $content = $this->renderPartial('../tips/tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
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
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD); ?>
    </div>

</div>

<?php $this->endWidget(); ?>

<script>
    function inputperiksa(obj) {
        if ($(obj).is(':checked')) {
            var pemeriksaanrad_id = obj.value;
            var kelaspelayanan_id = $('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id') ?>').val();
            var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
            if (kelaspelayanan_id == '') {
                window.parent.myAlert("Silakan pilih kelas pelayanan terlebih dahulu!");
                $(obj).attr('checked', false);
                return false;
            }
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('perawatanIntensif/radiologiTPI/loadFormPemeriksaanRad') ?>',
                'data': {
                    pemeriksaanrad_id: pemeriksaanrad_id,
                    kelaspelayanan_id: kelaspelayanan_id,
                    pendaftaran_id: pendaftaran_id
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if ($.trim(data.form) == '') {
                        $(obj).removeAttr('checked');
                        alert('Pemeriksaan belum memiliki tarif');
                    }
                    $('#tblFormPemeriksaanRad #trPeriksaRadKosong').detach();
                    $('#tblFormPemeriksaanRad > tbody').append(data.form);
                    $("#tblFormPemeriksaanRad > tbody > tr:last .integer").maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ".",
                        "thousands": ",",
                        "precision": 0
                    });
                    $('.integer').each(function() {
                        this.value = formatNumber(this.value)
                    });
                    hitungTotal();
                },
                'cache': false
            });
            //    } else {
            //        window.parent.myConfirm("Apakah Anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
            //            if(r){
            //                batalPeriksa(obj.value);
            //                hitungTotal();
            //            }else{
            //                $(obj).attr('checked', 'checked');
            //            }
            //        });
            //    }
        } else {

            var adaTindakanPelayanan = $('.boxtindakan').find('input[name$="adaTindakan_' + obj.value + '"]').val();
            var pemeriksaanrad_id = obj.value;
            if (adaTindakanPelayanan != 0) {
                window.parent.myConfirm("Apakah Anda akan membatalkan/hapus pemeriksaan ini dari database?", "Perhatian!", function(r) {
                    if (r) {

                        var pasienkirimkeunitlain_id = $('#pasienkirimkeunitlain_id').val();
                        if (pasienkirimkeunitlain_id != '') {
                            var daftartindakan_id = $('#periksarad_' + pemeriksaanrad_id).find("input[name*='idDaftarTindakan']").val();
                            var pasienkirimkeunitlain_id_tabel = $('#periksarad_' + pemeriksaanrad_id).find("input[name*='pasienkirimkeunitlain_id']").val();
                            if (pasienkirimkeunitlain_id_tabel != '') {
                                jQuery.ajax({
                                    'url': '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/deletePemeriksaanRad') ?>',
                                    'data': {
                                        pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                                        daftartindakan_id: daftartindakan_id
                                    },
                                    'type': 'post',
                                    'dataType': 'json',
                                    'success': function(data) {
                                        if (data.pesan != '') {
                                            window.parent.myAlert(data.pesan);
                                            $(obj).attr('checked', 'checked');
                                        } else {
                                            window.parent.myAlert("Berhasil dihapus");
                                            $(obj).removeAttr('checked');
                                            hitungTotal();
                                        }
                                    },
                                    'cache': false
                                });

                            }
                        }

                        $('#tblFormPemeriksaanRad #periksarad_' + pemeriksaanrad_id).detach();
                    } else {
                        $(obj).attr('checked', 'checked');
                    }
                });
            } else {
                $('#tblFormPemeriksaanRad #periksarad_' + pemeriksaanrad_id).detach();
            }

            hitungTotal();
        }
    }

    function batalPeriksa(idPemeriksaanrad) {
        var pasienkirimkeunitlain_id = $('#pasienkirimkeunitlain_id').val();
        if (pasienkirimkeunitlain_id != '') {
            var daftartindakan_id = $('#periksarad_' + idPemeriksaanrad).find("input[name*='idDaftarTindakan']").val();
            var pasienkirimkeunitlain_id_tabel = $('#periksarad_' + idPemeriksaanrad).find("input[name*='pasienkirimkeunitlain_id']").val();
            if (pasienkirimkeunitlain_id_tabel != '') {
                jQuery.ajax({
                    'url': '<?php echo Yii::app()->createUrl('perawatanIntensif/radiologiTPI/deletePemeriksaanRad') ?>',
                    'data': {
                        pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                        daftartindakan_id: daftartindakan_id
                    },
                    'type': 'post',
                    'dataType': 'json',
                    'success': function(data) {
                        if (data.pesan != '') {
                            $(obj).attr('checked', false);
                            window.parent.myAlert("Data Gagal Dihapus!");
                        }
                    },
                    'cache': false
                });
            }
        }
        $('#tblFormPemeriksaanRad #periksarad_' + idPemeriksaanrad).detach();
        if ($('#tblFormPemeriksaanRad tr').length == 1)
            $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
    }

    //function batalKirim(pasienkirimkeunitlain_id,pendaftaran_id)
    //{
    //    window.parent.myConfirm("Apakah Anda akan membatalkan kirim pasien ke Radiologi?","Perhatian!",function(r) {
    //        if(r){
    //            $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {pasienkirimkeunitlain_id: pasienkirimkeunitlain_id, pendaftaran_id:pendaftaran_id}, function(data){
    //                $('#tblListPemeriksaanRad').html(data.result);
    //				window.parent.myAlert(data.pesan);
    //            }, 'json');
    //        }
    //    });
    //}

    function hitungTotal() {
        var total = 0;
        $('.tarif_satuan').each(
            function() {
                qty = $(this).parents('tr').find('.qty').val();
                total += unformatNumber(this.value) * qty;
            }
        );

        $('#periksaTotal').val(formatNumber(total));
    }

    function cekInput() {
        var deposit = $('#deposit').val();
        var periksaTotal = unformatNumber($('#periksaTotal').val());
        var pemeriksaan = $('#tblFormPemeriksaanRad > tbody tr').length;
        if (pemeriksaan <= 0) {
            window.parent.myAlert("Pilih dahulu pemeriksaan");
            return false;
        }
        if (deposit == "") {
            //              RSPMC-1006
            //		window.parent.myConfirm("Pasien Belum Melakukan Deposit!","Perhatian!",function(r) {
            //		   if(r){	
            // notifikasi
            var periksaTotal = $('#periksaTotal').val();
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: 19,
                judulnotifikasi: 'Deposit Tidak Mencukupi',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik;
                                                                        echo "-";
                                                                        echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp <?php echo isset($modDeposit) ? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp ' + periksaTotal + '. Silakan hubungi kasir'
            };
            //			   insert_notifikasi(params);
            disableOnSubmit('#btn_submit');
            setTimeout(function() {
                $('#rjpasien-radiologi-t-form').submit();
            }, 2000);
            //		   }
            //	   });
        } else if (deposit < periksaTotal) {
            window.parent.myConfirm("Uang deposit tidak mencukupi, Silakan hubungi kasir!", "Perhatian!", function(r) {
                if (r) {
                    // notifikasi
                    var periksaTotal = $('#periksaTotal').val();
                    var params = [];
                    params = {
                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                        modul_id: 19,
                        judulnotifikasi: 'Deposit Tidak Mencukupi',
                        isinotifikasi: '<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik;
                                                                                echo "-";
                                                                                echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp <?php echo isset($modDeposit) ? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp ' + periksaTotal + '. Silakan hubungi kasir'
                    };
                    //					insert_notifikasi(params);
                    disableOnSubmit('#btn_submit');
                    setTimeout(function() {
                        $('#rjpasien-radiologi-t-form').submit();
                    }, 2000);
                }
            });
        } else {
            $('#rjpasien-radiologi-t-form').submit();
        }
        return false;
    }

    function cekInputQty(obj) {
        if ($(obj).val() == 0) {
            $(obj).val(1);
        }
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
                //        insert_notifikasi(params);
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
                modul_id: <?php echo Params::MODUL_ID_RAD ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            //        insert_notifikasi(params);
        <?php
        }
        ?>
    })
</script>
<?php echo $this->renderPartial('_jsFunctions', array()); ?>