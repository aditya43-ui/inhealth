<?php $linkHalaman = CustomFunction::getUrlByMenuID(1877); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Uang Muka Pembelian</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Transaksi berhasil disimpan!");
        } ?>
        <?php
        $this->breadcrumbs = array(
            'Pembayaran Uang Muka Pembelian',
        ); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaran-uangmukabeli-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);'
            ),
        )); ?>
        <?php echo $form->errorSummary(array($modUangMuka, $modBuktiKeluar)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Permintaan Pembelian</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_ringkasDataSupplier', array('modPermintaan' => $modPermintaan, 'modUangMuka' => $modUangMuka, 'modBuktiKeluar' => $modBuktiKeluar)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Permintaan Uang Muka Pembelian</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Permintaan Uang Muka', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeHiddenField($modPermintaan, 'tglpouangmuka', array()); ?>
                                <?php echo CHtml::activeTextField($modPermintaan, 'tglpermintaanuangmuka', array('readonly' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Jumlah Permintaan Uang Muka', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modPermintaan, 'jmlpermintaanuangmuka', array('readonly' => true, 'class' => 'integer-decimal span3')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran Uang Muka Pembelian</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('No Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modUangMuka, 'nopembayaran', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php $modUangMuka->tgluangmukabeli = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modUangMuka->tgluangmukabeli, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo CHtml::label('Tgl. Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modUangMuka,
                                'attribute' => 'tgluangmukabeli',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array(
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                        'readonly' => true
                    )); ?>
                    <div class="control-group">
                        <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo $form->labelEx($modBuktiKeluar, 'tglkaskeluar', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modBuktiKeluar,
                                'attribute' => 'tglkaskeluar',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modUangMuka, 'jumlahuang', array('class' => 'control-label', 'label' => 'Jumlah Pembayaran')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modUangMuka, 'jumlahuang', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungKasKeluar();',)); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungKasKeluar();',)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'biaya_materai', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungKasKeluar();',)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modUangMuka, 'jmlsisauangmuka', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modUangMuka, 'totalsisahutangpo', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Cara Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array(
                                'onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                                'maxlength' => 50
                            )); ?>
                        </div>
                    </div>
                    <div id="divCaraBayarTransfer">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modBuktiKeluar, 'bank_id', array('class' => 'control-label', 'required' => true, 'label' => 'Bank Pengirim')); ?>
                            <div class="controls">
                                <?php
                                $bank_data = BankM::model()->findAll('bank_aktif = true order by namabank');
                                $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
                                $option_bank = array();
                                foreach ($bank_data as $item) {
                                    $rekening = BankrekM::model()->findByAttributes(array(
                                        'bank_id' => $item->bank_id,
                                        'saldonormal' => 'D',
                                    ));
                                    $option_bank[$item->bank_id] = array(
                                        'data-rekening' => '',
                                        'data-norekening' => '',
                                    );
                                    if (!empty($rekening)) {
                                        $rek5 = Rekening5M::model()->findByPk($rekening->rekening5_id);
                                        $option_bank[$item->bank_id]['data-rekening'] = $rek5->kdrekening5 . " - " . $rek5->nmrekening5;
                                        $option_bank[$item->bank_id]['data-norekening'] = $item->norekening;
                                    }
                                }
                                echo $form->dropDownList(
                                    $modBuktiKeluar,
                                    'bank_id',
                                    $list_bank,
                                    array(
                                        'required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",
                                        'onchange' => 'setKodeAkunBank()', 'empty' => '-- Pilih Bank --',
                                        'options' => $option_bank
                                    )
                                ); ?>
                                <?php echo $form->hiddenField($modBuktiKeluar, 'denganrekening', array(
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Kode Akun", '', array('class' => 'control-label', 'required' => true, 'label' => 'Nominal')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('kode_akun_bank', '', array(
                                    'id' => 'kode_akun_bank', 'class' => 'span3', 'readonly' => true,
                                )); ?>
                            </div>
                        </div>
                        <!--<div class="control-group">
                                        <?php // echo CHtml::label("No Rekening", '', array('class' => 'control-label', 'required' => true)); 
                                        ?>
                                            <div class="controls">
                                            </div>
                                    </div>-->
                        <div class="control-group">
                            <?php echo CHtml::label("No. Bukti Transfer", '', array('class' => 'control-label', 'required' => true)); ?>
                            <div class="controls">
                                <?php echo $form->textField($modBuktiKeluar, 'nobukti_transfer', array(
                                    'class' => 'span3',
                                    'placeholder' => 'No. Bukti Transfer',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modBuktiKeluar, 'melalubank', array('class' => 'control-label', 'required' => true, 'label' => 'Bank Penerima')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modBuktiKeluar, 'melalubank', LookupM::getItems('bank'), array('required' => true, 'class' => 'span3', 'empty' => '-- Pilih Bank --', 'onchange' => 'setNamaBank();', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No Rekening Penerima', '', array('class' => 'control-label', 'required' => true,)) ?>
                            <div class="controls">
                                <?php echo $form->textField($modBuktiKeluar, 'norekpenerima', array(
                                    'class' => 'span3',
                                    'placeholder' => 'No Rekening Penerima',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                                )); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Penerima', '', array('class' => 'control-label', 'required' => true,)) ?>
                        <div class="controls">
                            <?php echo $form->textField($modBuktiKeluar, 'namapenerima', array(
                                'class' => 'span3',
                                'placeholder' => 'Nama Penerima',
                                'onkeypress' => "return $(this).focusNextInputField(event);"
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Alamat Penerima', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modBuktiKeluar, 'alamatpenerima', array(
                                'class' => 'span3',
                                'placeholder' => 'Alamat Penerima',
                                'onkeypress' => "return $(this).focusNextInputField(event);"
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Sebagai Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modBuktiKeluar, 'untukpembayaran', array(
                                'class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event);"
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return cekVerifikasi()', 'onclick' => 'cekVerifikasi()')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    'javascript:void(0);',
                    array('class' => 'btn btn-info', 'disabled' => true)
                );
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    'javascript:void(0);',
                    array('class' => 'btn btn-info', 'onClick' => 'print("PRINT")')
                );
            }
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        if (isset($_GET['uangmukabeli_id'])) {
            $urlPrint = $this->createUrl('Print&uangmukabeli_id=' . $_GET['uangmukabeli_id']);
            $js = <<< JSCRIPT
				function print(caraPrint){
					window.open("${urlPrint}","",'location=_new, width=890px');
				}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    function setKodeAkunBank() {
        var data = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?> :selected").data('rekening');
        var norek = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?> :selected").data('norekening');
        if (data != undefined && data != '') {
            $("#kode_akun_bank").val(data);
            $('#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening'); ?>').val(norek);
        } else {
            myAlert("Bank Pengirim Yang Dipilih Belum Memiliki Kode Akun !!!");
        }
    }
    $(document).ready(function() {
        formatNumberSemua();
    });

    function formCarabayar(carabayar) {
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').slideDown();
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").attr('disabled', false);
            $("#kode_akun_bank").attr('disabled', false);
        } else {
            $('#divCaraBayarTransfer').slideUp();
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").val('');
            $("#kode_akun_bank").val("");
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").attr('disabled', true);
            $("#kode_akun_bank").attr('disabled', true);
        }
        cekDisabled();
    }

    function cekVerifikasi() {
        if (requiredCheck($('form'))) {
            $(".integer, .float, .integer-decimal").each(function() {
                $(this).val(unformatNumber($(this).val()));
            });
            $('#pembayaran-uangmukabeli-form').submit();
        }
        return true;
    }

    function getSebagaiPembayaran() {
        var supplier = $("#<?php echo CHtml::activeId($modPermintaan, 'supplier_nama') ?>").val();
        var tgluangmuka = $("#<?php echo CHtml::activeId($modUangMuka, 'tgluangmukabeli') ?>").val();
        var tglpouangmuka = $("#<?php echo CHtml::activeId($modPermintaan, 'tglpouangmuka') ?>").val();
        // var myDate = new Date(tglpouangmuka);
        // var months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        // console.log(myDate);
        // var str = myDate.getDate() + " " + months[myDate.getMonth()] + " " + myDate.getFullYear();
        var sbg = "Pembayaran Uang Muka Supplier - " + supplier + " - " + tglpouangmuka;
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran') ?>").val(sbg);
    }

    function hitungKasKeluar() {
        unformatNumberSemua();
        var jmlpermintaanuangmuka = parseFloat($("#<?php echo CHtml::activeId($modPermintaan, 'jmlpermintaanuangmuka') ?>").val());
        var jumlahuang = parseFloat($("#<?php echo CHtml::activeId($modUangMuka, 'jumlahuang') ?>").val());
        var biayaadministrasi = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaadministrasi') ?>").val());
        var biaya_materai = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biaya_materai') ?>").val());
        var totalpo = parseFloat($("#<?php echo CHtml::activeId($modUangMuka, 'totalpo') ?>").val());
        if (jumlahuang > jmlpermintaanuangmuka) {
            myAlert('Jumlah Pembayaran tidak boleh melebihi jumlah permintaan uang muka');
            jumlahuang = jmlpermintaanuangmuka;
            $("#<?php echo CHtml::activeId($modUangMuka, 'jumlahuang') ?>").val(jmlpermintaanuangmuka);
        }
        var jmlkaskeluar = (jumlahuang + biayaadministrasi + biaya_materai);
        var sisapembayaran = (jmlpermintaanuangmuka - jumlahuang);
        var totalsisapo = (totalpo - jumlahuang);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar') ?>").val(jmlkaskeluar);
        $("#<?php echo CHtml::activeId($modUangMuka, 'jmlsisauangmuka') ?>").val(sisapembayaran);
        $("#<?php echo CHtml::activeId($modUangMuka, 'totalsisahutangpo') ?>").val(totalsisapo);
        formatNumberSemua();
    }
</script>