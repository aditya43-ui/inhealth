<?php

/**
 * view utama untuk menampilkan form - form pemeriksaan fisik
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 * 
 */

$this->breadcrumbs = array(
    'Anamnesa',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpemeriksaan-fisik-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RJPemeriksaanFisikT_keadaanumum_annoninput .maininput',
)); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.taggd.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/taggd.css'); ?>
<style>
    .groupUkurans {
        display: inline;
    }

    .row+.row {
        margin-top: 17px;
    }

    .dbnstyle {
        float: right !important;
    }

    .dbnstyle label {
        color: #fafafa !important;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-weight'></i> Pemeriksaan <b>Fisik</b>
        </div>
    </div>
    <div class="panel-body" style="padding-top: 0;">
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
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
        )); ?>
        <?php echo $form->errorSummary($modPemeriksaanFisik); ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="far fa-file-alt"></i> Data <b>Pemeriksaan</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'tglperiksafisik', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $modPemeriksaanFisik,
                                    'attribute' => 'tglperiksafisik',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker3 col-sm-8',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <?php //echo $form->textFieldRow($modPemeriksaanFisik,'keadaanumum',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); 
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'keadaanumum', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modPemeriksaanFisik, 'attribute' => 'keadaanumum', 'toolbar' => 'mini', 'height' => '200px')) ?>
                                <?php
                                // $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                                //     'model' => $modPemeriksaanFisik,
                                //     'attribute' => 'keadaanumum',
                                //     'data' => explode(',', $modPemeriksaanFisik->keadaanumum),
                                //     'debugMode' => true,
                                //     'options' => array(
                                //         //'bricket'=>false,
                                //         'json_url' => $this->createUrl('MasterKeadaanUmum'),
                                //         'addontab' => true,
                                //         'maxitems' => 10,
                                //         'input_min_size' => 0,
                                //         'cache' => true,
                                //         'newel' => true,
                                //         'addoncomma' => true,
                                //         'select_all_text' => "",
                                //     ),
                                // ));
                                ?>
                                <?php echo $form->error($modPemeriksaanFisik, 'keadaanumum'); ?>
                            </div>
                        </div>
                        <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'pegawai_id', CHtml::listData($modPemeriksaanFisik->getDokterItems($modAdmisi->ruangan_id), 'pegawai_id', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                        <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'ppds_id', CHtml::listData($modPemeriksaanFisik->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);", 'class' => '')); ?>
                        <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'paramedis_nama', CHtml::listData($modPemeriksaanFisik->ParamedisItems, 'pegawai.NamaLengkap', 'pegawai.NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <!--<div class="control-group">
                      <?php echo $form->LabelEx($modPemeriksaanFisik, 'paramedis_nama', array('class' => 'control-label')); ?>
                      <div class="controls">
                              <?php $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modPemeriksaanFisik,
                                    'attribute' => 'paramedis_nama',
                                    'value' => '',

                                    'sourceUrl' => $this->createUrl('AutocompleteParamedisRJ'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                              $(this).val( ui.item.label);
                                                              return false;
                                                      }',
                                    ),
                                )); ?>
                      </div>
              </div> 
