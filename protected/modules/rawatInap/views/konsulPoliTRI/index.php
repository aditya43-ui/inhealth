<?php
$this->breadcrumbs = array(
    'Konsul Poli',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<style>
    tr td .add-on {
        margin: 0 !important;
    }
</style>

<!--<legend class="rim">Tabel Konsultasi Poliklinik</legend>-->

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkonsul-poli-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#PPJadwaldokterM_pegawai_id' . CHtml::activeId($modKonsul, 'catatan_dokter_konsul'),
)); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Konsultasi Poliklinik
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_listKonsulPoli', array('modRiwayatKonsul' => $modRiwayatKonsul)); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($modKonsul); ?>
        <table style="width: 100%; border: none; margin-top: 17px;">
            <tr>
                <td>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php /*
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php // echo CHtml::textField('deposit',$modDeposit,array('onclick'=>'cekInput()')); ?>	
                    </div>
                </div>
                 * 
                 */ ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modKonsul, 'tglkonsulpoli', array('class' => 'control-label')) ?>
                                <?php $modKonsul->tglkonsulpoli = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKonsul->tglkonsulpoli, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modKonsul,
                                        'attribute' => 'tglkonsulpoli',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //                                                        'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true),
                                    )); ?>
                                </div>
                            </div>

                            
                            <div class="control-group">
                                <?php echo $form->labelEx($modPendaftaran, 'carabayar_id', array('class' => 'control-label refreshable')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList($modPendaftaran, 'carabayar_id', CHtml::listData($modPendaftaran->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                        'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPendaftaran))),
                                            //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                                            'success' => 'function(data){$("#' . CHtml::activeId($modPendaftaran, "penjamin_id") . '").html(data); setKarcis(); cekPilihSatu($("#' . CHtml::activeId($modPendaftaran, "penjamin_id") . '")); setKelasTanggunganDrop();}',
                                        ),
                                        'onchange' => 'setFormAsuransi(this.value);',
                                        'class' => 'span3 form-control ',
                                    ));
                                    ?>
                                </div>
                            </div>
   
                            <?php echo $form->dropDownListRow(
                                $modKonsul,
                                'ruangan_id',
                                CHtml::listData(RuangankonsulV::model()->findAll(), 'ruangan_id', 'ruangan_nama'),
                                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setTarif()')
                            ); ?>


                            <?php
                            echo $form->dropDownListRow($modKonsul, 'pegawai_id', CHtml::listData($modKonsul->getDokterItems(), 'pegawai_id', 'NamaLengkap'), array(
                                'empty' => '-- Pilih --',
                                'onchange' => 'setKarcis(); setNamaAsuransiDariPenjamin(this); searchPegawai(this); setAsuransiBadak(this.value); cekValiditasPenjamin(this.value); setFormAsuransiInhealth(this.value);',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 dokter-konsul form-control'
                            ));
                            ?>

                            <?php //echo $form->dropDownListRow($modKonsul,'ruangan_id', CHtml::listData(RIPendaftaranT::model()->getRuanganItems(), 'ruangan_id', 'ruangan_nama') ,
                                                    //   array('empty'=>'-- Pilih --',
                                                    //         'onchange'=>"listDokterRuangan(this.value)",
                                                    //         'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                            <?php //echo $form->dropDownListRow($modKonsul,'pegawai_id', CHtml::listData(RIPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                         
                            <?php /* echo $form->dropDownListRow(
                                $modKonsul,
                                'pegawai_id',
                                CHtml::listData($modKonsul->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                array('empty' => '-- Pilih --', 'class' => 'span3 dokter-konsul', 'onkeypress' => "return $(this).focusNextInputField(event);")
                            ); */ ?>
                            <?php //echo $form->textAreaRow($modKonsul, 'catatan_dokter_konsul', array('placeholder' => 'Catatan Dokter', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                        <div class="col-sm-6">

                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <span class="titleTindakan">
                                            <i class="glyphicon glyphicon-file"></i> Daftar Tindakan Konsultasi Poliklinik</span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div id="inputanHemodialisa" class="hidden">
                                        <br>
                                        <div class="control-group">
                                            <?php echo CHtml::label('Dialisat', 'Dialisat', array('class' => 'control-label')) ?>
                                            <div class="controls">
                                                <div class="form-inline">
                                                    <?php echo $form->radioButtonList($modKonsul, 'jenisdialisat_id', PeriksahdT::getJenisDialisat(), array('separator' => '', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <?php echo CHtml::label('Lama Hemodialisa', 'Lama Hemodialisa', array('class' => 'control-label')) ?>
                                            <div class="controls">
                                                <div class="form-inline">
                                                    <?php echo $form->textField($modKonsul, 'lama_hd', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?> Jam
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <?php echo CHtml::label('Penarikan Cairan', 'Penarikan Cairan', array('class' => 'control-label')) ?>
                                            <div class="controls">
                                                <div class="form-inline">
                                                    <?php echo $form->textField($modKonsul, 'penarikan_cairan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?> ml
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <?php echo CHtml::label('Akses Vaskular', 'Akses Vaskular', array('class' => 'control-label')) ?>
                                            <div class="controls">
                                                <?php echo $form->dropDownList(
                                                    $modKonsul,
                                                    'aksesvaskular_id',
                                                    CHtml::listData(AksesvaskularM::model()->findAll('aksesvaskular_aktif is TRUE'), 'aksesvaskular_id', 'aksesvaskular_nama'),
                                                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                                                ); ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <?php echo CHtml::label('Tranfusi', 'Tranfusi', array('class' => 'control-label')) ?>
                                            <div class="controls">
                                                <div class="form-inline">
                                                    <?php echo $form->radioButtonList($modKonsul, 'jenistransfusi_id', JenistransfusiM::getJenisTransfusi(), array('separator' => '', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="" id="tarif_poliklinik">

                                    </div>
                                    <?php //echo $form->dropDownListRow($modKonsul,'asalpoliklinikkonsul_id', CHtml::listData($modKonsul->getRuanganInstalasiItems(''), 'ruangan_id', 'ruangan_nama'),
                                    //array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <br/>
                            <b>Catatan Dokter</b>
                            <br/>
                            <br/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-group">
                                <label class="control-label">Subjective</label>
                                <div class="controls" style="width:80%;">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'subjective', 'toolbar'=>'mini','height'=>'100px')) ?>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Objective</label>
                                <div class="controls" style="width:80%;">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'objective', 'toolbar'=>'mini','height'=>'100px')) ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Assessment</label>
                                <div class="controls" style="width:80%;">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'assessment', 'toolbar'=>'mini','height'=>'100px')) ?>
                                </div>
                            </div>
                            <?php //echo $form->textAreaRow($modKonsul, 'subjective', array('placeholder' => 'Subjective', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php //echo $form->textAreaRow($modKonsul, 'assessment', array('placeholder' => 'Assessment', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                            <div class="control-group">
                                <label class="control-label">Planning</label>
                                <div class="controls" style="width:80%;">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'planning', 'toolbar'=>'mini','height'=>'100px')) ?>
                                </div>
                            </div>
                            <?php //echo $form->textAreaRow($modKonsul, 'objective', array('placeholder' => 'Objective', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php //echo $form->textAreaRow($modKonsul, 'planning', array('placeholder' => 'Planning', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </td>
            </tr>
            <!--<tr>
            <td colspan="2">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th colspan="2">Karcis Tindakan</th>
                        </tr>
                    </thead>
                    <?php //foreach ($karcisTindakan as $i => $karcis) { 
                    ?>
                    <tr>
                        <td width="15px;">
                            <?php //echo CHtml::checkBox('karcis[]', false, array()); 
                            ?>
                        </td>
                        <td>
                            <?php //echo $karcis->daftartindakan_nama; 
                            ?>
                        </td>
                    </tr>
                    <?php //} 
                    ?>
                </table>
            </td>
        </tr>-->
        </table>

        <div class="clear"></div>
        <div class="col-sm-6">
            <!--<div class="control-group">
                    <label class="control-label"></label>-->

            <!--</div>-->
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'onKeypress' => 'cekInput()', 'onclick' => 'cekInput()')
    ); ?>
    <?php
    if (isset($_GET['idKonsulPoli'])) {
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

    $idKonsulPoli = isset($_GET['idKonsulPoli']) ? $_GET['idKonsulPoli'] : null;
    $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idKonsulPoli=' . $idKonsulPoli);
    $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
    $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
    $urlListDokterRuangan = $this->createUrl('AjaxListDokter');

    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPermintaan(idKonsulPoli)
{
    window.open("${urlPrintPermintaan}&idKonsulPoli="+idKonsulPoli+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}

JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

    ?>
</div>


<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKonsul',
    'options' => array(
        'title' => 'Detail Konsul',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
        'position' => 'top',
    ),
));

