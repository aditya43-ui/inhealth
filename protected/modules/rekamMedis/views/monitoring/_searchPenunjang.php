<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'monitoring-search-form',
    'type' => 'horizontal',
)); ?>
<?php //echo $form->textFieldRow($model,'peminjamanrm_id',array('class'=>'span5')); 
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_awal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => '$(this).focusNextInputField(event)')); ?>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => '$(this).focusNextInputField(event)')); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4',)); ?>
        <?php echo $form->dropDownListRow($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJeniskasuspenyakitItems(), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => '$(this).focusNextInputField(event)')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'ruangan_id',
            CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = true AND instalasi_id In ('" . Params::INSTALASI_ID_RAD . "','" . Params::INSTALASI_ID_REHAB . "','" . Params::INSTALASI_ID_LAB . "','" . Params::INSTALASI_ID_IBS . "') ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'),
            array(
                'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => '$(this).focusNextInputField(event)',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/actionDynamic/getDokterRuangan', array('encode' => false, 'namaModel' => 'RKMonitoringpenunjangV')),
                    'update' => '#RKMonitoringpenunjangV_pegawai_id'  //selector to update
                ),
            )
        ); ?>
        <?php echo $form->dropDownListRow($model, 'pegawai_id', array(), array('empty' => '-- Pilih --', 'class' => 'span4',)); ?>
        <?php //echo $form->dropDownListRow($model,'carabayar_id',CHtml::listData($model->getCaraBayarItems(),'carabayar_id','carabayar_nama'),array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)')); 
        ?>
        <?php //echo $form->dropDownListRow($model,'penjamin_id',CHtml::listData($model->getPenjaminItems(),'penjamin_id','penjamin_nama'),array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)')); 
        ?>
        <?php echo $form->dropDownListRow($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => '$(this).focusNextInputField(event)')); ?>
        <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->CarabayarItems, 'carabayar_id', 'carabayar_nama'), array(
            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => 'RKMonitoringpenunjangV')),
                'update' => '#RKMonitoringpenunjangV_penjamin_id'  //selector to update
            ),
        )); ?>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'penjamin_id', PenjaminrekM::model()->getPenjaminItems(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
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
        Yii::app()->createUrl($this->module->id . '/Monitoring/Penunjang'),
        array(
            'title' => 'Ulang',
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