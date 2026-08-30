<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'laporan-lembur-search',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Realisasi", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("&nbsp;", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->checkBox($model, 'is_tertinggi') . " <label for='LaporanrealisasilemburV_is_tertinggi'>Jam Tertinggi</label>";
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Instalasi", 'instalasi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList(
                    $model,
                    'instalasi_id',
                    CHtml::listData(InstalasiM::model()->findAll(" instalasi_aktif = TRUE ORDER BY instalasi_nama ASC "), 'instalasi_id', 'instalasi_nama'),
                    array(
                        'onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple',
                    )
                );
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Ruangan", 'ruangan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList(
                    $model,
                    'create_ruangan',
                    array(),
                    array(
                        'onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple',
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>
<?php /*
	<?php echo $form->textFieldRow($model,'realisasilembur_id',array('class'=>'span3 numbers-only')); ?>
	<?php echo $form->textFieldRow($model,'tglrealisasi',array('class'=>'span3')); ?>
	<?php echo $form->textFieldRow($model,'norealisasi',array('class'=>'span3','maxlength'=>20)); ?>
	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 numbers-only')); ?>
	<?php echo $form->textFieldRow($model,'create_ruangan_nama',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'realisasilemburdet_id',array('class'=>'span3 numbers-only')); ?>
	<?php echo $form->textFieldRow($model,'nourut',array('class'=>'span3','maxlength'=>3)); ?>
	<?php echo $form->textFieldRow($model,'alasanlembur',array('class'=>'span3','maxlength'=>500)); ?>
	<?php echo $form->textFieldRow($model,'tglmulai',array('class'=>'span3')); ?>
	<?php echo $form->textFieldRow($model,'tglselesai',array('class'=>'span3')); ?>
	<?php echo $form->textFieldRow($model,'total_jam',array('class'=>'span3 numbers-only')); ?>
	<?php echo $form->textFieldRow($model,'nilai_lembur',array('class'=>'span3')); ?>
	<?php echo $form->textFieldRow($model,'total_nilai_lembur',array('class'=>'span3')); ?>
	<?php echo $form->textFieldRow($model,'pemberitugas_id',array('class'=>'span3 numbers-only')); ?>
	<?php echo $form->textFieldRow($model,'gelardepan_pegawaitugas',array('class'=>'span3','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'nama_pegawaitugas',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'gelarbelakang_pegawaitugas',array('class'=>'span3','maxlength'=>15)); ?>
	<?php echo $form->textFieldRow($model,'mengetahui_id',array('class'=>'span3 numbers-only')); ?>
	<?php echo $form->textFieldRow($model,'gelardepan_mengetahui',array('class'=>'span3','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'nama_mengetahui',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'gelarbelakang_mengetahui',array('class'=>'span3','maxlength'=>15)); ?>
	<?php echo $form->textFieldRow($model,'menyetujui_id',array('class'=>'span3 numbers-only')); ?>
	<?php echo $form->textFieldRow($model,'gelardepan_menyetujui',array('class'=>'span3','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'nama_menyetujui',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'gelarbelakang_menyetujui',array('class'=>'span3','maxlength'=>15)); ?>
*/ ?>
<div class="actions clear">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
</div>
<?php $this->endWidget(); ?>
<script>
    $(document).ready(function() {
        var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
        var ru = jQuery('#<?php echo CHtml::activeId($model, 'create_ruangan') ?>');
        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'create_ruangan') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                //alert(selected);
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onSelectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'create_ruangan') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onDeselectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'create_ruangan') ?>');
                var brands = ins_all;
                var selected = '';
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
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
    });
</script>