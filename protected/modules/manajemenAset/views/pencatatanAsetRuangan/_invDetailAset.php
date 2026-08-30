<div class="panel panel-primary panel-success list-data">
    <div class="panel-heading">
        <div class="panel-title">											
            Aset <span class="urutan_aset_det"></span>																	
        </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group ">
                    <?php echo CHtml::label('Kode <span class="required">*</span>', 'invperalatan_kode', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']invperalatan_kode', array('class' => 'span3 required kode_aset', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly'=>true, 'onblur'=>'cekKodeAset(this)')); ?>                        
                    </div>                    
                    <div class="controls">
                        <?php echo CHtml::activeCheckBox($modelDetail, '['.$i.']ceklis_kode', array('class' => '','onclick'=>'enableKode(this)')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Peralatan <span class="required">*</span>', 'invperalatan_namabrg', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']invperalatan_namabrg', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Nomor Seri <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']peralatan_noseri', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modelDetail, 'invperalatan_nopabrik', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']invperalatan_nopabrik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modelDetail, 'invperalatan_norangka', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']invperalatan_norangka', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modelDetail, 'invperalatan_nomesin', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']invperalatan_nomesin', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modelDetail, 'invperalatan_nopolisi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']invperalatan_nopolisi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modelDetail, 'invperalatan_nobpkb', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']invperalatan_nobpkb', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modelDetail, 'invperalatan_akumsusut', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']invperalatan_akumsusut', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modelDetail, 'invperalatan_ket', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextArea($modelDetail, '['.$i.']invperalatan_ket', array('rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Umur Ekonomis <span class="required">*</span>', 'invperalatan_umurekonomis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, '['.$i.']invperalatan_umurekonomis', array('class' => 'span1 numbersOnly required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Keadaan <span class="required">*</span>', 'invperalatan_keadaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($modelDetail, '['.$i.']invperalatan_keadaan', LookupM::getItems('inventariskeadaan'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>