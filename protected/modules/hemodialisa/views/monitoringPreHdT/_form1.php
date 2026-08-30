
<div class="panel panel-success">
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tanggal dan Jam', 'waktu', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'waktu',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>   
                    </div>
                </div> 
                <div class="row-fluid"> 
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'dpjp_id', array('class' => 'control-label', 'label' => 'DPJP')); ?>
                        <div class="controls">
                            <?php
                            echo $form->hiddenField($model, 'dpjp_id', array('readonly' => true));
                            echo $form->textField($model, 'dpjp_nama', array('readonly' => true, 'class' => 'span3'));
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label('Perawat 1', 'perawat1_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'perawat1_id', array());

                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'perawat1_nama',
                            'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('AutocompletePerawat') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.label);

                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                                $("#MonitoringPreHdT_perawat1_id").val(ui.item.pegawai_id);
                                                return false;
                                            }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Ketik Nama Perawat',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3',
                                'onblur' => 'if(this.value === "") $("#MonitoringPreHdT_perawat1_id").val("");'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPerawat1'),
                        ));
                        ?>
                    </div>
                </div>  
                <div class="control-group">
                    <?php echo CHtml::label('Perawat 2', 'perawat2_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'perawat2_id', array());

                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'perawat2_nama',
                            'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('AutocompletePerawat') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.label);

                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                                $("#MonitoringPreHdT_perawat2_id").val(ui.item.pegawai_id);
                                                return false;
                                            }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Ketik Nama Perawat',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3',
                                'onblur' => 'if(this.value === "") $("#MonitoringPreHdT_perawat2_id").val("");'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPerawat2'),
                        ));
                        ?>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>