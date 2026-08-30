<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'periodebuatjadwal', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->periodebuatjadwal = (!empty($model->periodebuatjadwal) ? date("d/m/Y", strtotime($model->periodebuatjadwal)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'periodebuatjadwal',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        //												'minDate' => 'd',
                        'yearRange' => "-150:+0",
                        'onSelect' => 'js:function(){cekJadwal();}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));

                $model->tglawaltemp = $model->periodebuatjadwal;
                echo $form->hiddenField($model, 'tglawaltemp', array('readonly' => true));

                ?>
                <?php echo $form->error($model, 'periodebuatjadwal'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'sampaidengan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->sampaidengan = (!empty($model->sampaidengan) ? date("d/m/Y", strtotime($model->sampaidengan)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'sampaidengan',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        //												'minDate' => 'd',
                        'yearRange' => "-150:+0",
                        'onSelect' => 'js:function(){cekJadwal();}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                $model->tglakhirtemp = $model->sampaidengan;
                echo $form->hiddenField($model, 'tglakhirtemp', array('readonly' => true));
                ?>
                <?php echo $form->error($model, 'sampaidengan'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kelompok Pegawai', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kelompokpegawai_id',  CHtml::listData($model->KelompokpegawaiItems, 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">

        <div class="control-group">
            <?php echo CHtml::label('Instalasi', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList(
                    $model,
                    'instalasi_id',
                    CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE"), 'instalasi_id', 'instalasi_nama'),
                    array(
                        'disabled' => $dis, 'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/ActionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                            'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                        )
                    )
                ); //'onchange'=>'getRuanganForCheckBox(this);'
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruangan_id', $ruanganAsal, array('disabled' => $dis, 'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php /*
		<div class="control-group">
			<?php echo CHtml::label('Ruangan','', array('class'=>'control-label')) ?>			
			<div class="controls" class="box" id="ruangan">
				&nbsp;<?php  echo CHtml::checkBox('check_all','true',array('onclick'=>'checkSemua(this);'));?> Pilih Semua
				<table style="width:500px;" id="tabel-ruangan">					
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
		
		 * 
		 */ ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'getPenjadwalan();', 'onkeypress' => 'getPenjadwalan();')
    ); ?>
</div>