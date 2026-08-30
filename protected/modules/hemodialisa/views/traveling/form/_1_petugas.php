<div class="panel panel-success">    
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Tanggal</label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tanggal',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                            'yearRange' => "-60:+0",
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Dokter DPJP</label>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'dpjp_id',['class'=>'dpjp_id']);
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,                                        
                            'attribute' => 'dpjp_nama',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/getPegawai') . '",
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
                                        setPetugas(ui.item,this,"dpjp");
                                        return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => "Ketik pelaksana",
                                'class' => 'span3 dpjp_nama setreq',
                                'onblur'=>'if(this.value==""){$(".dpjp_id").val("")}'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugas', 'jsFunction'=>'setDialog("dialogPetugas","dpjp");refreshGridPetugas();'),
                        ));
                    ?>
                </div>
            </div>
                        
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Perawat 1</label>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'perawat1_id',['class'=>'perawat1_id']);
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,                                        
                            'attribute' => 'perawat1_nama',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/getPegawai') . '",
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
                                        setPetugas(ui.item,this,"perawat1");
                                        return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => "Ketik perawat",
                                'class' => 'span3 perawat1_nama setreq',
                                'onblur'=>'if(this.value==""){$(".perawat1_nama").val("")}'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugas', 'jsFunction'=>'setDialog("dialogPetugas","perawat1");refreshGridPetugas();'),
                        ));
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Perawat 2</label>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'perawat2_id',['class'=>'perawat2_id']);
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,                                        
                            'attribute' => 'perawat2_nama',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/getPegawai') . '",
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
                                        setPetugas(ui.item,this,"perawat2");
                                        return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => "Ketik perawat",
                                'class' => 'span3 perawat2_nama setreq',
                                'onblur'=>'if(this.value==""){$(".perawat2_nama").val("")}'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugas', 'jsFunction'=>'setDialog("dialogPetugas","perawat2");refreshGridPetugas();'),
                        ));
                    ?>
                </div>
            </div>
        </div>
               
    </div>
</div>