echo '<div id="contentDetailKonsul">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKonsulHasil',
    'options' => array(
        'title' => 'Hasil Jawaban Konsul',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'resizable' => false,
        'position' => 'top',
    ),
));

echo '<div id="contentDetailKonsulHasil">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
$urlListDokterRuangan = $this->createUrl('AjaxListDokter');
?>

<script type="text/javascript">

function listDokterRuangan(idRuangan)
{
    $.post("<?php echo $urlListDokterRuangan; ?>", { idRuangan: idRuangan },
        function(data){
            $('#KonsulpoliT_pegawai_id').html(data.listDokter);
    }, "json");
}
    function viewDetailKonsul(idKonsulAntarPoli) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsul') ?>', {
            idKonsulAntarPoli: idKonsulAntarPoli
        }, function(data) {
            $('#contentDetailKonsul').html(data.result);
        }, 'json');
        $('#dialogDetailKonsul').dialog('open');
    }

    function viewDetailKonsulHasil(idKonsulAntarPoli) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsulHasil') ?>', {
            idKonsulAntarPoli: idKonsulAntarPoli
        }, function(data) {
            $('#contentDetailKonsulHasil').html(data.result);
        }, 'json');
        $('#dialogDetailKonsulHasil').dialog('open');
    }

    function batalKonsul(idKonsulAntarPoli, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan konsul ini?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKonsul') ?>', {
                    idKonsulAntarPoli: idKonsulAntarPoli,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    $('#tblListKonsul').html(data.result);
                }, 'json');
            }
        });
    }
    function setNamaAsuransiDariPenjamin(obj) {
        var t = ($(obj).find(":selected").text()).toUpperCase();
        $("#<?php echo CHtml::activeId($modPendaftaran, "namaperusahaan"); ?>").val(t);
    }

    function setAsuransiBadak() {
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>").val();
        var penjamin_id = $("#<?php echo CHtml::activeId($modPendaftaran, 'penjamin_id') ?>").val();
        var pegawai_id = $("#PPPasienM_pegawai_id").val();
        //	if(pasien_id!=''){
        $("#form-asubadak").addClass("animation-loading");
        $("#form-asudepartemen").addClass("animation-loading");
        $("#form-asupekerja").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAsuransiBadak'); ?>',
            data: {
                pasien_id: pasien_id,
                penjamin_id: penjamin_id,
                pegawai_id: pegawai_id
            },
            dataType: "json",
            success: function(data) {
                setAsuransiBadakReset();
                if (data != null) {
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nopeserta') ?>").val(data.nopeserta);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'namaperusahaan') ?>").val(data.namaperusahaan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'hubkeluarga') ?>").val(data.hubkeluarga);

                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'namaperusahaan') ?>").val(data.namaperusahaan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nopeserta') ?>").val(data.nopeserta);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);

                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nopeserta') ?>").val(data.nopeserta);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                    $("#<?php echo CHtml::activeId($modPegawai, 'alamat_pegawai') ?>").val(data.alamat_pegawai);
                    $("#<?php echo CHtml::activeId($modPegawai, 'notelp_pegawai') ?>").val(data.notelp_pegawai);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
                }

                $("#form-asubadak").removeClass("animation-loading");
                $("#form-asudepartemen").removeClass("animation-loading");
                $("#form-asupekerja").removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        //	}
    }

    function setAsuransiBadakReset() {
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'tgl_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'hubkeluarga') ?>").val("");

        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'tgl_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'hubkeluarga') ?>").val("");

        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'tgl_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'hubkeluarga') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'alamat_pegawai') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'notelp_pegawai') ?>").val("");
    }

    function setTarif() {
        var ruangan_id = $('#<?php echo CHtml::activeId($modKonsul, 'ruangan_id'); ?>').val();
        var penjamin_id = '<?php echo $modPendaftaran->penjamin_id; ?>';
        var kelaspelayanan_id = '<?php echo $modPendaftaran->kelaspelayanan_id; ?>';
        $.post('<?php echo $this->createUrl('ajaxSetTarif2') ?>', {
            ruangan_id: ruangan_id,
            penjamin_id: penjamin_id,
            kelaspelayanan_id: kelaspelayanan_id
        }, function(data) {
            $('#tarif_poliklinik').html(data.result);
            $('.dokter-konsul').html(data.dokter);
            hitungTotalTarif();
            if (ruangan_id == '<?php echo Params::RUANGAN_ID_HEMODIALISA; ?>') {
                $('.titleTindakan').html('Pengantar Permintaan Tindakan Hemodialisa');
                $('#inputanHemodialisa').removeClass('hidden');
            } else {
                $('.titleTindakan').html('Daftar Tindakan Konsultasi Poliklinik');
                $('#inputanHemodialisa').addClass('hidden');
            }
        }, 'json');
    }

    function cekInput() {
        //requiredCheck
        var ruangan = $('#RIKonsulPoliT_ruangan_id').val();
        if (ruangan == "") {
            alert('Ruangan Belum Dipilih!');
            return false;
        }
        //var deposit = $('#deposit').val();
        var totalTarif = unformatNumber($('#totalTarif').val());

        /*
        if (deposit == ""){
		myConfirm("Pasien Belum Melakukan Deposit!","Perhatian!",function(r) {
		   if(r){	
			   // notifikasi
			   var totalTarif =  $('#totalTarif').val();
			   var params = [];
			   params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik;
                                                                                                                                                                                                                echo "-";
                                                                                                                                                                                                                echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp <?php echo isset($modDeposit) ? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp ' + totalTarif + '. Silakan hubungi kasir'};
			   insert_notifikasi(params);
			   disableOnSubmit('#btn_submit');
			   setTimeout(function(){
			   $('#rjkonsul-poli-t-form').submit();
			   }, 2000);
		   }
	   });
	}else if (deposit < totalTarif){
			 myConfirm("Uang deposit tidak mencukupi, Silakan hubungi kasir!","Perhatian!",function(r) {
				if(r){	
					// notifikasi
					var totalTarif =  $('#totalTarif').val();
					var params = [];
					params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik;
                                                                                                                                                                                                                        echo "-";
                                                                                                                                                                                                                        echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp <?php echo isset($modDeposit) ? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp ' + totalTarif + '. Silakan hubungi kasir'};
					insert_notifikasi(params);
					disableOnSubmit('#btn_submit');
					setTimeout(function(){
					$('#rjkonsul-poli-t-form').submit();
					}, 2000);
				}
			});
	}else{ */
        $('#rjkonsul-poli-t-form').submit();
        // } 
    }


    function sembunyiFormAsuransi(){
        $('#content-asuransi').find(".required").addClass("not-required").removeClass("required");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-asuransi').removeClass().addClass("accordion-body collapse");
        $('#content-asuransi').removeAttr("style").attr("style","height:0px"); 
        $('#content-asuransi').find("input,select,textarea").attr("disabled",true); 
  
}
function tampilFormAsuransi(){
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-asuransi').removeClass().addClass("accordion-body in collapse");
        $('#content-asuransi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asuransi').removeAttr("style").attr("style","height:auto"); 
        $('#content-asuransi').find("input,select,textarea").removeAttr("disabled"); 
  
}

