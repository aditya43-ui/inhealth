<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Retur Tagihan Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pembayaran',
        ); ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaran-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#BKPendaftaranT_instalasi_id',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);'
                // 'onsubmit'=>'return cekOtorisasi();'
            ),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body">

                <?php
                if (isset($_GET['status']) && $_GET['status'] == 1) {
                    Yii::app()->user->setFlash('success', "Data retur berhasil disimpan!");
                }
                ?>
                <?php $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>

                <?php //echo $form->errorSummary(array($modRetur,$modBuktiKeluar)); 
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Retur</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
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
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modRetur,
                                    'attribute' => 'tglreturpelayanan',
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
                        <?php
                        $modRetur->totaloaretur = MyFormatter::formatNumberForPrint($modRetur->totaloaretur);
                        $modRetur->totaltindakanretur = MyFormatter::formatNumberForPrint($modRetur->totaltindakanretur);
                        $modRetur->totalbiayaretur = MyFormatter::formatNumberForPrint($modRetur->totalbiayaretur);

                        ?>
                        <?php echo CHtml::hiddenField('oa_limit', $modRetur->totaloaretur); ?>
                        <?php echo CHtml::hiddenField('tindakan_limit', $modRetur->totaltindakanretur); ?>
                        <?php echo $form->hiddenField($modRetur, 'noreturbayar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                        <div class="control-group">
                            <?php echo Chtml::label("No. Retur Bayar <span style='color:red;'>*</span>", 'noreturbayar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modRetur, 'notemp', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modRetur, 'totaloaretur', array('onblur' => 'cekLimitRetur()', 'onkeyup' => 'hitungTotalRetur()', 'class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modRetur, 'totaltindakanretur', array('onblur' => 'cekLimitRetur()', 'onkeyup' => 'hitungTotalRetur()', 'class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modRetur, 'totalbiayaretur', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", "readonly" => true)); ?>
                        <?php echo $form->textFieldRow($modRetur, 'biayaadministrasi', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($modRetur, 'keteranganretur', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo CHtml::activeHiddenField($modRetur, 'user_nm_otorisasi', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::activeHiddenField($modRetur, 'user_id_otorisasi', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); 
                        ?>
                        <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo $form->hiddenField($modBuktiKeluar, 'nokaskeluar', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <div class="control-group">
                            <?php echo Chtml::label("No kas Keluar <span style='color:red;'>*</span> ", 'noreturbayar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modBuktiKeluar, 'notemp', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <?php
                        echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('empty'=>'-- Pilih --','onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <div id="divCaraBayarTransfer" class="hide">
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if ($modRetur->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    '#',
                    array(
                        'class' => 'btn btn-info',
                        'onclick' => "return false",
                        'disabled' => true
                    )
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'class' => 'btn btn-danger',
                        'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)',
                        'disabled' => true
                    )
                );

                echo CHtml::link(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    '#',
                    array(
                        'class' => 'btn btn-info',
                        'onclick' => "printKasir($modRetur->returbayarpelayanan_id);return false",
                        'disabled' => false
                    )
                );
            }
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            /*
						echo CHtml::htmlButton(
							Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
							array(
								'class' => 'btn btn-default', 
								'type'=>'reset'
							)
						);
						 * 
						 */
            ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi_retur', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
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
        if (isset($modRetur->returbayarpelayanan_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_KEUANGAN ?>,
                judulnotifikasi: 'Retur Tagihan',
                isinotifikasi: 'Telah dilakukan retur dengan <?php echo $modRetur->noreturbayar ?> pada <?php echo $modRetur->tglreturpelayanan ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    })

    $('.currency').each(function() {
        this.value = formatNumber(this.value)
    });

    function hitungTotalRetur() {
        oa = parseFloat(unformatNumber($("#BKReturbayarpelayananT_totaloaretur").val()));
        tindakan = parseFloat(unformatNumber($("#BKReturbayarpelayananT_totaltindakanretur").val()));

        $("#BKReturbayarpelayananT_totalbiayaretur").val(formatNumber(oa + tindakan));
    }

    function cekLimitRetur() {
        oalimit = parseFloat(unformatNumber($("#oa_limit").val()));
        tindakanlimit = parseFloat(unformatNumber($("#tindakan_limit").val()));
        oa = parseFloat(unformatNumber($("#BKReturbayarpelayananT_totaloaretur").val()));
        tindakan = parseFloat(unformatNumber($("#BKReturbayarpelayananT_totaltindakanretur").val()));

        if (oa > oalimit) oa = oalimit;
        if (tindakan > tindakanlimit) tindakan = tindakanlimit;

        $("#BKReturbayarpelayananT_totaloaretur").val(formatNumber(oa));
        $("#BKReturbayarpelayananT_totaltindakanretur").val(formatNumber(tindakan));

        hitungTotalRetur();
    }

    function printKasir(idTandaBukti) {
        if (idTandaBukti.length > 0) {
            window.open('<?php echo Yii::app()->createUrl($module . '/' . $controller . '/returTagihan', array('tandabuktibayar_id' => "")); ?>' + idTandaBukti, 'printwin', 'left=100,top=100,width=800,height=400,scrollbars=1');
        } else {
            idTandaBukti = $('#BKReturbayarpelayananT_returbayarpelayanan_id').val();
            window.open('<?php echo Yii::app()->createUrl($module . '/' . $controller . '/returTagihan', array('tandabuktibayar_id' => "")); ?>' + idTandaBukti, 'printwin', 'left=100,top=100,width=800,height=400,scrollbars=1');
        }
    }

    /*
    function printKasir(idTandaBukti)
    {
        if(idTandaBukti>0)
        {
            window.open('<?php echo Yii::app()->createUrl('print/bayarKasir', array('idTandaBukti' => "")); ?>'+idTandaBukti,'printwin','left=100,top=100,width=400,height=400,scrollbars=1');
        } else {
            idTandaBukti = $('#BKReturbayarpelayananT_tandabuktibayar_id').val();
            window.open('<?php echo Yii::app()->createUrl('print/bayarKasir', array('idTandaBukti' => "")); ?>'+idTandaBukti,'printwin','left=100,top=100,width=400,height=400,scrollbars=1');
        }   
    }
    */
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
        // myAlert(carabayar);
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').slideDown();
        } else {
            $('#divCaraBayarTransfer').slideUp();
            $('#divCaraBayarTransfer input').each(function() {
                $(this).val('')
            });
        }
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