<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - digunakan sebagai form inputan pemeriksaan pengujian golongan darah
 * RSST-1471
 */
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Pra transfusi
        </div>
    </div>
    <div class="panel-body" id="form-pilihpemeriksaan">
        <div class="col-sm-6">
            <div class="control-group anti-a" anti="A">
                <label class="control-label">Anti A : <span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->radioButton($model, 'anti_a', array('id' => 'a_pos', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF)); ?> <label for="a_pos">Positif (+)</label>
                </div>
                <div class="controls">
                    <?php echo $form->radioButton($model, 'anti_a', array('id' => 'a_neg', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF)); ?> <label for="a_neg">Negatif (+)</label>
                </div>
            </div>

            <div class="control-group anti-b" anti="B">
                <label class="control-label">Anti B : <span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->radioButton($model, 'anti_b', array('id' => 'b_pos', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF)); ?> <label for="b_pos">Positif (+)</label>
                </div>
                <div class="controls">
                    <?php echo $form->radioButton($model, 'anti_b', array('id' => 'b_neg', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF)); ?> <label for="b_neg">Negatif (+)</label>
                </div>
            </div>

            <div class="control-group anti-d" anti="D">
                <label class="control-label">Anti D : <span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->radioButton($model, 'anti_d', array('id' => 'd_pos', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF)); ?> <label for="d_pos">Positif (+)</label>
                </div>
                <div class="controls">
                    <?php echo $form->radioButton($model, 'anti_d', array('id' => 'd_neg', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF)); ?> <label for="d_neg">Negatif (+)</label>
                </div>
            </div>

            <div class="control-group screeningab">
                <label class="control-label">Sreening Antibody : </label>
                <div class="controls">
                    <?php echo $form->radioButton($modPengujianDarah, 'screeningab', array('id' => 'sa_pos', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF)); ?> <label for="sa_pos">Positif (+)</label>
                </div>
                <div class="controls">
                    <?php echo $form->radioButton($modPengujianDarah, 'screeningab', array('id' => 'sa_neg', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF)); ?> <label for="sa_neg">Negatif (+)</label>
                </div>
            </div>

            <div class="control-group anti-b" anti="B">
                <label class="control-label">Imidiate Spin : </label>
                <div class="controls">
                    <?php echo $form->radioButton($modPengujianDarah, 'imidiatespin', array('id' => 'is_pos', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF)); ?> <label for="is_pos">Positif (+)</label>
                </div>
                <div class="controls">
                    <?php echo $form->radioButton($modPengujianDarah, 'imidiatespin', array('id' => 'is_neg', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF)); ?> <label for="is_neg">Negatif (+)</label>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Kesimpulan : <span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->textArea($model, 'kesimpulan_uji', array('placeholder' => 'Kesimpulan', 'class' => 'autogrow required')); ?>
                </div>
            </div>
        </div>
    </div>
</div>