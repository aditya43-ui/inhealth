<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarianpasien-form',
        'type' => 'horizontal',
    ));
    ?>
    <div class="row">
        <!--<div class="col-sm-6">
		<div class="control-group">
                    <br>
			<?php // echo CHtml::label('Tgl. Rencana MCU', '', array('class' => 'control-label')) 
            ?>
			<div class="controls">
				<?php
                //					$modPemanggilanMcu->tgl_awal_kontrol = (!empty($modPemanggilanMcu->tgl_awal_kontrol) ? MyFormatter::formatDateTimeForUser($modPemanggilanMcu->tgl_awal_kontrol) : null);
                //					$this->widget('MyDateTimePicker',array(
                //						'model'=>$modPemanggilanMcu,
                //						'attribute'=>'tgl_awal_kontrol',
                //						'mode'=>'datetime',
                //						'options'=> array(
                //							'showOn' => false,
                //							'maxDate' => 'd',
                //							'yearRange'=> "-150:+0",
                //						),
                //						'htmlOptions'=>array('class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
                //						),
                //					));
                //					$modPemanggilanMcu->tgl_awal_kontrol = (!empty($modPemanggilanMcu->tgl_awal_kontrol) ? MyFormatter::formatDateTimeForDb($modPemanggilanMcu->tgl_awal_kontrol) : null);
                ?>
			</div>
		</div>
		<div class="control-group">
			<?php // echo CHtml::label('Sampai dengan', '', array('class' => 'control-label')) 
            ?>
			<div class="controls">
				<?php
                //					$modPemanggilanMcu->tgl_akhir_kontrol = (!empty($modPemanggilanMcu->tgl_akhir_kontrol) ? MyFormatter::formatDateTimeForUser($modPemanggilanMcu->tgl_akhir_kontrol) : null);
                //					$this->widget('MyDateTimePicker',array(
                //						'model'=>$modPemanggilanMcu,
                //						'attribute'=>'tgl_akhir_kontrol',
                //						'mode'=>'datetime',
                //						'options'=> array(
                //							'showOn' => false,
                //							'maxDate' => 'd',
                //							'yearRange'=> "-150:+0",
                //						),
                //						'htmlOptions'=>array('class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
                //						),
                //					)); 
                //					$modPemanggilanMcu->tgl_akhir_kontrol = (!empty($modPemanggilanMcu->tgl_akhir_kontrol) ? MyFormatter::formatDateTimeForDb($modPemanggilanMcu->tgl_akhir_kontrol)  : null);
                ?>
			</div>
		</div>
	</div>-->
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Rencana MCU", 'tglrenkontrol', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPemanggilanMcu->tgl_awal_kontrol)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPemanggilanMcu->tgl_akhir_kontrol)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($modPemanggilanMcu->tgl_awal_kontrol)) ?> - <?php echo date('d M Y', strtotime($modPemanggilanMcu->tgl_akhir_kontrol)) ?></span>
                        <?php echo $form->hiddenField($modPemanggilanMcu, 'tgl_awal_kontrol', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($modPemanggilanMcu, 'tgl_akhir_kontrol', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPemanggilanMcu, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik Pasien', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modPemanggilanMcu, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <label for="namaPasien" class="control-label">Status Periksa</label>
                <div class="controls">
                    <?php echo $form->dropDownList($modPemanggilanMcu, 'keterangan_pemanggilan', LookupM::getItems('statusperiksa'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>