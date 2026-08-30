<?php
// ===========================Dialog Foto=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogFoto',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Foto USG',
                        'autoOpen'=>false,
                        'minWidth'=>1100,
                        'minHeight'=>100,
                        'resizable'=>true,
                         ),
                    ));
echo "<div align=\"center\">
        <img src=\"".Params::urlUSGDirectory().$modPeriksaKehamilan->filefotousg."\">
      </div>";
  
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Foto================================

$jscript = <<< JS

function slideDataKehamilan()
{
    $('#divDataKehamilan').slideToggle(500);
}

function lihatFoto()
{
    $('#divFoto').slideToggle(500);
    $('#divTombolLihat').slideToggle(500);
    $('#divTombolTutup').slideToggle(500);
}
   
function numberOnly(obj,nilaiKosong)
{
    var d = $(obj).attr('numeric');
    var value = $(obj).val();
    var orignalValue = value;

    if (d == 'decimal') {
    value = value.replace(/\./, "");
    msg = "Only Numeric Values allowed.";
    }

    if (value != '') {
    orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
    $(obj).val(orignalValue);
    }else{
    $(obj).val(nilaiKosong);
    }
    
}

function validasi()
{
    kosong = 'Tidak';
    $('.isRequired').each(function() {
           if($(this).val()==''){
             kosong='Ya';
             $(this).focus();
           }
        });
    
    if(kosong=='Tidak'){
        $('#btn_simpan').click();
    }else{
        myAlert('Harap isi semua field yang bertanda *');
    }    
}

    function readURL(input) 
    {
    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
    $('#img_prev')
    .attr('src', e.target.result)
    };

    reader.readAsDataURL(input.files[0]);
    }
}

JS;
Yii::app()->clientScript->registerScript('faktur',$jscript, CClientScript::POS_HEAD);
?>