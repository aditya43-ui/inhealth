<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Anamnesa',
    );
    $this->widget('bootstrap.widgets.BootAlert');
    $this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));

    $this->renderPartial('/_tabulasi', array('modPendaftaran'=>$modPendaftaran));
    ?>
    <div class="biru">
        <div class="white">
            <?php
            $this->widget('application.extensions.moneymask.MMask',array(
                'element'=>'.number',
                'config'=>array(
                    'defaultZero'=>true,
                    'allowZero'=>true,
                    'decimal'=>',',
                    'thousands'=>'.',
                    'precision'=>0,
                )
            ));
            ?>
            <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                    'id'=>'rjpemeriksaan-fisik-t-form',
                    'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                    'focus'=>'#',
            )); ?>
            <style>
                .groupUkurans{
                    display:inline;
                }
            </style>
            <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
            <?php echo $form->errorSummary($modPemeriksaanFisik); ?>
            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                        <?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'frame'=>true)),array('readonly'=>TRUE));?>
                        <?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>
                        <?php echo $form->labelEx($modPemeriksaanFisik,'tglperiksafisik', array('class'=>'control-label')) ?>
                        <div class="controls">  
                        <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modPemeriksaanFisik,
                                             'attribute'=>'tglperiksafisik',
                                             'mode'=>'datetime',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                             'maxDate'=>'d',   
                                                 ),
                                             'htmlOptions'=>array('readonly'=>true, 'class'=>'dtPicker3',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
                          </div> 
                            <?php //echo $form->textFieldRow($modPemeriksaanFisik,'keadaanumum',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>                    
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemeriksaanFisik, 'keadaanumum', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                            'model'=>$modPemeriksaanFisik,
                                            'attribute'=>'keadaanumum',
                                            'data'=> explode(',', $modPemeriksaanFisik->keadaanumum),   
                                            'debugMode'=>true,
                                            'options'=>array(
                                                //'bricket'=>false,
                                                'json_url'=>$this->createUrl('MasterKeadaanUmum'),
                                                'addontab'=> true, 
                                                'maxitems'=> 10,
                                                'input_min_size'=> 0,
                                                'cache'=> true,
                                                'newel'=> true,
                                                'addoncomma'=>true,
                                                'select_all_text'=> "", 
                                            ),
                                        ));
                                    ?>
                                    <?php echo $form->error($modPemeriksaanFisik, 'keadaanumum'); ?>
                                </div>
                            </div>
                    </td>
                    <td>
                          <?php echo $form->dropDownListRow($modPemeriksaanFisik,'pegawai_id',CHtml::listData($modPemeriksaanFisik->Dokter, 'pegawai_id', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",));?>
                          <?php // echo $form->dropDownListRow($modPemeriksaanFisik,'paramedis_nama',CHtml::listData(ParamedisV::model()->findAll(), 'nama_pegawai', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",));?>
                          <?php echo $form->dropDownListRow($modPemeriksaanFisik,'paramedis_nama', CHtml::listData($modPemeriksaanFisik->ParamedisItems, 'pegawai.nama_pegawai', 'pegawai.nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                         <!--<div class="control-group">
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'paramedis_nama',array('class'=>'control-label'));?>
                            <div class="controls">
                                <?php $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$modPemeriksaanFisik,
                                        'attribute'=>'paramedis_nama',
                                        'value'=>'',
                                        'sourceUrl'=> $this->createUrl('Paramedis'),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 2,
                                           'focus'=> 'js:function( event, ui ) {
                                                $(this).val( ui.item.label);
                                                return false;
                                            }',
                                        ),
                            )); ?>
                            </div>
                        </div> 
