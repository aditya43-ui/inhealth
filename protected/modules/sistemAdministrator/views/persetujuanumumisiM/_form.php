<style>
    
    .persetujuan_gambar_item {
        display: inline-block;
        margin: 5px;
    }
    
    .persetujuan_gambar_item .img_gambar {
        width: 150px;
        height: 100px;
        overflow: hidden;
        border: 1px solid black;
    }
    
    .persetujuan_gambar_item .btn_hapus {
        position: relative;
        bottom: 30px;
        right: 40px;
    }
    
    .panel_gambar_isi {
        border: 1px solid gray;
        min-width: 600px;
        min-height: 120px;
    }
    
</style>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'persetujuanumumisi-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'persetujuan_isi', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute'=>'persetujuan_isi', 'toolbar' => 'default', 'height' => '200px')) ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'persetujuan_urutan',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model,'isaktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model,'persetujuan_isiadagambar', array('class'=>'persetujuan_isiadagambar','onkeyup'=>"return $(this).focusNextInputField(event);", 'onclick'=>'cekInputGambar();')); ?>
            <div class="control-group panel_gambar">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo CHtml::fileField('input_gambar', '', array( 'class'=>'span3 input_gambar', 'onchange'=>"uploadGambarPersetujuan()")); ?><br/>
                    <div class="panel_gambar_isi">
                        <?php echo $this->renderPartial('form/_panelGambar', array('form'=>$form, 'model'=>$model), true); ?>
                    </div>
                </div>
            </div>
            <?php echo $form->checkBoxRow($model,'persetujuan_isiadainputan', array('class'=>'persetujuan_isiadainputan', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'onclick'=>'cekInputDetail();')); ?>
            <div class="panel_input">
                <hr/>
                <?php echo CHtml::htmlButton('+ Tambah', array('class'=>'btn btn-success', 'onclick'=>'tambahSubForm();')); ?>
                <?php
                if (!$model->isNewRecord) {
                    $inputans = PersetujuanumuminputanM::model()->findAllByAttributes(array(
                        'persetujuanumumisi_id'=>$model->persetujuanumumisi_id
                    ), array(
                        'order'=>'inputan_urutan asc'
                    ));
                    
                    foreach ($inputans as $idx => $inputan) {
                        echo $this->renderPartial('form/input/_form', array('inputan'=>$inputan, 'idx'=>$idx), true);
                    }
                    
                }
                ?>
                <?php // echo $this->renderPartial('form/input/_form', array('idx'=>0), true); ?>
            </div>
        </div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Isi Persetujuan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>

        
