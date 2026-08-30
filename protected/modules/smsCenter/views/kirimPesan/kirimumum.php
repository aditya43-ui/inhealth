<?php
$this->breadcrumbs = array(
    'Kirim Pesan Umum',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-envelope"></i> Kirim <b>Pesan Umum</b> <?php echo $this->is_blast ? "- SMS Blast" : ""; ?>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'outbox-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);',),
            'focus' => '#',
        )); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Pilih Phone Book</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'pilih_template',
                            'value' => $model->pilih_template,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                                               dataType: "json",
                                                               data: {
                                                                   no_rekam_medik: request.term,
                                                                   ruangan_id: $("#ruangan_id").val(),
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                            'options' => array(
                                'minLength' => 4,
                                'focus' => 'js:function( event, ui ) {
                                                         $(this).val( "");
                                                         return false;
                                                     }',
                                'select' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.no_rekam_medik);
                                                        setKunjungan(ui.item.pendaftaran_id);
                                                        return false;
                                                    }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogSms'),
                            'htmlOptions' => array(
                                'placeholder' => 'Pilih Phone Book', 'class' => 'all-caps',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'DestinationNumber', array(
                        'class' => 'control-label required',
                        'label' => 'No. Tujuan <span class="required">*</span>'
                    )) ?>
                    <div class="controls">
                        <?php
                        echo $form->textArea($model, 'DestinationNumber', array(
                            'placeholder' => 'No. Tujuan', 'class' => 'angka-spasi', 'rows' => 4, 'cols' => 50,
                        ));
                        ?>

                        <?php echo $form->error($model, 'DestinationNumber'); ?>
                    </div>
                </div>
                <?php // echo $form->textAreaRow($model,'DestinationNumber',array('rows'=>3, 'cols'=>50, 'class'=>'span5', 'hint'=>'gunakan tanda koma (,) untuk kirim ke lebih dari satu tujuan', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textAreaRow($model, 'TextDecoded', array('placeholder' => 'Pesan Teks', 'rows' => 4, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'CreatorID', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Kirim', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Kirim', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Kirim', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . $this->id . '/umum'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
                )
            );
            $content = 'Tidak ada petunjuk khusus.';
            $this->widget('UserTips', array('content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>
</div>

<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSms',
    'options' => array(
        'title' => 'Pencarian Phone Book',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modPbk = new Pbk;
$modPbk->unsetAttributes();

if (isset($_GET['Pbk'])) {
    $modPbk->attributes = $_GET['Pbk'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modPbk->search(),
    'filter' => $modPbk,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectSms",
                            "onClick" => "
                                setNomor(\"$data->Number\");
                                $(\"#dialogSms\").dialog(\"close\");
                            "))',
        ),
        array(
            'name' => 'GroupID',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'value' => 'empty($data->group) ? "" : $data->group->Name',
            'filter' => CHtml::listData(PbkGroups::model()->findAll(), 'ID', 'Name'),
        ),
        'Name',
        'Number',
    ),
    'afterAjaxUpdate' => 'function(id, data){
                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            }',
));
////======= end pendaftaran dialog =============

$this->endWidget();
?>

<script>
    function setNomor(nomor) {
        $("#Outbox_DestinationNumber").val($("#Outbox_DestinationNumber").val() + nomor + " ");
    }
</script>