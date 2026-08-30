<?php
$this->breadcrumbs = array(
    'Retur Pembayaran',
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
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pembayaran-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#BKTandabuktibayarUangMukaT_jmlpembayaran',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return cekOtorisasi();'
    ),
)); ?>

<legend class="rim2">Transaksi Retur Obat Pasien</legend>

<?php $this->renderPartial('billingKasir.views.returTagihanPasien._ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary(array($modRetur, $modBuktiKeluar)); ?>
<fieldset>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="fas fa-money-bill"></i> Data <b>Retur</b>
            </div>
        </div>
        <div class="panel-body">
            <table>
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
                        <?php echo $form->textFieldRow($modRetur, 'noreturbayar', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($modRetur, 'totaloaretur', array('class' => 'span3 currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->hiddenField($modRetur, 'totaltindakanretur', array('readonly' => true, 'class' => 'span3 currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modRetur, 'totalbiayaretur', array('readonly' => true, 'class' => 'span3 currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modRetur, 'biayaadministrasi', array('class' => 'span3 currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($modRetur, 'keteranganretur', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::activeHiddenField($modRetur, 'user_nm_otorisasi', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::activeHiddenField($modRetur, 'user_id_otorisasi', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </td>
                    <td width="50%">
                        <?php //echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); 
                        ?>
                        <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <div id="divCaraBayarTransfer" class="hide">
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Untuk Retur', 'untukpembayaran', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <?php
    if ($modRetur->isNewRecord) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array(
                'class' => 'btn btn-danger',
                'type' => 'submit',
                'onKeypress' => 'return formSubmit(this,event)'
            )
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
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $url_batal,
        array(
            'class' => 'btn btn-default',
            'disabled' => false
        )
    );

    ?>
    <?php
    $content = $this->renderPartial('../tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function isiDataPasien(data) {
        $('#BKPendaftaranT_tgl_pendaftaran').val(data.tglpendaftaran);
        $('#BKPendaftaranT_no_pendaftaran').val(data.nopendaftaran);
        $('#BKPendaftaranT_umur').val(data.umur);
        $('#BKPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit);
        $('#BKPendaftaranT_instalasi_nama').val(data.namainstalasi);
        $('#BKPendaftaranT_ruangan_nama').val(data.namaruangan);
        $('#BKPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
        $('#BKPendaftaranT_pasien_id').val(data.pasien_id);
        $('#BKPendaftaranT_pasienadmisi_id').val(data.pasienadmisi_id);
        if (typeof data.norekammedik != 'undefined') {
            $('#BKPasienM_no_rekam_medik').val(data.norekammedik);
        }
        $('#BKPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#BKPasienM_nama_pasien').val(data.namapasien);
        $('#BKPasienM_nama_bin').val(data.namabin);

        $('#BKReturbayarpelayananT_tandabuktibayar_id').val(data.tandabuktibayar_id);
        $('#BKReturbayarpelayananT_totaloaretur').val(formatNumber(data.totalbiayaoa));
        //    $('#BKReturbayarpelayananT_totaltindakanretur').val(formatNumber(data.totalbiayatindakan)); //INI FORM KHUSUS RETUR OBAT
        $('#BKReturbayarpelayananT_totaltindakanretur').val("0");
        $('#BKReturbayarpelayananT_totalbiayaretur').val(formatNumber(data.totalbiayapelayanan));

        $('#BKReturbayarpelayananT_noreturbayar').focus();
    }

    function isiTandaBuktiKeluar(data) {
        $('#BKTandabuktikeluarT_namapenerima').val(data.namapasien);
        $('#BKTandabuktikeluarT_alamatpenerima').val(data.alamatpasien);
    }

    function loadPembayaran(idPembayaran) {
        $.post('<?php echo Yii::app()->createUrl('billingKasir/ActionAjax/loadPembayaranRetur'); ?>', {
            idPembayaran: idPembayaran
        }, function(data) {
            $('#tblBayarTind tbody').html(data.formBayarTindakan);
            $('#tblBayarOA tbody').html(data.formBayarOa);
            $('#TandabuktibayarT_jmlpembayaran').val(formatNumber(data.jmlpembayaran));
            $('#totTagihan').val(formatNumber(data.tottagihan));

            $('#BKTandabuktibayarUangMukaT_jmlpembulatan').val(formatNumber(data.jmlpembulatan));
            $('#BKTandabuktibayarUangMukaT_uangditerima').val(formatNumber(data.uangditerima));
            $('#BKTandabuktibayarUangMukaT_uangkembalian').val(formatNumber(data.uangkembalian));
            $('#BKTandabuktibayarUangMukaT_biayamaterai').val(formatNumber(data.biayamaterai));
            $('#BKTandabuktibayarUangMukaT_biayaadministrasi').val(formatNumber(data.biayaadministrasi));
            $('#BKTandabuktibayarUangMukaT_darinama_bkm').val(data.namapasien);
            $('#BKTandabuktibayarUangMukaT_alamat_bkm').val(data.alamatpasien);
        }, 'json');
    }

    $('.currency').each(function() {
        this.value = formatNumber(this.value)
    });

    function printKasir(idReturBayar) {
        if (idReturBayar.length > 0) {
            window.open('<?php echo Yii::app()->createUrl('print/returObatPasien', array('idReturBayar' => "")); ?>' + idReturBayar, 'printwin', 'left=100,top=100,width=800,height=400,scrollbars=1');
        } else {
            idReturBayar = $('#BKReturbayarpelayananT_returbayarpelayanan_id').val();
            window.open('<?php echo Yii::app()->createUrl('print/returObatPasien', array('idReturBayar' => "")); ?>' + idReturBayar, 'printwin', 'left=100,top=100,width=800,height=400,scrollbars=1');
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