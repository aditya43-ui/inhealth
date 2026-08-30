<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Perbaikan PPh 21</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sajabatan Ms' => array('index'),
            'Create',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jabatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jabatan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jabatan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembetulan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);'
            ),
            'focus' => '',
        ));
        ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglpembetulan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $model->tglpembetulan = (!empty($model->tglpembetulan) ? MyFormatter::formatDateTimeForUser($model->tglpembetulan) : date('d M Y'));
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpembetulan',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        )); ?>
                        <?php echo $form->error($model, 'tglpembetulan'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'jml_bruto', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'jml_pph', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'tglpajak', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'jmlpembetulan', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group">
                    <?php
                    echo $form->labelEx($model, 'pembetulanke', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pembetulanke', array('class' => 'span1', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 20)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'keterangan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'keterangan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <?php // echo $form->textFieldRow($model,'jabatan_urutan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); 
        ?>
        <?php //echo $form->checkBoxRow($model,'jabatan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="form-actions">
            <?php
            //            $disabled = false;
            //            if(isset($_GET['sukses'])){
            //                $disabled = '';
            //            }
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = ($sukses > 0) ? true : false;
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)); //formSubmit(this,event) 
            ?>
            <?php
            //            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            //                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            ?>

            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'exportCSV()'));
            ?>

            <?php
            $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
        <?php
        $pembetulanpajak_id = isset($_GET['pembetulanpajak_id']) ? $_GET['pembetulanpajak_id'] : null;
        $penggajianpeg_id = isset($_GET['penggajianpeg_id']) ? $_GET['penggajianpeg_id'] : null;

        $urlPrint = $this->createUrl('printPembetulan', array('id' => $pembetulanpajak_id, 'penggajianpeg_id' => $penggajianpeg_id));
        $urlExportCsv = $this->createUrl('ExportCSV', array('id' => $pembetulanpajak_id, 'penggajianpeg_id' => $penggajianpeg_id));
        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
    
function exportCSV()
{
    window.open("${urlExportCsv}","",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>

<script type="text/javascript">
    function formatNumberSemua() {
        $(".integer").each(function() {
            $(this).val(formatInteger($(this).val()));
        });
    }
    jQuery(document).ready(function() {
        formatNumberSemua();
    });
</script>