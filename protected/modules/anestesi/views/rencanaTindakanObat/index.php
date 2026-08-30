<div class="panel panel-gradient">
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI ?>
	<?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash('success',"Data Rencana Tindakan dan Obat Alkes Anastesis berhasil disimpan");
		}
		$this->widget('bootstrap.widgets.BootAlert');
	?> 
    <div class="panel-heading">    
        <div class="panel-title">Rencana Tindakan Obat Dan Alkes</div>
    </div> 
     <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pasienanestesi-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),
    )); ?>
	<div class="row-fluid">
        <div class="span4">
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                'id'=>'riwayat-anamnesa',
                'content'=>array(
                    'content-riwayat-anamnesa'=>array(
                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat anamnesa')).'<b> Riwayat Anamnesis</b>',
                        'isi'=>'<div class="content"></div>',
                        'active'=>false,
                        ),   
                    ),
				)); 
			?>  
        </div>
        <div class="span4">
            <?php 
                $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                'id'=>'riwayat-pemeriksaan-fisik',
                'content'=>array(
                    'content-riwayat-pemeriksaan-fisik'=>array(
                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pemeriksaan fisik')).'<b> Riwayat Pemeriksaan Fisik</b>',
                        'isi'=>'<div class="content"></div>',
                        'active'=>false,
                        ),   
                    ),
				)); 
            ?>  
        </div>
        <div class="span4">
            <?php 
                $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                'id'=>'riwayat-pemeriksaan-penunjang',
                'content'=>array(
                    'content-riwayat-pemeriksaan-penunjang'=>array(
                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat diagnosa')).'<b> Riwayat Pemeriksaan Penunjang</b>',
                        'isi'=>'<div class="content"></div>',
                        'active'=>false,
                        ),   
                    ),
				)); 
            ?>  
        </div>
		
		<fieldset class="box" id="form-datarencana">
			<legend class="rim">Data Rencana</legend>
			<div class="row-fluid">
				<?php $this->renderPartial($this->path_view.'_formDataRencana',array('model'=>$model,'modPraAnestesi'=>$modPraAnestesi,'format'=>$format,'form'=>$form)); ?>	
			</div>
		</fieldset>

		<fieldset class="box" id="form-tindakan">
			<legend class="rim">Tabel Tindakan</legend>
			<?php $this->renderPartial($this->path_view.'_formTindakan',array('model'=>$model)); ?>
		</fieldset>
		
		<div class="span12">
			<div class="control-group">
				<?php echo CHtml::label('Pilih Uraian Tindakan','',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('daftartindakanPemakaianBahan', '',array(),array('empty'=>'Uraian Tindakan')) ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<fieldset class="box" id="form-bahan">
				<legend class="rim">Pemakaian Bahan</legend>
				<?php $this->renderPartial($this->path_view.'_formPemakaianBahan',array('model'=>$model)); ?>
			</fieldset>
			
			<fieldset class="box" id="form-alatmedis">
				<legend class="rim">Pemakaian Alat Medis</legend>
				<?php $this->renderPartial($this->path_view.'_formPemakaianAlatMedis',array('model'=>$model)); ?>
			</fieldset>
		</div>
		<div class="span6">
			<fieldset class="box" id="form-bmhp">
				<legend class="rim">Pemakaian BMHP</legend>
				<?php $this->renderPartial($this->path_view.'_formPemakaianBmhp',array('model'=>$model)); ?>
			</fieldset>
		</div>
    </div>
	
	<div class="form-actions">
		<?php 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit','disabled'=>(isset($_GET['sukses']))? true : false, 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);'));
			echo "&nbsp;";
			
			if(!isset($_GET['frame'])){
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
            }
			echo "&nbsp;";
			
			echo CHtml::link(Yii::t('mds', '{icon} Print Hasil', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printHasil();return false"));
			echo "&nbsp;";

			$content = $this->renderPartial($this->path_view.'tips/tipsRencanaTindakanObat',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
		?> 
	</div>	
     </div></div>
<?php $this->endWidget(); ?>
<?php
	$this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,
			'modPraAnestesi'=>$modPraAnestesi,
			'modTindakanAnestesi'=>$modTindakanAnestesi,
			'modTindakanPelayanan'=>$modTindakanPelayanan,
			'modObatAnestesi'=>$modObatAnestesi,
			'modObatAlkes'=>$modObatAlkes,
			'modPemeriksaanAnestesi'=>$modPemeriksaanAnestesi)); 
?>
<?php  
//====== dialog box pilih pemeriksaan ====
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialog-pilihpemeriksaan',
	'options'=>array(
		'title'=>'Pilih Tindakan Anestesi',
		'autoOpen'=>false,
		'width'=>840,
		'height'=>450,
		'modal'=>true,
		'resizable'=>false,
	),
));?>
<?php echo $this->renderPartial($this->path_view.'_formCariPemeriksaan', array('modPemeriksaanAnestesi'=>$modPemeriksaanAnestesi));?>
<div class="dialog-content"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>