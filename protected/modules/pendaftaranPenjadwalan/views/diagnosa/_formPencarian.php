<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <?php echo CHtml::label('Kata Kunci (Kode/Nama)', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('katakunci', '', array('class' => 'span3', 'placeholder' => 'Ketikan kata kunci')); ?>
                <?php echo CHtml::htmlButton(
                    '<i class="entypo-search"></i>',
                    array(
                        'onclick' => 'cariDataDiagnosa();return false;',
                        'class' => 'btn btn-primary btn-katakunci',
                        'onkeypress' => "cariDataDiagnosa();return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari data Diagnosa",
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>