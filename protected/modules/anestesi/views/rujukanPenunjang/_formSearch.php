
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'search-penunjangrujukan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); 

Yii::app()->clientScript->registerScript('search', "
$('#search-penunjangrujukan-form').submit(function(){
	$.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$myicon = new MyIcon();
$this->widget('bootstrap.widgets.BootAlert');
?>
<table width="100%">
    <tr>
        <td>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label("Tanggal Rujukan",'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>	

                <div class="control-group ">
                    <label for="noPendaftaran" class="control-label">No. Pendaftaran </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran')); ?>
                    </div>
                </div> 
                <div class="control-group ">
                    <label for="noRekamMedik" class="control-label">No. Rekam Medik </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'numbers-only','maxlength'=>8)); ?>
                    </div>
                </div>    
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">Nama Pasien </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien')); ?>
                    </div>
                </div> 
            </div>
            <div class="col-sm-6">
                <?php
                    $instalasi = InstalasiM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2,3,4),
                    ));
                    $ruangan = RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2,3,4),
                            'ruangan_aktif' => true,
                    ), array(
                            'order'=>'instalasi_id, ruangan_nama',
                    ));
                    echo $form->dropDownListRow($model,'instalasiasal_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3', 
                            'ajax' => array('type'=>'POST',
                                    'url'=> $this->createUrl('/actionDynamic/getRuanganAsalDariInstalasiAsal',array('encode'=>false,'namaModel'=>get_class($model))), 
                                    'success'=>'function(data){$("#'.CHtml::activeId($model, "ruanganasal_id").'").html(data); }',
                            ),
                     ));
                    echo $form->dropDownListRow($model,'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));
                ?>
            </div>
            <div class="col-sm-6">
            <?php 
                $carabayar = CarabayarM::model()->findAll(array(
                        'condition'=>'carabayar_aktif = true',
                        'order'=>'carabayar_nourut',
                ));
                foreach ($carabayar as $idx=>$item) {
                        $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                'carabayar_id'=>$item->carabayar_id,
                                'penjamin_aktif'=>true,
                   ));
                   if (empty($penjamins)) unset($carabayar[$idx]);
                }
                $penjamin = PenjaminpasienM::model()->findAll(array(
                        'condition'=>'penjamin_aktif = true',
                        'order'=>'penjamin_nama',
                ));
                echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                        'empty'=>'-- Pilih --',
                        'class'=>'span3', 
                        'ajax' => array('type'=>'POST',
                                'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                                'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                        ),
                 ));
                echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));
            ?>
            </div>
        </td>             
    </tr>
</table>
<div class="form-actions">
    <?php echo  CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="'.$myicon::getIcons('cari').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','name'=>'submitSearch')); ?>
    <?php echo  CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.$myicon::getIcons('ulang').'"></i>')), 
                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php   $content = $this->renderPartial($this->path_view_rujuk.'tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>

</div>

<?php $this->endWidget(); ?>
