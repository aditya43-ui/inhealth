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
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Kunjungan", 'tgl_rekam', array('class' => 'control-label')) ?>
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
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span4 alphanumeric-only all-caps', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Pendaftaran', 'maxlength' => 12)); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('autofocus' => true, 'class' => 'span4 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Rekam Medik', 'maxlength' => 6)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4 hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Pasien')); ?>
    </div>
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'alias',array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Alias')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Dokter Penanggung Jawab', 'Dokter Penanggung Jawab', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'nama_pegawai', CHtml::listData(PegawaiM::model()->findAll("pegawai_aktif = TRUE ORDER BY nama_pegawai ASC"), 'nama_pegawai', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <?php
        $instalasi = InstalasiM::model()->findAllByAttributes(array(
            'instalasi_id' => array(2, 3, 4),
        ));
        $ruangan = RuanganM::model()->findAllByAttributes(array(
            'instalasi_id' => array(2, 3, 4),
            'ruangan_aktif' => true,
        ), array(
            'order' => 'instalasi_id, ruangan_nama',
        ));
        echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span4',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/ActionDynamic/getRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'ruangan_id', array(), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
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
    <?php $content = $this->renderPartial('tips/tipsInformasiKunjunganRS', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>