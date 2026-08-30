<?php
$this->breadcrumbs = array(
    'Kirim Pesan Provider Asuransi',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-envelope"></i> Kirim <b>Pesan Provider Asuransi</b> <?php echo $this->is_blast ? "- SMS Blast" : ""; ?>
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
                            'dataProvider' => $modAsuransi->searchDialogSms(),
                            'filter' => $modAsuransi,
                            'template' => "{summary}\n{items}{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'htmlOptions' => array(
                                'onkeypress' => " if(event.keyCode == 13){ refreshGrid(this); } " /* Do ajax call when user presses enter key */
                            ),

                            'columns' => array(
                                array(
                                    'header' => 'Jenis Penjamin',
                                    'name' => 'carabayar_id',
                                    'type' => 'raw',
                                    'value' => '$data->carabayar->carabayar_nama',
                                    'filter' => CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif IS TRUE'), 'carabayar_id', 'carabayar_nama'),
                                ),
                                'penjamin_nama',
                                'penjamin_cp',
                                array(
                                    'name' => 'penjamin_nomobile',
                                    'type' => 'raw',
                                    'value' => 'CHtml::Link("<i class=\"icon-pencil\"></i> $data->penjamin_nomobile",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/KirimPesan/UbahNomorAsuransi",array("penjamin_id"=>$data->penjamin_id,"frame"=>true)),
												array("class"=>"", 
													  "target"=>"iframeNomor",
													  "onclick"=>"$(\"#editNomor\").dialog(\"open\");",
										))',
                                    'filter' =>
                                    CHtml::activeTextField($modAsuransi, 'penjamin_nomobile', array('style' => 'width: calc(100% - 30px) !important; float: left;',))
                                        . ' ' .
                                        CHtml::activeCheckBox($modAsuransi, 'nomor_valid', array('style' => 'width: initial !important; margin: 8px !important;', 'uncheckValue' => 0, 'rel' => 'tooltip', 'title' => 'Tampilkan nomor valid')),
                                    //                            'filter' => CHtml::activeCheckBox($modAsuransi, 'nomor_valid', array('uncheckValue'=>0,'rel'=>'tooltip','title'=>'Tampilkan nomor valid')).CHtml::activeTextField($modAsuransi, 'penjamin_nomobile'),
                                ),
                                array(
                                    'header' => '<p style="width: 80px;">Pilih <a href="javascript:pilihSemua();" onclick="pilihSemua();" rel="tooltip" data-original-title="Pilih Semua"><i class="icon-check"></i></a>&nbsp;&nbsp;<a href="javascript:hapusSemua();" onclick="hapusSemua();" rel="tooltip" data-original-title="Batal Pilih Semua"><i class="icon-trash"></i></a></p>',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:center;width:50px;'),
                                    'value' => 'CHtml::hiddenField("penjamin_id", $data->penjamin_id).CHtml::checkBox("Asuransi[".$data->penjamin_id."]", $data->pilih, array("class"=>"pilih","onclick"=>"pilihSatu(this,\'$data->penjamin_id\')"))',
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
    function cekStatusSelect() {

        $("#pasien-m-grid > table > tbody > tr").each(function() {
            id = $(this).find('#penjamin_id').val();
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
        var penjamin_nama = $("#pasien-m-grid tr.filters").find('input[name*="[penjamin_nama]"]').val();
        var penjamin_cp = $("#pasien-m-grid tr.filters").find('input[name*="[penjamin_cp]"]').val();
        var penjamin_nomobile = $("#pasien-m-grid tr.filters").find('input[name*="[penjamin_nomobile]"]').val();

        var carabayar_id = $("#pasien-m-grid tr.filters").find('select[name*="[carabayar_id]"]').val();

        $("#pasien-m-grid tr.filters").find('input[name*="[nomor_valid]"]').each(
            function() {
                if ($(this).is(":checked")) {
                    nomor_valid = 1;
                } else {
                    nomor_valid = 0;
                }
            });

        jQuery.ajax({
            'url': '<?php echo $this->createUrl('SelectAllPenjamin') ?>',
            'data': {
                penjamin_nama: penjamin_nama,
                penjamin_cp: penjamin_cp,
                penjamin_nomobile: penjamin_nomobile,
                carabayar_id: carabayar_id,
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

    function pilihSatu(obj, penjamin_id) {
        var d = document.getElementById('nomortujuan');

        if ($(obj).is(':checked')) {
            d.innerHTML += "<input id='Nomor_" + penjamin_id + "' class='span3 Nomor' type='hidden' name='Nomor[]' value='" + penjamin_id + "' readonly='readonly'>";
        } else {
            $('#nomortujuan #Nomor_' + penjamin_id).detach();
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
            myAlert("Silakan pilih penjamin yang akan dikirimi pesan!");
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
        'title' => 'Pencarian Data Template SMS',
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
$modSms->tujuansms = 'asuransi';

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