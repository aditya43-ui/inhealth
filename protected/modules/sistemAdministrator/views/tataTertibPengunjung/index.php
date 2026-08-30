<?php
$this->breadcrumbs = array(
	'Master Tata Tertib Pengunjung' => array('index')
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
            <strong>Master Tata Tertib Pengunjung/ Pendamping Pasien Rawat Inap</strong>
        </div>
    </div>
    <div class="panel-body">
				<p class="help-block">Isi form berikut sesuai dengan poin-poin yang ada pada Dokumen Rekam Medis Tata Tertib Pengunjung/ Pendamping Pasien Rawat Inap</p>
				<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
					'id'=>'tatatertibpengunjung-m-form',
					'enableAjaxValidation'=>false,
				        // 'type'=>'horizontal',
				        // 'focus'=>'#SAKelasPelayananM_jeniskelas_id',
				)); ?>
				<div class="row-fluid">
					<div class="col-sm-12">
						<div class="control-group ">
                <?php echo $form->labelEx($model,'tatatertibpengunjung_no_rm', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'tatatertibpengunjung_no_rm',array('class'=>'span3', 'placeholder'=>"Isi No. Dokumen RM", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </div>
            </div>
						<div class="control-group ">
                <?php echo $form->labelEx($model,'tatatertibpengunjung_judul', array('class'=>'control-label')) ?>
                <div class="controls">
									<div class="tatatertibpengunjung_judul">
											<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'tatatertibpengunjung_judul','height'=>'80px')) ?>
									</div>
                </div>
            </div>
						<div class="control-group ">
                <?php echo $form->labelEx($model,'tatatertibpengunjung_isi', array('class'=>'control-label')) ?>
                <div class="controls">
									<div class="tatatertibpengunjung_isi">
											<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'tatatertibpengunjung_isi','height'=>'500px')) ?>
									</div>
                </div>
            </div>
					</div>

				</div>
				<div class="form-actions">
					<?php
					$disabledSimpan = (!empty($model->tatatertibpengunjung_id)?true:false);
					$disabledUbah = (!empty($model->tatatertibpengunjung_id)?false:true);

					echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')), array('id'=>'btnsimpan','class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>$disabledSimpan));
					echo "&nbsp;";
					echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
										Yii::app()->createUrl($this->module->id.'/TataTerbitPengunjungM/index'),
										array('class'=>'btn btn-danger',
													'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
					echo "&nbsp;";
					echo CHtml::htmlButton(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="'.MyIcon::getIcons('ubah').'"></i>')), array('id'=>'btnubah','class'=>'btn btn-info', 'type'=>'button', 'onKeypress'=>'return formSubmit(this,event)','onclick'=>'aktifInput()','disabled'=>$disabledUbah));

					?>

				</div>
				<?php $this->endWidget(); ?>
		</div>
	</div>


<script type="text/javascript">

function aktifInput(value){
	if(value == 'aktif'){
		$('#btnsimpan').attr('disabled',true);
		$('#btnubah').attr('disabled',false);
		$('#<?php CHtml::activeId($model,'tatatertibpengunjung_no_rm') ?>').attr('disabled',true);
		setTimeout(function(){
			$('.tatatertibpengunjung_judul > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
			$('.tatatertibpengunjung_isi > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
		}, 500);
	}else{
		$('#btnsimpan').attr('disabled',false);
		$('#btnubah').attr('disabled',true);
		$('#<?php CHtml::activeId($model,'tatatertibpengunjung_no_rm') ?>').attr('disabled',false);
		setTimeout(function(){
			$('.tatatertibpengunjung_judul > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
			$('.tatatertibpengunjung_isi > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
		}, 500);
	}
}

	$(document).ready(function () {

		<?php if(!empty($model->tatatertibpengunjung_id)){ ?>
			aktifInput('aktif');
		<?php } ?>
	});

</script>