<script>
    
    var form_idx = 0;
    
    function cekInputDetail() {
        if ($(".persetujuan_isiadainputan").is(":checked")) {
            $(".panel_input").show();
        } else {
            $(".panel_input").hide();
            $(".panel_input .input_base").remove();
        }
    }
    
    function tambahSubForm() {
        $.post('<?php echo $this->createUrl('tambahSubForm'); ?>', {
            idx: form_idx
        }, function(data) {
            $(".panel_input").append(data);
            form_idx++;
        });
    }
    
    function pilihTipeInput(obj) {
        var tipe = $(obj).val();
        var base = $(obj).parents(".input_base");
        var input_idx = $(base).data('input-index');
        
        $(base).find(".input_detail").html("");
        
        $.post('<?php echo $this->createUrl('loadFormTipeInput'); ?>', {
            tipe: tipe, input_idx: input_idx
        }, function(data) {
            if (data.ok == 1) {
                $(base).find(".input_detail").html(data.html);
            }
        }, 'json');
    }
    
    function setInputanDetailDropdown(obj) {
        var nilai = $(obj).val();
        var input_idx = $(obj).parents(".input_base").data('input-index');
        
        $.post('<?php echo $this->createUrl('ajaxGenerateDetailDropdown'); ?>', {nilai: nilai, input_idx: input_idx}, function(data) {
            if (data.ok == 1) {
                $(obj).parents(".input_base_detail").find(".dropdown_gen_subinput").html(data.html);
            }
        }, 'json');
    }
    function setInputanDetailCheckBox(obj) {
        var nilai = $(obj).val();
        var input_idx = $(obj).parents(".input_base").data('input-index');
        
        $.post('<?php echo $this->createUrl('ajaxGenerateDetailCheckBox'); ?>', {nilai: nilai, input_idx: input_idx}, function(data) {
            if (data.ok == 1) {
                $(obj).parents(".input_base_detail").find(".checkbox_gen_subinput").html(data.html);
            }
        }, 'json');
    }
    
    function setInputanDetailRadio(obj) {
        var nilai = $(obj).val();
        var input_idx = $(obj).parents(".input_base").data('input-index');
        
        $.post('<?php echo $this->createUrl('ajaxGenerateDetailRadio'); ?>', {nilai: nilai, input_idx: input_idx}, function(data) {
            if (data.ok == 1) {
                $(obj).parents(".input_base_detail").find(".radio_gen_subinput").html(data.html);
            }
        }, 'json');
    }
    
    function setInputanDetailTextfield(obj) {
        var nilai = $(obj).val();
        var input_idx = $(obj).parents(".input_base").data('input-index');
        
        $.post('<?php echo $this->createUrl('ajaxGenerateDetailTextfield'); ?>', {nilai: nilai, input_idx: input_idx}, function(data) {
            if (data.ok == 1) {
                $(obj).parents(".input_base_detail").find(".textfield_gen_subinput").html(data.html);
            }
        }, 'json');
    }
    
    function setInputanDetailTextarea(obj) {
        var nilai = $(obj).val();
        var input_idx = $(obj).parents(".input_base").data('input-index');
        
        $.post('<?php echo $this->createUrl('ajaxGenerateDetailTextarea'); ?>', {nilai: nilai, input_idx: input_idx}, function(data) {
            if (data.ok == 1) {
                $(obj).parents(".input_base_detail").find(".textarea_gen_subinput").html(data.html);
            }
        }, 'json');
    }
    
    function setCeklisSubInput(obj) {
        if ($(obj).is(":checked")) {
            $(obj).parents(".input_subinput").find(".subinputan_jumlah").prop("readonly", false);
        } else {
            $(obj).parents(".input_subinput").find(".subinputan_jumlah").prop("readonly", true).val(0);
        }
    }
    
    $(document).ready(function() {
        $(".isada_subinputan").each(function() {
            setCeklisSubInput(this);
        });
    });
    
</script>
        
        
<script>
    
    var idx_gambar = 0;
    var row_gambar = <?php echo CJSON::encode(array('html'=>$this->renderPartial('form/_itemGambar', array(), true))); ?>;
    
    function cekInputGambar() {
        if ($(".persetujuan_isiadagambar").is(":checked")) {
            $(".panel_gambar").show();
        } else {
            $(".panel_gambar").hide();
        }
    }
    
    var fileToBase64 = file => new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });

    async function uploadGambarPersetujuan() {

        const file = $(".input_gambar").get(0).files[0];
        const val64 = await fileToBase64(file);
        
        var nama_file = $(".input_gambar").get(0).files[0].name;
        var tipe_file = $(".input_gambar").get(0).files[0].type;
        
        $(".input_gambar").val("");
        
        if (tipe_file.search("image") == -1) {
            myAlert("Harus dalam bentuk Gambar");
            return;
        } 

        if (val64 instanceof Error) {
            console.log('Error: ', result.message);
            return;
        }
        
        $(".panel_gambar_isi").append(row_gambar.html);
        var item_last = $(".panel_gambar_isi .persetujuan_gambar_item").last();
        item_last.find(".img_gambar").prop("src", val64);
        
        item_last.find(".nama_gambar").val(nama_file).prop("name", "PersetujuanumumisiM[persetujuan_gambar][" + idx_gambar + "][nama_gambar]");
        item_last.find(".val64_gambar").val(val64).prop("name", "PersetujuanumumisiM[persetujuan_gambar][" + idx_gambar + "][val64_gambar]");
        
        idx_gambar++;
        


    }
    
    $(document).ready(function() {
        cekInputGambar();
        cekInputDetail();
    });
    
    
</script>
