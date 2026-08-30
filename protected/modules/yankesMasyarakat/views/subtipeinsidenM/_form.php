<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'tiperesiko-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class="span12">
                <div class="span6">
                    <div class="control-group">
                       <?php echo Chtml::label('Tipe Insiden', 'nama', array('class' => 'control-label')); ?>
                       <div class="controls">
                           <?php echo Chtml::dropDownList('tipeinsiden_id','', Chtml::listData(TipeinsidenM::model()->findAllByAttributes(array('tipeinsiden_aktif'=>true)),'tipeinsiden_id','tipeinsiden_nama'),array('class' => 'span3', 'empty'=>'-- Pilih --','onchange'=>'setSubtipeInsiden();')); ?>		
                       </div>
                    </div> 
                    <div class="control-group">
                       <?php echo Chtml::label('Kelompok Subtipe Insiden', 'nama', array('class' => 'control-label')); ?>
                       <div class="controls">
                           <?php echo Chtml::dropDownList('kelompoksubtipeinsiden_id','', Chtml::listData(KelompoksubtipeinsidenM::model()->findAllByAttributes(array('kelompoksubtipeinsiden_aktif'=>true)),'kelompoksubtipeinsiden_id','kelompoksubtipeinsiden_nama'),array('class' => 'span3', 'empty'=>'-- Pilih --','onchange'=>'setSubtipeInsiden();')); ?>		
                       </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="control-group">
                       <?php echo Chtml::label('Subtipe Insiden', 'nama', array('class' => 'control-label')); ?>
                       <div class="controls">
                           <?php echo Chtml::textField('nama','',array('class' => 'span3', 'placeholder' => 'Ketik Nama ','onkeyup'=>'namaLain(this);')); ?>		
                       </div>
                    </div> 
                    <div class="control-group">
                           <?php echo Chtml::label('Nama Lain Sub Tipe Insiden', 'namalain', array('class' => 'control-label')); ?>
                       <div class="controls">
                           <?php echo Chtml::textField('namalain','', array('class' => 'span3', 'placeholder' => 'Ketik Nama Lain', 'maxlength' => 100)); ?>		

                       </div>
                    </div>
                    <div class="control-group">
                       <?php echo Chtml::label('', 'aktif', array('class' => 'control-label')); ?>
                       <div class="controls">
                           <?php  echo Chtml::checkBox('aktif',1,array('value'=>1,'uncheckValue'=>0)); ?> <label>Aktif</label>
                           <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i> Tambah', '#', array('class'=>'btn btn-primary','onclick'=>'tambah();')); ?>
                       </div>
                    </div> 
                </div> 
            </div>
            <div class="span12">
                <div class="row-fluid block-tabel overflow-x">
                    <table id="table-master" class="table table-striped table-bordered table-condensed">
                        <thead>
                            <th style="text-align: center;">No</th>
                            <th style="text-align: center;">Subtipe Insiden</th>
                            <th style="text-align: center;">Nama Lain Subtipe Insiden</th>
                            <th style="text-align: center;">Aktif</th>
                            <th style="text-align: center;">Hapus</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Subtipe Insiden',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->endWidget(); ?>