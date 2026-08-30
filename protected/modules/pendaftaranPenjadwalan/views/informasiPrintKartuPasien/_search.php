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
            'id' => 'ppinformasiprintkartupasien-search',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
        ));
        ?>
        <style>
            #ruangan label {
                width: 200px;
                display: inline-block;
            }
        </style>
        <div class="row">
            <div class="col-sm-6">
                <?php /* //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 
                    'class' => 'dtPicker2'),
                ));
                ?>
                <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Sampai dengan</label>
            <div class="controls">
                <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true,
                    'class' => 'dtPicker2'),
                ));
                ?>
                <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
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
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'maxlength' => 6)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'alamat_pasien', array('placeholder' => 'Alamat Pasien', 'class' => 'span4 custom-only', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
            <?php /*
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo CHtml::label('RT / RW','rt', array('class'=>'control-label inline')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'rt', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?>   / 
                <?php echo $form->textField($model,'rw', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?> 
            </div>
        </div>
        <?php
            echo $form->dropDownListRow(
                $model, 'statusprintkartu',array( '0' => 'Belum', '1' => 'Sudah'),array('empty'=>'-- Pilih --', 'options'=>array(1=>array('selected'=>false)))
        ); ?>
    </div>
     * 
     */ ?>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <!-- <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl('informasiPrintKartuPasien/index'),
                        array('title' => 'Ulang', 'class' => 'btn btn-default')
                    ); ?> -->
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array(
                    'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPrintKartuPasien', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>