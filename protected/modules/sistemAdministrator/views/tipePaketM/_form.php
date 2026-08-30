<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'satipe-paket-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($model, 'kelaspelayanan_id') . '',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData(SAPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'kelaspelayanan_id', 'multiple' => 'multiple')); ?>
        <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData(SAPendaftaranT::model()->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setDropdownPenjamin(this);', 'class' => 'span3 carabayar_id'
            //                                                'ajax' => array('type'=>'POST',
            //                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'SATipePaketM')), 
            //                                                    'update'=>'#'.CHtml::activeId($model,'penjamin_id').'', //selector to update
            ////                                                    'success'=>'function(data) {  getChangePenjamin(); }'
            //                                                ),
        ));
        ?>
        <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData(SAPendaftaranT::model()->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'getChangePenjamin();', 'class' => 'penjamin_id', 'multiple' => 'multiple')); ?>
        <div class='control-group'>
            <?php echo CHtml::label('Jenis Tarif', 'jenistarif_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'jenistarif_id', array()); ?>
                <?php echo $form->textField($model, 'jenistarif_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'tipepaket_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'tipepaket_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'tipepaket_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

    </div>
    <div class="col-sm-6">

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'tglkesepakatantarif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglkesepakatantarif',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                )); ?>
                <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nokesepakatantarif', array('placeholder' => 'No. Kesepakatan Tarif', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'nourut_tipepaket', array('placeholder' => 'No. Urut Tipe Paket', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model, 'keterangan_tipepaket', array('placeholder' => 'Keterangan', 'rows' => 2, 'cols' => 5, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->checkBoxRow($model, 'is_paketmedis', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->checkBoxRow($model,'tipepaket_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="control-group col-sm-3" style="margin-left: 86pt;">
            <label style="float:left; margin-left: -98pt;">Paket Penunjang</label>
            <?php echo $form->dropDownList($model, 'jenis_paket', array(
                'is_rad'    => 'Radiologi',
                'is_mikro'  => 'Mikrobiologi',
                'is_darah'  => 'Pemeriksaan Darah',
                'is_pk'     => 'Potologi Klinik',
                'is_pa'     => 'Patologi Anatomi',

            ), array('prompt' => 'Pilih Paket Penunjang','id' =>'paket')); ?>

            <?php echo $form->hiddenField($model, 'is_rad', array('value' => 0)); ?>
            <?php echo $form->hiddenField($model, 'is_mikro', array('value' => 0)); ?>
            <?php echo $form->hiddenField($model, 'is_darah', array('value' => 0)); ?>
            <?php echo $form->hiddenField($model, 'is_pk', array('value' => 0)); ?>
            <?php echo $form->hiddenField($model, 'is_pa', array('value' => 0)); ?>

            <?php //echo $form->checkBoxRow($model, 'is_rad', array('placeholder' => 'No. Urut Tipe Paket','onkeypress' => "return $(this).focusNextInputField(event);")); 
            ?>
            <?php //echo $form->checkBoxRow($model, 'is_mikro', array('onkeypress' => "return $(this).focusNextInputField(event);")); 
            ?>
            <?php //echo $form->checkBoxRow($model, 'is_darah', array('onkeypress' => "return $(this).focusNextInputField(event);")); 
            ?>
            <br>
            <div class="control-group">
                <label style="float:left; margin-left: -98pt;">Komponen Darah</label>
                <?php
                echo $form->dropDownList($model, 'jeniskomponendarah_id', CHtml::listData(JeniskomponendarahM::getItems(), 'jeniskomponendarah_id', 'jeniskomponenedarah_nama'), array('empty' => '-- Pilih --','disabled' => 'disabled','id'=>'komponen_darah')) ?>
            </div>
        </div>
        <div class="col-sm-3" style="margin-left:-30pt">
            <?php //echo $form->checkBoxRow($model, 'is_pk', array('onkeypress' => "return $(this).focusNextInputField(event);")); 
            ?>
            <?php //echo $form->checkBoxRow($model, 'is_pa', array('onkeypress' => "return $(this).focusNextInputField(event);")); 
            ?>
        </div>
        <br>

    </div>

