<?php
$this->breadcrumbs = array(
    'Kirim Pesan Pegawai',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-envelope"></i> Kirim <b>Pesan Pegawai</b> <?php echo $this->is_blast ? "- SMS Blast" : ""; ?>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div style="max-height: 1000px;overflow-x: auto">
            <table width="100%" cellpadding="5px">
                <tr>
                    <td width="100%">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'pasien-m-grid',
                            'dataProvider' => $modPegawai->searchDialog(),
                            'filter' => $modPegawai,
                            'template' => "{summary}\n{items}{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'NIP',
                                    'name' => 'nomorindukpegawai',
                                    'type' => 'raw',
                                    'name' => 'nomorindukpegawai',
                                    'value' => '$data->nomorindukpegawai'
                                ),
                                array(
                                    'type' => 'raw',
                                    'name' => 'nama_pegawai',
                                    'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama'
                                ),
                                array(
                                    'header' => 'Jenis Kelamin',
                                    'name' => 'jeniskelamin',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->jeniskelamin',
                                    'filter' => CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'jeniskelamin')), 'lookup_value', 'lookup_name'),
                                ),
                                array(
                                    'header' => 'Tanggal Lahir',
                                    'name' => 'tgl_lahirpegawai',
                                    'type' => 'raw',
                                    'name' => 'tgl_lahirpegawai',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'filter' => false,
                                ),
                                array(
                                    'header' => 'Jabatan',
                                    'name' => 'jabatan_id',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->jabatan_nama',
                                    'filter' => CHtml::listData(JabatanM::model()->findAll('jabatan_aktif IS TRUE'), 'jabatan_id', 'jabatan_nama'),
                                ),
                                array(
                                    'header' => 'Kategori Pegawai',
                                    'name' => 'kategoripegawai',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->kategoripegawai',
                                    'filter' => CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'kategoripegawai')), 'lookup_value', 'lookup_name'),
                                ),
                                array(
                                    'header' => 'Kelompok Pegawai',
                                    'name' => 'kelompokpegawai_id',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->kelompokpegawai_nama',
                                    'filter' => CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif IS TRUE'), 'kelompokpegawai_id', 'kelompokpegawai_nama'),
                                ), /*
                                array(
                        'header' => 'SIP / Berlaku',
                        'name' => 'surattandaregistrasi',
                        'type' => 'raw',
                        'name' => 'str',
                        'value' => '$data->surattandaregistrasi." / ".$data->tgl_str_berkala',
                        'htmlOptions' => array('style' => 'text-align: center;'),
                        'filter' => false,
                    ),/*
                    array(
                        'header' => 'SIK / Berlaku',
                        'name' => 'sik',
                        'type' => 'raw',
                        'name' => 'sik',
                        'value' => '$data->sik." / ".$data->tgl_sik_berkala',
                        'htmlOptions' => array('style' => 'text-align: center;'),
                        'filter' => false,
                    ),
                    * 
                    */
                                //                    'nomobile_pegawai',
                                //                    array(
                                //                        'header'=>'Pilih',
                                //                        'type'=>'raw',
                                //                        'htmlOptions'=>array('style'=>'text-align:center;'),
                                //                        'value'=>'CHtml::link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array("onclick"=>"tambahNoTelp(\"$data->nomobile_pegawai\",\"$data->nama_pegawai\");return false;","rel"=>"tooltip","title"=>"Pilih"))',
                                //                    ),
                                array(
                                    'header' => 'No. Handphone Pegawai',
                                    'name' => 'nomobile_pegawai',
                                    'type' => 'raw',
                                    'value' => 'CHtml::Link("<i class=\"icon-pencil\"></i> $data->nomobile_pegawai",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/KirimPesan/UbahNomorPegawai",array("pegawai_id"=>$data->pegawai_id,"frame"=>true)),
                            array("class"=>"", 
                            "target"=>"iframeNomor",
                            "onclick"=>"$(\"#editNomor\").dialog(\"open\");",
                            ))',
                                    'filter' =>
                                    CHtml::activeTextField($modPegawai, 'nomobile_pegawai', array('style' => 'width: calc(100% - 30px) !important; float: left;',))
                                        . ' ' .
                                        CHtml::activeCheckBox($modPegawai, 'nomor_valid', array('style' => 'width: initial !important; margin: 8px !important;', 'uncheckValue' => 0, 'rel' => 'tooltip', 'title' => 'Tampilkan nomor valid')),
                                    //                        'filter' => CHtml::activeCheckBox($modPegawai, 'nomor_valid', array('uncheckValue'=>0,'rel'=>'tooltip','title'=>'Tampilkan nomor valid')).CHtml::activeTextField($modPegawai, 'nomobile_pegawai', array('uncheckValue'=>0,'rel'=>'tooltip')),
                                ),
                                array(
                                    'header' => '<p style="width: 80px;">Pilih <a href="javascript:pilihSemua();" onclick="pilihSemua();" rel="tooltip" data-original-title="Pilih Semua"><i class="icon-check"></i></a>&nbsp;&nbsp;<a href="javascript:hapusSemua();" onclick="hapusSemua();" rel="tooltip" data-original-title="Batal Pilih Semua"><i class="icon-trash"></i></a></p>',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => 'CHtml::hiddenField("pegawai_id", $data->pegawai_id).CHtml::checkBox("Pegawai[".$data->pegawai_id."]", $data->pilih, array("class"=>"pilih","onclick"=>"pilihSatu(this,$data->pegawai_id)"))',
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){
                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        cekStatusSelect();
                        }',
                        ));
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'outbox-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#',
        )); ?>

        <!--<div class="col-sm-4">
            <div class="control-group">
                    <?php // echo $form->labelEx($model, 'destinationnumber', array('class' => 'control-label required')) 
                    ?>
                <div class="controls">
                    <div id="penerima"></div>
                    <?php // echo $form->error($model, 'destinationnumber'); 
                    ?>
                </div>
            </div>
        </div>-->

        <div id="nomortujuan">
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Gunakan Template</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'pilih_template',
                            'value' => $model->pilih_template,
                            'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                                           dataType: "json",
                                                           data: {
                                                               no_rekam_medik: request.term,
                                                               ruangan_id: $("#ruangan_id").val(),
                                                           },
                                                           success: function (data) {
                                                                   response(data);
                                                           }
                                                       })
                                                    }',
                            'options' => array(
                                'minLength' => 4,
                                'focus' => 'js:function( event, ui ) {
                                                     $(this).val( "");
                                                     return false;
                                                 }',
                                'select' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.no_rekam_medik);
                                                    setKunjungan(ui.item.pendaftaran_id);
                                                    return false;
                                                }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogSms'),
                            'htmlOptions' => array(
                                'placeholder' => 'Gunakan Template', 'class' => 'all-caps span4',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'TextDecoded', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'TextDecoded', array('placeholder' => 'Pesan Teks', 'class' => 'span5', 'rows' => 4, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'CreatorID', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <label class="control-label" for="Outbox_simpanke_pbk">Simpan ke Phonebook</label>
                    <div class="controls">
                        <?php echo CHtml::activeCheckBox($model, 'simpanke_pbk', array()); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cekInsert();return false'));
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . $this->id . '/pasien', array('modul_id' => Yii::app()->session['modul_id'])),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
                )
            );
            $content = 'Tidak ada petunjuk khusus.';
            $this->widget('UserTips', array('content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    function tambahNoTelp(noHp, nama) {
        var cek = false;
        if (noHp == '') {
            myAlert(nama + ' Belum Memiliki No. Handphone');
        } else {
            $('.destination').each(function() {
                if (this.value == noHp) {
                    myAlert(nama + ' Sudah ada dalam daftar yang akan dikirimi pesan');
                    cek = true;
                    $('.destination').stop();
                }
            });

            if (!cek) {
                $('#penerima').append('<div class="input-append"><input type="text" name="noPenerima[]" value="' + noHp + '" class="destination span2" readonly="readonly" style="float:left;" />' +
                    '<span class="add-on"><a href="javascript:void(0);" class="icon-form-silang" onclick="hapusNomor(this)"></a></span></div>');
            }
        }
    }

    function hapusNomor(obj) {
        if (myConfirm('Anda Yakin Akan Menghapus No. Tujuan Ini?'))
            $(obj).parent().parent().remove();

        return false;
    }

    function cekStatusSelect() {

        $("#pasien-m-grid > table > tbody > tr").each(function() {
            id = $(this).find('#pegawai_id').val();
            id_Save = $("#Nomor_" + id).val();

            if (id == id_Save) {
                $(this).find('input[type="checkbox"]').attr('checked', 'checked');
            }
        });

    }

    function pilihSemua() {
        $('input:checkbox.pilih').attr('checked', 'checked');
        selectAll();
    }

    function hapusSemua() {
        $('input:checkbox.pilih').removeAttr('checked');
        $('#nomortujuan .Nomor').detach();

    }

    function selectAll() {
        var nomorindukpegawai = $("#pasien-m-grid tr.filters").find('input[name*="[nomorindukpegawai]"]').val();
        var nama_pegawai = $("#pasien-m-grid tr.filters").find('input[name*="[nama_pegawai]"]').val();
        var nomobile_pegawai = $("#pasien-m-grid tr.filters").find('input[name*="[nomobile_pegawai]"]').val();
        var jeniskelamin = $("#pasien-m-grid tr.filters").find('select[name*="[jeniskelamin]"]').val();
        var jabatan_id = $("#pasien-m-grid tr.filters").find('select[name*="[jabatan_id]"]').val();
        var kategoripegawai = $("#pasien-m-grid tr.filters").find('select[name*="[kategoripegawai]"]').val();
        var kelompokpegawai_id = $("#pasien-m-grid tr.filters").find('select[name*="[kelompokpegawai_id]"]').val();
        $("#pasien-m-grid tr.filters").find('input[name*="[nomor_valid]"]').each(
            function() {
                if ($(this).is(":checked")) {
                    nomor_valid = 1;
                } else {
                    nomor_valid = 0;
                }
            });

        jQuery.ajax({
            'url': '<?php echo $this->createUrl('SelectAllPegawai') ?>',
            'data': {
                nomorindukpegawai: nomorindukpegawai,
                nama_pegawai: nama_pegawai,
                nomobile_pegawai: nomobile_pegawai,
                jeniskelamin: jeniskelamin,
                jabatan_id: jabatan_id,
                kategoripegawai: kategoripegawai,
                kelompokpegawai_id: kelompokpegawai_id,
                nomor_valid: nomor_valid
            },
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                $('#nomortujuan .Nomor').detach();
                var d = document.getElementById('nomortujuan');
                d.innerHTML += data;
            },
            'cache': false
        });
    }

    function setPesan(template) {
        $('#Outbox_TextDecoded').val(template);
        $('#pilih_template').val(template);
    }

    function refreshGrid(obj) {
        $(obj).yiiGridView('update', {
            data: $("form").serialize()
        });

    }

    function cekInsert() {
        var jumlahPilih = 0;
        $("#pasien-m-grid > table > tbody > tr").find('input[type="checkbox"]').each(
            function() {
                if ($(this).is(":checked")) {
                    jumlahPilih++;
                } else {}
            });
        if (jumlahPilih > 0) {
            $('#outbox-form').submit();
        } else {
            myAlert("Silakan pilih pasien yang akan dikirimi pesan!");
        }
    }

    function pilihSatu(obj, pegawai_id) {
        var d = document.getElementById('nomortujuan');

        if ($(obj).is(':checked')) {
            d.innerHTML += "<input id='Nomor_" + pegawai_id + "' class='span3 Nomor' type='hidden' name='Nomor[]' value='" + pegawai_id + "' readonly='readonly'>";
        } else {
            $('#nomortujuan #Nomor_' + pegawai_id).detach();
        }
    }

    $(function() {

    });
