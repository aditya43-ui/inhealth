<?php

/**
 *       - digunakan untuk menampilkan form in[utan kepala leher
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
?>

<style>
    #radio-sesuai>label.radio {
        width: 70px;
        display: inline-block;
    }
</style>

<div class="panel panel-success panel_cgsews">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->checkBox($modPemeriksaanFisik, 'is_pilih', array('class' => 'cek_ews', 'uncheckValue' => null)); ?>
            Kepala Leher
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label("Conjuctiva", 'is_pilih', array('class' => 'control-label', 'label' => "Conjuctiva")) ?>
            <div class="controls" id="radio-sesuai">
                <?php echo '<label class="radio-inline">' . $form->radioButton($modPemeriksaanFisik, 'is_pilih[val]', array('value' => 'isanemia', 'uncheckValue' => null)) . " " . CHtml::label('Normal', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modPemeriksaanFisik, 'is_pilih[val]', array('value' => 'isleterus', 'uncheckValue' => null)) . " " . CHtml::label('Anemic', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modPemeriksaanFisik, 'is_pilih[val]', array('value' => 'iscyanosis', 'uncheckValue' => null)) . " " . CHtml::label('Icterus', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modPemeriksaanFisik, 'is_pilih[val]', array('value' => 'isdyspneu', 'uncheckValue' => null))
                    . " " . $form->textField($modPemeriksaanFisik, 'is_pilih[lain2]', array('class' => 'span2')) . '</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaanFisik, 'leher_reflekpupil', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButtonList($modPemeriksaanFisik, 'leher_reflekpupil', Params::getReflectPupil(), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="hidden">
            <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'leher_pupil', LookupM::getItems('pupil'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'leher_nasal', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <?php echo $form->textAreaRow($modPemeriksaanFisik, 'leher_mata', array('rows' => 3, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
     
        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'leher_telinga', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'leher_orofans', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
            <?php echo CHtml::label("Pembesaran KGB", 'leher_reflekpupil', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButtonList($modPemeriksaanFisik, 'leher_kelgetahbening_teraba', Params::getPembesaranKGB(), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("Pembesaran Kelenjar Thyroid", 'leher_reflekpupil', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButtonList($modPemeriksaanFisik, 'leher_kelenjartiroid_teraba', Params::getPembesaranThroid(), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaanFisik, 'leher_jvp', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButtonList($modPemeriksaanFisik, 'leher_jvp', Params::getJVP(), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'leher_lainlain', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<script>
    function ceklisCGSEWS() {
        $(".cek_ews").each(function() {
            $(this).parents(".panel_cgsews")
                .find(".panel-body").hide()
                .find(":input").prop("disabled", true);
            if ($(this).is(":checked")) {
                $(this).parents(".panel_cgsews")
                    .find(".panel-body").show()
                    .find(":input").prop("disabled", false);

            }
        });
    }

    $(document).ready(function() {
        $(".cek_ews").on("click", ceklisCGSEWS);
        ceklisCGSEWS();
    });
</script>