-->
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="far fa-file-alt"></i> Tanda Vital
                        </div>
                    </div>
                    <div class="panel-body">
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
                        <!--
            <fieldset class="box">
                
                <div class="control-group">
                    <?php echo $form->LabelEx($modPemeriksaanFisik, 'tekanandarah', array('class' => 'control-label')); ?>
                    <div class="controls">
                     <?php
                        echo $form->textField($modPemeriksaanFisik, 'td_systolic', array('class' => 'span1 numbersOnly systolic', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this); getText();', 'style' => 'text-align: right;'));
                        /*
							$this->widget('CMaskedTextField', array(
							'model' => $modPemeriksaanFisik,
							'attribute' => 'td_systolic',
							'mask' => '999',
							'placeholder'=>'0',
							'htmlOptions' => array('class'=>'span1 systolic', 'onkeypress'=>"return $(this).focusNextInputField(event)",'onkeyup'=>'returnValue(this); getText();') // change(this); getTekananDarah(this) change(this);getText();
							));
		     */ ?>Mm
							<?php // echo $form->textField($modPemeriksaanFisik,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 integer numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));
                            ?>
                     <?php
                        echo $form->textField($modPemeriksaanFisik, 'td_diastolic', array('onblur' => '', 'readonly' => false, 'class' => 'span1 numbersOnly diastolic', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this); getText();', 'style' => 'text-align: right;'));
                        /*
							$this->widget('CMaskedTextField', array(
							'model' => $modPemeriksaanFisik,
							'attribute' => 'td_diastolic',
							'mask' => '999',
							'placeholder'=>'0',
							'htmlOptions' => array('class'=>'span1 diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'onkeyup'=>'returnValue(this); getText();') //getTekananDarah(this); ,'onkeyup'=>'getText();'
							)); */
                        ?>Hg
                     <?php // echo $form->textField($modPemeriksaanFisik,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));
                        ?>
						&nbsp;
                    </div>
            </div>
			<div class="control-group">
				<?php echo CHtml::Label('', '', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
                    $modPemeriksaanFisik->tekanandarah = empty($modPemeriksaanFisik->tekanandarah) ? "000 / 000" : $modPemeriksaanFisik->tekanandarah;
                    $this->widget('CMaskedTextField', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'tekanandarah',
                        'mask' => '999 / 999',
                        'placeholder' => '000 / 000',
                        'htmlOptions' => array('readonly' => true, 'class' => 'span2 integer', 'style' => 'width:60px;', 'onkeypress' => "return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                    ));
                    ?> Mm/Hg
				</div>
			</div>
                <div class="control-group">
                    <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                             <?php echo CHtml::textField('tekananDarah', '', array('class' => 'span2 ', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modPemeriksaanFisik, 'mean arteri pressure', array('class' => 'control-label')); ?>
                    <div class="controls">
                             <?php echo $form->textField($modPemeriksaanFisik, 'meanarteripressure', array('readonly' => true, 'class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    </div>
                </div>
                <div class="control-group">
                        <?php echo $form->LabelEx($modPemeriksaanFisik, 'detaknadi', array('label' => '<i class="icon-facetime-video hoveringIcon" onclick="getfromDevice();"></i> Detak Nadi', 'class' => 'control-label')); ?>
                        <div class="controls">
                                 <?php echo $form->textField($modPemeriksaanFisik, 'detaknadi', array('class' => 'span2 integer  numbersOnly', 'maxlength' => 10, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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
                                 <?php echo $form->textField($modPemeriksaanFisik, 'suhutubuh', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'style' => 'text-align:right;')); ?>
                         &#176 Celcius
                        </div>
                </div>
                <div class="control-group">
                        <?php echo $form->LabelEx($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'control-label', 'style' => 'width:75px')); ?>
                        <?php echo $form->LabelEx($modPemeriksaanFisik, 'beratbadan_kg', array('class' => 'control-label', 'style' => 'width:80px')); ?>
                        <div class="controls">
                                <div class="groupUkurans">
                                        <?php echo $form->textField($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'span1 numbersOnly tinggibadan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3, 'style' => 'text-align:right;')); ?>
                                        <?php echo $form->hiddenField($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'span1  numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
                                        <?php echo CHtml::dropDownList('meter', '100', array('100' => 'Cm', '0.01' => 'M'), array('style' => 'width:50px;', 'class' => 'span1', 'onchange' => 'gantiJumlah(this)')); ?>
                                </div>
                                <div class="groupUkurans">
                                 <?php echo $form->textField($modPemeriksaanFisik, 'beratbadan_kg', array('class' => 'span1 numbersOnly beratbadan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3, 'style' => 'text-align:right;')); ?>
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
            </fieldset>-->
                        <fieldset>
                            <?php echo $this->renderPartial($this->path_view . "pemeriksaan/_tandaVital", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true); ?>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 17px;">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Anggota Tubuh
                        </div>
                    </div>
                    <div class="panel-body" style="width:412px !important;">
                        <div class="control-group">
                            <?php //echo $form->LabelEx($modPemeriksaanFisik, 'gambartubuh_id', array('label' => 'Pilih Gambar', 'class' => 'control-label')); 
                            ?>
                            <!-- <div class="controls">
                            <?php
                            //echo $form->dropDownList($modPemeriksaanFisik, 'gambartubuh_id', GambartubuhM::listGambartubuh(), array('empty' => '-- Pilih --','class' => 'gambartubuh_id gambartubuh_select', 'onchange' => 'loadgambartubuh(this)'));
                            ?>
                        </div> -->
                        </div>
                        <div class="gambar">
                            <?php echo $this->renderPartial($this->path_view . "_formGambarNew", array('id' => $modPemeriksaanFisik->gambartubuh_id, 'temp_file' => $modPemeriksaanFisik->temp_file, 'modGambarTubuh' => $modGambarTubuh)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class='block-tabel'>
                            <table class="items table table-bordered table-striped table-condensed" id="table-bagtubuh">
                                <thead>
                                    <tr>
                                        <th width='30'>No.</th>
                                        <th width='120'>Tanggal Pemeriksaan</th>
                                        <th>Bagian Tubuh</th>
                                        <th>Look</th>
                                        <th>Feel</th>
                                        <th>Move</th>
                                        <th>Sensory</th>
                                        <th>Motorik</th>
                                        <th>Keterangan</th>
                                        <th width='80'>Batal / Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (($modPemeriksaanGambar)) {
                                        foreach ($modPemeriksaanGambar as $ii => $vv) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <p style="margin: 0; text-align: center;"><?= $ii + 1; ?></p>
                                                </td>
                                                <td><?= $format->formatDateTimeForUser($vv->tglpemeriksaan); ?></td>
                                                <td>
                                                    <?= $vv->bagiantubuh->namabagtubuh; ?>
                                                    <?php echo CHtml::HiddenField('bagiantubuh_id', $vv->bagiantubuh_id, array('style' => 'width:50px;', 'class' => 'integer', 'data-delete' => $vv->gambartubuh_id)); ?>
                                                    <?php echo CHtml::HiddenField('gambartubuh_id', $vv->gambartubuh_id, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                                    <?php echo CHtml::HiddenField('pemeriksaangambar_id', $vv->pemeriksaangambar_id, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                                    <?php echo CHtml::HiddenField('kordinat_tubuh_x', $vv->kordinat_tubuh_x, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                                    <?php echo CHtml::HiddenField('kordinat_tubuh_y', $vv->kordinat_tubuh_y, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                                </td>
                                                <td><?= $vv->look; ?></td>
                                                <td><?= $vv->feel; ?></td>
                                                <td><?= $vv->move; ?></td>
                                                <td><?= $vv->sensory; ?></td>
                                                <td><?= $vv->motorik; ?></td>
                                                <td><?= $vv->keterangan_periksa_gbr; ?></td>
                                                <td>
                                                    <p style="margin: 0; text-align: center;"><a onclick="hapusBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-trash"></i></a></p>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="far fa-file-alt"></i> Pemeriksaan Anggota Tubuh
                        </div>
                    </div>
                    <div class="panel-body" style="width:412px !important;">
                        <?php
                        // $i = 1;
                        // $gbrTubuh = $modGambarTubuh->AllDataGambarAnatomi;
                        // foreach ($gbrTubuh as $tbh) {
                        //     if ($i == 1) {
                        //         $css = " 
						// 		#imgtag" . $tbh->gambartubuh_id . "
						// 		{
						// 				position: relative;
						// 				min-width: 300px;
						// 				min-height: 300px;
						// 				float: none;
						// 				border: 3px solid #FFF;
						// 				cursor: crosshair;
						// 				text-align: center;
						// 				z-index:10 !important;
						// 		}
						// 		#tagit" . $tbh->gambartubuh_id . "
						// 		{
						// 				position: absolute;
						// 				top: 0;
						// 				left: 0;
						// 				width: 300px;
						// 				border: 1px solid #D7C7C7;
						// 				z-index: 10;
						// 		}
						// 		#tagit" . $tbh->gambartubuh_id . " .name
						// 		{
						// 				/*float: left;*/
						// 				background-color: #FFF;
						// 				width: 295px;
						// 				/*height: 92px;*/
						// 				/*padding: 5px;*/
						// 				font-size: 10pt;
						// 				margin:0 auto;
						// 				margin-bottom: 0 auto;
						// 		}
						// 		#tagit" . $tbh->gambartubuh_id . " DIV.text
						// 		{
						// 				margin-bottom: 5px;
						// 		}
						// 		#tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
						// 		{
						// 				margin-bottom: 5px;
						// 		}
						// 		#tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
						// 		{
						// 				width: 110px;
						// 		}";
                        ?>
                                <!--<div align="center" id="imgtag">
									<img img-no="" alt="<?php //echo $tbh->gambartubuh_id 
                                                        ?>"  id="myImgId" src="<?php //echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; 
                                                                                ?>" class="taggd"/> 
							<div id="tagbox"></div>
							</div>-->
                                <!-- <div align="center" id="imgtag<?php //echo $tbh->gambartubuh_id ?>">
                                    <!--<img data-id="" img-no="<?php //echo $tbh->gambartubuh_id ?>" alt="<?php //echo $tbh->gambartubuh_id ?>" id="myImgId<?php //echo $tbh->gambartubuh_id ?>" src="<?php //echo Params::urlPhotoAnatomiTubuh() . $tbh->nama_file_gbr; ?>" class="taggd<?php //echo $tbh->gambartubuh_id ?>" style="width:480px;" />-->
                                    <!-- <img data-id="" img-no="<?php //echo $tbh->gambartubuh_id ?>" alt="<?php //echo $tbh->gambartubuh_id ?>" id="myImgId<?php //echo $tbh->gambartubuh_id ?>" src="<?php //echo Yii::app()->request->baseUrl; ?>/images/anatomi.jpg" class="taggd<?php //echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                                    <div id="tagbox<?php //echo $tbh->gambartubuh_id ?>"//></div>
                                </div> -->
                            <?php
                           // } //else {

                            //if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD ||  Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PERSALINAN){
                            // $css .= " 
                            // #imgtag" . $tbh->gambartubuh_id . "
                            // {
                            //         position: relative;
                            //         min-width: 300px;
                            //         min-height: 300px;
                            //         float: none;
                            //         border: 3px solid #FFF;
                            //         cursor: crosshair;
                            //         text-align: center;
                            // 		z-index:10 !important;
                            // }
                            // #tagit" . $tbh->gambartubuh_id . "
                            // {
                            //         position: absolute;
                            //         top: 0;
                            //         left: 0;
                            //         width: 300px;
                            //         border: 1px solid #D7C7C7;
                            //         z-index: 10;
                            // }
                            // #tagit" . $tbh->gambartubuh_id . " .name
                            // {
                            //         /*float: left;*/
                            //         background-color: #FFF;
                            //         width: 295px;
                            //         /*height: 92px;*/
                            //         /*padding: 5px;*/
                            //         font-size: 10pt;
                            //         margin:0 auto;
                            //         margin-bottom: 0 auto;
                            // }
                            // #tagit" . $tbh->gambartubuh_id . " DIV.text
                            // {
                            //         margin-bottom: 5px;
                            // }
                            // #tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
                            // {
                            //         margin-bottom: 5px;
                            // }
                            // #tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
                            // {
                            //         width: 110px;
                            // }";
                            ?>
                            <!-- <div align="center" id="imgtag<?php //echo $tbh->gambartubuh_id 
                                                                ?>">
                                    <img img-no="<?php //echo $tbh->gambartubuh_id 
                                                    ?>" alt="<?php //echo $tbh->gambartubuh_id 
                                                                ?>" id="myImgId<?php //echo $i 
                                                                                ?>" src="<?php //echo Params::urlPhotoAnatomiTubuh() . $tbh->nama_file_gbr; 
                                                                                            ?>" class="taggd<?php //echo $tbh->gambartubuh_id 
                                                                                                            ?>" style="width:480px;" />
                                    <img img-no="<?php //echo $tbh->gambartubuh_id 
                                                    ?>" alt="<?php //echo $tbh->gambartubuh_id 
                                                                ?>" id="myImgId<?php //echo $i 
                                                                                ?>" src="<?php //echo Yii::app()->request->baseUrl; 
                                                                                            ?>/images/anatomi.jpg" class="taggd<?php //echo $tbh->gambartubuh_id 
                                                                                                                                ?>" style="width:480px;" />
                                    <div id="tagbox<?php //echo $tbh->gambartubuh_id 
                                                    ?>"></div>
                                </div> -->
                        <?php
                            //}
                            //}
                            //$i++;
                        // }
                        // Yii::app()->clientScript->registerCss('anatomi', $css);
                        ?>
                        <?php /*
					<div align="center" id="imgtag">
						<img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh().$modGambarTubuh->FileNameGambar; ?>" class="taggd"/> 
						<div id="tagbox"></div>
					</div>
                     * 
                     */ ?>
                    <!-- </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class='block-tabel'>
                            <table class="items table table-bordered table-striped table-condensed" id="table-bagtubuh">
                                <thead>
                                    <tr>
                                        <th width='30'>No.</th>
                                        <th width='120'>Tanggal Pemeriksaan</th>
                                        <th>Bagian Tubuh</th>
                                        <th>Look</th>
                                        <th>Feel</th>
                                        <th>Move</th>
                                        <th>Sensory</th>
                                        <th>Motorik</th>
                                        <th>Keterangan</th>
                                        <th width='80'>Batal / Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (($modPemeriksaanGambar)) {
                                        foreach ($modPemeriksaanGambar as $ii => $vv) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <p style="margin: 0; text-align: center;"><?= $ii + 1; ?></p>
                                                </td>
                                                <td><?= $format->formatDateTimeForUser($vv->tglpemeriksaan); ?></td>
                                                <td>
                                                    <?= $vv->bagiantubuh->namabagtubuh; ?>
                                                    <?php echo CHtml::HiddenField('bagiantubuh_id', $vv->bagiantubuh_id, array('style' => 'width:50px;', 'class' => 'integer', 'data-delete' => $vv->gambartubuh_id)); ?>
                                                    <?php echo CHtml::HiddenField('gambartubuh_id', $vv->gambartubuh_id, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                                    <?php echo CHtml::HiddenField('pemeriksaangambar_id', $vv->pemeriksaangambar_id, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                                    <?php echo CHtml::HiddenField('kordinat_tubuh_x', $vv->kordinat_tubuh_x, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                                    <?php echo CHtml::HiddenField('kordinat_tubuh_y', $vv->kordinat_tubuh_y, array('style' => 'width:50px;', 'class' => 'integer')); ?>
                                                </td>
                                                <td><?= $vv->look; ?></td>
                                                <td><?= $vv->feel; ?></td>
                                                <td><?= $vv->move; ?></td>
                                                <td><?= $vv->sensory; ?></td>
                                                <td><?= $vv->motorik; ?></td>
                                                <td><?= $vv->keterangan_periksa_gbr; ?></td>
                                                <td>
                                                    <p style="margin: 0; text-align: center;"><a onclick="hapusBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-trash"></i></a></p>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-sm-6">
                <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_kepalaLeher", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success panel_cgsews">
                    <div class="panel-heading">
                        <div class="panel-title"><?php echo $form->checkBox($modPemeriksaanFisik, 'gcs_eye', array('class' => 'cek_ews', 'uncheckValue' => null)); ?>
                            <i class="far fa-file-alt"></i> Glasgow Coma Scale
                            <?php echo CHtml::link('<i class="icon-chevron-right icon-white" style="cursor:pointer;"></i>', '', array('onclick' => "$('#dialogGCS').dialog('open')", 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'color:#333;')); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <div id="divGlowComoScale" style="display: block">
                                <?php // echo  CHtml::button('Gunakan Metode GCS',array('class'=>'btn btn-info','onclick'=>"$('#dialogGCS').dialog('open')", 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                                ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($modPemeriksaanFisik, 'gcs_eye', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php $crit = new CDbCriteria();
                                        $crit->compare('LOWER(metodegcs_singkatan)', "e");
                                        $crit->addCondition('metodegcs_nilai is not null');
                                        $crit->order = 'metodegcs_nilai ASC';
                                        echo $form->dropDownList(
                                            $modPemeriksaanFisik,
                                            'gcs_eye',
                                            CHtml::listData(RIMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'),
                                            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()')
                                        ); ?>
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
                                        echo $form->dropDownList(
                                            $modPemeriksaanFisik,
                                            'gcs_verbal',
                                            CHtml::listData(RIMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'),
                                            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()')
                                        ); ?>
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
                                        echo $form->dropDownList(
                                            $modPemeriksaanFisik,
                                            'gcs_motorik',
                                            CHtml::listData(RIMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'),
                                            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()')
                                        ); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo $form->labelEx($modPemeriksaanFisik, 'namaGCS', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($modPemeriksaanFisik, 'gcs_id', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                                        <?php echo CHtml::textField('namaGCS', (isset($modPemeriksaanFisik->gcs->gcs_nama) ? $modPemeriksaanFisik->gcs->gcs_nama : "-"), array('disabled' => true, 'class' => 'span2')); ?>
                                    </div>
                                </div>
                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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
                                    <?php foreach ($modRIMetodeGSCM as $i => $item) :
                                        if ($item->metodegcs_nilai == '') {
                                            echo "<tr bgcolor='#E5ECF9'>
                                            <td>" . $item->metodegcs_nama . "</td>
                                            <td>&nbsp;</td>    
                                      </tr>";
                                        } else {
                                            echo "<tr>
                                            <td>" . $item->metodegcs_nama . "</td>
                                            <td><div id=\"divTombol\">" . CHtml::button($item->metodegcs_nilai, array(
                                                'class' => 'btn btn-danger',
                                                'onclick' => 'SetNilai(this)',
                                                'id' => $item->metodegcs_singkatan,
                                            )) . "</div></td>    
                                      </tr>";
                                        }
                                    endforeach; ?>
                                </table>
                                <?php $this->endWidget(); ?>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <?php
                if (in_array(Yii::app()->user->getState('ruangan_id'), array(
                    Params::RUANGAN_ID_NICU,
                    Params::RUANGAN_ID_BAYI_SAKIT,
                    Params::RUANGAN_ID_BAYI_SEHAT,
                ))) {
                    echo $this->renderPartial($this->path_view . "pemeriksaan/_reflekBayi", array(
                        'modPemeriksaanFisik' => $modPemeriksaanFisik,
                        'form' => $form,
                    ), true);
                }
                ?>

            </div>
        </div>

        <div class="row" hidden>
            <div class="col-sm-12">
                <?php echo $this->renderPartial($this->path_view . 'pemeriksaan._ews', array(
                    'model' => $modPemeriksaanFisik, 'form' => $form
                ), true); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-7">
                <fieldset class=''>
                    <div class="panel panel-success panel_cgsews">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo $form->checkBox($modPemeriksaanFisik, 'thorax', array('class' => 'cek_ews', 'uncheckValue' => null)); ?>
                                <i class="far fa-file-alt"></i> Thorax
                            </div>
                            <div class="panel-title dbnstyle">
                                <span><?php echo CHtml::checkBox("DbnTorax", '', array('onchange' => 'dbnTorax()')) . ' <label>DBN (Dalam Batas Normal)</label>' ?></span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php

                            echo $this->renderPartial($this->path_view . "pemeriksaan/_thorax", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);

                            ?>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-sm-5">
                <fieldset>
                    <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_cardio", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <fieldset>
                    <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_pulmo", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
                </fieldset>
            </div>

            <div class="col-sm-6">
                <fieldset>
                    <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_abdomen", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <fieldset>
                    <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_obstetri", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
                </fieldset>
            </div>

            <div class="col-sm-6">
                <fieldset>
                    <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_genitalia", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
                </fieldset>
            </div>
        </div>

        <!--<legend class="accord1" style="width:460px;">-->
        <!--		<?php // echo CHtml::checkBox('pemeriksaanFisik',false, array('onkeypress'=>"return $(this).focusNextInputField(event)")) 
                    ?> Pemeriksaan Anggota Tubuh-->
        <!--</legend>-->
        <!--<div id="divBagianYAngDiperiksa" class="" style="display: none">-->

        <div class="row">
            <div class="col-sm-12">
                <?php
                echo $this->renderPartial($this->path_view . "pemeriksaan/_integumen", array(
                    'modIntegumen' => $modIntegumen,
                    'form' => $form
                ), true);
                ?>
            </div>
        </div>

        <?php echo $this->renderPartial($this->path_view . 'pemeriksaan/rd/_lainlain', array('form' => $form, 'modPemeriksaanFisik' => $modPemeriksaanFisik), true); ?>

        <div class="col-sm-6" hidden>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fas fa-lungs"></i> Jalan Nafas
                    </div>
                </div>
                <div class="panel-body">
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
                </div>
            </div>
        </div>
        <div class="col-sm-6" hidden>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fas fa-lungs"></i> Pernapasan
                    </div>
                </div>
                <div class="panel-body">
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
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div hidden class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fas fa-lungs"></i> Pernapasan Gerakan Dada
                    </div>
                </div>
                <div class="panel-body">
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
                </div>
            </div>
        </div>
        <div hidden class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Sirkulai</div>
                </div>
                <div class="panel-body">
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

                    </div>
                </div>
            </div>

            <div class="form-actions">
                <?php
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
                    echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => TRUE));
                    echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemeriksaanFisik();return false", 'disabled' => FALSE));
                }

                ?>
                <?php
                $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
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
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
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
        $('#RIPemeriksaanFisikT_gcs_eye').val(valueGCS);
    }else if(idTombol=='M'){
        $('#RIPemeriksaanFisikT_gcs_motorik').val(valueGCS);
    }else if(idTombol=='V'){
        $('#RIPemeriksaanFisikT_gcs_verbal').val(valueGCS);
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
    gcs_eye =  $('#RIPemeriksaanFisikT_gcs_eye').val();
    gcs_motorik =  $('#RIPemeriksaanFisikT_gcs_motorik').val();
    gcs_verbal =  $('#RIPemeriksaanFisikT_gcs_verbal').val(); 

        
    console.log(gcs_eye);    
    console.log(gcs_motorik);    
    console.log(gcs_verbal);    
   
    if((gcs_eye!='') && (gcs_motorik!='') &&(gcs_verbal!='')){
        $.post("${urlgetMetodeGCS}",{gcs_eye: gcs_eye,gcs_motorik:gcs_motorik,gcs_verbal:gcs_verbal},
        function(data){
            console.log(data)
               if(data.pesan==null){
                   console.log(data)
                 $('#RIPemeriksaanFisikT_gcs_id').val(data.gcs_id);
                 $('#namaGCS').val(data);
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
            $('#${arteriPressure}').val(arteri.toFixed(2));
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
<?php echo $this->renderPartial('_jsFunctions', array(
    'modPendaftaran' => $modPendaftaran,
    'modPemeriksaanFisik' => $modPemeriksaanFisik,
    'modBagianTubuh' => $modBagianTubuh,
    'modPemeriksaanGambar' => $modPemeriksaanGambar
)); ?>
