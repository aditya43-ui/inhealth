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
<?php
    $conjuctiva = '';
    if(!empty($modPemeriksaanFisik->conjuctiva)) {
        $conjuctiva = $modPemeriksaanFisik->conjuctiva;
        $modPemeriksaanFisik->is_pilih = true;
    }
?>
<div class="panel panel-success panel_cgsews">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->checkBox($modPemeriksaanFisik, 'is_pilih', array('class' => 'cek_ews', 'uncheckValue' => null)); ?>
        <i class="glyphicon glyphicon-file"></i>    Kepala Leher
        </div>
        <div class="panel-title dbnstyle">
            <span><?php echo CHtml::checkBox("DbnKepleh", '', array('onchange' => 'dbnKepleh(this)')) . ' <label>DBN (Dalam Batas Normal)</label>' ?></span>
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label("Conjuctiva", 'is_pilih', array('class' => 'control-label', 'label' => "Conjuctiva")) ?>
            <div class="controls rb-kl" id="radio-sesuai">
                <?php echo '<label class="radio-inline">' . $form->radioButton($modPemeriksaanFisik, 'is_pilih[val]', array('value' => 'isanemia', 'uncheckValue' => null, 'checked' => ($conjuctiva == 'isanemia'))) . " " . CHtml::label('Normal', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modPemeriksaanFisik, 'is_pilih[val]', array('value' => 'isleterus', 'uncheckValue' => null, 'checked' => ($conjuctiva == 'isleterus'))) . " " . CHtml::label('Anemic', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modPemeriksaanFisik, 'is_pilih[val]', array('value' => 'iscyanosis', 'uncheckValue' => null, 'checked' => ($conjuctiva == 'iscyanosis'))) . " " . CHtml::label('Icterus', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modPemeriksaanFisik, 'is_pilih[val]', array('value' => 'isdyspneu', 'uncheckValue' => null, 'checked' => ($conjuctiva == 'isdyspneu')))
                    . " " . $form->textField($modPemeriksaanFisik, 'is_pilih[lain2]', array('class' => 'span2')) . '</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaanFisik, 'leher_reflekpupil', array('class' => 'control-label')) ?>
            <div class="controls rb-kl">
                <?php echo $form->radioButtonList($modPemeriksaanFisik, 'leher_reflekpupil', Params::getReflectPupil(), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="hidden">
            <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'leher_pupil', LookupM::getItems('pupil'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <?php echo $form->textAreaRow($modPemeriksaanFisik, 'leher_mata', array('rows' => 3, 'class' => 'span3 txt-leher', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'leher_nasal', array('class' => 'txt-leher', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
       
     
        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'leher_telinga', array('class' => 'txt-leher','onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'leher_orofans', array('class' => 'txt-leher','onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
            <?php echo CHtml::label("Pembesaran KGB", 'leher_reflekpupil', array('class' => 'control-label')) ?>
            <div class="controls rb-kl-no">
                <?php echo $form->radioButtonList($modPemeriksaanFisik, 'leher_kelgetahbening_teraba', Params::getPembesaranKGB(), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("Pembesaran Kelenjar Thyroid", 'leher_reflekpupil', array('class' => 'control-label')) ?>
            <div class="controls rb-kl-no">
                <?php echo $form->radioButtonList($modPemeriksaanFisik, 'leher_kelenjartiroid_teraba', Params::getPembesaranThroid(), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaanFisik, 'leher_jvp', array('class' => 'control-label')) ?>
            <div class="controls rb-kl-jpv">
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