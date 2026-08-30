<?php

/**
 * form pemeriksaan fleksibilitas
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Fleksibilitas
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Kekuatan Otot
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <label class="control-label">Cybex</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'kekuatanotot_cybex', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">En-Tree</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'kekuatanotot_entree', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nk-Table</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'kekuatanotot_nktable', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Hand-Held Dinamometer</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'kekuatanotot_handhelddinamo', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Pinchmeter</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'kekuatanotot_pinchmeter', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Lingkup Gerak Sendi
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <label class="control-label">Iknometer</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'lingkupgeraksendi_ikinometer', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Goniometer</label>
                        <div class="controls">
                            <?php echo $form->textArea($modPemeriksaanFisik, 'lingkupgeraksendi_goniometer'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Fleksibilitas
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <label class="control-label">Schober Test</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'fleksibilitas_schober', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Site And Reach Test</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'fleksibilitas_sitandreach', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Shoulder Fleksibility Test</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'fleksibilitas_shoulderfleksibility', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Tes Sentuh Jari Kaki</label>
                        <div class="controls">
                            <?php echo $form->textField($modPemeriksaanFisik, 'fleksibilitas_sentuhjarikaki', array('maxlength' => 100)) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Sensibilitas</div>
                </div>
                <div class="panel-body">
                    <div>
                        <div class="control-group">
                            <div class="controls">
                                <div style="width: 100px; float: left;">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'sensibilitas_panasdingin[0]', array('value' => 'Panas', 'uncheckValue' => "-")); ?>
                                    <label>Panas</label>
                                </div>
                                <div style="width: 100px; float: left;">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'sensibilitas_panasdingin[1]', array('value' => 'Dingin', 'uncheckValue' => "-")); ?>
                                    <label>Dingin</label>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <div style="width: 100px; float: left;">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'sensibilitas_tajamtumpul[0]', array('value' => 'Tajam', 'uncheckValue' => "-")); ?>
                                    <label>Tajam</label>
                                </div>
                                <div style="width: 100px; float: left;">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'sensibilitas_tajamtumpul[1]', array('value' => 'Tumpul', 'uncheckValue' => "-")); ?>
                                    <label>Tumpul</label>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <div style="width: 100px; float: left;">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'sensibilitas_kasarhalus[0]', array('value' => 'Kasar', 'uncheckValue' => "-")); ?>
                                    <label>Kasar</label>
                                </div>
                                <div style="width: 100px; float: left;">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'sensibilitas_kasarhalus[1]', array('value' => 'Halus', 'uncheckValue' => "-")); ?>
                                    <label>Halus</label>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <div style="width: 100px; float: left;">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'sensibilitas_titik[0]', array('value' => '1 Titik', 'uncheckValue' => "-")); ?>
                                    <label>1 Titik</label>
                                </div>
                                <div style="width: 100px; float: left;">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'sensibilitas_titik[1]', array('value' => '2 Titik', 'uncheckValue' => "-")); ?>
                                    <label>2 Titik</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Kesimpulan</label>
                <div class="controls">
                    <?php echo $form->textArea($modPemeriksaanFisik, 'fleksibilitas_kesimpulan') ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Saran</label>
                <div class="controls">
                    <?php echo $form->textArea($modPemeriksaanFisik, 'fleksibilitas_saran') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Kemapuan Fungsional
            </div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class='control-label'>&nbsp;</label>
                <div class="controls">
                    <div class='checkbox'>
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'fungsional_tidur'); ?>
                        <?php echo $form->label($modPemeriksaanFisik, 'fungsional_tidur'); ?>
                    </div>
                    <div class='checkbox'>
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'fungsional_jalansendiri'); ?>
                        <?php echo $form->label($modPemeriksaanFisik, 'fungsional_jalansendiri'); ?>
                    </div>
                    <div class='checkbox checkbox_text'>
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'fungsional_alatbantu'); ?>
                        <?php echo $form->label($modPemeriksaanFisik, 'fungsional_alatbantu'); ?><br>
                        <?php echo $form->textField($modPemeriksaanFisik, 'fungsional_alatbantu_keterangan', array('class' => 'span3')); ?>
                    </div>
                    <div class='checkbox'>
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'fungsional_kursiroda'); ?>
                        <?php echo $form->label($modPemeriksaanFisik, 'fungsional_kursiroda'); ?>
                    </div>
                    <div class='checkbox checkbox_text'>
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'fungsional_prothese'); ?>
                        <?php echo $form->label($modPemeriksaanFisik, 'fungsional_prothese'); ?><br>
                        <?php echo $form->textField($modPemeriksaanFisik, 'fungsional_prothese_keterangan', array('class' => 'span3')); ?>
                    </div>
                    <div class='checkbox checkbox_text'>
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'fungsional_deformitas'); ?>
                        <?php echo $form->label($modPemeriksaanFisik, 'fungsional_deformitas'); ?><br>
                        <?php echo $form->textField($modPemeriksaanFisik, 'fungsional_deformitas_keterangan', array('class' => 'span3')); ?>
                    </div>
                    <div class='checkbox checkbox_text'>
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'fungsional_resikojatuh'); ?>
                        <?php echo $form->label($modPemeriksaanFisik, 'fungsional_resikojatuh'); ?><br>
                        <?php echo $form->textField($modPemeriksaanFisik, 'fungsional_resikojatuh_keterangan', array('class' => 'span3')); ?>
                    </div>
                    <div class='checkbox checkbox_text'>
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'fungsional_lainlain'); ?>
                        <?php echo $form->label($modPemeriksaanFisik, 'fungsional_lainlain'); ?><br>
                        <?php echo $form->textField($modPemeriksaanFisik, 'fungsional_lainlain_keterangan', array('class' => 'span3')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Pemeriksaan Sistematik Khusus
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->textAreaRow($modPemeriksaanFisik, 'sistematikkhusus_muskuloskeletal', array('class' => 'span3')); ?>
            <?php echo $form->textAreaRow($modPemeriksaanFisik, 'sistematikkhusus_neuromuscular', array('class' => 'span3')); ?>
            <?php echo $form->textAreaRow($modPemeriksaanFisik, 'sistematikkhusus_cardiopulmunal', array('class' => 'span3')); ?>
            <?php echo $form->textAreaRow($modPemeriksaanFisik, 'sistematikkhusus_integumen', array('class' => 'span3')); ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Pengukuran Khusus
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->textAreaRow($modPemeriksaanFisik, 'pengukurankhusus_muskuloskeletal', array('class' => 'span3')); ?>
            <?php echo $form->textAreaRow($modPemeriksaanFisik, 'pengukurankhusus_neuromuscular', array('class' => 'span3')); ?>
            <?php echo $form->textAreaRow($modPemeriksaanFisik, 'pengukurankhusus_cardiopulmunal', array('class' => 'span3')); ?>
            <?php echo $form->textAreaRow($modPemeriksaanFisik, 'pengukurankhusus_integumen', array('class' => 'span3')); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<script>
    function cekCheckboxText() {
        $(".checkbox_text").each(function() {
            var cek = $(this).find("input[type='checkbox']").is(":checked");
            if (!cek) {
                $(this).find("input[type='text']").val("").prop("readonly", true);
            } else {
                $(this).find("input[type='text']").prop("readonly", false);
            }
        });
    }
    $(document).ready(function() {
        $(".checkbox_text input[type='checkbox']").on("click", cekCheckboxText);
        cekCheckboxText();
    });
</script>