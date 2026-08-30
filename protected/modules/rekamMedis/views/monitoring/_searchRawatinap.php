<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'monitoring-search-form',
    'type' => 'horizontal',
)); ?>
<?php //echo $form->textFieldRow($model,'peminjamanrm_id',array('class'=>'span5')); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <div class="control-label">
                <?php echo CHtml::activeCheckBox($model, 'cekTanggalAdmisi'); ?>
                <?php echo CHtml::label("Tgl. Admisi", 'RKMonitoringrawatinapV_cekTanggalAdmisi', array('class' => 'control-label',)) ?>
            </div>
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
            <div class="control-label">
                <?php echo CHtml::label('Tgl. Masuk Kamar', 'tglmasukkamar'); ?>
            </div>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglmasukkamar',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4', 'onkeypress' => '$(this).focusNextInputField(event)', 'autofocus' => true, 'placeholder' => 'Nama Pasien')); ?>
        <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->CarabayarItems, 'carabayar_id', 'carabayar_nama'), array(
            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => 'RKMonitoringrawatinapV')),
                'update' => '#RKMonitoringrawatinapV_penjamin_id'  //selector to update
            ),
        )); ?>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'penjamin_id', PenjaminrekM::model()->getPenjaminItems(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span4', 'onkeypress' => '$(this).focusNextInputField(event)', 'placeholder' => 'No. Rekam Medik')); ?>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span4', 'onkeypress' => '$(this).focusNextInputField(event)', 'placeholder' => 'No. Pendaftaran')); ?>
        <?php //echo $form->dropDownListRow($model,'carakeluar',LookupM::getItems('carakeluar'),array('empty'=>'-- Pilih --','onkeypress'=>'$(this).focusNextInputField(event)')); 
        ?>
        <?php //echo $form->dropDownListRow($model,'kondisipulang',LookupM::getItems('kondisipulang'),array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)')); 
        ?>
        <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::getRuanganByInstalasi(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => '$(this).focusNextInputField(event)')); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'pegawai_id',
            CHtml::listData(DokterV::model()->findAllByAttributes(array(
                'instalasi_id' => Params::INSTALASI_ID_RI,
            ), array(
                'order' => 'nama_pegawai asc'
            )), 'pegawai_id', 'namaLengkap'),
            array('class' => 'span4', 'empty' => '-- Pilih --')
        ); ?>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    );
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/Monitoring/Rawatinap'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    // $content = $this->renderPartial('../tips/informasi', array(), true);
    // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>