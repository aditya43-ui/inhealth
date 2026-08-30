<?php

Yii::app()->clientScript->registerScript('cariPasien', "
    $('#searchLaporan').submit(function(){
            $.fn.yiiGridView.update('informasiorderbaralalokasi-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
");

$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'POST',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'
        ),
    )
);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-search"></i> Pencaran</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Order", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model, 'nama_petugas', array('placeholder' => 'Verifikator', 'class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            ?>
            <?php
            $content = $this->renderPartial('../tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>

<script>
    $(document).ready(function() {

        var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');		
        var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');		
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