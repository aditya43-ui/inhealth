<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'informasi-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'instalasi_id'),
    )); ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-search"></i> Pencarian Kartu Stok Obat Alkes
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Tgl. Transaksi", 'tgl_rekam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->dropDownListRow(
                            $model,
                            'instalasi_id',
                            $instalasiAsals,
                            array(
                                'disabled' => $disabled, 'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                                )
                            )
                        );
                        ?>
                    </div>
                    <div class="control-group">
                        <?php echo $form->dropDownListRow($model, 'ruangan_id', $ruanganAsals, array('disabled' => $disabled, 'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Transaksi', 'Nama Transaksi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'transaksi', $model->getNamaTransaksiKartuStok(), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->dropDownListRow(
                            $model,
                            'jenisobatalkes_id',
                            CHtml::listData(JenisobatalkesM::model()->findAll(array(
                                'condition' => 'jenisobatalkes_aktif = true',
                                'order' => 'jenisobatalkes_nama',
                            )), "jenisobatalkes_id", "jenisobatalkes_nama"),
                            array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)")
                        ); ?>
                    </div>
                    <?php echo $form->dropDownListRow($model, 'obatalkes_golongan', ObatAlkesGolongan::items(), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->dropDownListRow($model, 'obatalkes_kategori', ObatAlkesKategori::items(), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($model, 'obatalkes_kode', array('class' => 'span4 custom-only', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($model, 'obatalkes_nama', array('class' => 'span4 custom-only', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownListRow($model, 'satuankecil_nama',  CHtml::listData(SatuankecilM::model()->findAll("satuankecil_aktif = TRUE ORDER BY satuankecil_nama ASC"), 'satuankecil_nama', 'satuankecil_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php // echo $form->dropDownListRow($model,'transaksi',$model->getNamaTransaksiKartuStok(),array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); 
                    ?>
                    <?php // echo $form->textFieldRow($model,'obatalkes_golongan',array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    ?>
                    <?php echo $form->textFieldRow($model, 'nobatch', array('class' => 'span4 custom-only', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglkadaluarsa', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglkadaluarsa',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    //'maxDate' => 'd',
                                    'minDate' => 'd',
                                    'yearRange' => "-0:+20",
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'placeholder' => '00/00/0000', 'class' => 'col-sm-6 dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            $model->tglkadaluarsa = $format->formatDateTimeforDb($model->tglkadaluarsa); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print("PRINT")')
        );
        $content = $this->renderPartial($this->path_view . '/tips/tipsInformasi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>