</script>

<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSms',
    'options' => array(
        'title' => 'Pencarian Data Templete SMS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$nama_modul = Yii::app()->controller->module->id;
$modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
$modSms = new SSmsgatewayM('searchDialog');
$modSms->unsetAttributes();
$modSms->modul_id = $modul_id;
$modSms->tujuansms = 'pegawai';

if (isset($_GET['SSmsgatewayM'])) {
    $modSms->attributes = $_GET['SSmsgatewayM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modSms->searchDialog(),
    'filter' => $modSms,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectSms",
                            "onClick" => "
                                setPesan(\"$data->templatesms\");
                                $(\"#dialogSms\").dialog(\"close\");
                            "))',
        ),
        array(
            'name' => 'templatesms',
            'type' => 'raw',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            }',
));
////======= end pendaftaran dialog =============

$this->endWidget();
?>

<?php
//=============================== Ubah Data nomor Dialog =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editNomor',
        'options' => array(
            'title' => 'Ubah No. Hp Pegawai',
            'autoOpen' => false,
            'zIndex' => 1002,
            'minWidth' => 500,
            'modal' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('pasien-m-grid', {
                            data: $(this).serialize()
                    }); }",
        ),
    )
);
?>
<iframe id="iframeNomor" name="iframeNomor" width="100%"></iframe>
<?php $this->endWidget(); ?>