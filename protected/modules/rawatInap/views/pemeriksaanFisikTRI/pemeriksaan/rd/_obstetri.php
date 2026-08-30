<?php

/**
 *       - digunakan untuk menampilkan form in[utan kepala leher
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
?>

<div class="panel panel-success panel_cgsews">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->checkBox($modPemeriksaanFisik, 'obstetri', array('class' => 'cek_ews', 'uncheckValue' => null)); ?>
            <i class="far fa-file-alt"></i> Obstetri
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label("TFU", 'tinggifundus_uteri', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPemeriksaanFisik, 'tinggifundus_uteri', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>cm</label>
            </div>
        </div>

        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'obs_his', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
            <?php echo CHtml::label("Posisi", 'tinggifundus_uteri', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPemeriksaanFisik, 'leher_posisijanin', array('class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("Denyut", 'tinggifundus_uteri', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPemeriksaanFisik, 'denyutjantung_janin', array('class' => 'span1 ', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>/menit</label>
            </div>
        </div>

        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'obs_vaginatoucher', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
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