-->
                    </td>
                </tr>

            </table>        
            <style>
                .hoveringIcon:hover{
                    background-color: #FFA0A2;
                    cursor: pointer;
                    -webkit-border-radius:1px;
                    -moz-border-radius:1px;
                    -o-border-radius:1px;
                    -border-radius:1px;
                }
            </style>
            <legend class="rim">Tanda Vital</legend>
            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                                            <div class="control-group">
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'tekanandarah',array('class'=>'control-label'));?>
                            <div class="controls">
                                <?php
                                    $modPemeriksaanFisik->tekanandarah = empty($modPemeriksaanFisik->tekanandarah) ? "000 / 000" : $modPemeriksaanFisik->tekanandarah;
                                    $this->widget('CMaskedTextField', array(
                                    'model' => $modPemeriksaanFisik,
                                    'attribute' => 'tekanandarah',
                                    'mask' => '999 / 999',
                                    'placeholder'=>'000 / 000',
                                    'htmlOptions' => array('readonly'=>true, 'class'=>'span2', 'style'=>'width:60px;','onkeypress'=>"return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                                    ));
                                    ?>
                                 <?php //echo $form->textField($modPemeriksaanFisik,'tekanandarah',array('class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
                             /MmHg <?php echo "    ";?>
                             <?php
                                    $this->widget('CMaskedTextField', array(
                                    'model' => $modPemeriksaanFisik,
                                    'attribute' => 'td_systolic',
                                    'mask' => '999',
                                    'placeholder'=>'0',
                                    'htmlOptions' => array('class'=>'span1 number systolic', 'onkeypress'=>"return $(this).focusNextInputField(event)",'onkeyup'=>'returnValue(this); getText();') // change(this); getTekananDarah(this) change(this);getText();
                                    ));
                                    ?>Mm
                                    <?php // echo $form->textField($modPemeriksaanFisik,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 number numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));?>
                             <?php
                                    $this->widget('CMaskedTextField', array(
                                    'model' => $modPemeriksaanFisik,
                                    'attribute' => 'td_diastolic',
                                    'mask' => '999',
                                    'placeholder'=>'0',
                                    'htmlOptions' => array('class'=>'span1 number diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'onkeyup'=>'returnValue(this); getText();') //getTekananDarah(this); ,'onkeyup'=>'getText();'
                                    ));
                                    ?>Hg
                             <?php // echo $form->textField($modPemeriksaanFisik,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));?>

                            </div>
                        </div>
                        <div class="control-group">

                            <div class="controls">
                                 <?php echo CHtml::textField('tekananDarah','', array('class'=>'span3 ', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                            </div>
                        </div>
                                            <div class="control-group">
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'meanarteripressure',array('class'=>'control-label'));?>
                            <div class="controls">
                                 <?php echo $form->textField($modPemeriksaanFisik,'meanarteripressure',array('readonly'=>true, 'class'=>'span2 number numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'detaknadi',array('label'=>'<i class="icon-facetime-video hoveringIcon" onclick="getfromDevice();"></i> Detak Nadi','class'=>'control-label'));?>
                            <div class="controls">
                                 <?php echo $form->textField($modPemeriksaanFisik,'detaknadi',array('class'=>'span2 number numbersOnly', 'maxlength'=>10, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                             /Menit
                            </div>
                        </div>
                                            <div class="control-group">
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'denyutjantung',array('label'=>'<i class="icon-facetime-video hoveringIcon" onclick="getfromDevice();"></i> Denyut Jantung','class'=>'control-label'));?>
                            <div class="controls">
                            <?php
                            echo $form->dropDownList($modPemeriksaanFisik, 'denyutjantung', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>Params::LOOKUPTYPE_DENYUTJANTUNG)), 'lookup_value', 'lookup_name'), array('empty'=>'-- Pilih --'));
                            ?>
                            </div>
                       </div>
                                            <div class="control-group">
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'pernapasan',array('class'=>'control-label'));?>
                            <div class="controls">
                                 <?php echo $form->textField($modPemeriksaanFisik,'pernapasan',array('class'=>'span2 number numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
                             /Menit
                            </div>
                        </div>

                    </td>
                    <td>
                                            <div class="control-group">
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'suhutubuh',array('class'=>'control-label'));?>
                            <div class="controls">
                                 <?php echo $form->textField($modPemeriksaanFisik,'suhutubuh',array('class'=>'span2 number numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
                             &#176 Celcius
                            </div>
                        </div>
                         <div class="control-group">
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'tinggibadan_cm',array('class'=>'control-label','style'=>'width:75px'));?>
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'beratbadan_kg',array('class'=>'control-label','style'=>'width:80px'));?>
                            <div class="controls">
                                <div class="groupUkurans">
                                    <?php echo $form->textField($modPemeriksaanFisik,'tinggibadan_cm',array('class'=>'span1 number numbersOnly tinggibadan', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                                    <?php echo $form->hiddenField($modPemeriksaanFisik,'tinggibadan_cm',array('class'=>'span1 number numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                                    <?php echo CHtml::dropDownList('meter', '100', array('100'=>'Cm', '0.01'=>'M'), array('style'=>'width:50px;','class'=>'span1', 'onchange'=>'gantiJumlah(this)')); ?>
                                </div>
                                <div class="groupUkurans">
                                 <?php echo $form->textField($modPemeriksaanFisik,'beratbadan_kg',array('class'=>'span1 number numbersOnly beratbadan', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                                 <?php echo $form->hiddenField($modPemeriksaanFisik,'beratbadan_kg',array('class'=>'span1 number numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                                 <?php echo CHtml::dropDownList('gram', '0.001', array('1000'=>'Gr', '0.001'=>'Kg'), array('class'=>'span1', 'onchange'=>'gantiJumlah(this)')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->LabelEx($modPemeriksaanFisik,'bb_ideal',array('class'=>'control-label'));?>
                            <div class="controls">
                                 <?php echo $form->textField($modPemeriksaanFisik,'bb_ideal',array('class'=>'span2 number numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10, 'readonly'=>true)).' ';?>Kg
                            </div>
                        </div>
                        <div class="control-group">
                            <label class='control-label'>Index Masa Tubuh</label>
                            <div class="controls">
                                 <?php echo CHtml::textField('imtValue', '', array('readonly'=>true, 'class'=>'span1'));?>
                                 <?php echo CHtml::textField('imt', '', array('readonly'=>true, 'class'=>'span2'));?>
                            </div>
                        </div>

                        <?php echo $form->textFieldRow($modPemeriksaanFisik,'kelainanpadabagtubuh',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                    </td>
                </tr>
            </table>
            <fieldset>
                <legend class="rim">Thorax</legend>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td>
                            <?php echo $form->textFieldRow($modPemeriksaanFisik,'inspeksi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                            <?php echo $form->textFieldRow($modPemeriksaanFisik,'palpasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->textFieldRow($modPemeriksaanFisik,'perkusi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                            <?php echo $form->textFieldRow($modPemeriksaanFisik,'auskultasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset class="">
                <legend class="accord1" style="width:460px;">
                                 <?php echo CHtml::checkBox('pemeriksaanFisik',false, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?> Bagian Yang Diperiksa

                </legend>
                    <div id="divBagianYAngDiperiksa" class="toggle control-group" style="display: none">

                    <table style="width: 100%; border: none;">
                        <tr>
                            <td>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'kulit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'mata',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'hidung',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'tenggorokan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'jantung',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'kepala',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'telinga',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'leher',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'payudara',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textAreaRow($modPemeriksaanFisik,'abdomen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </td>
                        </tr>    
                    </table>
                    </div>       
            </fieldset>
            <fieldset class="">
                <legend class="rim" style="width:452px;">Glasgow Coma Scale
                    <?php echo CHtml::link('<i class="icon-chevron-right" style="cursor:pointer;"></i>', '', array('onclick'=>"$('#dialogGCS').dialog('open')", 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                </legend>
                    <div id="divGlowComoScale" style="display: block">
                        <table  style='margin-left:-70px;'>
                            <tr>
                                <?php $crit = new CDbCriteria();
                                $crit->compare('LOWER(metodegcs_singkatan)',"e");
                                $crit->addCondition('metodegcs_nilai is not null');
                                $crit->order = 'metodegcs_nilai ASC';
                                ?>
                                <!--<td><?php echo  CHtml::button('Gunakan Metode GCS',array('class'=>'btn btn-info','onclick'=>"$('#dialogGCS').dialog('open')", 'onkeypress'=>"return $(this).focusNextInputField(event);"));?></td>-->
                                <td><?php echo $form->dropDownListRow($modPemeriksaanFisik,'gcs_eye',  
                                        CHtml::listData(PPMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?></td>
                                <td><?php 
                                $crit2 = new CDbCriteria();
                                $crit2->compare('LOWER(metodegcs_singkatan)',"m");
                                $crit2->addCondition('metodegcs_nilai is not null');
                                $crit2->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownListRow($modPemeriksaanFisik,'gcs_motorik',
                                        CHtml::listData(PPMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?></td>
                                <td><?php 
                                $crit3 = new CDbCriteria();
                                $crit3->compare('LOWER(metodegcs_singkatan)',"v");
                                $crit3->addCondition('metodegcs_nilai is not null');
                                $crit3->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownListRow($modPemeriksaanFisik,'gcs_verbal',
                                        CHtml::listData(PPMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?></td>
                                <td><?php echo $form->hiddenField($modPemeriksaanFisik,'gcs_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                                    <?php echo CHtml::textField('namaGCS',(isset($modPemeriksaanFisik->gcs->gcs_nama) ? $modPemeriksaanFisik->gcs->gcs_nama : "-"),array('disabled'=>true,'class'=>'span2')); ?>
                                </td>
                            </tr>
                        </table>
                 <?php  $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>'dialogGCS',
                        'options'=>array(
                            'title'=>'',
                            'autoOpen'=>false,
                            'width'=>600,
                            'height'=>650,
                            'modal'=>false,
                            //'hide'=>'explode',
                            'resizelable'=>false,
                        ),
                    ));

                    ?>       
                    <table>
                    <?php foreach ($modRJMetodeGSCM AS $i=>$item):
                        if($item->metodegcs_nilai==''){
                            echo "<tr bgcolor='#E5ECF9'>
                                    <td>".$item->metodegcs_nama."</td>
                                    <td>&nbsp;</td>    
                                  </tr>";
                        }else{
                              echo "<tr>
                                    <td>".$item->metodegcs_nama."</td>
                                    <td><div id=\"divTombol\">".CHtml::button($item->metodegcs_nilai,array('class'=>'btn btn-prymari',
                                                                                     'onclick'=>'SetNilai(this)',
                                                                                     'id'=>$item->metodegcs_singkatan,
                                                                                     ))."</div></td>    
                                  </tr>";
                        }
                        endforeach;?>
                    </table>
                    <?php $this->endWidget();?>

                    </div>       
            </fieldset>
            <div class="form-actions">
                <?php echo CHtml::htmlButton($modPemeriksaanFisik->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                 array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')).'&nbsp;'; 
                 if($modPemeriksaanFisik->isNewRecord){
                     echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                 }else{
                     echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printPemeriksaanFisik();return false",'disabled'=>FALSE  ));
                 }

                 ?>
		<?php 
		   $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
		       $this->widget('UserTips',array('type'=>'admin','content'=>$content));
		?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
$diastolic = CHtml::activeId($modPemeriksaanFisik, 'td_diastolic');
$js = <<< JS
//Di komen karna menggunakan onkeyup = returnValue
//if ($('#${diastolic}').val().length == 2){
//    $('#${diastolic}').val('0'+$('#${diastolic}').val());
//};
//    $('#${diastolic}').blur(function(){
//    var jumlahPanjang = $(this).val().length;
//    var tambah = '';
//    for (i=jumlahPanjang; i<3;i++){
//        tambah = tambah+'0';
//    }
//    $(this).val(tambah+$(this).val());
//    change($(this));
//});

   $('#namaGCS').attr('value','Hasil Metode GCS');
$('#pemeriksaanFisik').change(function(){
        if ($(this).is(':checked')){
                $('#divBagianYAngDiperiksa input').removeAttr('disabled');
                $('#divBagianYAngDiperiksa select').removeAttr('disabled');
        }else{
                $('#divBagianYAngDiperiksa input').attr('disabled','true');
                $('#divBagianYAngDiperiksa select').attr('disabled','true');
                $('#divBagianYAngDiperiksa input').attr('value','');
                $('#divBagianYAngDiperiksa select').attr('value','');
        }
        $('#divBagianYAngDiperiksa').slideToggle(500);
    });
//===============Awal untu Mengecek Form Sudah DiUbah Atw Belum====================    
    $(":input").keyup(function(event){
            $('#berubah').val('Ya');
         });
    $(":input").change(function(event){
            $('#berubah').val('Ya');
         });  
    $(":input").click(function(event){
            $('#berubah').val('Ya');
         });  
//================Akhir untuk Mengecek  Form Sudah DiUbah Atw Belum===================         
$('.groupUkurans').find('input').keyup(function(){
    gantiHidden();
    getBeratBadanIdeal();
    getBMI();
});

getBMI();
getText();
JS;
Yii::app()->clientScript->registerScript('cekform',$js,CClientScript::POS_READY);
?>

<?php
$urlgetMetodeGCS=$this->createUrl('GetMetodeGCS');
$idTekananDarah = CHtml::activeId($modPemeriksaanFisik, 'tekanandarah');
$systolic = CHtml::activeId($modPemeriksaanFisik, 'td_systolic');
$diastolic = CHtml::activeId($modPemeriksaanFisik, 'td_diastolic');
$idDetakNadi = CHtml::activeId($modPemeriksaanFisik, 'detaknadi');
$getTextTekananDarah = $this->createUrl('GetTextTekananDarah');
$arteriPressure = CHtml::activeId($modPemeriksaanFisik, 'meanarteripressure');
$beratBadan = CHtml::activeId($modPemeriksaanFisik, 'beratbadan_kg');
$tinggiBadan = CHtml::activeId($modPemeriksaanFisik, 'tinggibadan_cm');
$jenisKelamin = CHtml::activeId($modPasien, 'jenis_kelamin');
$jenisKelaminPerempuan = Params::JENIS_KELAMIN_PEREMPUAN;
$beratBadanIdeal = CHtml::activeId($modPemeriksaanFisik, 'bb_ideal');
$getBMIText = $this->createUrl('getBMIText');
$getfromDevice = $this->createUrl('getfromDevice');
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
       if(confirm('Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?')){
           $('#url').val(obj);
           $('#btn_simpan').click();
       }
    }      
}

function ubahWarna(obj)   
{ 
    $(obj).attr("class","btn btn-success");
}

function kembaliWarna(obj)
{
   $(obj).attr("class","btn");
}

function SetNilai(obj)
{
    idTombol=obj.id;
    valueGCS=obj.value;
    i=0;
    if(idTombol=='E'){
        $('#PPPemeriksaanFisikT_gcs_eye').val(valueGCS);
    }else if(idTombol=='M'){
        $('#PPPemeriksaanFisikT_gcs_motorik').val(valueGCS);
    }else if(idTombol=='V'){
        $('#PPPemeriksaanFisikT_gcs_verbal').val(valueGCS);
    } 
    
    $('#divTombol #'+idTombol).each(function() {
        $(this).attr("class","btn"); 
    });

//    jumlah=$('#divTombol #'+idTombol).length;

$(obj).attr("class","btn btn-success"); 
    $(obj).removeAttr('onmouseout');
    $(obj).removeAttr('onmouseover');

    hitungCGS();
}

function hitungCGS()
{
    gcs_eye =  $('#PPPemeriksaanFisikT_gcs_eye').val();
    gcs_motorik =  $('#PPPemeriksaanFisikT_gcs_motorik').val();
    gcs_verbal =  $('#PPPemeriksaanFisikT_gcs_verbal').val();    
    if((gcs_eye!='') && (gcs_motorik!='') &&(gcs_verbal!='')){
        $.post("${urlgetMetodeGCS}",{gcs_eye: gcs_eye,gcs_motorik:gcs_motorik,gcs_verbal:gcs_verbal},
        function(data){
               if(data.pesan==null){
                 $('#PPPemeriksaanFisikT_gcs_id').val(data.idGCS);
                 $('#namaGCS').val(data.namaGCS);
               }else{
                    myAlert(data.pesan);
               }    
        },"json");
    }
}    

function getTekananDarah(obj){
    var hasil = $(obj).val();
    var data = hasil.split(' / ');

    data[0] = data[0].replace(/_/gi, "0");
    data[1] = data[1].replace(/_/gi, "0");
    $('#${systolic}').val(data[0]);
    $('#${diastolic}').val(data[1]);
}
    
function returnValue(obj){
    var value = $(obj).val();
    var attrID = $(obj).attr('id');
    var td = $('#${idTekananDarah}').val();
    var splitTD = td.split(' / ');
    
    if (attrID == '${diastolic}'){
        splitTD[0] = splitTD[0].replace(/_/gi, "0");
        $('#${idTekananDarah}').val(splitTD[0]+' / '+value);
    }
    else if (attrID == '${systolic}'){
        splitTD[1] = splitTD[1].replace(/_/gi, "0");
        $('#${idTekananDarah}').val(value+' / '+splitTD[1]);
    }
}

function change(obj){
    var value = $(obj).val();
    var hasil = value.replace(/_/gi, "0");
    
    if (value == ''){
        $(obj).val('000 / 000')
    }else{
        $(obj).val(hasil);
        returnValue(obj);
    }
    
}

function getText(){
    var dias = parseFloat($('#${diastolic}').val());
    var sys = parseFloat($('#${systolic}').val());
    var arteri = ((sys+(2*dias))/3);
    
    if (jQuery.isNumeric(dias)){
        if (jQuery.isNumeric(sys)){
            $.post('${getTextTekananDarah}', {diastolic:dias, systolic:sys}, function(data){
                if (data.text == null){
                    $('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
                } else {
                    $('#tekananDarah').val(data.text);
                }
            },'json');
            $('#${arteriPressure}').val(arteri);
        }
    }
}

function gantiJumlah(obj){
    var value = parseFloat($(obj).val());
    var teman = $(obj).parent('.groupUkurans').find('input[type="text"]');
    var valueTeman = parseFloat(teman.val());
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}

function gantiHidden(){
    var defaultBB = parseFloat(0.001);
    var defaultTB = parseFloat(100);
    var valueBB = parseFloat($('#${beratBadan}').val());
    var valueTB = parseFloat($('#${tinggiBadan}').val());

    if ($('#gram').val() != defaultBB){
        $('#${beratBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB*defaultBB);
    }
    else{
        $('#${beratBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB);
    }
    
    if ($('#meter').val() != defaultTB){
        $('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB*defaultTB);
    }
    else{
        $('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB);
    }
}            
            
function getBeratBadanIdeal(){
    var beratBadan = parseFloat($('#${beratBadan}').val());
    var tinggiBadan = parseFloat($('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
    var jenisKelamin = $('#${jenisKelamin}').val();
    var hasil;
    if (jenisKelamin == "${jenisKelaminPerempuan}"){
        hasil = (tinggiBadan - 100) - ((15/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('#${beratBadanIdeal}').val(hasil);
    }
    else{
        hasil = (tinggiBadan - 100) - ((10/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('#${beratBadanIdeal}').val(hasil);
    }
}

function getBMI(){
    var beratBadan = parseFloat($('#${beratBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
    var tinggiBadan = parseFloat($('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
    var hasil;
    
    hasil = (beratBadan/((tinggiBadan*tinggiBadan)/10000));
    if (jQuery.isNumeric(hasil)){
        $.post('${getBMIText}', {bmi:hasil}, function(data){
            $('#imt').val(data.text);
            $('#imtValue').val(Math.floor(hasil));
        },'json');
    }
}

function getfromDevice(){
    $.post('${getfromDevice}',{},function(dataz){
        $('#${idDetakNadi}').val(dataz.detaknadi);
        $('#${idTekananDarah}').val(dataz.tekanandarah);
        $('#${systolic}').val(dataz.sys);
        $('#${diastolic}').val(dataz.dias);
            getText();
    }, 'json');
    
    
}
JS;
Yii::app()->clientScript->registerScript('validasi',$js,CClientScript::POS_HEAD);

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
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?> 
		
<script type="text/javascript">
function printPemeriksaanFisik()
{
    window.open('<?php echo $this->createUrl('printPemeriksaanFisik',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=793,height=1122');
}

function defaultparamedis()
{
    var paramedis = '<?php echo PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->nama_pegawai; ?>';
    $("#<?php echo CHtml::activeId($modPemeriksaanFisik,'paramedis_nama') ?>").val(paramedis);
}

$(document).ready(function(){
    defaultparamedis();     
});
</script>