<?php
for ($i = 0; $i < $jmlKembar; $i++) {
    $jmlBy = $i + 2;
?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Bayi Ke-<?php echo $i + 2; ?></b>
            </div>
        </div>
        <div class="panel-body form-horizontal">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label required">Tanggal Lahir <span class="required">*</span></label>
                    <div class="controls">
                        <div class="input-append"><?php echo CHtml::activeTextField($model, '[' . $i . ']tgllahirbayi', array('readonly' => true, 'class' => 'tanggal dtPicker2', 'style' => 'float:left;', 'value' => MyFormatter::formatDateTimeForUser(date('Y-m-d')))); ?><span class="add-on"><i class="entypo-calendar"></i></span></div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required">Jam Lahir <span class="required">*</span></label>
                    <div class="controls">
                        <div class="input-append"><?php echo CHtml::activeTextField($model, '[' . $i . ']jamlahir', array('readonly' => true, 'class' => 'tanggal2 dtPicker2', 'style' => 'float:left;', 'value' => date('H:i:s'))); ?><span class="add-on"><i class="icon-time"></i></span></div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required">Nama Bayi <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, '[' . $i . ']namabayi', array('class' => 'span3', 'value' => $namaby . ' ' . $jmlBy,)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Kelamin <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, '[' . $i . ']jeniskelamin', LookupM::getItems('jeniskelamin'), array('class' => 'required', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required">Berat Badan <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, '[' . $i . ']bb_gram', array('class' => 'span1 numbersOnly')); ?>
                        <div class='additional-text'>Gram</div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required">Tinggi Badan <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, '[' . $i . ']tb_cm', array('class' => 'span1 float2')); ?>
                        <div class='additional-text'>CM</div><br>
                    </div>
                </div>
                <div class="pilih-cbasi">
                    <div class="control-group checkbox">
                        <label class="control-label">Bayi Lahir :</label>
                        <div class="controls">
                        </div>
                    </div>
                    <div class="control-group checkbox">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeCheckBox($model, '[' . $i . ']bayilahir_is_normal', array()); ?> <label>Normal, tindakan :</label>
                        </div>
                    </div>
                    <?php
                    $nor = explode('///', $model->bayilahir_normal_tindakan);
                    $getNormal = array();
                    foreach ($nor as $no) {
                        $getNormal[$no] = $no;
                    }

                    $normal = LookupM::model()->findAll(" lookup_type = 'bayilahirnormal' AND lookup_aktif = TRUE ORDER BY lookup_urutan ASC ");
                    foreach ($normal as $n) {
                        $model->bayilahir_normal_tindakan = isset($getNormal[$n->lookup_value]) ? $getNormal[$n->lookup_value] : '';
                    ?>
                        <div class="control-group checkbox">
                            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                            <div class="controls" style="padding-right:10px;">
                                <?php
                                echo CHtml::activeCheckBox($model, $i . '[detnormal][]bayilahir_normal_tindakan', array('checked' => !empty($model->bayilahir_normal_tindakan) ? true : false, 'uncheckValue' => null, 'value' => $n->lookup_value, 'style' => 'margin-left:0px !important;'));
                                ?>
                                <label><?php echo $n->lookup_name; ?></label>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="control-group checkbox">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeCheckBox($model, '[' . $i . ']bayilahir_is_aspiksia', array()); ?> <label>Aspiksia ringan/pucat/biru/lemas, tindakan :</label>
                        </div>
                    </div>
                    <?php
                    $aspt = explode('///', $model->bayilahir_aspiksia_tindakan);
                    $getAsp = array();
                    foreach ($aspt as $a) {
                        $getAsp[$a] = $a;
                    }
                    $asp = LookupM::model()->findAll(" lookup_type = 'bayilahiraspiksia' AND lookup_aktif = TRUE ORDER BY lookup_urutan ASC ");
                    foreach ($asp as $a) {
                    ?>
                        <div class="control-group checkbox">
                            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                            <div class="controls" style="padding-right:10px;">
                                <?php
                                $model->bayilahir_aspiksia_tindakan = isset($getAsp[$a->lookup_value]) ? $getAsp[$a->lookup_value] : '';
                                echo CHtml::activeCheckBox($model, $i . '[detaspiksia][]bayilahir_aspiksia_tindakan', array('checked' => !empty($model->bayilahir_aspiksia_tindakan) ? true : false, 'uncheckValue' => null, 'value' => $a->lookup_value, 'style' => 'margin-left:0px !important;', 'class' => (($a->lookup_name == 'Lain - Lain') ? 'adatext' : '')));
                                ?>
                                <label><?php echo $a->lookup_name . (($a->lookup_name == 'Lain - Lain') ? CHtml::activeTextField($model, '[' . $i . ']bayilahir_aspiksia_ketlainlain', array('class' => 'span3 txtlain', 'readonly' => true)) : ''); ?></label>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="control-group checkbox">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeCheckBox($model, '[' . $i . ']bayilahir_is_cacatbawaan', array('class' => 'adatext')); ?> <label>Cacat Bawaan, sebutkan</label>
                        </div>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, '[' . $i . ']bayilahir_cacatbawaan_keterangan', array('class' => 'span3 txtlain', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group checkbox">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeCheckBox($model, '[' . $i . ']bayilahir_is_hiportemi', array('class' => 'adatext')); ?> <label>Hipotermi, tindakan :</label>
                            <br>
                            <?php echo CHtml::activeTextArea($model, '[' . $i . ']bayilahir_hiportemi_tindakan', array('class' => 'txtlain', 'readonly' => true)); ?>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Kelainan Bayi</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextArea($model, '[' . $i . ']kelainanbayi', array('rows' => 3, 'class' => '')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Catatan Bayi</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextArea($model, '[' . $i . ']catatan_bayi', array('rows' => 2, 'class' => '')); ?>
                    </div>
                </div>
                <div class="pilih-cbasi">
                    <div class="control-group checkbox">
                        <label class="control-label">Pemberian Asi :</label>
                    </div>
                    <div class="control-group checkbox">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButton($model, '[' . $i . ']is_pemberianasi', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext', 'id' => 'yadiberi')); ?> <label>Ya, waktu :</label>
                        </div>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, '[' . $i . ']waktu_pemberianasi', array('class' => 'span1 txtlain numbersOnly', 'readonly' => true, 'id' => 'tidakdiberi')); ?>
                        </div>
                        <div class="controls">
                            <label>jam setelah lahir</label>
                        </div>
                    </div>
                    <div class="control-group checkbox">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButton($model, '[' . $i . ']is_pemberianasi', array('uncheckValue' => null, 'value' => false, 'class' => 'adatext', 'id' => 'yadiberi')); ?> <label>Tidak, alasan :</label>
                        </div>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, '[' . $i . ']alasantidak_pemberianasi', array('class' => 'span3 txtlain', 'readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Lingkar Dada</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, '[' . $i . ']ld_cm', array('class' => 'span1 float2')); ?>
                        <div class='additional-text'>CM</div><br>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Lingkar Lengan</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, '[' . $i . ']ll_cm', array('class' => 'span1 float2')); ?>
                        <div class='additional-text'>CM</div><br>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Lingkar Kepala</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, '[' . $i . ']lk_cm', array('class' => 'span1 float2')); ?>
                        <div class='additional-text'>CM</div><br>
                    </div>
                </div>

            </div>
            <div class="clear"></div>
            <br>
            <?php

            $appgards = PSMetodeapgarM::model()->findAll(array('order' => 'metodeapgar_id'), "metodeapgar_aktif = TRUE");
            echo $this->renderPartial('_metodeappgard_kembar', array('i' => $i, 'model' => $model, 'appgards' => $appgards), true); ?>
        </div>
    </div>

<?php
}
?>