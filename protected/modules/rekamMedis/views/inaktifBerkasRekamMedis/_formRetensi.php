<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Retensi Dokumen Rekam Medis
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label("Tgl. Retensi <span class='required'>*</span>", 'tglinaktifrekammedis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglinaktifrekammedis',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">No. Retensi <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'noretensiinaktif', array('readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Petugas Retensi <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                        echo CHtml::activeHiddenField($model, 'pegawai_pelaksana_id', array('readonly' => true));
                        echo CHtml::activeTextField($model, 'pegawai_pelaksana_nama', array('readonly' => true));
                        //                        $this->widget('MyJuiAutoComplete', array(
                        //                            'model'=>$model,
                        //                            'attribute' => 'pegawai_pelaksana_nama',
                        //                            'source' => 'js: function(request, response) {
                        //                                $.ajax({
                        //                                        url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                        //                                        dataType: "json",
                        //                                        data: {
                        //                                                term: request.term,
                        //                                                ruangan_id: '.Yii::app()->user->getState('ruangan_id').',                                                   
                        //                                        },
                        //                                        success: function (data) {
                        //                                            response(data);
                        //                                        }
                        //                                })
                        //                             }',
                        //                            'options' => array(
                        //                                'showAnim' => 'fold',
                        //                                'minLength' => 3,
                        //                                'focus' => 'js:function( event, ui ) {
                        //                                        $(this).val(ui.item.label);
                        //                                        return false;
                        //                                }',
                        //                                'select' => 'js:function( event, ui ) {
                        //                                        setPetugas(ui.item,"pelaksana");
                        //                                        return false;
                        //                                }',
                        //                            ),
                        //                            'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialog('pelaksana');"),
                        //                            'htmlOptions'=>array(                    
                        //                                'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'pegawai_pelaksana_id').'").val("");}',
                        //                                'class'=>'required pegawai_pelaksana_id','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Petugas Retensi'),
                        //                        ));		
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Petugas Mengetahui <span class="required">*</span></label>
                    <?php
                    echo CHtml::activeHiddenField($model, 'pegawai_penanggungjawab_id', array('readonly' => true));
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'pegawai_penanggungjawab_nama',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                                        dataType: "json",
                                        data: {
                                                term: request.term,
                                                ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . ',                                                   
                                        },
                                        success: function (data) {
                                            response(data);
                                        }
                                })
                             }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.label);
                                        return false;
                                }',
                            'select' => 'js:function( event, ui ) {
                                        setPetugas(ui.item,"penanggungjawab");
                                        return false;
                                }',
                        ),
                        'tombolDialog' => array("idDialog" => 'dialogPegawai', 'jsFunction' => "setDialog('penanggungjawab');"),
                        'htmlOptions' => array(
                            'onblur' => 'if(this.value==""){$("#' . CHtml::activeId($model, 'pegawai_penanggungjawab_id') . '").val("");}',
                            'class' => 'required pegawai_penanggungjawab_id', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Petugas Penanggung Jawab'
                        ),
                    ));
                    ?>
                </div>

                <div class="control-group">
                    <label class="control-label">Keterangan</label>
                    <div class="control-group">
                        <?php echo CHtml::activeTextArea($model, 'keterangan', array('placeholder' => 'Keterangan',)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->renderPartial($this->path_view . '_button', array('model' => $model,), true); ?>
</div>

<script>
    $(document).ready(function() {
        var ins = jQuery('#<?php echo CHtml::activeId($model, 'daftarinstalasiakhir_id') ?>');
        var ru = jQuery('#<?php echo CHtml::activeId($model, 'daftarruanganakhir_id') ?>');


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
    });
</script>