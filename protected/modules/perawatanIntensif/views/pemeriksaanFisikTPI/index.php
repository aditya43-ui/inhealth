<?php
$this->breadcrumbs = array(
    'Anamnesis',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpemeriksaan-fisik-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#PIPemeriksaanFisikT_keadaanumum_annoninput .maininput',
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.taggd.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/taggd.css'); ?>
<style>
    .groupUkurans {
        display: inline;
    }
</style>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'tabel-riwayatpemeriksaanfisik',
    'content' => array(
        'content-detailpemeriksaanfisik' => array(
            'header' => '<b>Tabel Riwayat Pemeriksaan Fisik</b>',
            'isi' => $this->renderPartial('_tabelRiwayatFisik', array(
                'tabelPemeriksaan' => $tabelPemeriksaan,
                'format' => $format,
            ), true),
            'active' => true,
        ),
    ),
));
?>
<?php echo $form->errorSummary($modPemeriksaanFisik); ?>
<div class="row">
    <div class="col-sm-4">
        <fieldset class="box">
            <legend class="rim">Data Pemeriksaan</legend>
            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'tglperiksafisik', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'tglperiksafisik',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'class' => 'span3 dtPicker3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <?php //echo $form->textFieldRow($modPemeriksaanFisik,'keadaanumum',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); 
            ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'keadaanumum', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'keadaanumum',
                        'data' => explode(',', $modPemeriksaanFisik->keadaanumum),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'json_url' => $this->createUrl('MasterKeadaanUmum'),
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'keadaanumum'); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'pegawai_id', CHtml::listData($modPemeriksaanFisik->getDokterItems($modAdmisi->ruangan_id), 'pegawai_id', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
            <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'ppds_id', CHtml::listData($modPemeriksaanFisik->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);", 'class' => 'required')); ?>
            <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'paramedis_nama', CHtml::listData($modPemeriksaanFisik->ParamedisItems, 'pegawai.nama_pegawai', 'pegawai.NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <!--<div class="control-group">
			<?php echo $form->LabelEx($modPemeriksaanFisik, 'paramedis_nama', array('class' => 'control-label')); ?>
				   <div class="controls">
			<?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPemeriksaanFisik,
                'attribute' => 'paramedis_nama',
                'value' => '',
                //                      RND-5044    'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/Paramedis'),
                'sourceUrl' => $this->createUrl('AutocompleteParamedisPI'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
                                                              $(this).val( ui.item.label);
                                                              return false;
                                                      }',
                ),
            ));
            ?>
				   </div>
		   </div> 
			-->
        </fieldset>
        <fieldset class="box">
            <legend class="rim">Pemeriksaan Thorax</legend>
            <br>
            <?php echo $form->textFieldRow($modPemeriksaanFisik, 'inspeksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($modPemeriksaanFisik, 'palpasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

            <?php echo $form->textFieldRow($modPemeriksaanFisik, 'perkusi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($modPemeriksaanFisik, 'auskultasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        </fieldset>
    </div>
    <div class="col-sm-4">
        <style>
            .hoveringIcon:hover {
                background-color: #FFA0A2;
                cursor: pointer;
                -webkit-border-radius: 1px;
                -moz-border-radius: 1px;
                -o-border-radius: 1px;
                -border-radius: 1px;
            }

            .taggd:hover {
                cursor: crosshair;
            }

            /*--------------------------*/

            #imgtag {
                position: relative;
                min-width: 300px;
                min-height: 300px;
                float: none;
                border: 3px solid #FFF;
                cursor: crosshair;
                text-align: center;
            }

            .tagview {
                border: 1px solid #F10303;
                width: 100px;
                height: 100px;
                position: absolute;
                /*display:none;*/
                opacity: 0;
                color: #FFFFFF;
                text-align: center;
            }

            .square {
                display: block;
                height: 79px;
            }

            .person {
                background: #282828;
                border-top: 1px solid #F10303;
            }

            #tagit {
                position: absolute;
                top: 0;
                left: 0;
                width: 300px;
                border: 1px solid #D7C7C7;
            }

            /*			#tagit .box
								{
										border: 1px solid #F10303;
										width: 10px;
										height: 10px;
										float: left;
								}*/
            #tagit .name {
                /*float: left;*/
                background-color: #FFF;
                width: 295px;
                /*height: 92px;*/
                /*padding: 5px;*/
                font-size: 10pt;
                margin: 0 auto;
                margin-bottom: 0 auto;
            }

            #tagit DIV.text {
                margin-bottom: 5px;
            }

            #tagit INPUT[type=text] {
                margin-bottom: 5px;
            }

            #tagit #tagname {
                width: 110px;
            }

            #taglist {
                width: 300px;
                min-height: 200px;
                height: auto !important;
                height: 200px;
                float: left;
                padding: 10px;
                margin-left: 20px;
                color: #000;
            }

            #taglist OL {
                padding: 0 20px;
                float: left;
                cursor: pointer;
            }

            #taglist OL A {}

            #taglist OL A:hover {
                text-decoration: underline;
            }

            .tagtitle {
                font-size: 14px;
                text-align: center;
                width: 100%;
                float: left;
            }
        </style>
        <fieldset class="box">
            <legend class="rim">Tanda Vital</legend>
            <div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'tekanandarah', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $modPemeriksaanFisik->tekanandarah = empty($modPemeriksaanFisik->tekanandarah) ? "000 / 000" : $modPemeriksaanFisik->tekanandarah;
                    $this->widget('CMaskedTextField', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'tekanandarah',
                        'mask' => '999 / 999',
                        'placeholder' => '000 / 000',
                        'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'style' => 'width:60px;', 'onkeypress' => "return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                    ));
                    ?>
                    <?php //echo $form->textField($modPemeriksaanFisik,'tekanandarah',array('class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));
                    ?>
                    /MmHg <?php echo "    "; ?>
                    <?php
                    $this->widget('CMaskedTextField', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'td_systolic',
                        'mask' => '999',
                        'placeholder' => '0',
                        'htmlOptions' => array('class' => 'span1 integer systolic', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onkeyup' => 'returnValue(this); getText();') // change(this); getTekananDarah(this) change(this);getText();
                    ));
                    ?>Mm
                    <?php // echo $form->textField($modPemeriksaanFisik,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 integer numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));
                    ?>
                    <?php
                    $this->widget('CMaskedTextField', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'td_diastolic',
                        'mask' => '999',
                        'placeholder' => '0',
                        'htmlOptions' => array('class' => 'span1 integer diastolic', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onkeyup' => 'returnValue(this); getText();') //getTekananDarah(this); ,'onkeyup'=>'getText();'
                    ));
                    ?>Hg
                    <?php // echo $form->textField($modPemeriksaanFisik,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)')); 
                    ?>

                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::Label('', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('tekananDarah', '', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'meanarteripressure', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'meanarteripressure', array('readonly' => true, 'class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'detaknadi', array('label' => '<i class="icon-facetime-video hoveringIcon" onclick="getfromDevice();"></i> Detak Nadi', 'class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'detaknadi', array('class' => 'span2  numbersOnly', 'maxlength' => 10, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    /Menit
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'denyutjantung', array('label' => '<i class="icon-facetime-video hoveringIcon" onclick="getfromDevice();"></i> Denyut Jantung', 'class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modPemeriksaanFisik, 'denyutjantung', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => Params::LOOKUPTYPE_DENYUTJANTUNG)), 'lookup_value', 'lookup_name'), array('empty' => '-- Pilih --'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'pernapasan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'pernapasan', array('class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    /Menit
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'suhutubuh', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'suhutubuh', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    &#176 Celcius
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::Label('Tinggi Badan / Berat Badan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <div class="groupUkurans">
                        <?php echo $form->textField($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'span1 numbersOnly tinggibadan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
                        <?php echo $form->hiddenField($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
                        <?php echo CHtml::dropDownList('meter', '100', array('100' => 'Cm', '0.01' => 'M'), array('style' => 'width:50px;', 'class' => 'span1', 'onchange' => 'gantiJumlah(this)')); ?>
                    </div>
                    <div class="groupUkurans">
                        <?php echo $form->textField($modPemeriksaanFisik, 'beratbadan_kg', array('class' => 'span1 numbersOnly beratbadan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
                        <?php echo $form->hiddenField($modPemeriksaanFisik, 'beratbadan_kg', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
                        <?php echo CHtml::dropDownList('gram', '0.001', array('1000' => 'Gr', '0.001' => 'Kg'), array('class' => 'span1', 'onchange' => 'gantiJumlah(this)')); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'bb_ideal', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'bb_ideal', array('class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?>Kg
                </div>
            </div>
            <div class="control-group">
                <label class='control-label'>Index Masa Tubuh</label>
                <div class="controls">
                    <?php echo CHtml::textField('imtValue', '', array('readonly' => true, 'class' => 'span1')); ?>
                    <?php echo CHtml::textField('imt', '', array('readonly' => true, 'class' => 'span2')); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPemeriksaanFisik, 'kelainanpadabagtubuh', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
        </fieldset>
    </div>
    <div class="row">
            <div class="col-sm-6">
                <fieldset class=''>
                    <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_kepalaLeher", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
                </fieldset>
                <?php /*
                <div class="panel panel-success">
                    <div class="panel-heading">
                            <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Thorax</div>
                    </div>
                    <div class="panel-body">      
                        <fieldset class="box">
                        <?php echo $form->textFieldRow($modPemeriksaanFisik,'inspeksi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        <?php echo $form->textFieldRow($modPemeriksaanFisik,'palpasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>

                        <?php echo $form->textFieldRow($modPemeriksaanFisik,'perkusi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        <?php echo $form->textFieldRow($modPemeriksaanFisik,'auskultasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    </div>
                </div> */
                ?>
            </div>
    <div class="col-sm-4">
        <fieldset class="box">
            <legend class="rim">Glasgow Coma Scale
                <?php echo CHtml::link('<i class="icon-chevron-right icon-white" style="cursor:pointer;"></i>', '', array('onclick' => "$('#dialogGCS').dialog('open')", 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

            </legend>
            <div id="divGlowComoScale" style="display: block">
                <?php // echo  CHtml::button('Gunakan Metode GCS',array('class'=>'btn btn-info','onclick'=>"$('#dialogGCS').dialog('open')", 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'gcs_eye', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $crit = new CDbCriteria();
                        $crit->compare('LOWER(metodegcs_singkatan)', "e");
                        $crit->addCondition('metodegcs_nilai is not null');
                        $crit->order = 'metodegcs_nilai ASC';
                        echo $form->dropDownList($modPemeriksaanFisik, 'gcs_eye', CHtml::listData(PIMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'gcs_verbal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $crit3 = new CDbCriteria();
                        $crit3->compare('LOWER(metodegcs_singkatan)', "v");
                        $crit3->addCondition('metodegcs_nilai is not null');
                        $crit3->order = 'metodegcs_nilai ASC';
                        echo $form->dropDownList($modPemeriksaanFisik, 'gcs_verbal', CHtml::listData(PIMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'gcs_motorik', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $crit2 = new CDbCriteria();
                        $crit2->compare('LOWER(metodegcs_singkatan)', "m");
                        $crit2->addCondition('metodegcs_nilai is not null');
                        $crit2->order = 'metodegcs_nilai ASC';
                        echo $form->dropDownList($modPemeriksaanFisik, 'gcs_motorik', CHtml::listData(PIMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'namaGCS', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modPemeriksaanFisik, 'gcs_id', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                        <?php // echo CHtml::textField('namaGCS',(isset($modPemeriksaanFisik->gcs->gcs_nama) ? $modPemeriksaanFisik->gcs->gcs_nama : "-"),array('disabled'=>true,'class'=>'span1')); 
                        ?>
                        <?php echo $form->textField($modPemeriksaanFisik, 'namaGCS', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)) . ' '; ?>
                    </div>
                </div>
                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'dialogGCS',
                    'options' => array(
                        'title' => '',
                        'autoOpen' => false,
                        'width' => 600,
                        'height' => 500,
                        'modal' => false,
                        //'hide'=>'explode',
                        'resizelable' => false,
                    ),
                ));
                ?>
                <table>
                    <?php
                    foreach ($modPIMetodeGSCM as $i => $item) :
                        if ($item->metodegcs_nilai == '') {
                            echo "<tr bgcolor='#E5ECF9'>
                                            <td>" . $item->metodegcs_nama . "</td>
                                            <td>&nbsp;</td>    
                                      </tr>";
                        } else {
                            echo "<tr>
                                            <td>" . $item->metodegcs_nama . "</td>
                                            <td><div id=\"divTombol\">" . CHtml::button($item->metodegcs_nilai, array(
                                'class' => 'btn btn-prymari',
                                'onclick' => 'SetNilai(this)',
                                'id' => $item->metodegcs_singkatan,
                            )) . "</div></td>    
                                      </tr>";
                        }
                    endforeach;
                    ?>
                </table>
                <?php $this->endWidget(); ?>
            </div>
        </fieldset>
    </div>
</div>
<!--<legend class="accord1" style="width:460px;">-->
<!--		<?php // echo CHtml::checkBox('pemeriksaanFisik',false, array('onkeypress'=>"return $(this).focusNextInputField(event)"))  
            ?> Pemeriksaan Anggota Tubuh-->
<!--</legend>-->
<!--<div id="divBagianYAngDiperiksa" class="" style="display: none">-->
<fieldset class="box">
    <legend class="rim">Pemeriksaan Anggota Tubuh</legend>
    <div class="row">
        <div class="span7 box">
            <div align="center" id="imgtag">
                <img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh() . $modGambarTubuh->FileNameGambar; ?>" class="taggd" />
                <div id="tagbox"></div>
            </div>
        </div>
        <div class="span1">
            &nbsp;
        </div>
        <div class="span5">
            <div class="block-tabel">
                <h6>Tabel <b>Pemeriksaan</b></h6>
                <table class="items table table-striped table-condensed" id="table-bagtubuh">
                    <thead>
                        <tr>
                            <th width='30'>No.</th>
                            <th width='120'>Tanggal Pemeriksaan</th>
                            <th>Bagian Tubuh</th>
                            <th>Keterangan</th>
                            <th width='80'>Batal / Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $format = new MyFormatter();
                        if (!empty($modPemeriksaanGambar)) {
                            foreach ($modPemeriksaanGambar as $ii => $vv) {
                        ?>
                                <tr>
                                    <td>
                                        <p style="margin: 0; text-align: center;"><?= $ii + 1; ?></p>
                                    </td>
                                    <td><?= $format->formatDateTimeForUser($vv->tglpemeriksaan); ?></td>
                                    <td>
                                        <?= $vv->bagiantubuh->namabagtubuh; ?>
                                        <?php echo CHtml::HiddenField('bagiantubuh_id', $vv->bagiantubuh_id, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                        <?php echo CHtml::HiddenField('pemeriksaangambar_id', $vv->pemeriksaangambar_id, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                        <?php echo CHtml::HiddenField('kordinat_tubuh_x', $vv->kordinat_tubuh_x, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                        <?php echo CHtml::HiddenField('kordinat_tubuh_y', $vv->kordinat_tubuh_y, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                    </td>
                                    <td><?= $vv->keterangan_periksa_gbr; ?></td>
                                    <td>
                                        <p style="margin: 0; text-align: center;"><a onclick="hapusBagianTubuh(this);
									return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-trash"></i></a></p>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'kepala',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'mata',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'hidung',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'telinga',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'tenggorokan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'leher',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'jantung',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'payudara',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'abdomen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <?php // echo $form->textAreaRow($modPemeriksaanFisik,'kulit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
</fieldset>
<!--</div>-->
<div class="row">
    <div class="span3">
        <fieldset class="box">
            <legend class="rim">Jalan Nafas</legend><br>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_paten', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_paten', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_obstruktifpartial', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_obstruktifpartial', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_obstruktifnormal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_obstruktifnormal', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_stridor', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_stridor', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_gargling', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_gargling', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="span3">
        <fieldset class="box">
            <legend class="rim">Pernapasan </legend><br>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_normal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_normal', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_kussmaul', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_kussmaul', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_takipnea', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_takipnea', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_retraktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_retraktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_dangkal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_dangkal', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </fieldset>
        <fieldset class="box">
            <legend class="rim">Pernapasan Gerakan Dada</legend><br>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'pgd_simetri', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'pgd_simetri', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'pgd_asimetri', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'pgd_asimetri', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-sm-6" style="width:53.17%">
        <fieldset class="box">
            <legend class="rim">Sirkulasi </legend>
            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'sirkulasi_nadicarotis', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPemeriksaanFisik, 'sirkulasi_nadicarotis', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this)')); ?> x/Menit
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'sirkulasi_nadiradialis', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPemeriksaanFisik, 'sirkulasi_nadiradialis', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this)')); ?> x/Menit
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'cfr_kecil_2', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'cfr_kecil_2', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <= 2 </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemeriksaanFisik, 'cfr_besar_2', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'cfr_besar_2', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    >= 2
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_normal', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_normal', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_jaundice', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_jaundice', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_cyanosis', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_cyanosis', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_pucat', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_pucat', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_berkeringat', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_berkeringat', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'akral', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($modPemeriksaanFisik, 'akral', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <fieldset class="box">
            <legend class="rim">Gastrointestinal</legend>
            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'adakelgastrointestinal', array('onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'setKeluhanGastroin();')); ?>
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'gastrointestinal_sebutkan'); ?>
              </label>
                <div class="controls">
                    <?php echo $form->textArea($modPemeriksaanFisik, 'gastrointestinal_sebutkan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'pembatasanmakanan', array('onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'setPembatasanMakanan();')); ?>
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'pembatasanmakanan'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'batasmakanan_sebutkan',
                        'data' => explode(',', $modPemeriksaanFisik->batasmakanan_sebutkan),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'batasmakanan_sebutkan'); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'gigipalsu', array('onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'setGigiPalsu();')); ?>
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'gigipalsu'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'gigipalsu_bagian',
                        'data' => explode(',', $modPemeriksaanFisik->gigipalsu_bagian),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'gigipalsu_bagian'); ?>
                </div>
            </div>

            <?php echo $form->checkBoxRow($modPemeriksaanFisik, 'mual', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($modPemeriksaanFisik, 'muntah', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </fieldset>

        <fieldset class="box">
            <legend class="rim">Kulit dan Kelamin</legend>
            <div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'skornorton', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'skornorton', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => false)) . ' '; ?> / 20
                </div>
            </div>
            <?php echo $form->checkBoxRow($modPemeriksaanFisik, 'resikodekubitus', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($modPemeriksaanFisik, 'terdapatluka', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'lokasiluka'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'lokasiluka',
                        'data' => explode(',', $modPemeriksaanFisik->lokasiluka),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'lokasiluka'); ?>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-sm-4">
        <fieldset class="box">
            <legend class="rim">Neurosensori</legend>
            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'pendengaran', array('onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'setPendengaran();')); ?>
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'pendengaran'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'pendengaran_sebutkan',
                        'data' => explode(',', $modPemeriksaanFisik->pendengaran_sebutkan),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'pendengaran_sebutkan'); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'penglihatan', array('onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'setPenglihatan();')); ?>
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'penglihatan'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'penglihatan_sebutkan',
                        'data' => explode(',', $modPemeriksaanFisik->penglihatan_sebutkan),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'penglihatan_sebutkan'); ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="box">
            <legend class="rim">Eliminasi</legend>
            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'defekasi', array('onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'setDefekasi();')); ?>
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'defekasi'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'defekasi_sebutkan',
                        'data' => explode(',', $modPemeriksaanFisik->defekasi_sebutkan),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'defekasi_sebutkan'); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'miksi', array('onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'setMiksi();')); ?>
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'miksi'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'miksi_sebutkan',
                        'data' => explode(',', $modPemeriksaanFisik->miksi_sebutkan),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'miksi_sebutkan'); ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="box">
            <legend class="rim">Kebutuhan Edukasi</legend>
            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->checkBox($modPemeriksaanFisik, 'hambatanpembelajaran', array('onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'setHambatanPembelajaran();')); ?>
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'hambatanpembelajaran'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'hambatanpembelajaran_ya',
                        'data' => explode(',', $modPemeriksaanFisik->hambatanpembelajaran_ya),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'json_url' => $this->createUrl('MasterHambatanPembelajaran'),
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'hambatanpembelajaran_ya'); ?>
                </div>
            </div>

            <?php echo $form->checkBoxRow($modPemeriksaanFisik, 'butuhpenerjemah', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>

            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'kebutuhanpembelajaran'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'kebutuhanpembelajaran',
                        'data' => explode(',', $modPemeriksaanFisik->kebutuhanpembelajaran),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'json_url' => $this->createUrl('MasterKebutuhanPembelajaran'),
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'kebutuhanpembelajaran'); ?>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-sm-4">
        <fieldset class="box">
            <legend class="rim">Obsterti dan Ginekologi</legend>
            <?php echo $form->checkBoxRow($modPemeriksaanFisik, 'hamil', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>

            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'hpht'); ?>
              </label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'hpht',
                        'data' => explode(',', $modPemeriksaanFisik->hpht),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPemeriksaanFisik, 'hpht'); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'keluhanmenstruasi'); ?>
              </label>
                <div class="controls">
                    <?php echo $form->textArea($modPemeriksaanFisik, 'keluhanmenstruasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
    </div>
    <div class="col-sm-6">
        <fieldset class="box">
            <legend class="rim">Penilaian Tingkat Nyeri Pasien Dewasa</legend>
            <div style="text-align: center;">
                <img width="600px" src="<?php echo Params::urlPemeriksaanGambarDirectory() . "nyeri.png"; ?>" />
            </div>
            <table style="width: 100%; border: none;">
                <tbody>
                    <tr>
                        <td>
                            <h5>Apakah Terdapat Keluhan Nyeri ?</h5>
                        </td>
                        <td>
                            <div class="form-inline">
                                <?php
                                echo $form->radioButtonList($modPemeriksaanFisik, 'keluhan_nyeri', array("1" => "<h5>YA</h5>", "0" => "<h5>TIDAK</h5>"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Skala Wong Baker / NSR </h5>
                        </td>
                        <td>
                            <?php
                            echo  $form->textField($modPemeriksaanFisik, 'skala_wongbaker_nrs', array('class' => 'span1 integer numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 2));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Apakah Terdapat Nyeri Berpindah - pindah </h5>
                        </td>
                        <td>
                            <div class="form-inline">
                                <?php
                                echo $form->radioButtonList($modPemeriksaanFisik, 'rasanyeri_berpindah', array("1" => "<h5>YA</h5>", "0" => "<h5>TIDAK</h5>"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Berapa Lama Nyeri </h5>
                        </td>
                        <td>
                            <div class="form-inline">
                                <?php
                                echo $form->dropDownList($modPemeriksaanFisik, 'lama_nyeri', LookupM::getItems('pemeriksaanfisik_lamanyeri'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Seberapa Sering Mengalami Nyeri ? Berapa Lama</h5>
                        </td>
                        <td>
                            <div class="form-inline">
                                <?php
                                echo $form->dropDownList($modPemeriksaanFisik, 'seringmengalami_nyeri', LookupM::getItems('pemeriksaanfisik_frekuensinyeri'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Apa yang Membuat Nyeri Berkurang atau Bertambah Parah ?</h5>
                        </td>
                        <td>
                            <div class="form-inline">
                                <?php
                                echo $form->dropDownList($modPemeriksaanFisik, 'penyebabberkurang_nyeri', LookupM::getItems('pemeriksaanfisik_nyeriberkurang'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                        <h5>Rasa Nyeri</h5>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('<h5>Tajam</h5>', 'sdff', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'rasanyeri_tajam', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('<h5>Nyeri Tumpul</h5>', 'sdff', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'rasanyeri_tumpul', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('<h5>Seperti Ditarik</h5>', 'sdff', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'rasanyeri_ditarik', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5></h5>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('<h5>Seperti Ditusuk</h5>', 'sdff', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'rasanyeri_ditusuk', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('<h5>Seperti Dibakar</h5>', 'sdff', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'rasanyeri_dibakar', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('<h5>Seperti Dipukul</h5>', 'sdff', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'rasanyeri_dipukul', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5></h5>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('<h5>Seperti Berdenyut</h5>', 'sdff', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'rasanyeri_berdenyut', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('<h5>Seperti Ditikam</h5>', 'sdff', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'rasanyeri_ditikam', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('<h5>Seperti Kram</h5>', 'sdff', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($modPemeriksaanFisik, 'rasanyeri_kram', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

        </fieldset>
    </div>

    <div class="col-sm-6">
        <fieldset class="box">
            <legend class="rim">Skrining Resiko Jatuh (MORSE FALLS SCALE)</legend>
            <table class="items table table-striped table-condensed" id="tblInputTindakan">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Resiko</th>
                        <th>Penilaian</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tr>
                    <th>1</th>
                    <th>Resiko Jatuh, yang baru atau dalam bulan terakhir</th>
                    <th>
                        <?php echo $form->dropDownList($modPemeriksaanFisik, 'riwayatjatuh_penilaian', array('1' => 'Ya', '0' => 'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'nilairiwayatjauh()'));
                        ?>
                    </th>
                    <th><?php echo $form->textField($modPemeriksaanFisik, 'riwayatjatuh_skor', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                </tr>
                <tr>
                    <th>2</th>
                    <th>Diagnisis Medis Sekunder > 1</th>
                    <th>
                        <?php echo $form->dropDownList($modPemeriksaanFisik, 'diagnosismedis_penilaian', array('1' => 'Ya', '0' => 'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'nilaidiagnosismedis()'));
                        ?>
                    </th>
                    <th><?php echo $form->textField($modPemeriksaanFisik, 'diagnosismedis_skor', array('class' => 'span1 integer numberOnly',  'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?></th>
                </tr>
                <tr>
                    <th>3</th>
                    <th>Alat Bantu Jalan</th>
                    <th>
                        <?php echo $form->dropDownList($modPemeriksaanFisik, 'alatbantujalan_penilaian', LookupM::getItems('resikojatuh_alatbantu'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'nilairiwayatjatuh()'));
                        ?> </th>
                    <th><?php echo $form->textField($modPemeriksaanFisik, 'alatbantujalan_skor', array('class' => 'span1 integer numberOnly',  'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ''; ?></th>
                </tr>
                <tr>
                    <th>4</th>
                    <th>Memakai Terapi Heparin Lock/ IV</th>
                    <th>
                        <?php echo $form->dropDownList($modPemeriksaanFisik, 'memakaiterapiheparin_penilaian', array('1' => 'Ya', '0' => 'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'nilaimemakaiterapiheparin()'));
                        ?> </th>
                    <th><?php echo $form->textField($modPemeriksaanFisik, 'memakaiterapiheparin_skor', array('class' => 'span1 integer numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ''; ?> </th>
                </tr>
                <tr>
                    <th>5</th>
                    <th>Cara Berjalan/ Berpindah</th>
                    <th>
                        <?php echo $form->dropDownList($modPemeriksaanFisik, 'caraberjalan_penilaian', LookupM::getItems('resikojatuh_caraberjalan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'nilaicaraberjalan()'));
                        ?>
                    </th>
                    <th> <?php echo $form->textField($modPemeriksaanFisik, 'caraberjalan_skor', array('class' => 'span1 integer numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ''; ?> </th>
                </tr>
                <tr>
                    <th>6</th>
                    <th>Status Mental</th>
                    <th>
                        <?php echo $form->dropDownList($modPemeriksaanFisik, 'statusmental_penilaian', LookupM::getItems('resikojatuh_statusmental'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'nilaistatusmental()'));
                        ?>
                    </th>
                    <th> <?php echo  $form->textField($modPemeriksaanFisik, 'statusmental_skor', array('class' => 'span1 integer numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ''; ?> </th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Total Score</th>
                    <th> <?php echo  $form->textField($modPemeriksaanFisik, 'resikojatuh_skor', array('class' => 'span1 integer numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true, 'onchange' => 'hasilresiko_jatuh()')) . ''; ?> </th>
                    <th></th>

                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Hasil Resiko Jatuh</th>
                    <th> <?php echo $form->textField($modPemeriksaanFisik, 'resikojatuh_keterangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,)) . ''; ?> </th>
                </tr>
            </table>
    </div>
    </fieldset>
</div>
</div>

<div class="form-actions">
    <?php
    if (!isset($_GET['sukses'])) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
        echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;')) . '&nbsp;';
    } else {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => TRUE));
        echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemeriksaanFisik();return false", 'disabled' => FALSE)) . '&nbsp;';
    }
    ?>
    <?php
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

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

$('#pemeriksaanFisik').attr('checked',true);
$('#divBagianYAngDiperiksa').slideToggle(500);
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
Yii::app()->clientScript->registerScript('cekform', $js, CClientScript::POS_READY);
?>

<?php
// RND-5044 $urlgetMetodeGCS=Yii::app()->createUrl('ActionAjax/GetMetodeGCS');
$urlgetMetodeGCS = $this->createUrl('GetMetodeGCS');
$idTekananDarah = CHtml::activeId($modPemeriksaanFisik, 'tekanandarah');
$systolic = CHtml::activeId($modPemeriksaanFisik, 'td_systolic');
$diastolic = CHtml::activeId($modPemeriksaanFisik, 'td_diastolic');
$idDetakNadi = CHtml::activeId($modPemeriksaanFisik, 'detaknadi');
$getTextTekananDarah = Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/GetTextTekananDarah');
$arteriPressure = CHtml::activeId($modPemeriksaanFisik, 'meanarteripressure');
$beratBadan = CHtml::activeId($modPemeriksaanFisik, 'beratbadan_kg');
$tinggiBadan = CHtml::activeId($modPemeriksaanFisik, 'tinggibadan_cm');
$jenisKelamin = CHtml::activeId($modPasien, 'jenis_kelamin');
$jenisKelaminPerempuan = Params::JENIS_KELAMIN_PEREMPUAN;
$beratBadanIdeal = CHtml::activeId($modPemeriksaanFisik, 'bb_ideal');
$getBMIText = Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText');
// RND-5044 $getfromDevice = Yii::app()->createUrl('actionAjax/getfromDevice');
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
        window.parent.myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
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
        $('#PIPemeriksaanFisikT_gcs_eye').val(valueGCS);
    }else if(idTombol=='M'){
        $('#PIPemeriksaanFisikT_gcs_motorik').val(valueGCS);
    }else if(idTombol=='V'){
        $('#PIPemeriksaanFisikT_gcs_verbal').val(valueGCS);
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
    gcs_eye =  $('#PIPemeriksaanFisikT_gcs_eye').val();
    gcs_motorik =  $('#PIPemeriksaanFisikT_gcs_motorik').val();
    gcs_verbal =  $('#PIPemeriksaanFisikT_gcs_verbal').val();    
    if((gcs_eye!='') && (gcs_motorik!='') &&(gcs_verbal!='')){
        $.post("${urlgetMetodeGCS}",{gcs_eye: gcs_eye,gcs_motorik:gcs_motorik,gcs_verbal:gcs_verbal},
        function(data){
               if(data.pesan==null){
                 $('#PIPemeriksaanFisikT_namaGCS').val(data);
               }else{
                    window.parent.myAlert(data.pesan);
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
	if(isNaN(valueTeman)){
		valueTeman = 0;
	}
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}

function gantiHidden(){
    var defaultBB = parseFloat(0.001);
    var defaultTB = parseFloat(100);
    var valueBB = parseFloat($('#${beratBadan}').val());
	if(isNaN(valueBB)){
		valueBB = 0;
	}
    var valueTB = parseFloat($('#${tinggiBadan}').val());
	if(isNaN(valueTB)){
		valueTB = 0;
	}

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
	if(isNaN(beratBadan)){
		beratBadan = 0;
	}
    var tinggiBadan = parseFloat($('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
	if(isNaN(tinggiBadan)){
		tinggiBadan = 0;
	}
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
Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);

$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9.]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9.].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>
<?php
echo $this->renderPartial('_jsFunctions', array(
    'modPendaftaran' => $modPendaftaran,
    'modPemeriksaanFisik' => $modPemeriksaanFisik,
    'modBagianTubuh' => $modBagianTubuh,
    'modPemeriksaanGambar' => $modPemeriksaanGambar
));
?>

<script type="text/javascript">
    function nilairiwayatjauh() {
        var nilai1 = $('#PIPemeriksaanFisikT_riwayatjatuh_penilaian').val();

        if (nilai1 == 1) {
            $("#PIPemeriksaanFisikT_riwayatjatuh_skor").val(25);
        } else if (nilai1 == 0) {
            $("#PIPemeriksaanFisikT_riwayatjatuh_skor").val(0);
        }
        total();
    }

    function nilaidiagnosismedis() {
        var nilai = $('#PIPemeriksaanFisikT_diagnosismedis_penilaian').val();

        if (nilai == 1) {
            $("#PIPemeriksaanFisikT_diagnosismedis_skor").val(15);
        } else if (nilai == 0) {
            $("#PIPemeriksaanFisikT_diagnosismedis_skor").val(0);
        }
        total();
    }

    function nilairiwayatjatuh() {
        var nilai = $('#PIPemeriksaanFisikT_alatbantujalan_penilaian').val();

        if (nilai == 'Bed Rest/ Dibantu Perawat') {
            $("#PIPemeriksaanFisikT_alatbantujalan_skor").val(0);
        } else if (nilai == 'Penopang, Tongkat, Walker') {
            $("#PIPemeriksaanFisikT_alatbantujalan_skor").val(15);
        } else if (nilai == 'Furnitur') {
            $("#PIPemeriksaanFisikT_alatbantujalan_skor").val(30);
        } else {
            $("#PIPemeriksaanFisikT_alatbantujalan_skor").val(0);
        }
        total();
    }

    function nilaimemakaiterapiheparin() {
        var nilai = $('#PIPemeriksaanFisikT_memakaiterapiheparin_penilaian').val();

        if (nilai == 1) {
            $("#PIPemeriksaanFisikT_memakaiterapiheparin_skor").val(20);
        } else if (nilai == 0) {
            $("#PIPemeriksaanFisikT_memakaiterapiheparin_skor").val(0);
        }
        total();
    }

    function nilaicaraberjalan() {
        var nilai = $('#PIPemeriksaanFisikT_caraberjalan_penilaian').val();

        if (nilai == 'Normal/ Bed Rest/ Imobilisasi') {
            $("#PIPemeriksaanFisikT_caraberjalan_skor").val(0);
        } else if (nilai == 'Lemah') {
            $("#PIPemeriksaanFisikT_caraberjalan_skor").val(10);
        } else if (nilai == 'Terganggu') {
            $("#PIPemeriksaanFisikT_caraberjalan_skor").val(20);
        } else {
            $("#PIPemeriksaanFisikT_caraberjalan_skor").val(0);
        }
        total();
    }

    function nilaistatusmental() {
        var nilai = $("#PIPemeriksaanFisikT_statusmental_penilaian").val();
        if (nilai == 'Orientasi sesuai kemampuan diri') {
            $("#PIPemeriksaanFisikT_statusmental_skor").val(0);
        } else if (nilai == 'lupa keterbatasan diri') {
            $("#PIPemeriksaanFisikT_statusmental_skor").val(15);
        } else if (nilai == '') {
            $("#PIPemeriksaanFisikT_statusmental_skor").val(0);
        }
        total();
    }

    function total() {
        var statusmental_score = $('#PIPemeriksaanFisikT_statusmental_skor').val();
        var caraberjalan_score = $('#PIPemeriksaanFisikT_caraberjalan_skor').val();
        var memakaiterapiheparin_score = $('#PIPemeriksaanFisikT_memakaiterapiheparin_skor').val();
        var riwayatjatuh_score = $('#PIPemeriksaanFisikT_alatbantujalan_skor').val();
        var diagnosismedis = $('#PIPemeriksaanFisikT_diagnosismedis_skor').val();
        var riwayatjauh = $('#PIPemeriksaanFisikT_riwayatjatuh_skor').val();
        var result = parseInt(statusmental_score) + parseInt(caraberjalan_score) + parseInt(memakaiterapiheparin_score) + parseInt(riwayatjatuh_score) + parseInt(diagnosismedis) + parseInt(riwayatjauh);
        if (!isNaN(result)) {
            $('#PIPemeriksaanFisikT_resikojatuh_skor').val(result);
        }
        hasilresiko_jatuh();
    }

    function hasilresiko_jatuh() {
        var hasil = $('#PIPemeriksaanFisikT_resikojatuh_skor').val();
        var tidak_beresiko = 'Tidak Beresiko';
        var resiko_rendah = 'Resiko Rendah-Sedang';
        var resiko_tinggi = 'Resiko Tinggi';
        if (hasil >= 0 && hasil <= 24) {
            $('#PIPemeriksaanFisikT_resikojatuh_keterangan').val(tidak_beresiko);
        } else if (hasil >= 25 && hasil <= 45) {
            $('#PIPemeriksaanFisikT_resikojatuh_keterangan').val(resiko_rendah);
        } else if (hasil > 45) {
            $('#PIPemeriksaanFisikT_resikojatuh_keterangan').val(resiko_tinggi);
        }

    }
</script>