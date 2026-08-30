<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">Intra Anestesia</div>
    </div>
    <div class="panel-body">
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI ?>
	<?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash('success',"Data Intra Anestesia berhasil disimpan");
		}
		$this->widget('bootstrap.widgets.BootAlert');
	?>
	
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'intraanestesi-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#'.CHtml::activeId($modPraAnestesi,'nopraanestesi'),
			)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'_dataPasien',array('modKunjungan'=>$modKunjungan)); ?>
            </div>
        </div>
	
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Data Pra Anestesia</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'_formPraAnestesia',array('model'=>$model,'modPraAnestesi'=>$modPraAnestesi,'modIntraAnestesi'=>$modIntraAnestesi, 'format'=>$format,'form'=>$form)); ?>	
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Data Intra Anestesia</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'_formIntraAnestesia',array('model'=>$model,'modIntraAnestesi'=>$modIntraAnestesi,'format'=>$format,'form'=>$form)); ?>	
            </div>
        </div>
	
	<div class="row-fluid">
		<div class="span12">
			<?php 
//				$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
//					'id'=>'tindakan-anestesi',
//					'content'=>array(
//                    'content-tindakan-anestesi'=>array(
//							'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat anamnesa')).'<b> Rencana Tindakan Anestesi</b>',
//							'isi'=>$this->renderPartial($this->path_view.'_formTindakan',array('modKondisiPasienAnestesi'=>$modKondisiPasienAnestesi),true),
//							'active'=>false,
//                        ),   
//                    ),
//				)); 
			?>  
		</div>
		
		<div class="span6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title judul">Pemakaian Bahan</div>
                        </div>
                        <div class="panel-body">
                            <?php $this->renderPartial($this->path_view.'_formPemakaianBahan',array('model'=>$model)); ?>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title judul">Pemakaian Alat Medis</div>
                        </div>
                        <div class="panel-body">
                            <?php $this->renderPartial($this->path_view.'_formPemakaianAlatMedis',array('model'=>$model)); ?>
                        </div>
                    </div>
		</div>
		<div class="span6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title judul">Pemakaian BMHP</div>
                        </div>
                        <div class="panel-body">
                            <?php $this->renderPartial($this->path_view.'_formPemakaianBmhp',array('model'=>$model)); ?>
                        </div>
                    </div>
		</div>
		<div class="span12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title judul">Pemantauan Kondisi Pasien</div>
                        </div>
                        <div class="panel-body" style="overflow-y: auto;">
                            <?php $this->renderPartial($this->path_view.'_formPemantauanKondisi',array('modKondisiPasienAnestesi'=>$modKondisiPasienAnestesi,'modDetails'=>$modDetails)); ?>
                        </div>
                    </div>
		</div>
    </div>
	
	<div class="form-actions">
		<?php 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>(isset($_GET['sukses']))? true : false));
			echo "&nbsp;";
			
			if(!isset($_GET['frame'])){
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
            }
			echo "&nbsp;";
			
			if(isset($_GET['id'])){
				echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printHasil();return false"));
				echo "&nbsp;";
			}else{
				echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printHasil();return false", 'disabled'=>true));
				echo "&nbsp;";
			}

			$content = $this->renderPartial($this->path_view.'tips/tipsIntraAnestesi',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
		?> 
	</div>	
</div>
</div>
<?php $this->endWidget(); ?>
<?php
	$this->renderPartial($this->path_view.'_jsFunctions',array(
		'model'=>$model,
		'modKunjungan'=>$modKunjungan,
		'modIntraAnestesi'=>$modIntraAnestesi,
		'modKondisiPasienAnestesi'=>$modKondisiPasienAnestesi,
		'modPraAnestesi'=>$modPraAnestesi,
		'modTindakanAnestesi'=>$modTindakanAnestesi,
		'modTindakanPelayanan'=>$modTindakanPelayanan,
		'modObatAnestesi'=>$modObatAnestesi,
		'modObatAlkes'=>$modObatAlkes,
		'modPemeriksaanAnestesi'=>$modPemeriksaanAnestesi
	)); 
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
	));
?>
<?php echo $this->renderPartial($this->path_view.'_formCariPemeriksaan', array('modPemeriksaanAnestesi'=>$modPemeriksaanAnestesi));?>
<div class="dialog-content"></div>
	<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
<div style='display:none;'>
	<?php
		$this->widget('MyDateTimePicker', array(
			'name'=>'tgl',
			'mode' => 'datetime',
			'options' => array(
				'dateFormat' => Params::DATE_FORMAT,
				'maxDate' => 'd',
			),
			'htmlOptions' => array('readonly' => true,
				'onkeypress' => "return $(this).focusNextInputField(event)"),
		));
	?>
</div>