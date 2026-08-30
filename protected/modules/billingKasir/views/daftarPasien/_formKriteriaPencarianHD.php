<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php
                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                    echo CHtml::label('Tgl. Pendaftaran', 'tglPendaftaran', array('class' => 'control-label inline'))
                    ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //                                                    'minDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'autofocus' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Alias', 'nama_bin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nama_bin', array('placeholder' => 'Nama Panggilan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <?php //$model->statusperiksa = (!empty($model->statusperiksa)) ? $model->statusperiksa : 'SEDANG PERIKSA';
                ?>
                <?php echo $form->dropDownListRow($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_HD), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($model, 'shift_id', CHtml::listData(ShiftM::model()->findAllByAttributes(array('shift_aktif' => true), array('order' => 'shift_nama')), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array(
                    'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>