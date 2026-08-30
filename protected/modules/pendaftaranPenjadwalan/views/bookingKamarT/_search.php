<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'ppbooking-kamar-t-search',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
        )); ?>
        <div class="row">
            <div class="col-sm-12">
                <?php /*
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Awal','tgl_awal', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                <?php   
                    $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_awal',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                ),
                                'htmlOptions'=>array('readonly'=>true,
                                'class'=>'dtPicker2', 
                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
            )); ?> 
                <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="namaPasien" class="control-label">
               Sampai Dengan
          </label>
            <div class="controls">
                <?php $model->tgl_akhir= $format->formatDateTimeForUser($model->tgl_akhir); ?>
                <?php
                    $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_akhir',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                ),
                                'htmlOptions'=>array('readonly'=>true,
                                'class'=>'dtPicker2', 
                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                )); ?>
                <?php $model->tgl_akhir= $format->formatDateTimeForDb($model->tgl_akhir); ?>
            </div>
        </div>
		 * 
		 */ ?>
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label("No. Pendaftaran", 'no_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'prefix_pendaftaran', PendaftaranT::model()->getColumn(), array('empty' => '-- Pilih --', 'class' => 'numbers-only span2')); ?>
                        <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'noRekamMedik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'noRekamMedik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 6)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'bookingkamar_no', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'bookingkamar_no', array('placeholder' => 'No. Pemesanan', 'class' => 'span4 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'statusbooking', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'statusbooking', LookupM::getItems('statusbooking'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'statuskonfirmasi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'statuskonfirmasi', CustomFunction::getStatusKonfirmasiBooking(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'ruangan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(KamarruanganM::model()->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array(
                            'class' => 'span4', 'empty' => '-- Pilih --',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('GetKamarRuangan', array('encode' => false, 'namaModel' => 'PPBookingKamarT')),
                                'update' => '#PPBookingKamarT_kamarruangan_id',
                            ),
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropdownKelasPelayanan', array('encode' => false, 'namaModel' => get_class($model))),
                                'update' => '#' . CHtml::activeId($model, 'kelaspelayanan_id')
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'kamarruangan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'kamarruangan_id', array(), array(
                            'class' => 'span4', 'empty' => '-- Pilih --',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'kelaspelayanan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model,'bookingkamar_id',array('class'=>'span4')); 
        ?>
        <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span4')); 
        ?>
        <?php //echo $form->textFieldRow($model,'pasienadmisi_id',array('class'=>'span4')); 
        ?>
        <?php //echo $form->textAreaRow($model,'keteranganbooking',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); 
        ?>
        <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span4')); 
        ?>
        <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span4')); 
        ?>
        <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span4')); 
        ?>
        <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span4')); 
        ?>
        <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span4')); 
        ?>
        <div class="form-actions">
            <?php $controller = Yii::app()->controller->id; ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array(
                    'class' => 'btn btn-danger',
                    'type' => 'submit',
                    'title' => 'Cari'
                )
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/Admin'),
                array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Admin') . '";} ); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiBookingKamar', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>