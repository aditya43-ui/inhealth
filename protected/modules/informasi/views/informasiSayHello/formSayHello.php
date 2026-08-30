<style type="text/css">
    table tr td.rights {
        text-align: right;
        padding-right: 10px;
        width: 100px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Say Hello
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pasien Penunjang' => Yii::app()->request->getUrlReferrer(),
            'Say Hello ',
        );
        $this->widget('bootstrap.widgets.BootAlert');
        echo $this->renderPartial('_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi));
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'inputSayHello-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>

        <br>
        <div class="row">
            <div class="col-sm-6">
                <?php echo CHtml::activeHiddenField($modSayHello, 'pasien_id', array('readonly' => true, 'value' => $modPasien->pasien_id)); ?>
                <?php echo CHtml::activeHiddenField($modSayHello, 'pendaftaran_id', array('readonly' => true, 'value' => $modPendaftaran->pendaftaran_id)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modSayHello, 'pasiensayhello_media', array('class' => 'control-label', 'label' => 'Media')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modSayHello,
                            'pasiensayhello_media',
                            LookupM::getItems('pasiensayhello_media'),
                            array(
                                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'required' => 'required'
                            )
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modSayHello, 'pasiensayhello_deskripsi', array('class' => 'control-label', 'label' => 'Deskripsi')); ?>
                    <div class="controls" style="width: 100%;">
                        <?php // echo $form->textArea($modSayHello, 'pasiensayhello_deskripsi', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                        ?>
                        <?php $this->widget('ext.redactorjs.Redactor', array(
                            'model' => $modSayHello,
                            'attribute' => 'pasiensayhello_deskripsi',
                            'name' => 'INPasiensayhelloT_pasiensayhello_deskripsi',
                            'toolbar' => 'mini',
                            'height' => '150px',
                            'htmlOptions' => array(
                                'required' => 'required'
                            )
                        )); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modSayHello, 'pasiensayhello_kritik', array('class' => 'control-label', 'label' => 'Kritik')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modSayHello, 'pasiensayhello_kritik', array('placeholder' => 'Kritik', 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modSayHello, 'pasiensayhello_saran', array('class' => 'control-label', 'label' => 'Saran')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modSayHello, 'pasiensayhello_saran', array('placeholder' => 'Saran', 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modSayHello, 'kesimpulan', array('class' => 'control-label', 'label' => 'Kesimpulan')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modSayHello,
                            'kesimpulan',
                            LookupM::getItems('kepuasanpasien'),
                            array(
                                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            )
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modSayHello, 'pasiensayhello_tgl', array('class' => 'control-label', 'label' => 'Tgl. Say Hello')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $modSayHello,
                            'attribute' => 'pasiensayhello_tgl',
                            'mode' => 'date',
                            'options' => array(
                                'maxDate' => 'd',
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => 'span3 dtPicker3'
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class='form-actions'>
            <?php
            if (@$_GET['SUKSES'] == 1) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                    'class' => 'btn btn-danger', 'type' => 'button',
                    'disable' => true,
                    'onclick' => "return false",
                    'style' => 'cursor:not-allowed;',
                    'title' => 'Simpan', 
                ));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            } else if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                    'class' => 'btn btn-danger', 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)',
                    'id' => 'btn_simpan',
                ));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                    'class' => 'btn btn-danger', 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)',
                    'id' => 'btn_simpan',
                ));
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
if (@$_GET['SUKSES'] == 1 || isset($_GET['edit'])) {
    $pendaftaran_id = $_GET['pendaftaran_id'];
    $pasienadmisi_id = $_GET['pasienadmisi_id'];
    $pasiensayhello_id = $_GET['pasiensayhello_id'];
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $js = <<< JSCRIPT
function print(caraPrint)
{
	window.open("${urlPrint}"+"&pendaftaran_id="+${pendaftaran_id}+"&pasienadmisi_id="+${pasienadmisi_id}+"&pasiensayhello_id="+${pasiensayhello_id},"",'location=_new, width=800px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
}
?>