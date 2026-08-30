<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'batalrawatinap-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return cekSubmit(this);'
    ),
    'focus' => '#',
));
?>
<div class="panel panel-gradient">


    <div class="panel-heading">
        <div class="panel-title">
            Transaksi Tanda Bukti Kas Keluar Anggaran Operasional
        </div>
    </div>
    <div class="panel-body">
        <?php

        $this->widget('bootstrap.widgets.BootAlert');
        echo $form->errorSummary(array($modBukti));

        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pengajuan Anggaran Operasional
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'form._formPegawai', array('modPegawai' => $modPegawai, 'model' => $model, 'form' => $form), true); ?>
                <div class="clear"></div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Detail</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php echo $this->renderPartial($this->path_view . 'table._tableItemsApp', array('det' => $modDet, 'modDetR' => $modDetR, 'form' => $form, 'model' => $model), true); ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Form Kas Keluar
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <?php echo $this->renderPartial($this->path_view . 'form._rowListRekening', array(
                        'form' => $form,
                        'modUraian' => null,
                        'modPengUmum' => $modPengUmum,
                    )); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->hiddenField($model, 'pengajuanpetty_id') ?>
                    <?php
                    echo $form->textFieldRow($modBukti, 'tglkaskeluar', array('class' => 'span3 realtime', 'readonly' => true));
                    ?>
                    <?php echo $form->textFieldRow($modBukti, 'nokaskeluar', array('class' => 'span3', 'readonly' => true)) ?>

                    <?php echo $form->textFieldRow($modBukti, 'jmlkaskeluar', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;', 'readonly' => true)); ?>

                    <?php echo $form->textAreaRow($modBukti, 'keterangan_pengeluaran', array('class' => 'span3 autogrow')) ?>
                    <?php echo $form->dropDownListRow($modBukti, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'caraBayarPilih(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <div id="divCaraBayarTransfer" class="hide">
                        <?php echo $form->textFieldRow($modBukti, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textFieldRow($modBukti, 'denganrekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textFieldRow($modBukti, 'atasnamarekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textFieldRow($modBukti, 'nobukti_transfer', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                    <?php echo $form->textFieldRow($modBukti, 'namapenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textAreaRow($modBukti, 'alamatpenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modBukti, 'untukpembayaran', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    $modBukti->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'submit')
                );
            } else {
                echo CHtml::htmlButton(
                    $modBukti->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
                );
            }
            ?>
        </div>
    </div>
</div>

<?php echo $this->renderPartial($this->path_view . 'js._jsFunctionsApp', array('model' => $model, 'modDet' => $modDet, 'modBukti' => $modBukti)); ?>
<script>
    $(document).ready(function() {
        hitungTot();
        caraBayarPilih($("#<?php echo CHtml::activeId($modBukti, 'carabayarkeluar') ?>").val());
    });
</script>
<?php
$this->endWidget();
?>