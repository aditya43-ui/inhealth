<!--div class="white-container"-->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Penjualan Peralatan Medis</b>
                </div>
            </div>
            <div class="panel-body">
                <fieldset id="input-penjualanaset">
                    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                        'id' => 'akpenjualanaset-t-form',
                        'enableAjaxValidation' => false,
                        'type' => 'horizontal',
                        'htmlOptions' => array(
                            'onKeyPress' => 'return disableKeyPress(event)',
                            'onsubmit' => 'return requiredCheck(this);'
                        ),
                        'focus' => '#',
                    )); ?>
                    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-search"></i> Pencarian Barang
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <fieldset class="box">
                                    <div class="control-group">
                                        <?php echo $form->labelEx($modAset, 'Nama Barang', array('class' => 'control-label')); ?>
                                        <div class="controls">
                                            <?php echo $form->textField($modAset, 'barang_nama'); ?>
                                            <!-- <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modAset,
                                                    'attribute'=>'[0]tglpenghapusan',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                            'dateFormat'=> 'MM yy',
                                                            'changeYear' => true,
                                                            'changeMonth' => true,
                                                            'changeDate' => false,
                                                            'showSecond' => false,
                                                            'showDate' => false,
                                                            'showMonth' => false,
                                                            // 'timeFormat' => 'hh:mm:ss',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,
                                                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                            'class'=>'dtPicker3 tglpenghapusan',
                                                            'onChange'=>'ambilDataPenghapusan()',
                                                    ),
                                            )); ?> -->
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'ambilDataPenghapusan(); return false;')); ?>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Peralatan Medis</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <div id="div_tblInputUraian" class="block-tabel">
                                <table id="tblInputUraian" class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Pilih<br><?php
                                                                        echo CHtml::checkBox('checkAllAset', true, array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')) ?>
                                            </th>
                                            <th>Kode Inventaris</th>
                                            <th>No. Register</th>
                                            <th>Nama Barang</th>
                                            <th>Harga</th>
                                            <th>Harga Jual Aktiva</th>
                                            <!--th>&nbsp;</th-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $this->renderPartial($this->path_view . '_rowUraian', array('form' => $form, 'modAset' => $modAset)); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <?php $disableSave = (isset($_GET['sukses'])) ? 'disabled' : ''; ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekSimpanPeralatanMedis()', 'onkeypress' => 'cekSimpanPeralatanMedis()', 'disabled' => $disableSave)); ?>
                        <?php
                        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl("/" . $this->route), array(
                            'class' => 'btn btn-default',
                            'onclick' => 'return refreshForm(this);'
                        ));
                        ?>
                        <?php
                        $content = $this->renderPartial($this->path_view . 'tips.tipsPenjualanAset', array(), true);
                        $this->widget('UserTips', array('content' => $content));
                        ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<!--/div-->

<?php $this->renderPartial($this->path_view . "_jsFunctions"); ?>