<div class="panel panel-success panel_monitor">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo CHtml::checkBox('cb_kontraksi', !$kontraksi->isNewRecord, array(
                'class'=>'cb_monitor', 'disabled'=> !$kontraksi->isNewRecord,
            )); ?>
            Kontraksi
        </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($kontraksi, 'pemeriksaanke', array('class'=>'span1 numbers-only', 'readonly'=>true)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($kontraksi, 'tgl_pemeriksaan', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$kontraksi,
                            'attribute'=>'tgl_pemeriksaan',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'span3','onclick'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($kontraksi, 'jam_pemeriksaan', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$kontraksi,
                            'attribute'=>'jam_pemeriksaan',
                            'mode'=>'time',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'span3','onclick'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <?php echo $form->radioButtonListRow($kontraksi, 'jml_kontraksi', LookupM::getItemsUrutan('jmlkontraksidlmsepuluhmenit_partograf'), array(
                    'template'=>'<div class="radio inline">{input}{label} </div>', 'uncheckValue'=>null,
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->radioButtonListRow($kontraksi, 'durasikontraksi', LookupM::getItemsUrutan('durasikontraksi_partograf'), array(
                    'template'=>'<div class="radio inline">{input}{label} </div>', 'uncheckValue'=>null,
                )); ?>
                <?php echo $form->dropDownListRow($kontraksi, 'petugaspemeriksa_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                    'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                    'pegawai_aktif'=>true,
                )), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --')); ?>
            </div>
        </div>
    </div>
</div>

