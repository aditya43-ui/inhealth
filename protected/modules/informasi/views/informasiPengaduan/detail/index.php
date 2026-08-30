<style type="text/css">
	table tr td.rights {
		text-align: right;
		padding-right: 10px;
		width: 100px;
	}
	table tr td img {
		width: 50px;
	}
	table tr td {
		vertical-align: middle;
		padding: 0 10px;
	}
        .foricon{
            /*background-color: #eee;*/
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 10px;
            font-weight: bold;
            text-align: center;
            font-size: 10px;
            min-width: 100px;
            cursor: pointer;
            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2);
        }
        .foricon:hover {
          background-color: #3093c7;  
        }
        .iconactive{
            background-color: #3093c7;
        }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengaduan Pelayanan</b></div>
    </div>
    <div class="panel-body">
        <?php
                $sukses = null;
                if(isset($_GET['sukses'])){
                    $sukses = $_GET['sukses'];
                }
                if($sukses > 0) 
                    Yii::app()->user->setFlash('success',"Transaksi Pengaduan Pelayanan berhasil disimpan!");

                ?> 
	<?php 
	$this->widget('bootstrap.widgets.BootAlert');
	 ?>
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'id' => 'inputPengaduan-form',
		'enableAjaxValidation' => false,
		'enableClientValidation' => false,
		'type' => 'horizontal',
		'focus' => '#',
		'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
	));
	?>
	
	<div class="row">
            <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

		<div class="col-sm-6">
				<div class="control-group">
                    <label class="control-label">Tanggal Pengaduan</label>
                    <div class="controls">
                            <?php $model->kepuasanpasien_tgl = MyFormatter::formatDateTimeForUser($model->kepuasanpasien_tgl); ?>
                            <?php    $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'kepuasanpasien_tgl',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        )); ?>
                    </div>
                </div> 
                     <div class="control-group">
                            <label class="control-label">Media Pengaduan <span class="required">*</span></label>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'mediapengaduan', LookupM::getItemsUrutan('media_pengaduan'),array('disabled'=>true,'required'=>'required','style' => 'width:170px;','class'=>'form-control span3 ','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                             </div>   
                    </div>
			
			<?php echo $form->textFieldRow($model,'kp_namapelapor',array('disabled'=>true,'placeholder'=>'Nama Pelapor','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'kp_noidentitasn_pelapor',array('disabled'=>true,'placeholder'=>'No. Identitas Pelapor','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'kp_alamat_pelapor',array('disabled'=>true,'placeholder'=>'Alamat','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
			<?php echo $form->textFieldRow($model,'kp_hp_pelapor',array('disabled'=>true,'placeholder'=>'Nomer HP','class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		</div>
		
		<div class="col-sm-6">
			<div class="control-group">
                                <div class="controls">
			<?php echo $form->textFieldRow($model,'no_rekam_medik',array('disabled'=>true,'placeholder'=>'Nama Pasien','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
				</div>
			</div>
			
			<?php echo $form->textFieldRow($model,'nama_pasien',array('disabled'=>true,'placeholder'=>'Nama Pasien','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
			
                   
                    
                    
                    <div class="control-group">
				<label class="control-label">Instalasi Terkait Pengaduan <span class="required">*</span></label>
                                
				 
                                <div class="controls"style="margin-top:1%">
					
                                    <?php /*echo $form->dropDownList($model,'layanansurvei_id',  CHtml::listData(LayanansurveiM::model()->findAllByAttributes(array('layanansurvei_aktif'=>true), array('order'=>'layanansurvei_nama ASC')), 'layanansurvei_id', 'layanansurvei_nama'),
                                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'required'=>'required',
                                'empty'=>'-- Pilih  --', 
									/*	'ajax'=>array('type'=>'POST',
                                                    'url'=>$this->createUrl('SetDropdownInstalasiSurvei',array('encode'=>false,'model_nama'=>get_class($model))),
                                                    'update'=>"#".CHtml::activeId($model, 'kp_namaunit'),
											),
									)); */
                                        ?>
                                    <?php
                                           echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true), array('order'=>'instalasi_nama ASC')), 'instalasi_id', 'instalasi_nama'), array(
				'empty'=>'-- Pilih --',
				'class'=>'span3', 
                                'disabled'=>true,
				'ajax' => array('type'=>'POST',
					'url'=> $this->createUrl('/actionDynamic/GetRuanganDariInstalasi',array('encode'=>false,'namaModel'=>get_class($model))), 
					'success'=>'function(data){$("#'.CHtml::activeId($model, "ruangan_id").'").html(data); }',
				),
			 ));
                                        ?>
                                     </div>
                                <br> 
                                <div class="controls">
                                    
					<?php //echo $form->dropDownList($model,'kp_namaunit',array(),
                                                //array('required'=>'required', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih  --',)); 
                                        ?>
                                    
                                </div>
				
				
			</div>
                    <div class="control-group">
				<label class="control-label">Ruangan <span class="required">*</span></label>
                                <div class="controls">
                                    
				        <?php echo $form->dropDownList($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true), array('order'=>'ruangan_nama ASC')), 'ruangan_id', 'ruangan_nama'),
                                                array('required'=>'required', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih  --','disabled'=>true)); 
                                        ?>
                                    
                                </div>
				
				
			</div>
			
			<div class="control-group">
                    <label class="control-label">Target Tanggal Penyelesaian</label>
                    <div class="controls">
                            <?php $model->kp_tindaklanjut_tgl = MyFormatter::formatDateTimeForUser($model->kp_tindaklanjut_tgl); ?>
                            <?php    $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'kp_tindaklanjut_tgl',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','disabled'=>true,),
                        )); ?>
                    </div>
            </div>
		</div>
		
		<div class="span10">
			<div class="control-group">
				<?php echo CHtml::label("Uraian Keluhan <span class='required'>*</span>", '', array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textArea($model,'kp_deskripsi_aduan',array('disabled'=>true,'rows'=>5, 'cols'=>50, 'class'=>'span8', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Tindakan Awal", '', array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textArea($model,'kp_tindakawal_desk',array('disabled'=>true,'rows'=>5, 'cols'=>50, 'class'=>'span8', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Tindakan Lanjut", '', array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textArea($model,'kp_tindaklanjut_desk',array('disabled'=>true,'rows'=>5, 'cols'=>50, 'class'=>'span8', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class='form-actions'>
                                    <?php
                                    $hasil = '';
                                     if($model->kp_sangatpuas == 1) { 
                                            $hasil ="Sangat Puas"; 

                                          }else if($model->kp_puas == 1){
                                            $hasil ="Puas"; 

                                          }else if($model->kp_tidakpuas == 1){
                                           $hasil ="Tidak Puas"; 
 
                                          }
                                          ?>
		<table>
			<tr>       
                            <?php if($hasil == "Sangat Puas") { ?>
                                <td>
                                    <div class="foricon" onclick="sangatPuas(this);">
                                        <img src='data/images/informasi/sangatpuas.png' height="40"> 
                                        <br>SANGAT PUAS
                                        <?php echo $form->hiddenField($model,'kp_sangatpuas',array('readonly'=>true, 'value'=>'0'));?>
                                    </div>
                                </td>
                            <?php }else if($hasil == "Puas") { ?>
				<td>
                                    <div class="foricon" onclick="puas(this);">
                                        <img src='data/images/informasi/puas.png' height="40"> 
                                        <br>PUAS
                                        <?php echo $form->hiddenField($model,'kp_puas',array('readonly'=>true, 'value'=>'0'));?>
                                    </div>
                                </td>
                            <?php }else if($hasil == "Tidak Puas") { ?>
				<td>
                                    <div class="foricon" onclick="tidakPuas(this);">
                                        <img src='data/images/informasi/tidakpuas.png' height="40"> 
                                        <br>TIDAK PUAS
                                        <?php echo $form->hiddenField($model,'kp_tidakpuas',array('readonly'=>true, 'value'=>'0'));?>
                                    </div>
                                </td>
                            <?php } ?>
			</tr>
		</table>
    </div>
	
	<?php $this->endWidget(); ?>
</div>
</div>
