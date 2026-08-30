
<div class="control-group">
    <?= $form->labelEx($model,'info_rs_dari',['class'=>'control-label']) ?>
    <div class="controls">
        <?= $form->dropDownList($model,'info_rs_dari', LookupM::getItemsUrutan('inforsdari'),['empty'=>'-- Pilih --','class'=>'form-control info_rs_dari']) ?>
    </div>
    <div class="controls">
        <?= CHtml::htmlButton("<i class='entypo-plus'></i>",['class'=>'btn btn-sm btn-primary','onclick'=>'$("#dialogInfoRSDari").dialog("open");clearInfoRs();']) ?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogInfoRSDari',
    'options' => array(
        'title' => 'Menambah Data Asal Informasi RS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 530,
        'height' => 150,
        'resizable' => false,
    ),
));

echo '<div id="form-rs" class="form-horizontal" style="padding:10px;">';
echo '<br/>';
echo '
    <div class="control-group">
        <label class="control-label">Mendapatkan informasi RS dari</label>
        <div class="controls">
            '.CHtml::textField('inforsdari','',['class'=>'span3 required']).'
        </div>
        <div class="controls">
            '.CHtml::htmlButton("<span class='entypo-check'></span> Simpan",['class'=>'btn btn-gold', 'onclick'=>'simpanInfoRs();']).'
        </div>
    </div>
';
echo '</div>';

$this->endWidget();

$jscript = <<< JS
    //mengubah dropdown menjadi dropdown dengan pencarian
    jQuery($(".info_rs_dari")).multiselect({            
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '180px',
            enableCaseInsensitiveFiltering: true
    }).hide();	
JS;

Yii::app()->clientScript->registerScript('info_rs_dari-pendaftaran-ready', $jscript, CClientScript::POS_READY);

$urlTambahInfoRs = $this->createUrl('/actionAjax/tambahLookup');
$jscript = <<< JS
    const clearInfoRs = () => {
        $("#inforsdari").val("")
    }
        
    const simpanInfoRs = () => {
        const value = $("#inforsdari").val();
        if (requiredCheck($("#form-rs"))){
            $.ajax({
               type: 'POST',
               url: '${urlTambahInfoRs}',
               data: {
                   value:value,
                   type:'inforsdari'
                },
               dataType: "json",
               success: function (data) {                                                            
                   if (data.sukses == 1){
                       $(".info_rs_dari").html(data.drop);
                       jQuery($(".info_rs_dari")).val(data.infors).change().multiselect('rebuild');
                       toastr.success("Info RS sukses ditambahkan!","Perhatian!");
                       $("#dialogInfoRSDari").dialog("close");
                   }else{
                       toastr.error("Info RS gagal ditambahkan!","Perhatian!");
                   }
                    clearInfoRs();
               },
               error: function (jqXHR, textStatus, errorThrown) {                                    
               }
           });
        }
    }
JS;

Yii::app()->clientScript->registerScript('info_rs_dari-pendaftaran-head', $jscript, CClientScript::POS_HEAD);
?>