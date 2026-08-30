<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'reinformasipenjualanprodukpos-v-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Rencana Operasi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $format = new MyFormatter; ?>
                    <?php 
                        $model2 = clone $model;
                        $model2->tgl_awal = $format->formatDateTimeForUser($model2->tgl_awal); ?>
                <?php
                // $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                // $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model2,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php $format = new MyFormatter; ?>
                    <?php 
                        $model2 = clone $model;
                        $model2->tgl_akhir = $format->formatDateTimeForUser($model2->tgl_akhir); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model2,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span4', 'maxlength' => 200, 'placeholder' => 'No. Pendaftaran')); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span4', 'maxlength' => 200, 'placeholder' => 'No. Rekam Medik')); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4', 'maxlength' => 100, 'placeholder' => 'Nama Pasien', 'autofocus' => true)); ?>
        <?php //echo $form->textFieldRow($model,'nama_bin',array('class'=>'span4','style'=>'width:140px','maxlength'=>200, 'placeholder'=>'Alias')); 
        ?>
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
    $content = $this->renderPartial('bedahSentral.views.tips.informasi_jadwalOperasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>