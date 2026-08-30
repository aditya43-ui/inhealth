<?php
$this->breadcrumbs = array(
    'Kirim Pesan Pasien',
); ?>

<style>
    tr td .add-on {
        margin: 0 !important;
    }

    table .grid-view .filters input {
        width: calc(100% - 30px) !important;
    }

    table .input-append {
        display: inline;
        float: left;
        width: calc(100% - 30px) !important;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-envelope"></i> Kirim <b>Pesan Pasien</b> <?php echo $this->is_blast ? "- SMS Blast" : ""; ?>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div style="max-height: 1000px;overflow-x: auto">
            <table width="100%" cellpadding="5px">
                <tr>
                    <td width="100%">
                        <?php

                        $prov = $modPasien->searchDialog();
                        $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
                        $rm = explode("-", $modPasien->tgl_rekam_medik);

                        // $modPasien->tgl_rekam_medik = MyFormatter::formatDateTimeForUser(MyFormatter::formatDateTimeForDb(trim($rm[0])))." - ".MyFormatter::formatDateTimeForUser(MyFormatter::formatDateTimeForDb(trim($rm[1])));

                        // var_dump($rm, $modPasien->tgl_rekam_medik); die;

                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'pasien-m-grid',
                            'dataProvider' => $prov,
                            'filter' => $modPasien,
                            'template' => "{summary}\n{items}{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'htmlOptions' => array(
                                'onkeypress' => " if(event.keyCode == 13){ refreshGrid(this); } " /* Do ajax call when user presses enter key */
                            ),

                            'columns' => array(
                                'no_rekam_medik',
                                array(
                                    'header' => 'Tgl. RM',
                                    'name' => 'tgl_rekam_medik',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:center;width:150px;'),
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_rekam_medik)',
                                    'filter' => CHtml::activeTextField($modPasien, 'tgl_rekam_medik', array('style' => 'text-align:center', 'readonly' => true)),
                                ),
                                'nama_pasien',
                                array(
                                    'header' => 'Alamat',
                                    'name' => 'alamat_pasien',
                                    'type' => 'raw',
                                    'value' => '$data->alamat_pasien.", ".$data->propinsi_nama.", ".$data->kabupaten_nama.", ".$data->kecamatan_nama.", ".$data->kelurahan_nama',
                                ),
                                array(
                                    'header' => 'Tgl. Lahir',
                                    'name' => 'tanggal_lahir',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:center;width:180px;'),
                                    'headerHtmlOptions' => array('style' => 'width:180px;'),
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                                    'filter' =>
                                    $this->widget(
                                        'MyDateTimePicker',
                                        array(
                                            'model' => $modPasien,
                                            'attribute' => 'tanggal_lahir',
                                            'mode' => 'date', //date / datetime
                                            'gridFilter' => true,
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)"
                                            ),
                                        ),
                                        true
                                    )
                                        . CHtml::activeCheckBox($modPasien, 'is_tgllahir', array('style' => 'width: initial !important; float: left !important; margin: 8px !important;', 'uncheckValue' => 0, 'rel' => 'tooltip', 'title' => 'Filter Tanggal Lahir')),
                                    //                            'filter'=>CHtml::activeCheckBox($modPasien, 'is_tgllahir', array('uncheckValue'=>0,'rel'=>'tooltip','title'=>'Filter Tanggal Lahir')).$this->widget('MyDateTimePicker', array(
                                    //                                        'model' => $modPasien,
                                    //                                        'attribute' => 'tanggal_lahir',
                                    //                                        'mode' => 'date', //date / datetime
                                    //                                        'gridFilter' => true,
                                    //                                        'options' => array(
                                    //                                        'dateFormat' => 'yy-mm-dd',
                                    //                                        'maxDate'=>'d',
                                    //                                        ),
                                    //                                        'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    //                                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                                    //                                        ),true
                                    //                                    ),
                                ),
                                array(
                                    'header' => 'Ulang Tahun Hari ini',
                                    'name' => 'pasien_ulang_tahun',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->tanggal_lahir',
                                    'filter' => CHtml::activeCheckBox($modPasien, 'pasien_ulang_tahun', array('style' => 'margin: 8px 0 !important;', 'uncheckValue' => 0, 'rel' => 'tooltip')),
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
                                    'name' => 'agama',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->agama',
                                    'filter' => CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'agama')), 'lookup_value', 'lookup_name'),
                                ),
                                //                        'agama',
                                /*array(
								'header' => 'Gol Darah',
								'name' => 'golongandarah',
								'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center;'),
								'value' => '$data->golongandarah',
								'filter' => CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'golongandarah')), 'lookup_value', 'lookup_name'),
							),*/
                                array(
                                    'header' => 'Kelompok Umur',
                                    'name' => 'kelompokumur_id',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->kelompokumur_nama',
                                    'filter' => CHtml::listData(KelompokumurM::model()->findAll('kelompokumur_aktif IS TRUE'), 'kelompokumur_id', 'kelompokumur_nama'),
                                ),
                                array(
                                    'name' => 'no_mobile_pasien',
                                    'type' => 'raw',
                                    'value' => 'CHtml::Link("<i class=\"icon-pencil\"></i>$data->no_mobile_pasien",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/KirimPesan/UbahNomorPasien",array("no_rekam_medik"=>$data->no_rekam_medik,"frame"=>true)),
												array("class"=>"", 
													  "target"=>"iframeNomor",
													  "onclick"=>"$(\"#editNomor\").dialog(\"open\");",
										))',
                                    'filter' =>
                                    CHtml::activeTextField($modPasien, 'no_mobile_pasien', array('style' => 'width: calc(100% - 30px) !important; float: left;',))
                                        . ' ' .
                                        CHtml::activeCheckBox($modPasien, 'nomor_valid', array('style' => 'width: initial !important; margin: 8px !important;', 'uncheckValue' => 0, 'rel' => 'tooltip', 'title' => 'Tampilkan nomor valid')),
                                    //                            'filter' => CHtml::activeCheckBox($modPasien, 'nomor_valid', array('uncheckValue'=>0,'rel'=>'tooltip','title'=>'Tampilkan nomor valid')).CHtml::activeTextField($modPasien, 'no_mobile_pasien'),
                                ),
                                array(
                                    'header' => '<p style="width: 80px;">Pilih <a href="javascript:pilihSemua();" onclick="pilihSemua();" rel="tooltip" data-original-title="Pilih Semua"><i class="icon-check"></i></a>&nbsp;&nbsp;<a href="javascript:hapusSemua();" onclick="hapusSemua();" rel="tooltip" data-original-title="Batal Pilih Semua"><i class="icon-trash"></i></a></p>',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:center;width:50px;'),
                                    //                            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array("onclick"=>"tambahNoTelp(\"$data->no_mobile_pasien\",\"$data->nama_pasien\");return false;","rel"=>"tooltip","title"=>"Pilih"))',
                                    'value' => 'CHtml::hiddenField("no_rekam_medik", $data->no_rekam_medik).CHtml::checkBox("RM[".$data->no_rekam_medik."]", $data->pilih, array("class"=>"pilih","onclick"=>"pilihSatu(this,\'$data->no_rekam_medik\')"))',
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){
						jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
						jQuery("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"yy-mm-dd","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
						jQuery("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").datepicker("show");});
						$(\'input[name="PasiensmscenterV[tgl_rekam_medik]"]\').daterangepicker({
							"maxDate": "' . date('m/d/Y') . '",
							"showDropdowns": true,
						}, afterPilihTanggal);
						cekStatusSelect();
					}',
                        ));
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'outbox-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#',
        ));
        ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <div id="nomortujuan">
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Gunakan Format</label>
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
                                'placeholder' => 'Gunakan Format', 'class' => 'all-caps span4',
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
            id = $(this).find('#no_rekam_medik').val();
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
        var no_rekam_medik = $("#pasien-m-grid tr.filters").find('input[name*="[no_rekam_medik]"]').val();
        var tgl_rekam_medik = $("#pasien-m-grid tr.filters").find('input[name*="[tgl_rekam_medik]"]').val();
        var nama_pasien = $("#pasien-m-grid tr.filters").find('input[name*="[nama_pasien]"]').val();
        var tanggal_lahir = $("#pasien-m-grid tr.filters").find('input[name*="[tanggal_lahir]"]').val();
        var alamat_pasien = $("#pasien-m-grid tr.filters").find('input[name*="[alamat_pasien]"]').val();
        var no_mobile_pasien = $("#pasien-m-grid tr.filters").find('input[name*="[no_mobile_pasien]"]').val();

        var jeniskelamin = $("#pasien-m-grid tr.filters").find('select[name*="[jeniskelamin]"]').val();
        var agama = $("#pasien-m-grid tr.filters").find('select[name*="[agama]"]').val();
        var kelompokumur_id = $("#pasien-m-grid tr.filters").find('select[name*="[kelompokumur_id]"]').val();

        $("#pasien-m-grid tr.filters").find('input[name*="[is_tgllahir]"]').each(
            function() {
                if ($(this).is(":checked")) {
                    is_tgllahir = 1;
                } else {
                    is_tgllahir = 0;
                }
            });
        $("#pasien-m-grid tr.filters").find('input[name*="[pasien_ulang_tahun]"]').each(
            function() {
                if ($(this).is(":checked")) {
                    pasien_ulang_tahun = 1;
                } else {
                    pasien_ulang_tahun = 0;
                }
            });
        $("#pasien-m-grid tr.filters").find('input[name*="[nomor_valid]"]').each(
            function() {
                if ($(this).is(":checked")) {
                    nomor_valid = 1;
                } else {
                    nomor_valid = 0;
                }
            });

        jQuery.ajax({
            'url': '<?php echo $this->createUrl('SelectAllPasien') ?>',
            'data': {
                no_rekam_medik: no_rekam_medik,
                tgl_rekam_medik: tgl_rekam_medik,
                nama_pasien: nama_pasien,
                tanggal_lahir: tanggal_lahir,
                alamat_pasien: alamat_pasien,
                no_mobile_pasien: no_mobile_pasien,
                jeniskelamin: jeniskelamin,
                agama: agama,
                kelompokumur_id: kelompokumur_id,
                is_tgllahir: is_tgllahir,
                pasien_ulang_tahun: pasien_ulang_tahun,
                nomor_valid: nomor_valid,
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

    function pilihSatu(obj, no_rekam_medik) {
        var d = document.getElementById('nomortujuan');

        if ($(obj).is(':checked')) {
            d.innerHTML += "<input id='Nomor_" + no_rekam_medik + "' class='span3 Nomor' type='hidden' name='Nomor[]' value='" + no_rekam_medik + "' readonly='readonly'>";
        } else {
            $('#nomortujuan #Nomor_' + no_rekam_medik).detach();
        }
    }

    function afterPilihTanggal(start, end) {
        $.fn.yiiGridView.update('pasien-m-grid', {
            data: $("#pasien-m-grid thead :input").serialize()
        });
    }

    $(function() {
        $('input[name="PasiensmscenterV[tgl_rekam_medik]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,

        }, afterPilihTanggal);
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
$modSms->tujuansms = 'pasien';

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
            'title' => 'Ubah No. Hp Pasien',
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