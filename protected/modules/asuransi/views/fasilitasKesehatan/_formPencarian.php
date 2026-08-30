<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <?php echo CHtml::label('Kata Kunci (Kode/Nama)', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('katakunci_faskes1', '', array('class' => 'span3', 'placeholder' => 'Ketikan kata kunci')); ?>

            </div>
        </div>
        <?php echo CHtml::htmlButton(
            '<i class="entypo-search"></i>',
            array(
                'onclick' => 'cariDataFaskes();return false;',
                'class' => 'btn btn-primary btn-katakunci',
                'onkeypress' => "cariDataFaskes();return false;",
                'rel' => "tooltip",
                'title' => "Klik untuk mencari data Fasilitas Kesehatan",
            )
        ); ?>
    </div>
    <div class="span6">
        <div class="control-group ">
            <?php echo CHtml::label('Kata Kunci (Jenis)', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('katakunci_faskes2', 1, array('1' => 'Faskes', '2' => 'Faskes 2/RS'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
    </div>
</div>