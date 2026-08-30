<?php
$this->breadcrumbs = array(
    'Surveilans HAis' => array(),
    'HAis',
);
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'surveilans-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //        'focus'=>'#namaObatNonRacik',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));

if ($this->layout != '//layouts/iframe') { ?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Surveilans HAIs
            </div>
        </div>
        <div class="panel-body">
        <?php } ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php
        if ($this->action->id == 'periksa') {
            echo $this->renderPartial($this->path_view . "_pilihDaftarPasien", array(
                'form' => $form,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
            ), true);
        }

        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'riwayat-Surveilans',
            'content' => array(
                'content-riwayat-Surveilans' => array(
                    'header' => '<b>Riwayat Surveilans</b>',
                    'isi' => $this->renderPartial($this->path_view . '_tableRiwayatSurveilans', array(
                        'modRiwayatSurveilans' => $modRiwayatSurveilans,
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        ?>

        <div style="overflow-x: hidden;">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-calendar"></i> Hari Pemasangan Alat
                            </div>
                        </div>
                        <div class="panel-body table-responsive">

                            <div class="control-group">
                                <?php

                                echo CHtml::label('ETT', 'Ett', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'ett', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label('PVC', 'CVP', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'cvp', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label('CVC', 'CVC', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'cvc', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label('UC', 'UC', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'uc', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label('CDL', 'CDL', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'cdl', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-briefcase"></i> Tindakan
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <div class="control-group">
                                <?php

                                echo CHtml::label('Surgery', 'Surgery', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'surgery', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="panel panel-success" style="min-height: 360px;">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-briefcase"></i> Infeksi Rs
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <div class="control-group">
                                <?php echo CHtml::label('VAP', 'VAP', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'vap', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label('IADP', 'IADP', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'iad', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label('ISK', 'ISK', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'isk', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label('IDO', 'IDO', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'ido', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label('Phlebitis', 'PLEB', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'pleb', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Dekubitus', 'PLEB', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activecheckBox($modSurveilans, 'deku', array('value' => 1, 'uncheckValue' => 0, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-file-alt"></i> Data <b>Surveilans</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Sputum', 'Sputum', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::activetextField($modSurveilans, 'sputum', array('placeholder' => 'Sputum', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Darah', 'Darah', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::activetextField($modSurveilans, 'darah', array('placeholder' => 'Darah', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Urine', 'Urine', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::activetextField($modSurveilans, 'urine', array('placeholder' => 'Urine', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modSurveilans, 'diagnosa_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::activehiddenField($modSurveilans, 'diagnosa_id', array('readonly' => true)) ?>
                                <?php

                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'diagnosa',
                                    'value' => empty($modSurveilans->diagnosa) ? "" : $modSurveilans->diagnosa->diagnosa_nama,
                                    'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . Yii::app()->createUrl('ActionAutoComplete/Diagnosa') . '",
                                                                           dataType: "json",
                                                                           data: {
                                                                               term: request.term,
                                                                           },
                                                                           success: function (data) {
                                                                                   response(data);
                                                                           }
                                                                       })
                                                                    }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui )
                                                                               {
                                                                                $(this).val(ui.item.label);
                                                                                return false;
                                                                                }',
                                        'select' => 'js:function( event, ui ) {
                                                                               $(\'#RJSurveilansT_diagnosa_id\').val(ui.item.value);
                                                                              
                                                                              
                                                                                return false;
                                                                            }',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => false,
                                        'placeholder' => 'Diagnosa',
                                        'size' => 13,
                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogkasuspenyakitdiagnosa'),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Pasang', 'Tanggal Pasang', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modSurveilans,
                                    'attribute' => 'surveilans_tgl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //							'maxDate'=>'d',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'span2',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Lepas', 'Tanggal Lepas', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modSurveilans,
                                    'attribute' => 'pelepasan_tgl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //							'maxDate'=>'d',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'span2',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Infeksi', 'Tanggal Infeksi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modSurveilans,
                                    'attribute' => 'infeksi_tgl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //							'maxDate'=>'d',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'span2',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Antibiotik', 'Antibiotik', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextArea($modSurveilans, 'antibiotik', array(
                                    'class' => 'span4',
                                    'placeholder' => 'Antibiotik',
                                    'onkeyup' => "return $(this).focusNextInputField(event);"
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">

                    <?php
                    if ($modSurveilans->isNewRecord) {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'enabled' => true)
                        );
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => false)
                        ); //RND-8620
                    }
                    if ($this->action->id == 'periksa') {
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/periksa'),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default',
                                'onclick' => 'return refreshForm(this);'
                            )
                        );
                    } else {
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl('index', array('pendaftaran_id' => $modSurveilans->pendaftaran_id)),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default',
                                'onclick' => 'return refreshForm(this);'
                            )
                        );
                    }
                    ?>

                </div>
            </div>
        </div>
        </div>

        <?php $this->endWidget(); ?>

        <?php if ($this->layout != '//layouts/iframe') { ?>
    </div>
<?php } ?>

<?php echo $this->renderPartial($this->path_view_dialog_pasien . "_dialog", array(), true); ?>

<!--============================== Widget Dialog Diagnosa ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogkasuspenyakitdiagnosa',
    'options' => array(
        'title' => 'Pencarian Diagnosa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDiagnosa = new RJDiagnosaM('searchDiagnosaAnamnesa');
$modDiagnosa->unsetAttributes();
if (isset($_GET['RJDiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['RJDiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-grid',
    'dataProvider' => $modDiagnosa->searchDiagnosaAnamnesa(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectKasuspenyakit",
                                    "onClick" => "
                                    
                                    $(\'#RJSurveilansT_diagnosa_id\').val(\'$data->diagnosa_id\');
                                    $(\'#diagnosa\').val(\'$data->diagnosa_nama\');
                                    $(\'#dialogkasuspenyakitdiagnosa\').dialog(\'close\');	
                                    return false;"))',
        ),
        array(
            'header' => 'Nama Diagnosa',
            'name' => 'diagnosa_nama',
            'value' => '$data->diagnosa_nama',
        ),
        array(
            'header' => 'Nama Lainnya',
            'name' => 'diagnosa_namalainnya',
            'value' => '$data->diagnosa_namalainnya',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>