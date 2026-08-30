<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modPemakaian, 'norekammedis', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modPemakaian,'norekammedis',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemakaian,'noidentitas',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    <?php echo $form->textFieldRow($modPemakaian,'namapasien',array('class'=>'span3 reqPasien', 'onchange'=>'clearDataPasien();' ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>

    <?php echo CHtml::activeHiddenField($modPemakaian,'pasien_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::activeHiddenField($modPemakaian,'pendaftaran_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::activeHiddenField($modPemakaian,'pesanambulans_t',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

    <?php echo $form->textFieldRow($modPemakaian,'tempattujuan',array('class'=>'span3 reqPasien', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    <?php echo $form->textAreaRow($modPemakaian,'alamattujuan',array('class'=>'span3 reqPasien', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($modPemakaian,'kelurahan_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPemakaian,'rt_rw', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPemakaian,'rt',array('class'=>'span1 numbers-only reqPasien', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3)); ?> /
           <?php echo $form->textField($modPemakaian,'rw',array('class'=>'span1 numbers-only reqPasien', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3)); ?>
            <?php echo $form->error($modPemakaian, 'rt_rw'); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemakaian,'nomobile',array('class'=>'span3 numbers-only reqPasien', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    <?php echo $form->textFieldRow($modPemakaian,'notelepon',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
<?php echo CHtml::hiddenField('ispilihtarif'); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPemakaian, 'supir_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPemakaian,'supir_id',array('readonly'=>true, 'class'=>'span3 reqPasien', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'supir_nama',
                                'value'=>$modPemakaian->supir_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteSupir').'",
                                                   dataType: "json",
                                                   data: {
                                                       supir_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            $("#BKPemakaianambulansT_supir_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogSupir'),
                                'htmlOptions'=>array('placeholder'=>'nama supir','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'Ketik nama supir / klik icon untuk mencari data supir',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",       
                                    'onblur'=>'if(this.value === ""){ $("#'.CHtml::activeId($modPemakaian,'supir_id').'").val(""); }'
                                    ),
                            ));
            
            ?>
            <?php echo $form->error($modPemakaian, 'supir_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPemakaian, 'pelaksana_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPemakaian,'pelaksana_id',array('readonly'=>true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php // echo $form->textField($modPemakaian,'pelaksana_nama',array('readonly'=>true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
//                echo CHtml::htmlButton('<i class="entypo-search"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogPelaksana').dialog('open');",
//                    'id' => 'btnAddPelaksana', 'onkeyup' => "return $(this).focusNextInputField(event)",
//                    'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('pelaksana_id')))
            ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'pelaksana_nama',
                                'value'=>$modPemakaian->pelaksana_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteSupir').'",
                                                   dataType: "json",
                                                   data: {
                                                       supir_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            $("#BKPemakaianambulansT_pelaksana_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPelaksana'),
                                'htmlOptions'=>array('placeholder'=>'nama pelaksana','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'Ketik nama pelaksana / klik icon untuk mencari data pelaksana',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                    'onblur'=>'if(this.value === "") { $("#'.CHtml::activeId($modPemakaian,'pelaksana_id').'").val(""); }',
                                    ),
                            ));
            
            ?>
            <?php echo $form->error($modPemakaian, 'pelaksana_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPemakaian, 'paramedis1_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPemakaian,'paramedis1_id',array('readonly'=>true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php // echo $form->textField($modPemakaian,'paramedis1_nama',array('readonly'=>true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
//                echo CHtml::htmlButton('<i class="entypo-search"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogParamedis').dialog('open');$('#dialogParamedis #paramedisKe').val(1);",
//                    'id' => 'btnAddParamedis1', 'onkeyup' => "return $(this).focusNextInputField(event)",
//                    'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('paramedis1_id')))
            ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'paramedis1_nama',
                                'value'=>$modPemakaian->paramedis1_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteParamedis').'",
                                                   dataType: "json",
                                                   data: {
                                                       paramedis_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            $("#BKPemakaianambulansT_paramedis1_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogParamedis1'),
                                'htmlOptions'=>array('placeholder'=>'nama paramedis 1','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'Ketik nama paramedis / klik icon untuk mencari data paramedis',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'onblur'=>'if(this.value === ""){ $("#'.CHtml::activeId($modPemakaian,'paramedis1_id').'").val(""); } '
                                    ),
                            ));
            
            ?>
            <?php echo $form->error($modPemakaian, 'paramedis1_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPemakaian, 'paramedis2_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPemakaian,'paramedis2_id',array('readonly'=>true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php // echo $form->textField($modPemakaian,'paramedis2_nama',array('readonly'=>true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
//                echo CHtml::htmlButton('<i class="entypo-search"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogParamedis').dialog('open');$('#dialogParamedis #paramedisKe').val(2);",
//                    'id' => 'btnAddParamedis2', 'onkeyup' => "return $(this).focusNextInputField(event)",
//                    'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('paramedis2_id')))
            ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'paramedis2_nama',
                                'value'=>$modPemakaian->paramedis2_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteParamedis').'",
                                                   dataType: "json",
                                                   data: {
                                                       paramedis_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            $("#BKPemakaianambulansT_paramedis2_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogParamedis2'),
                                'htmlOptions'=>array('placeholder'=>'nama paramedis 2','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'Ketik nama paramedis / klik icon untuk mencari data paramedis',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                    'onblur'=>'if(this.value === "")$("#'.CHTml::activeId($modPemakaian, 'paramedis2_id').'").val("");'
                                    ),
                            ));
            
            ?>
            <?php echo $form->error($modPemakaian, 'paramedis2_id'); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Pemakaian Ambulans', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans); ?>
            <?php $this->widget('MyDateTimePicker',array(
                    'model'=>$modPemakaian,
                    'attribute'=>'tglpemakaianambulans',
                    'mode'=>'datetime',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                        //'minDate' => 'd',
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3 dtPicker2-5'),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Kembali Ambulans', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                    'model'=>$modPemakaian,
                    'attribute'=>'tglkembaliambulans',
                    'mode'=>'datetime',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                        'minDate' => 'd',
                    ),
                    'htmlOptions'=>array('readonly'=>false,'class'=>'span3 dtPicker2-5'),
                )); 
            ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemakaian,'namapj',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>                
    <?php echo $form->dropDownListRow($modPemakaian,'hubunganpj', LookupM::getItems('hubungankeluarga'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --')); ?>
    <?php echo $form->textAreaRow($modPemakaian,'alamatpj',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textAreaRow($modPemakaian,'untukkeperluan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modPemakaian, 'Ruangan <span style=color:red>*</span>', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::dropDownList('instalasi', $instalasi, CHtml::listData($modInstalasi, 'instalasi_id', 'instalasi_nama'),
                                            array('empty' =>'-- Instalasi --',
                                                'ajax'=>array('type'=>'POST',
                                                'url'=>  CController::createUrl('dynamicRuangan'),
                                                'update'=>'#BKPemakaianambulansT_ruangan_id',),'class'=>'span2')); ?>
            <?php echo CHtml::activeDropDownList($modPemakaian, 'ruangan_id',  CHtml::listData(RuanganM::model()->getRuanganByInstalasi($instalasi),'ruangan_id','ruangan_nama'),array('empty' =>'-- Ruangan --','class'=>'span2')); ?>
        </div>
    </div>
    <fieldset>
        <div class="control-group">
            <?php echo $form->labelEx($modPemakaian, 'mobilambulans_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPemakaian,'mobilambulans_id',array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php // echo $form->textField($modPemakaian,'mobilambulans_nama',array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php
//                    echo CHtml::htmlButton('<i class="entypo-search"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogKendaraan').dialog('open');",
//                        'id' => 'btnAddParamedis2', 'onkeyup' => "return $(this).focusNextInputField(event)",
//                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('mobilambulans_id')))
                ?>
                <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'mobilambulans_nama',
                                'value'=>$modPemakaian->mobilambulans_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKendaraan').'",
                                                   dataType: "json",
                                                   data: {
                                                       mobilambulans_kode: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 3,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            $("#BKPemakaianambulansT_mobilambulans_id").val(ui.item.mobilambulans_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogKendaraan'),
                                'htmlOptions'=>array('placeholder'=>'kode kendaraan','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'Ketik kode kendaraan / klik icon untuk mencari data kendaraan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",    
                                    'onblur'=>'if(this.value===""){ $("#'.CHtml::activeId($modPemakaian,'mobilambulans_id').'").val(""); }'
                                    ),
                            ));
            
            ?>
                <?php echo $form->error($modPemakaian, 'mobilambulans_id'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemakaian, 'kmawal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPemakaian,'kmawal',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->error($modPemakaian, 'kmawal'); ?> s/d <span style="font-size:11px;"><?php echo $modPemakaian->getAttributeLabel('kmakhir'); ?></span>
                <?php echo $form->textField($modPemakaian,'kmakhir',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->error($modPemakaian, 'kmakhir'); ?>
            </div>
        </div>    
        <?php echo $form->textFieldRow($modPemakaian,'jmlbbmliter',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>  
    </fieldset>
</div>