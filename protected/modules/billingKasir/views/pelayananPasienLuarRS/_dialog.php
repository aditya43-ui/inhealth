<?php


// dialog pasase
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));
$this->renderPartial($this->path_view.'grid/_daftar_tindakan',[]);
$this->endWidget();

$jscript = <<< JS
       
    const setTindakan = (data, obj) => {                
        let no = $(obj).parents(".trparent").attr("row-data");
        let attr_id = $(obj).parents("form-utama").attr("id");
        
        if (obj == ''){
            no = $("#no_row").val();
            attr_id = 'tbl_tindakan';
        }                
        
        let form_body = $("#"+attr_id).find('.trparent[row-data="'+no+'"]');
           
        form_body.find("input[name*='[daftartindakan_id]']").val(data.daftartindakan_id);
        form_body.find("input[name*='[daftartindakan_nama]']").val(data.daftartindakan_nama);        
                
        $("#dialogTindakan").dialog("close");                
    }
        
    const resetTindakan = (obj) => {
        let val = $(obj).val();
        
        if (val == ''){            
            let form_body = $(obj).parents('.trparent');
        
            form_body.find(".daftartindakan_id").val("");
            form_body.find(".daftartindakan_nama").val("");          
        }
    }
        
    const refreshGridTindakan = () => {
        $.fn.yiiGridView.update('daftar-tindakan-grid',{
            data:{
                'DaftartindakanM[default]':'',
                'DaftartindakanM[kelompoktindakan_id]':$("#kelompoktindakan_id").val(),
            }
        });
    }
        
JS;

Yii::app()->clientScript->registerScript('pelayanan-pasien-luar-dialog',$jscript, CClientScript::POS_HEAD);
?>


