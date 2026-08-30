<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">											
            Aset <span class="urutan_aset_det"></span>																	
        </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelDetail, 'invasetlain_kode', array(
                        'class'=>'control-label',
                        'label'=>'Kode <span class="required">*</span>',
                    )); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '[detail]['.$i.']invasetlain_kode', array('readonly'=>true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelDetail, 'invasetlain_namabrg', array(
                        'class'=>'control-label',
                        'label'=>'Nama Aset Lain <span class="required">*</span>'
                    )); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '[detail]['.$i.']invasetlain_namabrg', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelDetail, 'kode_wilayah', array(
                        'class'=>'control-label',
                    )); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '[detail]['.$i.']kode_wilayah', array('readonly' => false, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">Tanggal Penggunaan<span class="required">*</span></label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modelDetail,
                            'attribute' => '[detail]['.$i.']invasetlain_tglguna',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            //
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 
                                'class' => 'dtPicker3 invasetlain_tglguna required', 
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'style'=>'width:204px;',
                                'onchange'=>'$("#MAInvasetlainT_invasetlain_noregister").blur();'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelDetail, 'invasetlain_akumsusut', array(
                        'class'=>'control-label',
                    )); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '[detail]['.$i.']invasetlain_akumsusut', array(
                            'class' => 'span1 float2', 
                            'style'=>'text-align: right;', 
                            'onkeypress' => "return $(this).focusNextInputField(event);", 
                            'maxlength' => 30
                        )); ?>
                        <label>%</label>
                    </div>
                </div>
                
                
                
            </div>
            <div class="col-sm-6">
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelDetail, 'invasetlain_asalkesenian', array(
                        'class'=>'control-label',
                    )); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '[detail]['.$i.']invasetlain_asalkesenian', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelDetail, 'invasetlain_penciptakesenian', array(
                        'class'=>'control-label',
                    )); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '[detail]['.$i.']invasetlain_penciptakesenian', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelDetail, 'invasetlain_bahankesenian', array(
                        'class'=>'control-label',
                    )); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '[detail]['.$i.']invasetlain_bahankesenian', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelDetail, 'invasetlain_ukuranhewan_tum', array(
                        'class'=>'control-label',
                    )); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '[detail]['.$i.']invasetlain_ukuranhewan_tum', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>