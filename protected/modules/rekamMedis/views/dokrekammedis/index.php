<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('ppdokumenpasienrmbaru-v-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>
<legend class="rim2">Data Rekam Medis</legend>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>

<fieldset>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_searchPasienBaru',array(
    'model'=>$model,
)); ?>
</div><!--search-form-->
</fieldset>
<br>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppdokrekammedis-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'ppdokumenpasienrmbaru-v-grid',
    'dataProvider'=>$model->searchPengiriman(),
    //'filter'=>$model,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=> 'Pilih',
            'type'=>'raw',
            'value'=>'
                CHtml::hiddenField(\'Dokumen[pasien_id][]\', $data->pasien_id).
                CHtml::hiddenField(\'Dokumen[tgl_rekam_medik][]\', $data->tgl_rekam_medik).
                CHtml::hiddenField(\'Dokumen[pendaftaran_id][]\', $data->pendaftaran_id).
                CHtml::hiddenField(\'Dokumen[no_rekam_medik][]\', $data->no_rekam_medik).
                CHtml::hiddenField(\'Dokumen[ruangan_id][]\', $data->ruangan_id).
                CHtml::checkBox(\'cekList[]\', \'\', array(\'onclick\'=>\'setUrutan()\', \'class\'=>\'cekList\'));
                ',
        ),
//        array(
//            'header'=> 'Lokasi Rak',
//            'type'=>'raw',
//            'value'=>'
//                CHtml::dropDownList(\'Dokumen[lokasirak_id][]\',\'\',Chtml::listData(LokasirakM::model()->findAll(\'lokasirak_aktif=true\'), \'lokasirak_id\', \'lokasirak_nama\'), array(\'empty\'=>\'-- Pilih --\',\'class\'=>\'span2\'));'
//        ),
//        array(
//            'header'=> 'Sub Rak',
//            'type'=>'raw',
//            'value'=>'
//                CHtml::dropDownList(\'Dokumen[subrak_id][]\',\'\',Chtml::listData(SubrakM::model()->findAll(\'subrak_aktif=true\'), \'subrak_id\', \'subrak_nama\'), array(\'empty\'=>\'-- Pilih --\', \'class\'=>\'span2\'));'
//        ),
        //'lokasirak_id',
        //'subrak_id',
        //'warnadokrm_id',
//        array(
//            'header'=>'Warna Dokumen RK',
//            'type'=>'raw',
//            'value'=>"$ex",
//        ),
        array(
            'header'=>'Warna Dokumen RK',
            'type'=>'raw',
            'value'=>'$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(), true)',
        ),
        //'pasien_id',
        'no_rekam_medik',
        'tgl_pendaftaran',
        'no_pendaftaran',
        'nama_pasien',
        'tanggal_lahir',
        'jeniskelamin',
        //'alamat_pasien',
        array(
            'header'=>'Nama Instalasi',
            'value'=>'$data->instalasi_nama',
        ),
//        'instalasi_nama',
        array(
            'header'=>'Nama Ruangan',
            'value'=>'$data->ruangan_nama',
        ),
//        'ruangan_nama',
        array(
            'header'=> 'Kelengkapan Dokumen',
            'type'=>'raw',
            'value'=>'
                CHtml::checkBox(\'Dokumen[kelengkapandokumen][]\').
                ',
        ),
        //'tgl_rekam_medik',
        //'nama_pasien',
//        'nama_bin',
//        'jeniskelamin',
        /*
        
        'alamat_pasien',
        'tempat_lahir',
        'ruangan_id',
        'ruangan_nama',
        
        ////'pendaftaran_id',
        array(
                        'name'=>'pendaftaran_id',
                        'value'=>'$data->pendaftaran_id',
                        'filter'=>false,
                ),
        
        'no_urutantri',
        'instalasi_id',
        'instalasi_nama',
        'statuspasien',
        */
//        array(
//                        'header'=>Yii::t('zii','View'),
//            'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{view}',
//        ),
//        array(
//                        'header'=>Yii::t('zii','Update'),
//            'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{update}',
//                        'buttons'=>array(
//                            'update' => array (
//                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
//                                        ),
//                         ),
//        ),
//        array(
//                        'header'=>Yii::t('zii','Delete'),
//            'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{remove} {delete}',
//                        'buttons'=>array(
//                                        'remove' => array (
//                                                'label'=>"<i class='icon-form-silang'></i>",
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pendaftaran_id"))',
//                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                                        ),
//                                        'delete'=> array(
//                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
//                                        ),
//                        )
//        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
                        var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                        jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
                }',
)); ?> 

	
       
	<?php echo $form->errorSummary($modDokRekamMedis); ?>

            
            <?php //echo $form->textFieldRow($modDokRekamMedis,'nodokumenrm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php //echo $form->dropDownListRow($modDokRekamMedis,'statusrekammedis', LookupM::getItems('statusrekammedis') ,array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
            <div class="control-group">
                    <?php echo $form->labelEx($modPengiriman, 'tglpengirimanrm', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPengiriman,
                            'attribute' => 'tglpengirimanrm',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT_MEDIUM,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                        ));
                        ?>
                    </div>
                </div>
            <?php echo $form->textFieldRow($modPengiriman,'petugaspengirim',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php //echo $form->checkBoxRow($modPengiriman,'kelengkapandokumen', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

            <?php //echo $form->textFieldRow($model,'warnadokrm_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'subrak_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'lokasirak_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglrekammedis',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglmasukrak',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglkeluarakhir',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglmasukakhir',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'nomortertier',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2)); ?>
            <?php //echo $form->textFieldRow($model,'nomorsekunder',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2)); ?>
            <?php //echo $form->textFieldRow($model,'nomorprimer',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2)); ?>
            <?php //echo $form->textFieldRow($model,'warnanorm_i',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php //echo $form->textFieldRow($model,'warnanorm_ii',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php //echo $form->textFieldRow($model,'tgl_in_aktif',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglpemusnahan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($modDokRekamMedis->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
												
                <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('dokrekammedis/index'), array('class'=>'btn btn-danger')); ?>
				 <?php if((!$model->isNewRecord) AND ((Yii::app()->user->getState('printkartulsng')==TRUE) OR (Yii::app()->user->getState('printkartulsng')==TRUE))) 
                        {  
                ?>
                            <script>
                                print(<?php echo $model->pendaftaran_id ?>);
                            </script>
                 <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"print('$model->pendaftaran_id');return false",'disabled'=>FALSE  )); 
                       }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','disabled'=>TRUE  )); 
                       } 
                ?>

				<?php 
$content = $this->renderPartial('../tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>   
			
	</div>

<?php $this->endWidget(); ?>

<script>
    function setUrutan(){
        noUrut = 0;
        $('.cekList').each(function(){
           $(this).attr('name','cekList['+noUrut+']');
           noUrut++;
        });
    }
    
    $(document).ready(function(){
        $('form#ppdokrekammedis-m-form').submit(function(){
            var jumlah = 0;
            $('.cekList').each(function(){
                if ($(this).is(':checked')){
                    jumlah++;
                }
            });
            if (jumlah < 1){
                myAlert('Silakan pilih dokumen yang akan dikirim!');
                return false;
            }
            else if ($('#<?php echo CHtml::activeId($modDokRekamMedis, 'statusrekammedis'); ?>').val() == ''){
                myAlert('Isi Status Rekam Medis');
                return false;
            }
        });
    });
</script>