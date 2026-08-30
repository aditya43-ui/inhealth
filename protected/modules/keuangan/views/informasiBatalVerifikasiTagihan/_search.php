
<?php
Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form').submit(function(){
        $.fn.yiiGridView.update('informasi_grid', {
            data: $(this).serialize()
        });
        return false;
});
");

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'penjamin_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ); ?>
            </div>
        </div>
        <?php /*
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array(
                    'instalasi_id'=>array(
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD, 
                        Params::INSTALASI_ID_RI, 
                        79, 38, 14
                    )
                ), array(
                    'order'=>'instalasi_id asc',
                )), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'ruangan_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ); ?>
            </div>
        </div>
        */ ?>
        <div class="control-group">
            <?php echo CHtml::label('Petugas Batal', 'petugasbatal_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField(
                    $model,
                    'petugasbatal_nama',
                    array('class' => 'form-control span3')
                ); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')
    ); ?>
</div>
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function() {
        var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');		
        var ru   = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');		
        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');		
        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
        
        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {				
                var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

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
                var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

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
                var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

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
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        /**
        * multi select cara bayar dan penjamin
         */

        jQuery(cara).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {				
                var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = cara_all;
                var selected = [];

                $(brands).each(function(index, brand){
                        selected.push($(this).val());
                });

                penj.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type:'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',					
                    dataType: "json",
                    data: {carabayar_id:selected},
                    success: function(data){	

                        if (data.sukses != '1'){

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        }else{							
                            //alert(data.ruangan);
                            penj.html(data.penjamin);								
                            penj.multiselect('rebuild');																
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 					
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = cara_all;
                var selected = [];

                $(brands).each(function(index, brand){
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');

                jQuery.ajax({
                    type:'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                    dataType: "json",
                    data: {carabayar_id:selected},
                    success: function(data){	

                        if (data.sukses != '1'){

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        }else{							
                            //alert(data.ruangan);
                            penj.html(data.penjaminan);								
                            penj.multiselect('rebuild');																
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 					
                            console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {		
                var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = cara_all;
                var selected = '';


                penj.addClass('animation-loading');

                jQuery.ajax({
                    type:'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                    dataType: "json",
                    data: {carabayar_id:selected},
                    success: function(data){	

                        if (data.sukses != '1'){

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        }else{							
                            //alert(data.ruangan);
                            penj.html(data.penjamin);								
                            penj.multiselect('rebuild');															
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 					
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(penj).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>