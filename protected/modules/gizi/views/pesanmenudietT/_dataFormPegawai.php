<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownPenjamin', array('encode' => false, 'namaModel' => get_class($model))),
                    //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                    'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);}',
                ),
                'class' => 'span3',
            )); ?>
            <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jenisdiet_id', array('class' => 'control-label')); ?>
            <div class="controls">
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
                        'placeholder' => 'Jenis Diet',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogJenisDiet'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->hiddenField($model, 'nopesanmenu', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo Chtml::label("No Pesan Menu <span style = 'color:red;'>*</span>", 'nopesanmenu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'temp_no', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
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
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3 realtime', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'tglpesanmenu'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Pegawai Pemesan <span style='color:red'>*</span>", 'nama_pemesan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pemesan', array('readonly' => TRUE, 'placeholder' => 'Nama Pemesan', 'class' => 'span3 hurufs-only required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
        <?php echo $form->hiddenField($model, 'totalpesan_org'); ?>
        <?php echo $form->textFieldRow($model, 'adaalergimakanan', array('placeholder' => 'Ada Alergi Makanan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textAreaRow($model, 'keterangan_pesan', array('placeholder' => 'Keterangan Pesan', 'rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<!--<div class="control-group">
                <?php //echo $form->labelEx($model, 'bahandiet_id', array('class' => 'control-label')); 
                ?>
                <div class="controls">
                    <?php //echo $form->hiddenField($model, 'bahandiet_id'); 
                    ?>
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

<?php //echo $form->textFieldRow($model,'bahandiet_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<?php //echo $form->dropDownListRow($model, 'jenispesanmenu', LookupM::getItems('jenispesanmenu'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); 
?>
<?php echo CHtml::css('input[type="checkbox"].span2{width:13px;}'); ?>

<script type="text/javascript">
    $(document).ready(function() {

        // Notifikasi Pasien
        <?php
        if (isset($model->pesanmenudiet_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_GIZI ?>,
                judulnotifikasi: 'Pesan Menu Diet Pegawai & Tamu',
                isinotifikasi: 'Telah dilakukan pemesanan menu diet pada <?php echo $model->tglpesanmenu ?> di <?php echo $model->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>

    });
</script>