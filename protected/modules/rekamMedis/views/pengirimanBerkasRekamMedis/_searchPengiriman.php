<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modPengiriman, 'tgl pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPengiriman->tgl_rekam_medik = MyFormatter::formatDateTimeForUser($modPengiriman->tgl_rekam_medik);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPengiriman,
                    'attribute' => 'tgl_rekam_medik',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                ));
                $modPengiriman->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($modPengiriman->tgl_rekam_medik);

                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Sampai dengan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPengiriman->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForUser($modPengiriman->tgl_rekam_medik_akhir);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPengiriman,
                    'attribute' => 'tgl_rekam_medik_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                ));
                $modPengiriman->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForDb($modPengiriman->tgl_rekam_medik_akhir);
                ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($modPengiriman, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span3', 'maxlength' => 10)); ?>
        <div class="control-group">
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPengiriman, 'no_rekam_medik_akhir', array('placeholder' => 'Sampai Dengan', 'class' => 'span3', 'maxlength' => 10)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($modPengiriman, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php //echo $form->dropDownListRow($modPengiriman, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true), array('order'=>'instalasi_nama ASC')), 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onchange'=>'getRuangan();')); 
        ?>
        <?php //echo $form->dropDownListRow($modPengiriman, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true), array('order'=>'ruangan_nama ASC')), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $criIns = new CDbCriteria();
                $criIns->addCondition(" instalasi_aktif = TRUE ");
                $criIns->order = " instalasi_nama ASC ";
                echo $form->dropDownList($modPengiriman, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($criIns), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $modPengiriman,
                    'ruangan_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPengiriman, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span3', 'maxlength' => 20)); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function() {
        var ins = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'instalasi_id') ?>');
        var ru = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'ruangan_id') ?>');

        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'ruangan_id') ?>');

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
                var ins = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'ruangan_id') ?>');

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
                var ins = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($modPengiriman, 'ruangan_id') ?>');

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