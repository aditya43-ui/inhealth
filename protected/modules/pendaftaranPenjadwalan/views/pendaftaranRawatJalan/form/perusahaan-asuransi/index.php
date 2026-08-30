
<div class="control-group">
    <?= $form->labelEx($model,'namaperusahaan',['class'=>'control-label']) ?>
    <div class="controls">
        <?= $form->dropDownList($model,'namaperusahaan', LookupM::getItemsUrutan('namaperusahaan'),['empty'=>'-- Pilih --','class'=>'form-control namaperusahaan']) ?>
    </div>
    <div class="controls">
        <?= CHtml::htmlButton("<i class='entypo-plus'></i>",['class'=>'btn btn-sm btn-primary','onclick'=>'$("#dialogPerusahaan").dialog("open");clearPerusahaan();']) ?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPerusahaan',
    'options' => array(
        'title' => 'Menambah Data Perusahaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 530,
        'height' => 150,
        'resizable' => false,
    ),
));

echo '<div id="form-asuransi-perusahaan" class="form-horizontal" style="padding:10px;">';
echo '<br/>';
echo '
    <div class="control-group">
        <label class="control-label">Mendapatkan informasi RS dari</label>
        <div class="controls">
            '.CHtml::textField('namaperusahaan','',['class'=>'span3 required']).'
        </div>
        <div class="controls">
            '.CHtml::htmlButton("<span class='entypo-check'></span> Simpan",['class'=>'btn btn-gold', 'onclick'=>'simpanPerusahaan();']).'
        </div>
    </div>
';
echo '</div>';

$this->endWidget();

$jscript = <<< JS
    //mengubah dropdown menjadi dropdown dengan pencarian
    jQuery($(".namaperusahaan")).multiselect({            
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '180px',
            enableCaseInsensitiveFiltering: true
    }).hide();	
JS;

Yii::app()->clientScript->registerScript('perusahaan-pendaftaran-ready', $jscript, CClientScript::POS_READY);

$urlTambahInfoRs = $this->createUrl('/actionAjax/tambahLookup');
$jscript = <<< JS
        
    const setAsuransiField = (jenis) => {
        $("#namaperusahaan").attr("disabled", true);
        $(".namaperusahaan").multiselect('disable')
        if (jenis == 'tampil'){
            //dialog field
            $("#dialogPerusahaan").find("#namaperusahaan").removeAttr("disabled");
        
            //dropdown nama perusahaan
            $(".namaperusahaan").multiselect('enable')
        }
    }
        
    const clearPerusahaan = () => {
        $("#namaperusahaan").val("")
    }
        
    const simpanPerusahaan = () => {
        const value = $("#namaperusahaan").val();
        if (requiredCheck($("#form-asuransi-perusahaan"))){
            $.ajax({
               type: 'POST',
               url: '${urlTambahInfoRs}',
               data: {
                   value:value,
                   type:'namaperusahaan'
                },
               dataType: "json",
               success: function (data) {                                                            
                   if (data.sukses == 1){
                       $(".namaperusahaan").html(data.drop);
                       jQuery($(".namaperusahaan")).val(data.infors).change().multiselect('rebuild');
                       toastr.success("Info RS sukses ditambahkan!","Perhatian!");
                       $("#dialogPerusahaan").dialog("close");
                   }else{
                       toastr.error("Info RS gagal ditambahkan!","Perhatian!");
                   }
                    clearPerusahaanAsuransi();
               },
               error: function (jqXHR, textStatus, errorThrown) {                                    
               }
           });
        }
    }
JS;

Yii::app()->clientScript->registerScript('perusahaan-pendaftaran-head', $jscript, CClientScript::POS_HEAD);
?>