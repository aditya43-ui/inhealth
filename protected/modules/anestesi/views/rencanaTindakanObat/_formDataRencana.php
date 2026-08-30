<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($modPraAnestesi, 'tglpraanestesi', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                $modPraAnestesi->tglpraanestesi = (!empty($modPraAnestesi->tglpraanestesi) ? date("d/m/Y H:i:s", strtotime($modPraAnestesi->tglpraanestesi)) : date("d/m/Y H:i:s"));
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPraAnestesi,
                    'attribute' => 'tglpraanestesi',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker3 datetimemask	',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::activelabel($modPraAnestesi, 'Dokter Anestesi <font style="color:red;">*</font>', array(
                'class' => 'control-label required'))
            ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($modPraAnestesi, 'dokter_id', CHtml::listData($modPraAnestesi->DokterItems, 'pegawai.pegawai_id', 'pegawai.NamaLengkap'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
        <div class="control-group "> 
                <?php echo CHtml::label('Asisten Anestesi', 'Asisten_Anestesi', array('class' => 'control-label')); ?>
            <div class="controls">
<?php
echo $form->dropDownList($modPraAnestesi, 'perawat1_id', CHtml::listData($modPraAnestesi->ParamedisItems, 'pegawai.pegawai_id', 'pegawai.NamaLengkap'), array(
    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
    'maxlength' => 100));
?>
            </div>
        </div>
        <div class="control-group "> 
                <?php echo CHtml::label('Penata Anestesi', 'Penata_Anestesi', array(
                    'class' => 'control-label'));
                ?>
<?php //echo $form->label($modPraAnestesi, 'perawat2_id', array('class' => 'control-label'))  ?>
            <div class="controls">
            <?php
            echo $form->dropDownList($modPraAnestesi, 'perawat2_id', CHtml::listData($modPraAnestesi->ParamedisItems, 'pegawai.pegawai_id', 'pegawai.NamaLengkap'), array(
                'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                'maxlength' => 100));
            ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->label($model, 'typeanastesi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'typeanastesi_id', CHtml::listData($modPraAnestesi->TypeAnestesiItems, 'typeanastesi_id', 'typeanastesi_nama'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
        <div class='control-group'>
                <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($modPraAnestesi, 'ruangan_id'), array(
                    'class' => 'control-label required'))
                ?>                                   
            <div class='controls'>
<?php
echo $form->dropDownList($modPraAnestesi, 'ruangan_id', CHtml::listData($modPraAnestesi->getRuanganInstalasiItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'), array(
    'empty' => '-- Pilih --',
    'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
    'ajax' => array(
        'type' => 'POST',
        'url' => $this->createUrl('SetDropdownKamarKosong', array('encode' => false, 'namaModel' => get_class($modPraAnestesi))),
        'update' => '#' . CHtml::activeId($modPraAnestesi, 'kamarruangan_id'),
)));
?>  
            </div>
        </div>

        <div class="control-group">
<?php echo CHtml::activelabel($modPraAnestesi, 'Kamar Ruangan <font style="color:red;">*</font>', array(
    'class' => 'control-label required'));
?>
            <div class='controls'>
            <?php
            echo $form->dropDownList($modPraAnestesi, 'kamarruangan_id', !empty($modPraAnestesi->ruangan_id) ? CHtml::listData(KamarruanganM::model()->findAllByAttributes(array(
                                        'ruangan_id' => $modPraAnestesi->ruangan_id, 'kamarruangan_status' => true)), 'kamarruangan_id', 'KamarDanTempatTidur') : array(), array(
                'empty' => '-- Pilih --',
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span2',
            ));
            ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
                <?php echo $form->labelEx($modPraAnestesi, 'tglpuasa', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPraAnestesi,
                    'attribute' => 'tglpuasa',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker3',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
                <?php echo $form->label($modPraAnestesi, 'tekniksedasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($modPraAnestesi, 'tekniksedasi', LookupM::getItems('tekniksedasi'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
        <div class="control-group ">
                <?php echo $form->labelEx($modPraAnestesi, 'monitoring', array(
                    'class' => 'control-label'))
                ?>
            <div class="controls">
                <?php
                $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                    'model' => $modPraAnestesi,
                    'attribute' => 'monitoring',
                    'data' => explode(',', $modPraAnestesi->monitoring),
                    'debugMode' => true,
                    'options' => array(
                        //'bricket'=>false,
                        'json_url' => $this->createUrl('MasterMonitoring'),
                        'addontab' => true,
                        'maxitems' => 10,
                        'input_min_size' => 0,
                        'cache' => true,
                        'newel' => true,
                        'addoncomma' => true,
                        'select_all_text' => "",
                        'autoFocus' => true,
                    ),
                ));
                ?>
                <?php echo $form->error($modPraAnestesi, 'monitoring'); ?>
            </div>
        </div>
                <?php echo $form->textAreaRow($modPraAnestesi, 'ketpraanestesi', array('class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
        <h6 style="color:#000000;">Perawatan Pasca Anestesia</h6>
        <div class="control-group ">
                <?php echo $form->label($modPraAnestesi, 'instalasipasca_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($modPraAnestesi, 'instalasipasca_id', CHtml::listData($modPraAnestesi->InstalasiItems, 'instalasi_id', 'instalasi_nama'), array(
                    'empty' => '-- Pilih --',
                    'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropDownRuangan', array('encode' => false, 'namaModel' => get_class($modPraAnestesi))),
                        'update' => '#' . CHtml::activeId($modPraAnestesi, 'ruanganpasca_id'),
                )));
                ?>
            </div>
        </div>
        <div class="control-group ">
<?php echo $form->label($modPraAnestesi, 'ruanganpasca_id', array('class' => 'control-label')) ?>
            <div class="controls">
<?php
echo $form->dropDownList($modPraAnestesi, 'ruanganpasca_id', !empty($modPraAnestesi->instalasipasca_id) ? CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => $modPraAnestesi->instalasipasca_id, 'ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama') : array(), array(
    'empty' => '-- Pilih --',
    'onkeypress' => "return $(this).focusNextInputField(event)",
    'class' => 'span2',
));
?>
            </div>
        </div>
    </div>
</div>
