<?php

/**
 *       - digunakan untuk menampilkan form in[utan kepala leher
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
?>

<div class="panel panel-success panel_cgsews">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->checkBox($modPemeriksaanFisik, 'abd_inspeksi', array('class' => 'cek_ews', 'uncheckValue' => null)); ?>
            <i class="glyphicon glyphicon-file"></i> Abdomen
        </div>
        <div class="panel-title dbnstyle">
            <span><?php echo CHtml::checkBox("DbnAbdomen", '', array('onchange' => 'dbnAbdomen()')) . ' <label>DBN (Dalam Batas Normal)</label>' ?></span>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'abd_inspeksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <label class="control-label">Palpasi</label>
            <div class="controls">
                <div class="control-group">
                    <?php echo $form->textField($modPemeriksaanFisik, 'abd_palpasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'leopold_1', array('class' => 'control-label', 'style' => 'width: 65px;')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanFisik, 'leopold_1', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'leopold_2', array('class' => 'control-label', 'style' => 'width: 65px;')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanFisik, 'leopold_2', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'leopold_3', array('class' => 'control-label', 'style' => 'width: 65px;')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanFisik, 'leopold_3', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'leopold_4', array('class' => 'control-label', 'style' => 'width: 65px;')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanFisik, 'leopold_4', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'abd_perkusi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modPemeriksaanFisik, 'abd_auskultasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
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