</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Tipe Paket</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tableObatAlkes" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th><?php echo $form->labelEx($model, 'tarifpaket'); ?></th>
                    <th><?php echo $form->labelEx($model, 'paketsubsidiasuransi'); ?></th>
                    <th class="cols_hide"><?php echo $form->labelEx($model, 'paketsubsidipemerintah'); ?></th>
                    <th><?php echo $form->labelEx($model, 'paketsubsidirs'); ?></th>
                    <th><?php echo $form->labelEx($model, 'paketiurbiaya'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>

                    <td>
                        <?php echo $form->textField($model, 'tarifpaket', array('class' => 'span2 numbersOnly', 'onblur' => 'validasiInputan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, 'paketsubsidiasuransi', array('class' => 'span2 numbersOnly harga', 'onblur' => 'validasiInputan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                    <td class="cols_hide">
                        <?php echo $form->textField($model, 'paketsubsidipemerintah', array('class' => 'span2 numbersOnly harga', 'onblur' => 'validasiInputan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, 'paketsubsidirs', array('class' => 'span2 numbersOnly harga', 'onblur' => 'validasiInputan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, 'paketiurbiaya', array('class' => 'span2 numbersOnly harga', 'onblur' => 'validasiInputan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/tipePaketM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Tipe Paket', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>

    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<script type="text/javascript">
    function validasiInputan(obj) {
        var tarifPaket = parseFloat($("#<?php echo CHtml::activeId($model, 'tarifpaket'); ?>").val());
        var tarifSubAsuransi = parseFloat($("#<?php echo CHtml::activeId($model, 'paketsubsidiasuransi'); ?>").val());
        var tarifSubRs = parseFloat($("#<?php echo CHtml::activeId($model, 'paketsubsidirs'); ?>").val());
        var total = (tarifPaket - tarifSubAsuransi - tarifSubRs);
        $("#<?php echo CHtml::activeId($model, 'paketiurbiaya'); ?>").val(total);
    }

    function namaLain(nama) {
        document.getElementById('SATipePaketM_tipepaket_namalainnya').value = nama.value.toUpperCase();
    }

    function getChangePenjamin() {
        var penjamin = $('#<?php echo CHtml::activeId($model, 'penjamin_id'); ?>').val();

        if (penjamin != '') {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('getJenisTarifPejamin') ?>',
                data: {
                    penjamin_id: penjamin
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('#<?php echo CHtml::activeId($model, 'jenistarif_id'); ?>').val(data.jenistarif_id);
                    $('#<?php echo CHtml::activeId($model, 'jenistarif_nama'); ?>').val(data.jenistarif_nama);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function setDropdownPenjamin(obj) {
        var caraBayar = $(obj).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownPenjaminPasien'); ?>',
            data: {
                carabayar_id: caraBayar,
                nopilih: 0,
            }, //
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('#<?php echo CHtml::activeId($model, 'penjamin_id'); ?>').html(data.listPenjamin).multiselect("rebuild");
                getChangePenjamin();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    $('#paket').change(function() {
        var selectedValue = $(this).val();
        if (selectedValue == 'is_darah') {
            $('#komponen_darah').removeAttr('disabled');
        } else {
            $('#komponen_darah').attr('disabled', 'disabled');
        }
    });
    $('#paket').change(function() {
        var selectedValue = $(this).val();
        // console.log(selectedValue,'a')
        if (selectedValue == 'is_rad') {
            $('#is_rad').val(1);
            $('#is_mikro').val(0);
            $('#is_darah').val(0);
            $('#is_pk').val(0);
            $('#is_pa').val(0);
        } else if (selectedValue == 'is_mikro') {
            $('#is_rad').val(0);
            $('#is_mikro').val(1);
            $('#is_darah').val(0);
            $('#is_pk').val(0);
            $('#is_pa').val(0);
        } else if (selectedValue == 'is_darah') {
            $('#is_rad').val(0);
            $('#is_mikro').val(0);
            $('#is_darah').val(1);
            $('#is_pk').val(0);
            $('#is_pa').val(0);
        }
        else if (selectedValue == 'is_pk') {
            $('#is_rad').val(0);
            $('#is_mikro').val(0);
            $('#is_darah').val(0);
            $('#is_pk').val(1);
            $('#is_pa').val(0);
        }
        else if (selectedValue == 'is_pa') {
            $('#is_rad').val(0);
            $('#is_mikro').val(0);
            $('#is_darah').val(0);
            $('#is_pk').val(0);
            $('#is_pa').val(1);
        }
    });




    var input_kelaspelayanan = $("<?php echo "#" . CHtml::activeId($model, 'kelaspelayanan_id'); ?>");
    var input_penjamin = $("<?php echo "#" . CHtml::activeId($model, 'penjamin_id'); ?>");

    $(document).ready(function() {
        jQuery(input_kelaspelayanan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(input_penjamin).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

    });
</script>