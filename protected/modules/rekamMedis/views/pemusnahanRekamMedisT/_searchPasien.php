<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'searchCari',
    'type'=>'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($modPasien, 'tglkunjunganterakhir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPasien->tglkunjunganterakhir = MyFormatter::formatDateTimeForUser($modPasien->tglkunjunganterakhir);					
                $this->widget('MyDateTimePicker', array(
                        'model' => $modPasien,
                        'attribute' => 'tglkunjunganterakhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                ));
                $modPasien->tglkunjunganterakhir = MyFormatter::formatDateTimeForDb($modPasien->tglkunjunganterakhir);	
                
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPasien->tglkunjungan_akhir = MyFormatter::formatDateTimeForUser($modPasien->tglkunjungan_akhir);
                $this->widget('MyDateTimePicker', array(
                        'model' => $modPasien,
                        'attribute' => 'tglkunjungan_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                ));
                $modPasien->tglkunjungan_akhir = MyFormatter::formatDateTimeForDb($modPasien->tglkunjungan_akhir);
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->label($modPasien, 'no_rekam_medik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPasien, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 10, 'placeholder'=>'Nomor Rekam Medik')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPasien, 'no_rekam_medik_akhir', array('class' => 'span3', 'maxlength' => 10, 'placeholder'=>'Contoh: 00000001')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->label($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPasien, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50, 'placeholder'=>'Nama Pasien')); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('Instalasi','instalasiterakhir_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                    $criIns = new CDbCriteria();						
                    $criIns->addCondition(" instalasi_aktif = TRUE and revenuecenter = true");
                    $criIns->order = " instalasi_nama ASC ";
                    echo $form->dropDownList($modPasien,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($criIns), 'instalasi_id', 'instalasi_nama'),array('class'=>'form-control', 'multiple'=>'multiple')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php  echo CHtml::label('Ruangan','ruanganakhir_id', array('class' => 'control-label')) ?>
            <div class="controls">												 
                <?php echo $form->dropDownList($modPasien,'ruangan_id',
                        array(),
                        array('class'=>'form-control', 'multiple'=>'multiple')); ?>
            </div>
        </div>
        <?php /*
        <div class="control-group">
            <?php echo CHtml::label("",'is_dimusnahkan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($modPasien,'is_dimusnahkan',array('checked'=>'is_dimusnahkan')); ?> <label>Aktif</label>
            </div>				
        </div>
         * 
         */ ?>
    
        <?php // echo $form->textFieldRow($modPasien, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 20, 'placeholder'=>'Nomor Pendaftaran')); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>
<?php $this->endWidget(); ?>

<script>
$(document).ready(function() {
    var ins  = jQuery('#<?php echo CHtml::activeId($modPasien, 'instalasi_id') ?>');		
    var ru  = jQuery('#<?php echo CHtml::activeId($modPasien, 'ruangan_id') ?>');		


    jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {				
                            var ins  = jQuery('#<?php echo CHtml::activeId($modPasien, 'instalasi_id') ?>');
                            var ins_all = jQuery('#<?php echo CHtml::activeId($modPasien, 'instalasi_id') ?>   option:selected');
                            var ru  = jQuery('#<?php echo CHtml::activeId($modPasien, 'ruangan_id') ?>');

                            var brands = ins_all;
                            var selected = [];


                            $(brands).each(function(index, brand){
                                    selected.push($(this).val());
                            });

                            ru.addClass('animation-loading');
                            //alert(selected);

                            jQuery.ajax({
                                    type:'POST',
                                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                                    dataType: "json",
                                    data: {instalasi_id:selected},
                                    success: function(data){	

                                            if (data.sukses != '1'){

                                                    //toastr.error(data.pesan);
                                                    ru.addClass('animation-loading');
                                            }else{							
                                                    //alert(data.ruangan);
                                                    ru.html(data.ruangan);								
                                                    ru.multiselect('rebuild');																
                                                    ru.removeClass('animation-loading');
                                            }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) { 					
                                            console.log(errorThrown);

                                    }
                            });

            },
            onSelectAll: function() {
                            var ins  = jQuery('#<?php echo CHtml::activeId($modPasien, 'instalasi_id') ?>');
                            var ins_all = jQuery('#<?php echo CHtml::activeId($modPasien, 'instalasi_id') ?>   option:selected');
                            var ru  = jQuery('#<?php echo CHtml::activeId($modPasien, 'ruangan_id') ?>');

                            var brands = ins_all;
                            var selected = [];

                            $(brands).each(function(index, brand){
                                    selected.push($(this).val());
                            });

                            ru.addClass('animation-loading');


                            jQuery.ajax({
                                    type:'POST',
                                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                                    dataType: "json",
                                    data: {instalasi_id:selected},
                                    success: function(data){	

                                            if (data.sukses != '1'){

                                                    //toastr.error(data.pesan);
                                                    ru.addClass('animation-loading');
                                            }else{							
                                                    //alert(data.ruangan);
                                                    ru.html(data.ruangan);								
                                                    ru.multiselect('rebuild');																
                                                    ru.removeClass('animation-loading');
                                            }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) { 					
                                            console.log(errorThrown);

                                    }
                            });

            },
            onDeselectAll: function() {		
                    var ins  = jQuery('#<?php echo CHtml::activeId($modPasien, 'instalasi_id') ?>');
                    var ins_all = jQuery('#<?php echo CHtml::activeId($modPasien, 'instalasi_id') ?>   option:selected');
                    var ru  = jQuery('#<?php echo CHtml::activeId($modPasien, 'ruangan_id') ?>');

                    var brands = ins_all;
                    var selected = '';



                    ru.addClass('animation-loading');


                    jQuery.ajax({
                            type:'POST',
                            url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                            dataType: "json",
                            data: {instalasi_id:selected},
                            success: function(data){	

                                    if (data.sukses != '1'){

                                            //toastr.error(data.pesan);
                                            ru.addClass('animation-loading');
                                    }else{							
                                            //alert(data.ruangan);
                                            ru.html(data.ruangan);								
                                            ru.multiselect('rebuild');															
                                            ru.removeClass('animation-loading');
                                    }
                            },
                            error: function (jqXHR, textStatus, errorThrown) { 					
                                    console.log(errorThrown);

                            }
                    });

            }
    }).hide();

    jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
    }).hide();				
});
</script>
