<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gradingrisiko-m-form',
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
                       <?php echo Chtml::label('Peluang', 'nama', array('class' => 'control-label')); ?>
                       <div class="controls">
                           <?php echo Chtml::dropDownList('peluang_id','', Chtml::listData(PeluangM::model()->findAllByAttributes(array('peluang_aktif'=>true)),'peluang_id','peluang_descriptor'),array('class' => 'span3', 'empty'=>'-- Pilih --')); ?>		
                       </div>
                    </div> 
                    <div class="control-group">
                       <?php echo Chtml::label('Konsekuensi', 'nama', array('class' => 'control-label')); ?>
                       <div class="controls">
                           <?php echo Chtml::dropDownList('konsekuensi_id','', Chtml::listData(KonsekuensiM::model()->findAllByAttributes(array('konsekuensi_aktif'=>true)),'konsekuensi_id','konsekuensi_namabobot'),array('class' => 'span3', 'empty'=>'-- Pilih --')); ?>		
                       </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="control-group">
                       <?php echo Chtml::label('Tingkat Risiko', 'nama', array('class' => 'control-label')); ?>
                       <div class="controls">
                           <?php echo Chtml::dropDownList('tingkatrisiko_id','', Chtml::listData(TingkatrisikoM::model()->findAllByAttributes(array('tingkatrisiko_aktif'=>true)),'tingkatrisiko_id','tingkatrisiko_nama'),array('class' => 'span3', 'empty'=>'-- Pilih --','onchange'=>'setWarnaRisiko();')); ?>		
                       </div>
                    </div> 
                    <div class="control-group">
                        <?php echo Chtml::label('Warna Risiko', 'namalain', array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo Chtml::textField('warnarisiko','', array('class' => 'span3', 'placeholder' => 'Warna Risiko','readonly'=>true)); ?>		
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
                            <th style="text-align: center;">Peluang</th>
                            <th style="text-align: center;">Konsekuensi</th>
                            <th style="text-align: center;">Tingkat Risiko</th>
                            <th style="text-align: center;">Warna Risiko</th>
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Grading Risiko',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->endWidget(); ?>