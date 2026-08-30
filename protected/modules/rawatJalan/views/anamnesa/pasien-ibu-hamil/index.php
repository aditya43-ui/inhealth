
<div class="panel panel-default "  style="margin: 17px 0;">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo $form->checkBox($model, 'is_ibuhamil', array('id'=>'cekIbuHamil')); ?>
            Pasien Ibu Hamil
        </div>
    </div>
    <div class="panel-body form-cek-lis hide" id="formPasienIbuHamil">
        <?= $this->renderPartial($this->path_view.'pasien-ibu-hamil/form/_1_reproduksi_kebidanan',['model'=>$model, 'form'=>$form]) ?>
        <div class="clear"></div>
        <?= $this->renderPartial($this->path_view.'pasien-ibu-hamil/form/_2_untuk_bayi',['model'=>$model, 'form'=>$form]) ?>
    </div>
</div>

<?php

$jscript = <<< JS
        
    $("#cekIbuHamil").click(function(){
       setPanelIbuHamil();
    });
        
    $("#formPasienIbuHamil").find(".kelompok").find("input:radio, input:checkbox").click(function(){
        set_dis($(this));
    });
        
    $("#formPasienIbuHamil").find(".kelompok").find("input:radio, input:checkbox").each(function(){
        set_dis($(this));        
    });
        
    setPanelIbuHamil();
JS;

Yii::app()->clientScript->registerScript('anamnesa-ibu-hamil-ready', $jscript, CClientScript::POS_READY);


$jscript = <<< JS
        
    const setPanelIbuHamil = () => {
        const obj = $("#cekIbuHamil");
        const cek = obj.prop("checked");
        const formbody = $("#formPasienIbuHamil");
        
        formbody.addClass('hide');
        formbody.find('input,textarea').attr('disabled',true);
        if (cek){
            formbody.removeClass('hide');
            formbody.find('input,textarea').removeAttr('disabled');
        }
        
        $("#formPasienIbuHamil").find(".kelompok").find("input:radio, input:checkbox").each(function(){
            set_dis($(this));        
        });
    }
        
    const setReproduksi = (obj) => {
        const val = $(obj).val();        
        $("#reproduksi_kb_bebas").attr('value',val);
    }
    
JS;

Yii::app()->clientScript->registerScript('anamnesa-ibu-hamil-head', $jscript, CClientScript::POS_HEAD);



$css = <<< CSS
    label.radio > input[type="radio"]{
        margin-top:4px !important;
    }  
        
    #formPasienIbuHamil input[type="checkbox"]{
        margin-top:5px !important;    
    }
        
CSS;

Yii::app()->clientScript->registerCss('anamnesa-ibu-hamil-css', $css);
?>