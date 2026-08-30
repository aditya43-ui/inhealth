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
            'id' => 'gzpengajuanbahanmkn-search',
            'type' => 'horizontal',
        )); ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Permintaan Bahan", 'tglpermintaanpembelian', array('class' => 'control-label')) ?>
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
                    <label for="namaPasien" class="control-label">
                        Tanggal Minta Dikirim
                    </label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglmintadikirim',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                // 'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span4'),
                        )); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nopengajuan', array('class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'placeholder' => 'No. Pengajuan')); ?>
                <?php //echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span4', 'maxlength'=>20)); 
                ?>
                <?php echo $form->dropDownListRow($model, 'status_persetujuan', Params::statusPersetujuan(), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Jenis PPh', 'pajak_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'pajak_id', CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND ispajakpegawai = false ORDER BY pajak_nama ASC'), 'pajak_id', 'pajak_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Sumber Dana Bahan', 'sumberdana_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'sumberdana_id', Chtml::ListData(SumberdanaM::model()->findAll("sumberdana_aktif = TRUE"), 'sumberdana_id', 'sumberdana_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')) ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model, 'idpegawai_mengajukan', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id  = '" . Yii::app()->user->getState('ruangan_id') . "' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Permintaan Uang Muka', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'statuspermintaanuangmuka', array(1 => 'Ada', 2 => 'Tidak Ada'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
                <?php // echo $form->dropDownListRow($model,'idpegawai_mengetahui', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id  = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --','class'=>'span4')); 
                ?>
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
            $content = $this->renderPartial($this->path_view . 'tips/informasiPengajuanBM', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>