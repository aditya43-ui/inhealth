<?php
$this->breadcrumbs = array(
    'Retur Penerimaan Umum',
); ?>
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
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'returpenerimaanumum-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        // 'onsubmit'=>'return cekOtorisasi();'
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>
<?php $this->renderPartial('_infoBuktiBayar', array('modBuktiBayar' => $modBuktiBayar)) ?>

<?php echo $form->errorSummary(array($modRetur, $modBuktiKeluar)) ?>

<fieldset>
    <legend>Data Penerimaan</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPenerimaan, 'tglpenerimaan', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUPenerimaanUmumT[tglpenerimaan]', $modPenerimaan->tglpenerimaan, array('readonly' => true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPenerimaan, 'nopenerimaan', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUPenerimaanUmumT[nopenerimaan]', $modPenerimaan->nopenerimaan, array('readonly' => true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPenerimaan, 'kelompoktransaksi', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUPenerimaanUmumT[kelompoktransaksi]', $modPenerimaan->kelompoktransaksi, array('readonly' => true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPenerimaan, 'hargasatuan', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUPenerimaanUmumT[hargasatuan]', $modPenerimaan->hargasatuan, array('class' => 'currency', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPenerimaan, 'namapenandatangan', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUPenerimaanUmumT[namapenandatangan]', $modPenerimaan->namapenandatangan, array('readonly' => true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPenerimaan, 'totalharga', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUPenerimaanUmumT[totalharga]', $modPenerimaan->totalharga, array('class' => 'currency', 'readonly' => true)); ?></td>
        </tr>
    </table>
</fieldset>

<fieldset>
    <legend>Data Retur</legend>
    <table>
        <tr>
            <td width="50%">
                <div class="control-group">
                    <?php $modRetur->tglreturumum = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRetur->tglreturumum, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modRetur, 'tglreturumum', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modRetur,
                            'attribute' => 'tglreturumum',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <?php echo $form->textAreaRow($modRetur, 'alasanreturumum', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('class' => 'inputFormTabel integer span3', 'onblur' => 'hitungJmlKeluar();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeHiddenField($modRetur, 'user_name_otoritasi', array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo CHtml::activeHiddenField($modRetur, 'user_id_otorisasi', array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo CHtml::activeHiddenField($modRetur, 'penerimaanumum_id', array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo CHtml::activeHiddenField($modRetur, 'tandabuktibayar_id', array('class' => 'span3', 'readonly' => true)); ?>
            </td>
            <td width="50%">
                <?php echo $form->dropDownListRow($modBuktiKeluar, 'tahun', CustomFunction::getTahun(null, null), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)); ?>
                <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div id="divCaraBayarTransfer" class="hide">
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
        </tr>
    </table>
</fieldset>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); 
    ?>
</div>
<?php $this->endWidget(); ?>

<script>
    $('.currency').each(function() {
        this.value = formatNumber(this.value)
    });

    function cekLogin() {
        $.post('<?php echo $this->createUrl('CekLogin', array('task' => 'Retur')); ?>', $('#formLogin').serialize(), function(data) {
            if (data.error != '')
                myAlert(data.error);
            $('#' + data.cssError).addClass('error');
            if (data.status == 'success') {
                $('#KUReturPenerimaanUmumT_user_name_otoritasi').val(data.username);
                $('#KUReturPenerimaanUmumT_user_id_otorisasi').val(data.userid);
                $('#loginDialog').dialog('close');
            } else {
                myAlert(data.status);
            }
        }, 'json');
    }

    function cekOtorisasi() {
        if ($('#KUReturPenerimaanUmumT_user_name_otoritasi').val() == '' || $('#KUReturPenerimaanUmumT_user_id_otorisasi').val() == '') {
            $('#loginDialog').dialog('open');
            return false;
        }

        $('.currency').each(function() {
            this.value = unformatNumber(this.value)
        });
        return true;
    }

    function formCarabayar(carabayar) {
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').slideDown();
        } else {
            $('#divCaraBayarTransfer').slideUp();
            $('#divCaraBayarTransfer input').each(function() {
                $(this).val('')
            });
        }
    }

    function hitungJmlKeluar() {
        var biayaAdmin = unformatNumber($('#BKTandabuktikeluarT_biayaadministrasi').val());
        var jmlKeluar = unformatNumber($('#BKTandabuktikeluarT_jmlkaskeluar').val());

        $('#BKTandabuktikeluarT_jmlkaskeluar').val(formatNumber(biayaAdmin + jmlKeluar));
    }
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'loginDialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 190,
        'resizable' => false,
    ),
)); ?>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'formLogin')); ?>
<div class="control-group">
    <?php echo CHtml::label('Login Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array()); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Password', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array()); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cekLogin();return false;')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default', 'onclick' => "$('#loginDialog').dialog('close');return false", 'disabled' => false)); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>