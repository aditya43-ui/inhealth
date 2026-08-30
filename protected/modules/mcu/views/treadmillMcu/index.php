<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Treadmill berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'treadmill-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>

<div class="formInputTab">
    <?php echo $form->errorSummary($modTreadmill); ?>
    <div class="row">
        <!--<fieldset class="box">-->
        <!--<legend class="rim">Pemeriksaan Treadmill</legend>-->
        <div class="span12">
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-riwayat',
                'content' => array(
                    'content-riwayat' => array(
                        'header' => '<b>Riwayat Treadmil</b>',
                        'isi' => $this->renderPartial($this->path_view . '_formRiwayat', array(
                            //'form'=>$form,
                            'format' => $format,
                            'modTreadmill' => $modTreadmill,
                            'modTreadmilRiwayat' => $modTreadmilRiwayat,
                            'modPegawai' => $modPegawai
                        ), true),
                        'active' => false,
                    ),
                ),
            )); ?>

            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'duration_treadmill', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modTreadmill,
                        'duration_treadmill',
                        CHtml::listData(KlasifikasifitnesM::model()->findAll(), 'klasifikasifitnes_id', 'lama_menit'),
                        array('style' => 'width:160px;', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")
                    ); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'blood_preasure', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('CMaskedTextField', array(
                        'model' => $modTreadmill,
                        'attribute' => 'td_systolic',
                        'mask' => '999',
                        'placeholder' => '0',
                        'htmlOptions' => array('class' => 'span1 numbers-only systolic', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onkeyup' => 'returnValue(this); getText();', 'onblur' => 'setRange(this);') // change(this); getTekananDarah(this) change(this);getText();
                    ));
                    ?> /
                    <?php // echo $form->textField($modPemeriksaanFisik,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 integer numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));
                    ?>
                    <?php
                    $this->widget('CMaskedTextField', array(
                        'model' => $modTreadmill,
                        'attribute' => 'td_diastolic',
                        'mask' => '999',
                        'placeholder' => '0',
                        'htmlOptions' => array('class' => 'span1 numbers-only diastolic', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onkeyup' => 'returnValue(this); getText();') //getTekananDarah(this); ,'onkeyup'=>'getText();'
                    ));
                    ?> mmHg
                    <?php // echo $form->textField($modPemeriksaanFisik,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'heart_rate', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTreadmill, 'heart_rate', array('class' => 'span1 numbersOnly systolic', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this)')); ?>
                    <?php echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i>',
                        array(
                            'onclick' => 'tambahTreadmill();return false;',
                            'class' => 'btn btn-danger',
                            'onkeypress' => "tambahTreadmill();return false;",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan Treadmill",
                            'disabled' => false,
                        )
                    ); ?>
                </div>
            </div>
        </div>
        <table style="width: 100%; border: none;">
            <tr>
                <td width="100%">
                    <table id="form-treadmilldetail-mcu" class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Duration</th>
                                <th>Blood Preasure</th>
                                <th>Heart Rate</th>
                                <th>Work Load</th>
                                <th>Est. 02 Rate</th>
                                <th>Max. 02 Intake</th>
                                <th>Mets</th>
                                <th>Fitness Clasification</th>
                                <th>Walking</th>
                                <th>Jogging</th>
                                <th>Bicycling</th>
                                <th>Other Sport</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'resttime_menit', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTreadmill, 'resttime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'worktime_menit', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTreadmill, 'worktime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'recoverytime_menit', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTreadmill, 'recoverytime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'totaltime_menit', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTreadmill, 'totaltime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'interpretation_tradmill', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modTreadmill, 'interpretation_tradmill', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'namapemeriksa_treadmill', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modTreadmill,
                        'attribute' => 'namapemeriksa_treadmill',
                        'value' => '',
                        'sourceUrl' => $this->createUrl('AutocompletePemeriksa'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                                              $(this).val( ui.item.nama_pegawai);
                                                              return false;
                                                      }',
                        ),
                    )); ?>
                    <?php // echo $form->textField($modTreadmill,'namapemeriksa_treadmill',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php // echo $form->LabelEx($modTreadmill,'hasiltreadmill',array('class'=>'control-label'));
                ?>
                <!--<div class="controls">-->
                <?php echo $form->radioButtonListInlineRow($modTreadmill, 'hasiltreadmill', array('Normal' => 'Normal', 'Ada Kelainan' => 'Ada Kelainan'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <!--</div>-->
            </div>
        </div>
        <!--</fieldset>-->
    </div>
    <div class="form-actions">
        <?php
        $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
        $disableSave = false;
        $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
        ?>
        <?php $disablePrint = ($disableSave) ? false : true; ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekInput();', 'onkeypress' => 'cekInputan();', 'disabled' => $disableSave)); //formSubmit(this,event)        
        //  jika tanpa cek inputan
        /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
				array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
         * 
         */
        ?>
        <?php if (!isset($_GET['frame'])) {
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
        } ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Diagram', array('{icon}' => '<i class="entypo-print"></i>')),
            $this->createUrl($this->id . '/grafik&treadmill_id=' . $modTreadmill->treadmill_id . '&pendaftaran_id=' . $modTreadmill->pendaftaran_id),
            array('class' => 'btn btn-info', "target" => "frameDiagramTreadmill", "onclick" => "$('#dialogGrafik').dialog('open');")
        );
        ?>
        <?php
        $content = $this->renderPartial($this->path_view . 'tips/tipsTreadmill', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPendaftaran' => $modPendaftaran, 'modTreadmill' => $modTreadmill, 'modTreadmillDetail' => $modTreadmillDetail)); ?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogGrafik',
        'options' => array(
            'title' => 'Diagram Treadmill',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe name='frameDiagramTreadmill' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>