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
                 <div class="control-group">
                    <?php echo Chtml::label('Nama', 'nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo Chtml::textField('nama','',array('class' => 'span3', 'placeholder' => 'Ketik Nama ')); ?>		
                    </div>
                </div> 
                <div class="control-group">
                        <?php echo Chtml::label('Nama Lain', 'namalain', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo Chtml::textField('namalain','', array('class' => 'span3', 'placeholder' => 'Ketik Nama Lain', 'maxlength' => 100)); ?>		
                        
                    </div>
                </div>
                <div class="control-group">
                        <?php echo Chtml::label('Kode', 'kode', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo Chtml::textField('kode','', array('class' => 'span3', 'placeholder' => 'Ketik Kode', 'maxlength' => 100)); ?>		
                        
                    </div>
                </div>
                <div class="control-group">
                        <?php echo Chtml::label('Keterangan', 'namalain', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo Chtml::textArea('keterangan','', array('class' => 'span3', 'placeholder' => 'Ketik Keterangan', 'maxlength' => 100)); ?>		
                        
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
            <div class="span12">
                <div class="row-fluid block-tabel overflow-x">
                    <table id="table-master" class="table table-striped table-bordered table-condensed">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nama Lain</th>
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Aktif</th>
                            <th>Hapus</th>
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tipe Risiko',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->endWidget(); ?>