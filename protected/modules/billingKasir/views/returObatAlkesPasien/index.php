<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Retur Penjualan Obat Alkes</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pembayaran',
        ); ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaran-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#BKPendaftaranT_instalasi_id',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);'
            ),
        )); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Retur Resep</b>
                </div>
            </div>
            <div class="panel-body">
                <fieldset id="form-datakunjungan">
                    <div class="row">
                        <?php $this->renderPartial('_ringkasDataRetur', array('modReturResep' => $modReturResep, 'modPasien' => $modPasien)); ?>
                    </div>
                </fieldset>
            </div>
        </div>


        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Retur Bayar</b>
                </div>
            </div>
            <div class="panel-body">


                <fieldset>
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td width="50%">
                                <?php echo CHtml::activeHiddenField($modRetur, 'tandabuktikeluar_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::activeHiddenField($modRetur, 'tandabuktibayar_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::activeHiddenField($modRetur, 'returbayarpelayanan_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php //echo $form->textFieldRow($modRetur,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                                ?>
                                <?php //echo $form->textFieldRow($modRetur,'tglreturpelayanan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                                ?>
                                <div class="control-group">
                                    <?php $modRetur->tglreturpelayanan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRetur->tglreturpelayanan, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                    <?php echo $form->labelEx($modRetur, 'tglreturpelayanan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        echo $form->textField($modRetur, 'tglreturpelayanan', array(
                                            'class' => 'realtime span3', 'readonly' => true,
                                        ));
                                        /*
                            $this->widget('MyDateTimePicker',array(
                                    'model'=>$modRetur,
                                    'attribute'=>'tglreturpelayanan',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
                             )); 
                             * 
                             */
                                        ?>
                                    </div>
                                </div>
                                <?php echo $form->textFieldRow($modRetur, 'noreturbayar', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                                <?php echo $form->textFieldRow($modRetur, 'totaloaretur', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                                <?php echo $form->hiddenField($modRetur, 'totaltindakanretur', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->hiddenField($modRetur, 'totalbiayaretur', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modRetur, 'biayaadministrasi', array('class' => 'span3 integer2', 'onblur' => 'hitungJmlKasKeluar();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                                <?php echo $form->textFieldRow($modRetur, 'jumlahpembulatan', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;', 'readonly' => true)); ?>
                                <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'text-align: right;')); ?>
                                <?php echo $form->textAreaRow($modRetur, 'keteranganretur', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::activeHiddenField($modRetur, 'user_nm_otorisasi', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::activeHiddenField($modRetur, 'user_id_otorisasi', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td width="50%">
                                <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                                <?php
                        echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
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
            </div>
        </div>
        <div class="form-actions">
            <?php
            $disableSave = false;
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = (!empty($_GET['returpembayaranpelayanan_id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'return cekDokter();', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)
            );
            ?>
            <?php if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
            } ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $('.currency').each(function() {
        this.value = formatNumber(this.value)
    });

    function print(caraPrint) {
        var returbayarpelayanan_id = '<?php echo isset($_GET['returbayarpelayanan_id']) ? $_GET['returbayarpelayanan_id'] : null; ?>';
        if (returbayarpelayanan_id.length > 0) {
            window.open('<?php echo $this->createUrl('printRetur'); ?>&returbayarpelayanan_id=' + returbayarpelayanan_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }
    }

    function hitungJmlKasKeluar() {
        var total_retur = parseFloat(unformatNumber($("#BKReturbayarpelayananT_totaloaretur").val()));
        var biaya_adm = parseFloat(unformatNumber($("#BKReturbayarpelayananT_biayaadministrasi").val()));
        var konfig_pembulatan = <?php echo Yii::app()->user->getState('pembulatanhargakasir'); ?>;
        var jmlpembulatan = 0;

        if (konfig_pembulatan > 0) {
            var jmlPembulatan = Math.round((total_retur + biaya_adm));
            var nilai_bulat = Math.round((jmlPembulatan) / konfig_pembulatan) * konfig_pembulatan;
            jmlpembulatan = nilai_bulat - jmlPembulatan;
        }

        $("#<?php echo CHtml::activeId($modRetur, 'jumlahpembulatan'); ?>").val(formatNumber(jmlpembulatan));
        $("#BKTandabuktikeluarT_jmlkaskeluar").val(formatNumber(total_retur + biaya_adm + jmlpembulatan));

    }

    function cekHakRetur() {
        var cek = false;
        $.post('<?php echo Yii::app()->createUrl('billingKasir/ActionAjax/CekHakRetur'); ?>', {
            idUser: '<?php echo Yii::app()->user->id; ?>',
            useName: '<?php echo Yii::app()->user->name; ?>'
        }, function(data) {
            if ($('#BKReturbayarpelayananT_user_nm_otorisasi').val() != '' || $('#BKReturbayarpelayananT_user_id_otorisasi').val() != '')
                return true;
            if (data.cekAkses) {
                //myAlert('punya hak');
                $('#BKReturbayarpelayananT_user_nm_otorisasi').val(data.username);
                $('#BKReturbayarpelayananT_user_id_otorisasi').val(data.userid);
                return true;
            } else {
                $('#loginDialog').dialog('open');
            }
        }, 'json');

        return cek;
    }

    function cekLogin() {
        $.post('<?php echo $this->createUrl('CekLogin', array('task' => 'Retur')); ?>', $('#formLogin').serialize(), function(data) {
            if (data.error != '')
                myAlert(data.error);
            $('#' + data.cssError).addClass('error');
            if (data.status == 'success') {
                //myAlert(data.status);
                $('#BKReturbayarpelayananT_user_nm_otorisasi').val(data.username);
                $('#BKReturbayarpelayananT_user_id_otorisasi').val(data.userid);
                $('#loginDialog').dialog('close');
                $("#pembayaran-form").submit();
            } else {
                myAlert(data.status);
            }
        }, 'json');
    }

    function cekOtorisasi() {
        if ($('#BKReturbayarpelayananT_user_nm_otorisasi').val() == '' || $('#BKReturbayarpelayananT_user_id_otorisasi').val() == '') {
            $('#loginDialog').dialog('open');
            return false;
        }

        $('.currency').each(function() {
            this.value = unformatNumber(this.value)
        });
        return true;
    }

    function formCarabayar(carabayar) {
        //myAlert(carabayar);
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').slideDown();
        } else {
            $('#divCaraBayarTransfer').slideUp();
            $('#divCaraBayarTransfer input').each(function() {
                $(this).val('')
            });
        }
    }

    $(document).ready(function() {
        hitungJmlKasKeluar();
    });
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
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array(
            'class' => 'btn btn-danger',
            'type' => 'submit',
            'onclick' => 'cekLogin();return false;'
        )
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')),
        '#',
        array(
            'class' => 'btn btn-default',
            'onclick' => "$('#loginDialog').dialog('close');return false",
            'disabled' => false
        )
    );
    ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>