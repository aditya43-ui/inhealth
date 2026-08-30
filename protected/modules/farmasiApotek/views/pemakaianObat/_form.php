<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'fapemakaianobat-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<?php $disabled = isset($_GET['sukses']) ? true : false; ?>
<?php echo $form->errorSummary($model); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-file-alt"></i> Data <b>Pemakaian Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <fieldset class="">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    if ($disabled) {
                        echo $form->textFieldRow($model, 'tglpemakaianobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true));
                    } else { ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglpemakaianobat', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $model->tglpemakaianobat = !empty($model->tglpemakaianobat) ? MyFormatter::formatDateTimeForUser($model->tglpemakaianobat) : date('d M Y H:i:s');
                                /*$this->widget('MyDateTimePicker', array(
										'model' => $model,
										'attribute' => 'tglpemakaianobat',
										'mode' => 'datetime',
										'options' => array(
											'dateFormat' => Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 realtime', 'onkeypress' => "return $(this).focusNextInputField(event)",),
									));*/
                                echo $form->textField($model, 'tglpemakaianobat', array('class' => 'realtime span3', 'readonly' => TRUE));
                                $model->tglpemakaianobat = !empty($model->tglpemakaianobat) ? MyFormatter::formatDateTimeForDb($model->tglpemakaianobat) : date('Y-m-d H:i:s');
                                ?>
                                <?php echo $form->error($model, 'tglpemakaianobat'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php echo $form->textFieldRow($model, 'nopemakaian_obat', array('disabled' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => $disabled)); ?>
                    <?php echo $form->textAreaRow($model, 'untukkeperluan_obat', array('placeholder' => 'Untuk Keperluan', 'rows' => 3, 'cols' => 80, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => $disabled)); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textAreaRow($model, 'ket_pemakaianobat', array('placeholder' => 'Keterangan Pemakaian Obat', 'rows' => 5, 'cols' => 180, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => $disabled)); ?>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<?php if (!$disabled) { ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class='fas fa-file-contract'></i> Detail <b>Obat</b>
            </div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial($this->path_view . '_formInputObat', array('model' => $model, 'form' => $form,)); ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Obat Alkes</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Obat</th>
                                <th hidden>Satuan Kecil</th>
                                <th>Jumlah</th>
                                <th hidden>Stok</th>
                                <th>Harga Satuan (Rp)</th>
                                <th>Subtotal</th>
                                <?php echo ($disabled) ? "" : "<th>Batal</th>"; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count((array)$modDetails) > 0) {
                                foreach ($modDetails as $i => $modDetail) {
                                    $modDetail->jmlstok = StokobatalkesT::getJumlahStokOaPemakaianTersimpan($modDetail->pemakaianobatdetail_id);
                                    $modDetail->subtotal = $modDetail->qty_satuanpakai * $modDetail->harga_satuanpakai;
                                    echo $this->renderPartial($this->path_view . '_rowDetail', array('modPemakaianObatDetail' => $modDetail));
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align: right;">Total</th>
                                <th><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $form->textField($model, 'totalharga', array('class' => 'integer2', 'style' => 'width:100px;', 'readonly' => 'true')) : $form->passwordField($model, 'totalharga', array('class' => 'integer2', 'style' => 'width:100px;', 'readonly' => 'true')); ?></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekObat();', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabled)
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->module->id . '/Index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'
        )
    ); ?>
    <?php
    if (isset($_GET['sukses'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => false));
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
    }
    ?>
    <?php
    $content = $this->renderPartial('farmasiApotek.views.pemakaianObat.tips.transsaksiPemakaianObat', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>