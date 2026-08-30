<div class="panel panel-success">
		<div class="panel-heading">
				<div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
		</div>
		<div class="panel-body">
			<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
				'action'=>Yii::app()->createUrl($this->route),
				'method'=>'get',
				'id'=>'rekonsiliasiobat-info-search',
							'type'=>'horizontal',
			)); ?>
			<div class="row-fluid">
				<div class="col-sm-6">
						<div class="control-group">
								<?php echo CHtml::label("Tanggal Pendaftaran",'', array('class' => 'control-label')) ?>
								<div class="controls">
										<div class="daterange daterange-inline input-inline" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
												<i class="entypo-calendar"></i>
												<span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
												<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
												<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
										</div>
								</div>
						</div>
						<?php echo $form->dropDownListRow($model,'statusperiksa', Params::statusPeriksa(), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
						<div class="control-group">
								<?php echo CHtml::label("No Pendaftaran",'', array('class' => 'control-label')) ?>
								<div class="controls">
									<?php
											$prefix = array(
													0 => Params::PREFIX_RAWAT_DARURAT,
													1 => Params::PREFIX_RAWAT_JALAN,
													2 => Params::PREFIX_RAWAT_INAP,
											);
											echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;'));
									?>
										<?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>
								</div>
						</div>

					</div>
					<div class="col-sm-6">
						<?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik No. Rekam Medik')); ?>
						<?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Nama Pasien')); ?>
					</div>
				</div>

				<div class="form-actions">
		        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
		        <?php
		             if(!isset($_GET['frame'])){
		                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
		                    $this->createUrl($this->id.'/index'),
		                    array('class'=>'btn btn-danger',
		                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
		            }
		        ?>
		        <?php
		            $content = $this->renderPartial('../tips/informasi_pencarian',array(),true);
		           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		        ?>
		    </div>
			<?php $this->endWidget(); ?>
		</div>
</div>