function cekPilihSatu(obj) {
        // console.log($(obj).find('option').length);
        if ($(obj).find('option').length == 2) {
            $(obj).val($(obj).find('option').eq(1).val());
            $(obj).change();
        }
        if ($(obj).find('option').length == 1) {
            $(obj).change();
        }
    }
function setKarcis(form_index)
{
    var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
    var penjamin_id=$("#<?php echo CHtml::activeId($modPendaftaran,"penjamin_id");?>").val();
    var ruangan_id = $("#form-pemeriksaan-"+form_index).find('input[name$="[ruangan_id]"]').val();
    var kelaspelayanan_id = $("#form-pemeriksaan-"+form_index).find('select[name$="[kelaspelayanan_id]"]').val();
    if(ruangan_id !== "" && kelaspelayanan_id !=="" && penjamin_id !== "") {
        $("#form-karcis-"+form_index).addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {form_index:form_index, kelaspelayanan_id:kelaspelayanan_id, ruangan_id : ruangan_id, penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#form-karcis-"+form_index+" #content-karcis-html").html(data.listKarcis[form_index]);
                $("#form-karcis-"+form_index).removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
       $("#form-karcis-"+form_index).find("#content-karcis-html").html("");
    }
       
}


    function setFormAsuransi(carabayar_id){
    var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>;
	var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS; ?>;

	if (carabayar_id == carabayar_id_umum) {
		sembunyiFormAsuransi();
		$('#form-asuransi').show();
	} else {
		tampilFormAsuransi();
		$('#form-asuransi').show();
	}
}

    function hitungTotalTarif() {
        var totalTarif = 0;
        var harga_tariftindakan = 0;
        $('#tblListKonsul > tbody > tr').each(function() {
            harga_tariftindakan = unformatNumber($(this).find('input[name*="[harga_tariftindakan]"]').val());
            totalTarif += harga_tariftindakan;
        });
        $('#totalTarif').val(formatNumber(totalTarif));
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
                modul_id: <?php echo Params::MODUL_ID_RJ ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });



    function setKelasTanggunganDrop(){
	<?php
		$drop_kelasbpjs = CHtml::listData(RIPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama');
		
		$drop_bpjs = '';
		if (count((array)$drop_kelasbpjs)>0){
		
			if (count((array)$drop_kelasbpjs)>1){
				$drop_bpjs .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			}
			
			foreach($drop_kelasbpjs as $value=>$name)
			{
				$drop_bpjs .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			}
		}
		
		$drop_kelas = CHtml::listData(RIPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama');
		$drop_asuran = '';
		
		if (count((array)$drop_kelas)>0){
			
			if (count((array)$drop_kelas)>1){
				$drop_asuran .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			}
			
			foreach($drop_kelas as $value1=>$name1)
			{
				$drop_asuran .= CHtml::tag('option', array('value'=>$value1),CHtml::encode($name1),true);
			}
		}
	?>
	var dropdown_kelasbpjs = '<?php echo $drop_bpjs; ?>';
	var dropdown_kelas = '<?php echo $drop_asuran; ?>';
	
	
	var carabayar = $("#PPPendaftaranT_carabayar_id option:selected").val();

		
	if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>){
		$("#RIAsuransipasienM_nokartuasuransi").attr('maxlength',13);
		$("#RIAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelasbpjs);
	}else{
		$("#RIAsuransipasienM_nokartuasuransi").attr('maxlength',24);
		$("#RIAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelas);
	}
	
	
}


    $(document).ready(function() {
           var ruangans = jQuery('#<?php echo CHtml::activeId($modKonsul, 'ruangan_id') ?>');	
           jQuery(ruangans).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });

    //    $(document).ready(function() {
    //        var pegawai = jQuery('#<?php echo CHtml::activeId($modKonsul, 'pegawai_id') ?>');	
    //        jQuery(pegawai).multiselect({
    //                includeSelectAllOption: false,
    //                buttonClass: "form-control",
    //                maxHeight: 300,
    //                buttonWidth: '182px',
    //                enableCaseInsensitiveFiltering: true
    //        })
    //    });


       

    function searchPegawai() {
            $('#rjkonsul-poli-t-form input[name*="pegawai_id"]').each(function() {
            });
    }

</script>