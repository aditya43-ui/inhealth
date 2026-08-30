<style>
    .control-group {
        padding: 5px;
    }

    td .control-group:hover {
        background-color: #B5C1D7;
    }

    .additional-text {
        display: inline-block !important;
        font-size: 11px;
    }

    .checkbox {
        padding: 0 !important;
        margin: 0;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Kelarihan Bayi
        </div>
    </div>
    <div class="panel-body">
        <?php // $this->renderPartial('/_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); 
        ?>
        <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
        <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._jsFunctions', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
        <?php $this->renderPartial('_persalinan', array('modPersalinan' => $modPersalinan)); ?>
        <?php $this->renderPartial('_kelahiran', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modKelahiran' => $modKelahiran)); ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pskelahiranbayi-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Kelahiran Bayi
                </div>
            </div>
            <div class="panel-body">
                <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <?php echo $form->errorSummary($model); ?>
                <?php echo CHtml::hiddenField('kelahiranbayi_id', $model->kelahiranbayi_id); ?>
                <div class="col-sm-6">
                    <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'persalinan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'nourutbayi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'tgllahirbayi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tgllahirbayi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgllahirbayi',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    //
                                    'onkeypress' => "js:function(){getUmur(this);}",
                                    'onSelect' => 'js:function(){getUmur(this);}',
                                    'yearRange' => "-60:+0",
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tgllahirbayi'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'jamlahir', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'jamlahir',
                                'mode' => 'time',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    //
                                    'onkeypress' => "js:function(){getUmur(this);}",
                                    'onSelect' => 'js:function(){getUmur(this);}',
                                    'yearRange' => "-60:+0",
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'jamlahir'); ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($model,'jamlahir',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php echo $form->textFieldRow($model, 'namabayi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Bayi Ny. ' . $modPasien->nama_pasien)); ?>
                    <?php //echo $form->textFieldRow($model,'jeniskelamin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); 
                    ?>
                    <?php echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php //echo $form->textFieldRow($model,'bb_gram',array('maxlength'=>3,'class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'tb_cm',array('maxlength'=>3, 'class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'bb_gram', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'bb_gram', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Gram</div><br>
                            <?php echo $form->error($model, 'bb_gram'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tb_cm', array('class' => 'control-label','label'=>'Panjang Badan')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'tb_cm', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>CM</div><br>
                            <?php echo $form->error($model, 'tb_cm'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Penilaian Bayi Baru Lahir', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($model, 'penilaianbayi_barulahir', array('Baik'=>'Baik','Ada'=>'Ada'), array('class'=>'penilaianbayi_barulahir','onchange'=>'changePenilaianBaruLahir()','onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="controls">
                            <label>Penyulit</label> <?php echo $form->textField($model, 'penilaianbbl_penyulit', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label">Bayi Lahir :</label>
                            <div class="controls">
                            </div>
                        </div>
                    <div class="pilih-cb">
                        
                        <div class="control-group checkbox">
                            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'bayilahir_is_normal', array()); ?> <label>Normal, tindakan :</label>
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
                                <div class="controls" style="padding-left:30px;">
                                    <?php
                                    echo $form->checkBox($model, 'detnormal[]bayilahir_normal_tindakan', array('checked' => !empty($model->bayilahir_normal_tindakan) ? true : false, 'uncheckValue' => null, 'value' => $n->lookup_value, 'style' => 'margin-left:0px !important;'));
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
                                <?php echo $form->checkBox($model, 'bayilahir_is_aspiksia', array()); ?> <label>Aspiksia</label>
                            </div>
                        </div>
                        <div class="control-group checkbox">
                            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                            <div class="controls" style="padding-left:30px; width: 80%">
                                <table width="50%">
                                <?php
                                    $lookup_aspiksia = LookupM::model()->findAllByAttributes(array('lookup_type'=>'tingkat_aspiksia'),array('order'=>'lookup_urutan ASC'));

                                    if(!empty($lookup_aspiksia)){
                                        $html_aspiksia = "";
                                        $ind_aspiksia = 1;
                                        foreach($lookup_aspiksia as $i => $look){
                                            $ischeck = false;
                                            
                                            if(!empty($model->tingkat_aspiksia)){
                                                if($model->tingkat_aspiksia == $look->lookup_value){
                                                    $ischeck = true;
                                                }
                                            }
                                            if($ind_aspiksia == 1){
                                                $html_aspiksia .= '<tr>';
                                            }
                                            $html_aspiksia .= '<td>';
                                            $html_aspiksia .= CHtml::activeRadioButton($model,'tingkat_aspiksia',array('class'=>'tingkat_aspiksia','value'=>$look->lookup_value,'uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")).' <label>'.$look->lookup_name.'</label>';
            
                                            $html_aspiksia .= '</td>';
                                            if($ind_aspiksia == 2){
                                                $html_aspiksia .= '<tr>';
                                                $ind_aspiksia = 0;
                                            }
                                            $ind_aspiksia++;
                                        }
                                        echo $html_aspiksia;
                                    }
                                ?>
                                </table>
                            </div>
                        </div>
                        <div class="control-group checkbox">
                            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                            <div class="controls" style="padding-left:30px;">
                                <label>Tindakan :</label>
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
                                <div class="controls" style="padding-left:30px;">
                                    <?php
                                    $model->bayilahir_aspiksia_tindakan = isset($getAsp[$a->lookup_value]) ? $getAsp[$a->lookup_value] : '';
                                    echo $form->checkBox($model, 'detaspiksia[]bayilahir_aspiksia_tindakan', array('checked' => !empty($model->bayilahir_aspiksia_tindakan) ? true : false, 'uncheckValue' => null, 'value' => $a->lookup_value, 'style' => 'margin-left:0px !important;', 'class' => (($a->lookup_name == 'Lain - Lain') ? 'adatext' : '')));
                                    ?>
                                    <label><?php echo $a->lookup_name . (($a->lookup_name == 'Lain - Lain') ? $form->textField($model, 'bayilahir_aspiksia_ketlainlain', array('class' => 'span3 txtlain', 'readonly' => true)) : ''); ?></label>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="control-group checkbox">
                            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'bayilahir_is_cacatbawaan', array('class' => 'adatext')); ?> <label>Cacat Bawaan, sebutkan</label>
                            </div>
                            <div class="controls">
                                <?php echo $form->textField($model, 'bayilahir_cacatbawaan_keterangan', array('class' => 'span3 txtlain', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group checkbox">
                            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'bayilahir_is_hiportemi', array('class' => 'adatext')); ?> <label>Hipotermi, tindakan :</label>
                                <br>
                                <?php echo $form->textArea($model, 'bayilahir_hiportemi_tindakan', array('class' => 'txtlain', 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php
                    if ($model->isNewRecord) {
                        echo $form->checkBoxRow($model, 'islahirtunggal', array('onkeypress' => "return $(this).focusNextInputField(event);"));
                    } else {
                        echo $form->checkBoxRow($model, 'islahirtunggal', array('disabled' => 'disabled', 'onkeypress' => "return $(this).focusNextInputField(event);", 'uncheckValue' => true));
                    } ?>
                    <?php echo $form->dropDownListRow($model, 'lahirkembar',  LookupM::getItems('lahirkembar'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));

                    ?>
                    <?php
                    echo CHtml::hiddenField('jmlkembar', $model->jmlkembar); ?>
                    <?php echo $form->textFieldRow($model, 'jmlkembar', array('onblur' => 'inputJumlahBayiKembar(this.value);', 'maxlength' => 3, 'class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($model, 'kelainanbayi', array('rows' => 3, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textAreaRow($model,'warnakulit',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textAreaRow($model,'denyutjantung',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textAreaRow($model,'aktivitasotot',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textAreaRow($model,'responrefleks',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textAreaRow($model,'pernapasan',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'interpretasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                    ?>
                    <?php echo $form->textAreaRow($model, 'catatan_bayi', array('rows' => 2, 'onkeypress' => "return $(this).focusNextInputField(event);"));
                    ?>
                    <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <div class="control-group">
                            <label class="control-label">Pemberian Asi :</label>
                        </div>
                    <div class="pilih-cb">
                        
                        <div class="control-group checkbox">
                            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButton($model, 'is_pemberianasi', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext', 'id' => 'yadiberi')); ?> <label>Ya, waktu :</label>
                            </div>
                            <div class="controls">
                                <?php echo $form->textField($model, 'waktu_pemberianasi', array('class' => 'span1 txtlain numbers-only', 'readonly' => true, 'id' => 'tidakdiberi')); ?>
                            </div>
                            <div class="controls">
                                <label>jam setelah lahir</label>
                            </div>
                        </div>
                        <div class="control-group checkbox">
                            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButton($model, 'is_pemberianasi', array('uncheckValue' => null, 'value' => false, 'class' => 'adatext')); ?> <label>Tidak, alasan</label>
                            </div>
                            <div class="controls">
                                <?php echo $form->textField($model, 'alasantidak_pemberianasi', array('class' => 'span3 txtlain', 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("Lingkar Perut", '', array('class' => 'control-label')) ?>
                        <?php //echo $form->labelEx($model, 'ld_cm', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'ld_cm', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>CM</div><br>
                            <?php echo $form->error($model, 'ld_cm'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'll_cm', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'll_cm', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>CM</div><br>
                            <?php echo $form->error($model, 'll_cm'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'lk_cm', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'lk_cm', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>CM</div><br>
                            <?php echo $form->error($model, 'lk_cm'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'masalah_lain', array('class' => 'control-label','label'=>'Masalah lain, sebutkan')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'masalah_lain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
                            ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'penatalaksanaan_masalahlain', array('class' => 'control-label','label'=>'Penatalaksanaan masalah tersebut')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textArea($model, 'penatalaksanaan_masalahlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
                            ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'hasilpenatalaksanaan_masalahlain', array('class' => 'control-label','label'=>'Hasilnya')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'hasilpenatalaksanaan_masalahlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
                            ?>

                        </div>
                    </div>

                </div>
                <div class="clear"></div>
                <br>
                <?php $this->renderPartial('_metodeappgard', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'model' => $model, 'appgards' => $appgards, 'model' => $model, 'form' => $form)); ?>
            </div>
        </div>

        <div id="jumlahBayiKembar">
            <?php
            $idx = 0;
            foreach ($modKelahiran as $item) {



                if ($item->kelahiranbayi_id != $model->kelahiranbayi_id) {


                    if (!empty($item->tb_cm)) {
                        $item->tb_cm = number_format($item->tb_cm, 2, ",", "");
                    }
                    if (!empty($item->ld_cm)) {
                        $item->ld_cm = number_format($item->ld_cm, 2, ",", "");
                    }
                    if (!empty($item->ll_cm)) {
                        $item->ll_cm = number_format($item->ll_cm, 2, ",", "");
                    }
                    if (!empty($item->lk_cm)) {
                        $item->lk_cm = number_format($item->lk_cm, 2, ",", "");
                    }

                    echo $this->renderPartial("_formKelahiranKembarModel", array('model' => $item, 'i' => $idx), true);
                    $idx++;
                }
            } ?>
        </div>

        <div class="form">
            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                ); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/daftarPasien/index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                ); ?>
                <?php
                $content = $this->renderPartial('../kelahiranbayiT/tips/transaksi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>

    <?php
    $js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
    Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
    ?>

    <?php Yii::app()->clientScript->registerScript('kembar', "
    $(document).ready(function(){
        var jmlkembar = $('#PSKelahiranbayiT_jmlkembar').val();
        if (jmlkembar > 1){
            $('#PSKelahiranbayiT_jmlkembar').attr('disabled','disabled');
            $('#PSKelahiranbayiT_lahirkembar').attr('disabled','disabled');
            $('#PSKelahiranbayiT_islahirtunggal').attr('disabled','disabled');
        }
        
        $('#PSKelahiranbayiT_jmlkembar').attr('disabled','disabled');
        $('#PSKelahiranbayiT_lahirkembar').attr('disabled','disabled');

        $('#PSKelahiranbayiT_islahirtunggal').change(function(){

           if (!($(this).is(':checked'))){
                
                $('#PSKelahiranbayiT_jmlkembar').removeAttr('disabled');
                $('#PSKelahiranbayiT_lahirkembar').removeAttr('disabled');
                inputJumlahBayiKembar($('#PSKelahiranbayiT_jmlkembar').val());
            }
            else{
                $('#PSKelahiranbayiT_jmlkembar').attr('disabled','disabled');
                $('#PSKelahiranbayiT_lahirkembar').attr('disabled','disabled');
                inputJumlahBayiKembar(1);
                               
            }
        });
    });
",  CClientScript::POS_BEGIN); ?>

    <script>
        function inputJumlahBayiKembar(jmlKembar) {
            var namaby = $('#PSKelahiranbayiT_namabayi').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('jumlahBayiKembar') ?>',
                dataType: "json",
                data: {
                    jmlKembar: jmlKembar,
                    namaby: namaby
                },
                success: function(data) {
                    if (data.sukses == 1) {
                        $("#jumlahBayiKembar").html(data.form);

                        $(".float2").unmaskMoney();
                        $(".float2").maskMoney({
                            "symbol": "",
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": "",
                            "precision": 2
                        });

                        $('.numbersOnly').keyup(function() {
                            setNumbersOnly(this);
                        });
                        //                            resetFormLain();
                        //                            renameInput($("#partograf-lainlain"));
                        pemberianAsi();
                        $('#jumlahBayiKembar').each(function() {
                            var obj_lahir = jQuery('input[name$="[tgllahirbayi]"]');
                            jQuery('input[name$="[tgllahirbayi]"]').datepicker(
                                jQuery.extend({
                                        showMonthAfterYear: false
                                    },
                                    jQuery.datepicker.regional['id'], {
                                        'dateFormat': 'dd M yy',
                                        'maxDate': 'd',
                                        'timeText': 'Waktu',
                                        'hourText': 'Jam',
                                        'minuteText': 'Menit',
                                        'secondText': 'Detik',
                                        'showSecond': true,
                                        'timeOnlyTitle': 'Pilih Waktu',
                                        'timeFormat': 'hh:mm:ss',
                                        'changeYear': true,
                                        'changeMonth': true,
                                        'showAnim': 'fold',
                                        'yearRange': '-80y:+20y'
                                    }
                                )
                            );

                            jQuery(obj_lahir).parent().find('.add-on').click(function() {
                                $(this).parent().find('input').focus();
                            });
                        });
                        $('#jumlahBayiKembar').each(function() {

                            var obj_jam = jQuery('input[name$="[jamlahir]"]');

                            jQuery('input[name$="[jamlahir]"]').timepicker(
                                jQuery.extend({
                                        showMonthAfterYear: false
                                    },
                                    jQuery.datepicker.regional['id'], {
                                        'dateFormat': 'dd M yy',
                                        'maxDate': 'd',
                                        'timeText': 'Waktu',
                                        'hourText': 'Jam',
                                        'minuteText': 'Menit',
                                        'secondText': 'Detik',
                                        'showSecond': true,
                                        'timeOnlyTitle': 'Pilih Waktu',
                                        'timeFormat': 'hh:mm:ss',
                                        'changeYear': true,
                                        'changeMonth': true,
                                        'showAnim': 'fold',
                                        'yearRange': '-80y:+20y'
                                    }
                                )
                            );
                            jQuery(obj_jam).parent().find('.add-on').click(function() {
                                $(this).parent().find('input').focus();
                            });
                        });

                    } else {
                        toastr.error(data.pesan);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

        function pemberianAsi() {
            $(".pilih-cbasi").find('input:radio').click(function() {
                $(this).parents(".pilih-cbasi").find('.txtlain').each(function() {

                    if ($(this).parents(".control-group").find('.adatext').prop("checked") == false) {
                        $(this).attr('readonly', true);
                        $(this).val('');
                    }
                });
                if ($(this).prop("checked") == true) {
                    if ($(this).hasClass('adatext')) {
                        $(this).parents(".control-group").find('.txtlain').removeAttr('readonly');
                        $(this).parents(".control-group").find('.txtlain').val('');
                    }
                } else {
                    $(this).parents(".control-group").find('.txtlain').val('');
                }
            });
            $(".pilih-cbasi").find('input:checkbox').click(function() {
                $(this).parents(".pilih-cbasi").find('.txtlain').each(function() {
                    if ($(this).parents(".control-group").find('.adatext').prop("checked") == false) {
                        $(this).attr('readonly', true);
                    }
                });
                if ($(this).prop("checked") == true) {
                    if ($(this).hasClass('adatext')) {
                        $(this).parents(".control-group").find('.txtlain').removeAttr('readonly');
                        $(this).parents(".control-group").find('.txtlain').val('');
                    }
                } else {
                    $(this).parents(".control-group").find('.txtlain').val('');
                }
            });

            $(".pilih-cbasi").find('input:radio.adatext, input:checkbox.adatext').each(function() {
                if ($(this).prop("checked") == true) {
                    $(this).parents('.control-group').find('.txtlain').removeAttr('readonly');
                }
            });

            $('.apgar_menit').keyup(function() {
                cekMenit($(this));
            });

            $('.apgar').change(function() {
                $(this).parent().parent().css('background', '#B5C1D7');
            });
        }


        $(document).ready(function() {

            $(".pilih-cb").find('input:checkbox').click(function() {
                $(this).parents(".pilih-cb").find('.txtlain').each(function() {
                    if ($(this).parents(".control-group").find('.adatext').prop("checked") == false) {
                        $(this).attr('readonly', true);
                    }
                });
                if ($(this).prop("checked") == true) {
                    if ($(this).hasClass('adatext')) {
                        $(this).parents(".control-group").find('.txtlain').removeAttr('readonly');
                        $(this).parents(".control-group").find('.txtlain').val('');
                    }
                } else {
                    $(this).parents(".control-group").find('.txtlain').val('');
                }
            });

            $(".pilih-cb").find('input:radio').click(function() {
                $(this).parents(".pilih-cb").find('.txtlain').each(function() {

                    if ($(this).parents(".control-group").find('.adatext').prop("checked") == false) {
                        $(this).attr('readonly', true);
                        $(this).val('');
                    }
                });
                if ($(this).prop("checked") == true) {
                    if ($(this).hasClass('adatext')) {
                        $(this).parents(".control-group").find('.txtlain').removeAttr('readonly');
                        $(this).parents(".control-group").find('.txtlain').val('');
                    }
                } else {
                    $(this).parents(".control-group").find('.txtlain').val('');
                }
            });


            $(".pilih-cb").find('input:radio.adatext, input:checkbox.adatext').each(function() {
                if ($(this).prop("checked") == true) {
                    $(this).parents('.control-group').find('.txtlain').removeAttr('readonly');
                }
            });

            pemberianAsi();

            $(".float2").maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ",",
                "thousands": "",
                "precision": 2
            });

            changePenilaianBaruLahir();
        });



        function hapusApgar(obj, kelahiranbayi_id, menitke) {
            myConfirm("Anda yakin untuk menghapus data Apgar ini?", "Peringatan", function(r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('hapusApgar'); ?>', {
                        id: kelahiranbayi_id,
                        menitke: menitke
                    }, function(data) {
                        if (data.ok == 1) {
                            myAlert(data.msg);
                            $(obj).parent().parent().remove();
                        } else {
                            myAlert(data.msg);
                        }
                    }, 'json');
                }
            });
        }
        
        function changePenilaianBaruLahir(){
            $('.penilaianbayi_barulahir').each(function(){
                if($(this).prop('checked')==true && $(this).val() == 'Ada'){
                    $('#<?php echo CHtml::activeId($model,'penilaianbbl_penyulit') ?>').attr('readonly',false);
                }else{
                    $('#<?php echo CHtml::activeId($model,'penilaianbbl_penyulit') ?>').attr('readonly',true);
                    $('#<?php echo CHtml::activeId($model,'penilaianbbl_penyulit') ?>').val('');
                }
            });
        }
    </script>