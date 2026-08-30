<div class="white-container">
    <?php
    $this->breadcrumbs = array(
        'Bayar Uang Muka Beli',
    ); ?>

    <?php
    // $this->widget('application.extensions.moneymask.MMask',array(
    //     'element'=>'.currency',
    //     'currency'=>'PHP',
    //     'config'=>array(
    //         'symbol'=>'Rp ',
    // //        'showSymbol'=>true,
    // //        'symbolStay'=>true,
    //         'defaultZero'=>true,
    //         'allowZero'=>true,
    //         'precision'=>0,
    //     )
    // ));
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); 
    ?>
    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
    ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pembayaran-uangmukabeli-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#BKSupplierM_supplier_nama',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)',
            // 'onsubmit'=>'return cekInput();'
            'onsubmit' => 'return requiredCheck(this);'
        ),
    )); ?>
    <legend class="rim2">Transaksi Bayar <b>Uang Muka Pembelian</b></legend>
    <?php $this->renderPartial($this->path_view . '_ringkasDataSupplier', array('modSupplier' => $modSupplier)); ?>
    <?php echo $form->errorSummary(array($modUangMuka, $modBuktiKeluar)); ?>
    <fieldset class="box">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pengeluaran</b>
                </div>
            </div>
            <div class="panel-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td>
                            <?php //echo $form->textFieldRow($modBuktiKeluar,'tglkaskeluar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                            ?>
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
                                            'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textAreaRow($modBuktiKeluar, 'keterangan_pengeluaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
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
            </div>
        </div>
    </fieldset>

    <div class="form-actions">
        <?php
        if (!isset($_GET['sukses'])) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            );
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);')
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
        $content = $this->renderPartial($this->path_view . 'tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
$urlPrint = $this->createUrl('Print&tandabuktikeluar_id=' . $modBuktiKeluar->tandabuktikeluar_id);
$js = <<< JSCRIPT
function print(caraPrint){
	window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=890px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    $('.currency').each(function() {
        this.value = formatNumber(this.value)
    });

    function formCarabayar(carabayar) {
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').slideDown();
        } else {
            $('#divCaraBayarTransfer').slideUp();
            $('#divCaraBayarTransfer input').each(function() {
                this.value = ''
            });
        }
    }

    function cekInput() {
        $('.currency').each(function() {
            this.value = unformatNumber(this.value)
        })
        if ($('#BKTandabuktikeluarT_jmlkaskeluar').val() == 0)
            return false;

        return true;
    }
</script>