<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Kacamata berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'periksamata-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>

<div class="formInputTab">
    <?php echo $form->errorSummary($modPeriksaKacamata); ?>
    <!--<fieldset class="box">-->
    <!--<legend class="rim">Pemeriksaan Kacamata</legend>-->
    <table class="table-condensed" width="100%">
        <tr>
            <td width="100%">
                <table id="form-pemeriksaanmata-mcu" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th></th>
                            <th style='text-align:center;'>Vitrum Spher</th>
                            <th style='text-align:center;'>Vitrum Cylindr</th>
                            <th style='text-align:center;'>Axis</th>
                            <th style='text-align:center;'>Prisma Basis</th>
                            <th style='text-align:center;'>Vitrum Spher</th>
                            <th style='text-align:center;'>Vitrum Cylindr</th>
                            <th style='text-align:center;'>Axis</th>
                            <th style='text-align:center;'>Prisma Basis</th>
                            <th style='text-align:center;'>Forma Vitror</th>
                            <th style='text-align:center;'>Color Vitror</th>
                            <th style='text-align:center;'>Distant Vitror</th>
                            <th style='text-align:center;'>Forma Jugi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $this->renderPartial('_rowPemeriksaan', array('modUkuranKacamata' => $modUkuranKacamata)); ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->LabelEx($modPeriksaKacamata, 'pro_kacamata', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPeriksaKacamata, 'pro_kacamata', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modPeriksaKacamata, 'permintaanke_kacamata', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPeriksaKacamata, 'permintaanke_kacamata', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPeriksaKacamata, 'jatuhtempo_kacamata', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $modPeriksaKacamata->jatuhtempo_kacamata = (!empty($modPeriksaKacamata->jatuhtempo_kacamata) ? date("d/m/Y", strtotime($modPeriksaKacamata->jatuhtempo_kacamata)) : null);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPeriksaKacamata,
                        'attribute' => 'jatuhtempo_kacamata',
                        'mode' => 'date',
                        'options' => array(
                            //                                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    )); ?>
                    <?php echo $form->error($modPeriksaKacamata, 'jatuhtempo_kacamata'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($modPeriksaKacamata, 'tglperiksakacamata', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $modPeriksaKacamata->tglperiksakacamata = (!empty($modPeriksaKacamata->tglperiksakacamata) ? date("d/m/Y", strtotime($modPeriksaKacamata->tglperiksakacamata)) : null);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPeriksaKacamata,
                        'attribute' => 'tglperiksakacamata',
                        'mode' => 'date',
                        'options' => array(
                            //                                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    )); ?>
                    <?php echo $form->error($modPeriksaKacamata, 'tglperiksakacamata'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php // echo $form->LabelEx($modPeriksaKacamata,'hasil_penglihatan',array('class'=>'control-label'));
                ?>
                <!--<div class="controls">-->
                <?php echo $form->radioButtonListInlineRow($modPeriksaKacamata, 'hasil_penglihatan', array('Normal' => 'Normal', 'Ada Kelainan' => 'Ada Kelainan'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <!--</div>-->
            </div>
        </div>
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
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
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
        $content = $this->renderPartial($this->path_view . 'tips/tipsTreadmill', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPendaftaran' => $modPendaftaran, 'modPeriksaKacamata' => $modPeriksaKacamata, 'modUkuranKacamata' => $modUkuranKacamata)); ?>


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