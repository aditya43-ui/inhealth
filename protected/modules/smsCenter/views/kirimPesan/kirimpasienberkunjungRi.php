<?php
$this->breadcrumbs = array(
    'Kirim Pesan Pasien Rawat Inap',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-envelope"></i> Kirim <b>Pesan Pasien Kunjungan Rawat Inap</b> <?php echo $this->is_blast ? "- SMS Blast" : ""; ?>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div style="max-height: 1000px;overflow-x: auto">
            <table width="100%" cellpadding="5px">
                <tr>
                    <td width="100%">
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'pasien-m-grid',
                            'dataProvider' => $modPasien->searchDialog(),
                            'filter' => $modPasien,
                            'template' => "{summary}\n{items}{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'htmlOptions' => array(
                                'onkeypress' => " if(event.keyCode == 13){ refreshGrid(this); } " /* Do ajax call when user presses enter key */
                            ),

                            'columns' => array(
                                'no_rekam_medik',
                                'nama_pasien',
                                'no_pendaftaran',
                                array(
                                    'header' => 'Tgl. Admisi',
                                    'name' => 'tgladmisi',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:center;width:150px;'),
                                    'value' => '$data->tgladmisi',
                                ),
                                array(
                                    'header' => 'Alamat',
                                    'name' => 'alamat_pasien',
                                    'type' => 'raw',
                                    'value' => '$data->alamat_pasien.", ".$data->propinsi_nama.", ".$data->kabupaten_nama.", ".$data->kecamatan_nama.", ".$data->kelurahan_nama',
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
                                    'header' => 'Penjamin',
                                    'name' => 'penjamin_nama',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->carabayar_nama."/".$data->penjamin_nama',
                                ),
                                array(
                                    'header' => 'Ruangan/Poli',
                                    'name' => 'ruangan_nama',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->instalasi_nama."/".$data->ruangan_nama',
                                ),
                                array(
                                    'header' => 'Kelompok Umur',
                                    'name' => 'kelompokumur_id',
                                    'type' => 'raw',
                                    'value' => '$data->kelompokumur_nama',
                                    'filter' => CHtml::listData(KelompokumurM::model()->findAll('kelompokumur_aktif IS TRUE'), 'kelompokumur_id', 'kelompokumur_nama'),
                                ),
                                array(
                                    'header' => 'Tgl. Pulang Admisi',
                                    'name' => 'tglpasienpulang',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    'value' => '$data->tglpasienpulang',
                                    'filter' =>
                                    CHtml::activeTextField($modPasien, 'tglpasienpulang', array('style' => 'width: calc(100% - 30px) !important; float: left;','uncheckValue' => 0, 'rel' => 'tooltip'))
                                        . ' ' .
                                        CHtml::activeCheckBox($modPasien, 'is_tglPulang', array('style' => 'width: initial !important; margin: 8px !important;', 'uncheckValue' => 0, 'rel' => 'tooltip', 'title' => 'Filter Tanggal Pulang')),
                                    //                            'filter' => CHtml::activeCheckBox($modPasien, 'is_tglPulang', array('uncheckValue'=>0,'rel'=>'tooltip','title'=>'Filter Tanggal Pulang')).CHtml::activeTextField($modPasien, 'tglpasienpulang', array('uncheckValue'=>0,'rel'=>'tooltip')),
                                ),
                                array(
                                    'name' => 'no_mobile_pasien',
                                    'type' => 'raw',
                                    'value' => 'CHtml::Link("<i class=\"icon-pencil\"></i> $data->no_mobile_pasien",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/KirimPesan/UbahNomorPasien",array("no_rekam_medik"=>$data->no_rekam_medik,"frame"=>true)),
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
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                    //                            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array("onclick"=>"tambahNoTelp(\"$data->no_mobile_pasien\",\"$data->nama_pasien\");return false;","rel"=>"tooltip","title"=>"Pilih"))',
                                    'value' => 'CHtml::hiddenField("no_rekam_medik", $data->no_rekam_medik).CHtml::checkBox("RM[".$data->no_rekam_medik."]", $data->pilih, array("class"=>"pilih","onclick"=>"pilihSatu(this,\'$data->no_rekam_medik\')"))',
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){
						jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
						jQuery("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"yy-mm-dd","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
						jQuery("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").datepicker("show");});
						$(\'input[name="PasienrawatinapsmscenterV[tgladmisi]"]\').daterangepicker({
							"maxDate": "' . date('m/d/Y') . '",
							"showDropdowns": true,
						}, afterPilihTanggal);
						$(\'input[name="PasienrawatinapsmscenterV[tglpasienpulang]"]\').daterangepicker({
							"showDropdowns": true,
							"maxDate": "' . date('m/d/Y') . '",
							"opens": "left"
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
        <div class="row">
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
        var nama_pasien = $("#pasien-m-grid tr.filters").find('input[name*="[nama_pasien]"]').val();
        var no_pendaftaran = $("#pasien-m-grid tr.filters").find('input[name*="[no_pendaftaran]"]').val();
        var tgladmisi = $("#pasien-m-grid tr.filters").find('input[name*="[tgladmisi]"]').val();
        var alamat_pasien = $("#pasien-m-grid tr.filters").find('input[name*="[alamat_pasien]"]').val();
        var penjamin_nama = $("#pasien-m-grid tr.filters").find('input[name*="[penjamin_nama]"]').val();
        var ruangan_nama = $("#pasien-m-grid tr.filters").find('input[name*="[ruangan_nama]"]').val();
        var tglpasienpulang = $("#pasien-m-grid tr.filters").find('input[name*="[tglpasienpulang]"]').val();
        var no_mobile_pasien = $("#pasien-m-grid tr.filters").find('input[name*="[no_mobile_pasien]"]').val();

        var jeniskelamin = $("#pasien-m-grid tr.filters").find('select[name*="[jeniskelamin]"]').val();
        var kelompokumur_id = $("#pasien-m-grid tr.filters").find('select[name*="[kelompokumur_id]"]').val();

        $("#pasien-m-grid tr.filters").find('input[name*="[is_tglPulang]"]').each(
            function() {
                if ($(this).is(":checked")) {
                    is_tglPulang = 1;
                } else {
                    is_tglPulang = 0;
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
            'url': '<?php echo $this->createUrl('SelectAllKunjunganRI') ?>',
            'data': {
                no_rekam_medik: no_rekam_medik,
                nama_pasien: nama_pasien,
                no_pendaftaran: no_pendaftaran,
                tgladmisi: tgladmisi,
                alamat_pasien: alamat_pasien,
                penjamin_nama: penjamin_nama,
                ruangan_nama: ruangan_nama,
                tglpasienpulang: tglpasienpulang,
                no_mobile_pasien: no_mobile_pasien,
                jeniskelamin: jeniskelamin,
                kelompokumur_id: kelompokumur_id,
                is_tglPulang: is_tglPulang,
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

    function pilihSatu(obj, no_rekam_medik) {
        var d = document.getElementById('nomortujuan');

        if ($(obj).is(':checked')) {
            d.innerHTML += "<input id='Nomor_" + no_rekam_medik + "' class='span3 Nomor' type='hidden' name='Nomor[]' value='" + no_rekam_medik + "' readonly='readonly'>";
        } else {
            $('#nomortujuan #Nomor_' + no_rekam_medik).detach();
        }
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

    function afterPilihTanggal(start, end) {
        $.fn.yiiGridView.update('pasien-m-grid', {
            data: $("#pasien-m-grid thead :input").serialize()
        });
    }

    $(function() {
        $('input[name="PasienrawatinapsmscenterV[tgladmisi]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        }, afterPilihTanggal);
        $('input[name="PasienrawatinapsmscenterV[tglpasienpulang]"]').daterangepicker({
            "showDropdowns": true,
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "opens": "left"
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