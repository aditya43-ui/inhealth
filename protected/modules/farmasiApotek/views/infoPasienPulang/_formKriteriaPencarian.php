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
                    <?php echo CHtml::label("Tgl. Awal", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php //echo $form->textFieldRow($model,'nama_bin',array('placeholder'=>'Nama Panggilan Pasien','class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                ?>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'autofocus' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php if ($this->action->id == 'indexRI') : ?>
                    <?php echo $form->dropDownListRow(
                        $model,
                        'kelaspelayanan_id',
                        CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array(
                            'kelaspelayanan_aktif' => true,
                        ), array(
                            'order' => 'kelaspelayanan_nama',
                        )), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                        array('empty' => '-- Pilih --', 'class' => 'span4')
                    ); ?>
                <?php endif; ?>
            </div>
            <div class="col-sm-6">
                <?php
                $carabayar = CarabayarM::model()->findAll(array(
                    'condition' => 'carabayar_aktif = true',
                    'order' => 'carabayar_nama ASC',
                ));
                foreach ($carabayar as $idx => $item) {
                    $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                        'carabayar_id' => $item->carabayar_id,
                        'penjamin_aktif' => true,
                    ));
                    if (empty($penjamins)) unset($carabayar[$idx]);
                }
                $penjamin = PenjaminpasienM::model()->findAll(array(
                    'condition' => 'penjamin_aktif = true',
                    'order' => 'penjamin_nama',
                ));
                echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span4',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                    ),
                ));
                echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                ?>
                <?php if ($this->action->id == 'indexRJ') : ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true, 'instalasi_id' => array(Params::INSTALASI_ID_RJ)), array('order' => 'instalasi_id, ruangan_nama ASC')), 'ruangan_id', 'ruangan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($this->action->id == 'indexRI') : ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'ruangan_id',
                                CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true, 'instalasi_id' => array(Params::INSTALASI_ID_RI)), array('order' => 'instalasi_id, ruangan_nama ASC')), 'ruangan_id', 'ruangan_nama'),
                                array(
                                    'class' => 'span4',
                                    'empty' => '-- Pilih --',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('/actionDynamic/getKamarRuangan', array('encode' => false, 'namaModel' => get_class($model))),
                                        'success' => 'function(data){$("#' . CHtml::activeId($model, "kamarruangan_id") . '").html(data); }',
                                    ),
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kamar Ruangan', 'kamarruangan_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'kamarruangan_id', array(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData(
                    DokterV::model()->findAll(array(
                        'order' => 'nama_pegawai'
                    )),
                    'pegawai_id',
                    'namaLengkap'
                ), array(
                    'empty' => '-- Pilih--', 'class' => 'span4',
                )); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/informasiPasienPulang', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>