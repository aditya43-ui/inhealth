<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Asesmen Awal Medis</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">                
                <div class="control-group">
                    <?php echo CHtml::label('Waktu Pemeriksaan', 'tanggalruangan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAsesmenAwalMedis,
                            'attribute' => 'tgl_pemeriksaan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'class' => 'span3 ',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>   
                    </div>
                </div> 
                <div class="control-group">
                    <?php echo CHtml::label('Konsultan Nefrologi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeHiddenField($modAsesmenAwalMedis, 'konsultan_nefrologi_id', array('readonly' => true));
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modAsesmenAwalMedis,
                            'attribute' => 'konsultan_nefrologi_nama',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('GetKonsultanNefrologi') . '",
                                            dataType: "json",
                                                data: {
                                                    term: request.term,
                                                    tipe: 1,
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
                                                    $(this).val(ui.item.label);
                                                    return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
//                                          $("#RIAsesmenAwalMedisT_konsultan_nefrologi_id").val(ui.item.value);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array('placeholder' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3'),
                            'tombolDialog' => array('idDialog' => 'KonsultanNefrologidialog'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Dokter Pemeriksa</label>
                    <div class="controls">
                        <?= CHtml::activeHiddenField($modAsesmenAwalMedis, 'dokterpemeriksa_id', array('class'=>'span4')); ?>
                        <?= CHtml::activeTextField($modAsesmenAwalMedis, 'dokterpemeriksa_nama', array('class'=>'span4', 'readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Ruangan Asal</label>
                    <div class="controls">
                        <?= CHtml::activeHiddenField($modAsesmenAwalMedis, 'ruangan_asal_id', array('class'=>'span4')); ?>
                        <?= CHtml::activeTextField($modAsesmenAwalMedis, 'ruangan_asal_nama', array('class'=>'span4', 'readonly'=>true)); ?>
                    </div>
                </div>
                <?php if ($this->init != 'HD'){ ?>
                <div class="control-group">
                    <?php echo CHtml::label('Diagnosa Masuk RS <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeHiddenField($modAsesmenAwalMedis, 'diagnosa_id', array('readonly' => true));
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modAsesmenAwalMedis,
                            'attribute' => 'diagnosa_nama',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('GetDiagnosaMasukRS') . '",
                                            dataType: "json",
                                                data: {
                                                    term: request.term,
                                                    tipe: 1,
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
                                                    $(this).val(ui.item.label);
                                                    return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
//                                          $("#RIAsesmenAwalMedisT_diagnosa_id").val(ui.item.value);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array('placeholder' => 'Nama Diagnosa', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required'),
                            'tombolDialog' => array('idDialog' => 'diagnosa-dialog'),
                        ));
                        ?>
                    </div>
                </div>
                <?php } ?>
                <div class="control-group">
                    <?php echo CHtml::label('Dialisis Pertama Pada', 'tanggalruangan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAsesmenAwalMedis,
                            'attribute' => 'dialisis_pertama_pada',
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
            </div>
        </div>
    </div>
</div>