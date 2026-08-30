<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group hide">
            <?php echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'kelaspelayanan_id',CHtml::listData($model->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3','empty'=>'-- Pilih --', 'onchange'=>'setKelasKunjungan($(this).val())')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jenisdiet_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                
                // echo $form->dropDownList($model, 'jenisdiet_id', CHtml::listData(
                    // JenisdietM::model()->findAllByAttributes(array(
                        // 'jenisdiet_aktif'=>true
                    // ), array(
                        // 'order' => 'jenisdiet_nama ASC',
                    // )), 'jenisdiet_id', 'jenisdiet_nama'), array(
                        // 'class' => 'span3',
                        // 'empty' => '-- Pilih --',
                        // 'onchange'=> "$('#".Chtml::activeId($model,'jenisdiet_id')."').val($(this).val());
                            // $('#jenisdiet').val($(this).val());
                            // $('#GZMenuDietM_jenisdiet_id').val($(this).val());
                            // refreshDialogMenuDiet();
                            // $('#dialogJenisDiet').dialog('close'); return false;",
                    // )); ?>
                <?php echo $form->hiddenField($model, 'jenisdiet_id'); ?>
                <!--<div class="input-append" style='display:inline'>-->
                <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'jenisdiet',
                    'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('JenisDiet') . '",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                        'select' => 'js:function( event, ui ) {
                                                        $("#' . Chtml::activeId($model, 'jenisdiet_id') . '").val(ui.item.jenisdiet_id);
                                                        $(\'#GZMenuDietM_jenisdiet_id\').val(ui.item.jenisdiet_id);
                                                        refreshDialogMenuDiet();
                                                        return false;
                                                    }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogJenisDiet'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Tipe Diet",'tipediet',array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'tipediet', ['CAIR' => 'CAIR', 'PADAT' => 'PADAT', 'TIPE DIET' => 'TIPE DIET'], array('class'=>'span3','empty'=>'-- Pilih --', 'onchange'=>'setKelasKunjungan($(this).val())')); ?>
            </div>
        </div>
        <div class="control-group hide">
            <?php echo Chtml::label("No Pesan Menu <span style = 'color:red;'>*</span>",'nopesanmenu',array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'temp_no', array('readonly'=>TRUE,'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglpesanmenu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpesanmenu',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'tglpesanmenu'); ?>
            </div>
        </div>       
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("Pegawai Pemesan <span style='color:red'>*</span>", 'nama_pemesan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pemesan', array('readonly'=>TRUE,'placeholder'=>'Nama Pemesan','class' => 'span3 hurufs-only required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->hiddenField($model, 'totalpesan_org'); ?>
            <?php echo $form->textFieldRow($model, 'adaalergimakanan', array('placeholder'=>'Ket. Alergi Makanan','class' => 'span3 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        </div>
        <div class="control-group hide">
            <?php echo $form->textAreaRow($model, 'keterangan_pesan', array('placeholder'=>'Ket. Pemesanan Menu Diet','rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>        
    </div>
</div>
<!--<div class="control-group">
                <?php //echo $form->labelEx($model, 'bahandiet_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php //echo $form->hiddenField($model, 'bahandiet_id'); ?>
                                    <div class="input-append" style='display:inline'>
                    <?php
//                    $this->widget('MyJuiAutoComplete', array(
//                        'name' => 'bahandiet',
//                        'source' => 'js: function(request, response) {
//                                                               $.ajax({
//                                                                   url: "' .$this->createUrl('BahanDiet') . '",
//                                                                   dataType: "json",
//                                                                   data: {
//                                                                       term: request.term,
//                                                                   },
//                                                                   success: function (data) {
//                                                                           response(data);
//                                                                   }
//                                                               })
//                                                            }',
//                        'options' => array(
//                            'showAnim' => 'fold',
//                            'minLength' => 2,
//                            'focus' => 'js:function( event, ui ) {
//                                                            $(this).val( ui.item.label);
//                                                            return false;
//                                                        }',
//                            'select' => 'js:function( event, ui ) {
//                                                            $("#' . CHtml::activeId($model, 'bahandiet_id') . '").val(ui.item.bahandiet_id); 
//                                                            return false;
//                                                        }',
//                        ),
//                        'htmlOptions' => array(
//                            'onkeypress' => "return $(this).focusNextInputField(event)",
//                        ),
//                        'tombolDialog' => array('idDialog' => 'dialogBahanDiet'),
//                    ));
                    ?>
                </div>
            </div>-->
            
            <?php //echo $form->textFieldRow($model,'bahandiet_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->dropDownListRow($model, 'jenispesanmenu', LookupM::getItems('jenispesanmenu'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>                   
            <?php //echo $form->textFieldRow($model,'tglpesanmenu',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>       
            <?php echo CHtml::css('input[type="checkbox"].span2{width:13px;}'); ?>

<script type="text/javascript">
    $(document).ready(function(){

    // Notifikasi Pasien
        <?php 
            if(isset($model->pesanmenudiet_id)){
        ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GIZI ?>, judulnotifikasi:'Pesan Menu Diet Pasien', isinotifikasi:'Telah dilakukan pemesanan menu diet pada <?php echo $model->tglpesanmenu ?> di <?php echo $model->ruangan->ruangan_nama ?>'}; // 16 
            insert_notifikasi(params);
        <?php
            }
        ?>

    });

    function setKelasKunjungan(id) {
        $("#GZInfokunjunganriV_kelaspelayanan_id").val(id);
        $.fn.yiiGridView.update("gzinfokunjunganri-v-grid", {data: $("#dialogPasien :input").serialize()});
    }
</script>