<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">
			Transaksi <b>Pertukaran Shift</b>
		</div>
	</div>
	<div class="panel-body">
	<?php
		$sukses = null;
		if(isset($_GET['sukses'])){
			$sukses = $_GET['sukses'];
		}
		//if($sukses > 0){ 
		//	Yii::app()->user->setFlash('success',"Data Permohonan Tukar Dinas berhasil disimpan!");
			$this->widget('bootstrap.widgets.BootAlert');
		//}
	?>
	
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'kppenjadwalan-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
		'focus'=>'#',
	)); ?>
	<?php echo $form->errorSummary($model); ?>
		
	
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">
                Tabel <b>Pertukaran Shift</b>
			</div>
		</div>
		<div class="panel-body">
			<?php $this->renderPartial('_detailPertukaran',array('form'=>$form,'model'=>$model,'modDetail'=>$modDetail)); ?>		                
		</div>
	</div>
		
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">
				Form <b>Pertukaran Shift</b>
			</div>
		</div>
		<div class="panel-body">
			<?php $this->renderPartial('_dataPertukaran',array('form'=>$form,'model'=>$model)); ?>
			
			<?php $this->renderPartial('_dataPengaju',array('form'=>$form,'model'=>$model,'modDetail'=>$modDetail)); ?>		
		</div>
	</div>
	<div class="form-actions">
        <div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['pertukaranjadwal_id'])) ? true : (($sukses > 0) ? true : false); 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'validasiCek();', 'onkeypress'=>'validasiCek();','disabled'=>$disableSave,)); ?>
		<?php 
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-default',
					  'onclick'=>'return refreshForm(this);'));
		?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')')); ?>
		<?php	$content = $this->renderPartial('tips/tipsTransaksi',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
    </div>	
</div>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modDetail'=>$modDetail)); ?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'dialog_pegawai',
        'options'=>array(
            'title'=>'Daftar Pegawai',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>860,
            'height'=>600,
            'resizable'=>false,
        ),
    )
);
echo CHtml::hiddenField('pegawai_untuk',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untukid',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untuknm',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untuktgl',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untukshift',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untukshifttukar',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untukjadwalid',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untukjadwaldetailid',"",array('readonly'=>true));
$modDokter = new KPPegawaiV('search');
$modDokter->unsetAttributes();
$modDokter->pegawai_aktif = true;
if (isset($_GET['KPPegawaiV'])){
    $modDokter->attributes = $_GET['KPPegawaiV'];
	$modDokter->pegawai_aktif = true;
}
$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'pegawai-grid',
        'dataProvider'=>$modDokter->search(),
        'filter'=>$modDokter,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                . '"onClick" => "pilihPegawai(\"$data->pegawai_id\",\"$data->NamaLengkap\",\"$data->nomorindukpegawai\");
                    $(\"#dialog_pegawai\").dialog(\"close\");
                    return false;"))',
            ),
            'nomorindukpegawai',
			array(
				'name' => 'nama_pegawai',
				'value' => '$data->namaLengkap'
			),                                    
            array(
				'header' => 'Jabatan',
				'name' => 'jabatan_id',
				'value' => function($data){
					$j = JabatanM::model()->findByPk($data->jabatan_id);
					
					if (!empty($j)){
						return $j->jabatan_nama;
					}
				},
				'filter' => CHtml::activeDropDownList($modDokter, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), "jabatan_id", "jabatan_nama"),array('empty' => '-- Pilih --'))
			),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>