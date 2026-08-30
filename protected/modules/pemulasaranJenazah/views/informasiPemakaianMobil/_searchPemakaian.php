<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'id' => 'pemakaianambulans-t-search',
                'type' => 'horizontal',
                'focus' => '#' . CHtml::activeId($model, 'nopolisi'),
            )); ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Pemakaian', 'tglpemakaianambulans', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $model->tgl_awal = MyFormatter::formatDateTimeForDb($model->tgl_awal);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' =>  Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'class' => 'dtPicker2 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                            <?php echo $form->error($model, 'tgl_awal'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="namaPasien" class="control-label">Sampai dengan</label>
                        <div class="controls">
                            <?php
                            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($model->tgl_akhir);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' =>  Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'class' => 'dtPicker2 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                            <?php echo $form->error($model, 'tgl_akhir'); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'nopolisi', array('placeholder' => 'No. Polisi', 'class' => 'span3', 'maxlength' => 20)); ?>
                    <?php echo $form->textFieldRow($model, 'pemakai_nama', array('placeholder' => 'Nama Pemakai', 'class' => 'span3', 'maxlength' => 100)); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model, 'ruangan_nama', array('placeholder' => 'Ruangan', 'class' => 'span3')); ?>
                    <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span3', 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span3', 'maxlength' => 10)); ?>
                    <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3', 'maxlength' => 100)); ?>
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
                ); ?>
                <?php
                $content = $this->renderPartial('tips/informasi_pemakaian', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>