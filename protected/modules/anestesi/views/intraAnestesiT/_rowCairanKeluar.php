<div class="control-group ">
    <?php echo Chtml::label('Cairan Keluar', '', array('class' => 'control-label')) ?>
    <div class="controls">
    </div>
</div>
<div class="control-group ">
    <?php echo Chtml::label('Urin', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo CHtml::textField('cairankeluar[0][nama]',isset($det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_URIN])?$det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_URIN]['nama']:'', array('class' => 'span3'));
        echo CHtml::hiddenField('cairankeluar[0][sub_jenis]','URIN', array('class' => 'span3'));
        echo CHtml::hiddenField('cairankeluar[0][id]',isset($det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_URIN])?$det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_URIN]['id']:'', array('class' => 'span3'));
        ?>
    </div>
</div>
<div class="control-group ">
    <?php echo Chtml::label('S&I', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo CHtml::textField('cairankeluar[1][nama]',isset($det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_SI])?$det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_SI]['nama']:'', array('class' => 'span3'));
        echo CHtml::hiddenField('cairankeluar[1][sub_jenis]','S&I', array('class' => 'span3'));
        echo CHtml::hiddenField('cairankeluar[1][id]',isset($det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_SI])?$det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_SI]['id']:'', array('class' => 'span3'));
        ?>
    </div>
</div>
<div class="control-group ">
    <?php echo Chtml::label('Darah', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo CHtml::textField('cairankeluar[2][nama]',isset($det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_DARAH])?$det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_DARAH]['nama']:'', array('class' => 'span3'));
        echo CHtml::hiddenField('cairankeluar[2][sub_jenis]','DARAH', array('class' => 'span3'));
        echo CHtml::hiddenField('cairankeluar[2][id]',isset($det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_DARAH])?$det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_DARAH]['id']:'', array('class' => 'span3'));
        ?>
    </div>
</div>
<div class="control-group ">
    <?php echo Chtml::label('EBL', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo CHtml::textField('cairankeluar[3][nama]',isset($det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_EBL])?$det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_EBL]['nama']:'', array('class' => 'span3'));
        echo CHtml::hiddenField('cairankeluar[3][sub_jenis]','EBL', array('class' => 'span3'));
        echo CHtml::hiddenField('cairankeluar[3][id]',isset($det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_EBL])?$det[Params::KATEGORI_CAIRAN_OUTPUT][Params::KELOMPOK_CAIRAN_OUTPUT_EBL]['nama']:'', array('class' => 'span3'));
        ?> %
    </div>
</div>