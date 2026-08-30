<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nokirimmenu', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
        <?php echo $form->hiddenField($model, 'jenispesanmenu', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglkirimmenu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglkirimmenu',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'tglkirimmenu'); ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model, 'bahandiet_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
        ?>
        <div class="control-group">
            <?php //echo $form->labelEx($model, 'bahandiet_id', array('class' => 'control-label')); 
            ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'bahandiet_id'); ?>
                <!--<div class="input-append" style='display:inline'>-->
                <?php echo Chtml::hiddenField(isset($model->bahandiet_id) ? $model->bahandiet_id : 0);
                //        $this->widget('MyJuiAutoComplete', array(
                //            'name' => 'bahandiet',
                //            'value'=>  (isset($modPesan->bahandiet_id) ? $modPesan->bahandiet->bahandiet_nama : ""),
                //            'source' => 'js: function(request, response) {
                //                       $.ajax({
                //                           url: "' . Yii::app()->createUrl('ActionAutoComplete/BahanDiet') . '",
                //                           dataType: "json",
                //                           data: {
                //                               term: request.term,
                //                           },
                //                           success: function (data) {
                //                                   response(data);
                //                           }
                //                       })
                //                    }',
                //            'options' => array(
                //                'showAnim' => 'fold',
                //                'minLength' => 2,
                //                'focus' => 'js:function( event, ui ) {
                //                                                            $(this).val( ui.item.label);
                //                                                            return false;
                //                                                        }',
                //                'select' => 'js:function( event, ui ) {
                //                                                            $("#'.Chtml::activeId($model, 'bahandiet_id') . '").val(ui.item.bahand_id); 
                //                                                            return false;
                //                                                        }',
                //            ),
                //            'htmlOptions' => array(
                //                'onkeypress' => "return $(this).focusNextInputField(event)",
                //            ),
                //            'tombolDialog' => array('idDialog' => 'dialogBahanDiet'),
                //        ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php
            $labelJenisMenu = $form->labelEx($model, 'jenisdiet_id', array('class' => 'control-label'));

            if (isset($model->jenispesanmenu)) {
                if ($model->jenispesanmenu == Params::JENISPESANMENU_PEGAWAI) {
                    $labelJenisMenu = CHtml::label("Jenis Menu ", "", array('class' => 'control-label'));
                }
            }
            echo $labelJenisMenu;
            ?>
            <?php // echo $form->labelEx($model, 'jenisdiet_id', array('class' => 'control-label')); 
            ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenisdiet_id', CHtml::listData(JenisdietM::model()->findAll(array(
                    'condition' => 'jenisdiet_aktif = true',
                    'order' => 'jenisdiet_nama',
                )), 'jenisdiet_id', 'jenisdiet_nama'), array(
                    'class' => 'span4',
                    'empty' => '-- Pilih --',
                    'onchange' => 'refreshDialogMenu()',
                )); ?>
                <?php /* echo $form->hiddenField($model, 'jenisdiet_id'); ?>
        <?php echo CHtml::hiddenField('idJenisDiet',''); ?>
        <?php echo CHtml::hiddenField('idJenisDiet2',''); ?>
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'jenisdiet',
            'value'=>(isset($modPesan) ? $modPesan->jenisdiet->jenisdiet_nama : ""),
            'source' => 'js: function(request, response) {
                                                               $.ajax({
                                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/JenisDiet') . '",
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
                                                            return false;
                                                        }',
            ),
            'htmlOptions' => array(
                'onkeypress' => "return $(this).focusNextInputField(event)",
            ),
            'tombolDialog' => array('idDialog' => 'dialogJenisDiet'),
        ));
         * 
         */
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'keterangan_kirim', array('placeholder' => 'Keterangan Kirim', 'rows' => 5, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>