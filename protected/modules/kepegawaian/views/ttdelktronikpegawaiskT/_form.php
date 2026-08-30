<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ttdelktronikpegawaisk-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype'=>'multipart/form-data','onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data SK Direktur Tanda Tangan Elektronik</div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-sm-6">
                    <?php echo $form->hiddenField($model, 'pegawai_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($model, 'nomor_sk', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'file_surat', array(
                            'class'=>'control-label'
                        )); ?>
                        <div class="controls">
                            <?php echo $form->fileField($model, 'file_surat', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", "onchange"=>"uploadData(this);", "uncheckValue"=>null)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">
                            <?php
                            $src = "";
                            $file_name = "";
                            if (!$model->isNewRecord && !empty($model->file_surat) && file_exists($model->path_file_surat)) {
                                $mime = mime_content_type($model->path_file_surat);
                                if (strpos($mime, "image") !== false) {
                                    $src = "data:".$mime.";base64,".base64_encode(file_get_contents($model->path_file_surat));
                                } else {
                                    $file_name = $model->file_surat;
                                }
                            }
                            
                            ?>
                            <div id="file_peview_name"><?php echo $file_name; ?></div>
                            <img src="<?php echo $src ?>" id="img_preview" style="height: 150px;" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                       <?php echo $form->labelEx($model,'tglberlaku_awal',array('class'=>'control-label')); ?>
                       <div class="controls">
                           <?php   
                           $this->widget('MyDateTimePicker',array(
                               'model'=>$model,
                               'attribute'=>'tglberlaku_awal',
                               'mode'=>'date',
                               'options'=> array(
                                   'dateFormat' => Params::DATE_FORMAT,
                                   'showOn' => false,
                                   // 'maxDate' => 'd',
                                   'showAnim' => '',
                                   'yearRange'=> "-150:+0",
                               ),
                               'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                               ),
                       )); ?>    
                       </div>
                   </div>
                    <div class="control-group">
                       <?php echo $form->labelEx($model,'tglberlaku_akhir',array('class'=>'control-label')); ?>
                       <div class="controls">
                           <?php   
                           $this->widget('MyDateTimePicker',array(
                               'model'=>$model,
                               'attribute'=>'tglberlaku_akhir',
                               'mode'=>'date',
                               'options'=> array(
                                   'dateFormat' => Params::DATE_FORMAT,
                                   'showOn' => false,
                                   'showAnim' => '',
                                   // 'maxDate' => 'd',
                                   'yearRange'=> "-150:+0",
                               ),
                               'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                               ),
                       )); ?>    
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('create', array('id'=>$model->pegawai_id)),
                array('class' => 'btn btn-danger',
                    'onclick' => 'return refreshForm(this);'));
        ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>


<script>
    
    var fileToBase64 = file => new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });

    async function uploadData(obj) {

        $("#img_preview").prop("src", "");
        $("#file_peview_name").html("");

        const file = obj.files[0];
        const type = file.type;
        
        if (type.search("image") == -1 && type.search("pdf") == -1) {
            myAlert("Harus dalam bentuk format PDF/PNG/JPEG/JPG");
            $(obj).val(null);
            return;
        }
        
        const val64 = await fileToBase64(file);
        
        if (val64 instanceof Error) {
            console.log('Error: ', result.message);
            return;
        }
        
        if (type.search("image") != -1) {
            $("#img_preview").prop("src", val64);
        }
        
        console.log(val64, file.type);

    }
    
    $(document).ready(function() {
        <?php 
        if (
            in_array($pegawai->kelompokpegawai_id, array(Params::KELOMPOKPEGAWAI_ID_BIDAN, Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP))
            && (
                empty($pegawai->masa_str) || time() > strtotime($pegawai->masa_str)
            )
        ): ?>
        myAlert("Masa berlaku Surat Tanda Registrasi sudah berakhir. Silahkan perbaharui terlebih dahulu.");
        <?php endif; ?>
    });
    
    
</script>