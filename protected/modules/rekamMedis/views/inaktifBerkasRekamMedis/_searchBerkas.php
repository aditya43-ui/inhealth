<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label("Tgl. Kunjungan Terakhir", 'tgl pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group ">
                    <?php echo CHtml::label('Sampai dengan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2'),
                        ));
                        ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Rekam Medik')); ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Sampai dengan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_rekam_medik_akhir', array('class' => 'span3 numbers-only', 'maxlength' => 10, 'placeholder' => 'Contoh: 00000001')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>

                <div class="control-group">
                    <?php echo CHtml::label('Instalasi', 'daftarinstalasiakhir_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $criIns = new CDbCriteria();
                        $criIns->addCondition(" instalasi_aktif = TRUE ");
                        $criIns->order = " instalasi_nama ASC ";
                        echo $form->dropDownList($model, 'daftarinstalasiakhir_id', CHtml::listData(InstalasiM::model()->findAll($criIns), 'instalasi_id', 'instalasi_nama'), array(
                            'class' => 'span3', 'multiple' => 'multiple'
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan', 'daftarruanganakhir_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'daftarruanganakhir_id',
                            array(),
                            array('class' => 'span3', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Status', 'daftarruanganakhir_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'statusrekammedis',
                            LookupM::getItemsUrutan('statusrekammedis'),
                            array('class' => 'span3', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
            ); ?>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        var ins = jQuery('#<?php echo CHtml::activeId($model, 'daftarinstalasiakhir_id') ?>');
        var ru = jQuery('#<?php echo CHtml::activeId($model, 'daftarruanganakhir_id') ?>');
        var status = jQuery('#<?php echo CHtml::activeId($model, 'statusrekammedis') ?>');

        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'daftarinstalasiakhir_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'daftarinstalasiakhir_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'daftarruanganakhir_id') ?>');

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
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'daftarinstalasiakhir_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'daftarinstalasiakhir_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'daftarruanganakhir_id') ?>');

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
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'daftarinstalasiakhir_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'daftarinstalasiakhir_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'daftarruanganakhir_id') ?>');

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
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(status).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>