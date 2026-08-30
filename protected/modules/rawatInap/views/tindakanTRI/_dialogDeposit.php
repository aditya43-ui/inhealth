<fieldset class="box">
    <legend class="rim">Data Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id',array('class'=>'control-label')); ?>
                <?php
                    if (!empty($modPasienPulang)){
                        echo CHtml::activeHiddenField($modPasienPulang,'tglpasienpulang',array('class'=>'span3 realtime', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'carakeluar_id',array('value'=>Params::CARAKELUAR_ID_RAWATINAP, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'kondisikeluar_id',array('value'=>Params::KONDISIKELUAR_ID_RAWATINAP, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'lamarawat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                    }
                ?>
            </td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            <td rowspan="4">
                <?php 
                    if(!empty($modPasien->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'Foto pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly'=>true)); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->dokter, 'nama_pegawai', array('readonly'=>true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('readonly'=>true)); ?></td>
        </tr>        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

            <td><?php echo CHtml::activeLabel($modPasien, 'alamat_pasien', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'alamat_pasien', array('readonly'=>true)); ?></td>
        </tr>        
    </table>
</fieldset>
<?php echo CHtml::activeHiddenField($modBayarUangMuka, 'bayaruangmuka_id'); ?>
<fieldset class="box">
    <legend class="rim">Deposit Pasien</legend>
    <table class="table table-condensed" width="100%">
        <tr>
			<td width='15%'>Jumlah Uang Muka</td>
            <td width='30%'>: <?php echo MyFormatter::formatUang($modBayarUangMuka->jumlahuangmuka); ?></td>

			<td width='15%'>Tanggal Perjanjian <span class="required">*</span></td>
            <td width='30%'>
				<?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modBayarUangMuka,
                    'attribute' => 'tglperjanjian',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
						'minDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true,'class'=>'dtPicker3',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
			</td>
			
			<td width='15%'></td>
            <td width='30%'></td>
		</tr>
        <tr>
			<td>Tanggal Uang Muka</td>
            <td>: <?php echo $modBayarUangMuka->tgluangmuka; ?></td>
			
			<td>Keterangan Perjanjian <span class="required">*</span></td>
            <td rowspan="2"><?php echo CHtml::activeTextArea($modBayarUangMuka, 'keterangan_perjanjian', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
        <tr>
			<td>No. Bukti Bayar</td>
            <td>: <?php echo $modBayarUangMuka->tandabuktibayar->nobuktibayar; ?></td>
			
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</fieldset>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
			array('class' => 'btn btn-danger', 'id'=>'btn_savedeposit','type'=>'button', 'onKeypress'=>'simpanDeposit();', 'onClick'=>'simpanDeposit();')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds','Batal'),
			array('class'=>'btn btn-info', 'type'=>'button', 'onKeypress'=>'$("#dialogDeposit").dialog("close"); return false;', 'onClick'=>'$("#dialogDeposit").dialog("close"); return false;')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds','Lanjutkan <i class="icon-arrow-right icon-white"></i>'),
			array('class' => 'btn btn-danger','id'=>'btn_lanjutdeposit', 'type'=>'button', 'onKeypress'=>'cekInput(); $("#dialogDeposit").dialog("close");', 'onClick'=>'cekInput(); $("#dialogDeposit").dialog("close");','disabled'=>true)); ?>
</div>