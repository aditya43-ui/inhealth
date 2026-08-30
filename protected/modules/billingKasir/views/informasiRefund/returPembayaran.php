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

$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.number',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => '.',
        'thousands' => ',',
        'precision' => 1,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'returpembayaran-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'method' => 'post',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onSubmit' => 'return cekHakRetur();'
    ),
));
?>

<fieldset>
    <legend class="rim">Retur Pembayaran Obat Alkes</legend>
    <table id="tblReturObat" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>Tgl. Retur</th>
                <th>No. Retur Resep</th>
                <th>Total Harga Jual</th>
                <th>Total Biaya Administrasi</th>
                <th>Total Harga Retur</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $subTotal = $model->totaloaretur - $model->biayaadministrasi;
                $totalSub += $subTotal;
                $totalretur += $model->totaloaretur;
                $totaladm += $model->biayaadministrasi;

                ?>
                <td><?php echo CHtml::checkBox("tandabuktiKeluar[$i][returbayarpelayanan_id]", false, array('onchange' => 'hitungTotalSemuaRetur();', 'value' => $model->returbayarpelayanan_id, 'uncheckValue' => '0')) ?></td>
                <td><?php echo $model->tglreturpelayanan; ?></td>
                <td><?php echo $model->noreturbayar; ?></td>
                <td><?php echo CHtml::textField("tandabuktiKeluar[$i][jmlkaskeluar]", $model->totaloaretur, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?></td>
                <td><?php echo CHtml::textField("tandabuktiKeluar[$i][biayaadministrasi]", $model->biayaadministrasi, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?></td>
                <td><?php echo CHtml::textField("tandabuktiKeluar[$i][jmlkaskeluar]", $subTotal, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?></td>
            </tr>
            <tr class="trfooter">
                <td colspan="3">Total <?php //echo $subsidiOa['max']; 
                                        ?></td>
                <td>
                    <?php echo CHtml::textField("totalbiayaretur", $totalretur, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totalbiayaadm", $totaladm, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totalkaskeluar", $totalSub, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>

<fieldset>
    <legend class="rim">Data Pembayaran</legend>
    <table>
        <tr>
            <td>
                <!--<div class="control-group">
                    <?php //echo CHtml::label('Total Tagihan','harusDibayar', array('class'=>'control-label inline')) 
                    ?>
                    <div class="controls">
                        <?php //echo CHtml::textField('totTagihan',$totTagihan,array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) 
                        ?>
                    </div>
                </div>-->
                <!--<div class="control-group">
                    <?php //echo CHtml::label('Discount','disc', array('class'=>'control-label inline')) 
                    ?>
                    <div class="controls">
                        <?php //echo CHtml::textField('disc',0,array('readonly'=>false,'onblur'=>'hitungDiscount();','class'=>'inputFormTabel number lebar1', 'onkeypress'=>"return $(this).focusNextInputField(event);")) 
                        ?> %
                    </div>
                </div>-->
                <!--<div class="control-group">
                    <?php //echo CHtml::label('Discount Rupiah','discRupiah', array('class'=>'control-label inline')) 
                    ?>
                    <div class="controls">
                        Rp <?php //echo CHtml::textField('discRupiah',0,array('readonly'=>false,'onblur'=>'hitungDiscountRupiah();','class'=>'inputFormTabel number lebar3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) 
                            ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php //echo CHtml::label('','discount', array('class'=>'control-label inline')) 
                    ?>
                    <div class="controls">
                        <?php //echo CHtml::textField('discount',$modBayar->totaldiscount,array('readonly'=>true,'class'=>'inputFormTabel currency', 'onkeypress'=>"return $(this).focusNextInputField(event);")) 
                        ?>
                    </div>
                </div>-->
                <!--<div class="control-group">
                    <?php //echo CHtml::label('Deposit','deposit', array('class'=>'control-label inline')) 
                    ?>
                    <div class="controls">
                        <?php //echo CHtml::textField('deposit',$totDeposit,array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) 
                        ?>
                    </div>
                </div>-->
                <!--<div class="control-group">
                    <?php //echo CHtml::label('Total Pembebasan','totPembebasan', array('class'=>'control-label inline')) 
                    ?>
                    <div class="controls">
                        <?php ///echo CHtml::textField('totPembebasan',$totPembebasanTarif,array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) 
                        ?>
                    </div>
                </div>-->
                <?php //echo $form->textFieldRow($modTandaBukti,'jmlpembulatan',array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <div>
                    <?php echo CHtml::label('Total Harga Jual', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'totaloaretur', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div><br>

                <?php echo $form->textFieldRow($modTandaBukti, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'biayamaterai',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'jmlkaskeluar', array('onkeyup' => 'hitungKembalian();', 'readonly' => false, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'uangditerima',array('onkeyup'=>'hitungKembalian(this);','class'=>'inputFormTabel currency span3', 'onblur'=>'cekKembalian();' )); 
                ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'uangkembalian',array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
            </td>
            <td>
                <div class="control-group">
                    <?php $modTandaBukti->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBukti->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modTandaBukti, 'tglkaskeluar', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modTandaBukti,
                            'attribute' => 'tglkaskeluar',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($modTandaBukti,'tglbuktibayar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>

                <?php echo $form->dropDownListRow($modTandaBukti, 'carabayarkeluar',  LookupM::getItems('carapembayaran'), array('readonly' => 'readonly', 'onchange' => 'ubahCaraPembayaran(this)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Menggunakan Kartu', 'pakeKartu', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::checkBox('pakeKartu', false, array('onchange' => "enableInputKartu();", 'onkeypress' => "return $(this).focusNextInputField(event);")) ?> <i class="icon-chevron-down"></i>
                    </div>
                </div>
                <div id="divDenganKartu" class="hide">
                    <?php echo $form->dropDownListRow($modTandaBukti, 'melalubank',  LookupM::getItems('dengankartu'), array('onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti, 'denganrekening', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti, 'atasnamarekening', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

                </div>
                <?php echo $form->textFieldRow($modTandaBukti, 'namapenerima', array('placeholder' => 'Nama Penerima', 'readonly' => false, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'untukpembayaran', array('placeholder' => 'Untuk Pembayaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textAreaRow($modTandaBukti, 'alamatpenerima', array('placeholder' => 'Alamat Penerima', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'keterangan_pengeluaran', array('placeholder' => 'Keterangan Pengeluaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
        </tr>
    </table>
</fieldset>
<div class="form-actions">
    <?php
    if ($modTandaBukti->isNewRecord)
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        );
    else
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
        );
    if (!$modTandaBukti->isNewRecord)
        echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi Retur', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-info', 'onclick' => 'printRincianKasir(\'PRINT\')', 'disabled' => false));
    //                    
    //                    CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printRincianKasir($modTandaBukti->returbayarpelayanan_id);return false",'disabled'=>false)); 
    else
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->route, array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')); ?>
    <?php
    $content = $this->renderPartial('billingKasir.views.tips.transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/kwitansi/view');
$urlPrintRincian =  Yii::app()->createUrl('billingKasir/kwitansi/viewRincian&id=' . $modTandaBukti->returbayarpelayanan_id);

$js = <<< JSCRIPT
function printKasir(caraPrint)
{
    window.open("${urlPrint}/"+$('#sanapza-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printRincianKasir(caraPrint)
{
    window.open("${urlPrintRincian}"+$('#sanapza-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function ubahCaraPembayaran(obj) {
        if (obj.value == 'CICILAN') {
            $('#TandabuktibayarT_jmlpembayaran').removeAttr('readonly');
        } else {
            $('#TandabuktibayarT_jmlpembayaran').attr('readonly', true);
            hitungJmlBayar();
        }

        if (obj.value == 'TUNAI') {
            hitungJmlBayar();
        }
    }

    function enableInputKartu() {
        if ($('#pakeKartu').is(':checked'))
            $('#divDenganKartu').show();
        else
            $('#divDenganKartu').hide();
        if ($('#TandabuktikeluarT_melalubank').val() != '') {
            //myAlert('isi');
            $('#TandabuktikeluarT_denganrekening').removeAttr('readonly');
            $('#TandabuktikeluarT_atasnamarekening').removeAttr('readonly');
        } else {
            //myAlert('kosong');
            $('#TandabuktikeluarT_denganrekening').attr('readonly', 'readonly');
            $('#TandabuktikeluarT_atasnamarekening').attr('readonly', 'readonly');

            $('#TandabuktikeluarT_denganrekening').val('');
            $('#TandabuktikeluarT_atasnamarekening').val('');
        }
    }
</script>