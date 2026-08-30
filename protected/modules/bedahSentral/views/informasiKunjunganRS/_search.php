<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'search',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
            'htmlOptions' => array(),

        )); ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Kunjungan', 'Tanggal Awal', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',

                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker3 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('sampai dengan', 'Tanggal Akhir', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //                                                    'minDate' => 'd',
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker3 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('autofocus' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Rekam Medik')); ?>
                <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Pendaftaran')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Pasien')); ?>
                <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Alias')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Dokter Penanggung Jawab', 'Dokter Penanggung Jawab', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'nama_pegawai', CHtml::listData(PegawaiM::model()->findAll(), 'nama_pegawai', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Asal Instalasi', 'Asal Instalasi', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_id in(' . PARAMS::INSTALASI_ID_RJ . ',' . PARAMS::INSTALASI_ID_RD . ',' . PARAMS::INSTALASI_ID_RI . ')'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php $content = $this->renderPartial('tips/tipsInformasiKunjunganRS', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
</fieldset>