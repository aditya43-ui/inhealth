
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Verifikasi Mutasi Aset
        </div>
    </div>
    <div class="panel-body">
        
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'mutasiaset-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        )); ?>
        <?php echo $this->renderPartial('_formMutasi', array(
            'model'=>$model,
            'detail'=>$detail,
            'form'=>$form,
        ), true); ?>
        <?php echo $this->renderPartial('_formPeralatan', array(
            'model'=>$model,
            'detail'=>$detail,
            'form'=>$form,
        ), true); ?>
        
        <div class="hide not-dis">
            <?php
                echo CHtml::activeCheckBox($model, 'is_disetujui', ['class'=>'is_disetujui']);
            ?>
        </div>
        
        <div class="form-actions  not-dis">
            <?php 
                if (empty($model->tanggal_verifikasi)){
                echo CHtml::htmlButton('<i class="'.MyIcon::getIcons('simpan').'"></i> Setuju', array(
                        'class'=>'btn btn-success btn_submit',              
                        'onclick' => 'verifikasi("setuju")',
                        'type'=>'button',
                    )); 
                echo '&nbsp;';
                    echo CHtml::htmlButton('<i class="'.MyIcon::getIcons('simpan').'"></i> Tidak Setuju', array(
                        'class'=>'btn btn-danger btn_submit',
                        'onclick' => 'verifikasi("tidak")',
                        'type'=>'button',
                    )); 
                }
            ?>
        </div>
        
        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#mutasiaset-t-form").find('input,select,textarea').attr("disabled",true);
        $("#mutasiaset-t-form").find('a,button,.add-on,.button-aksi').hide();        
        
        $("#mutasiaset-t-form").find('.not-dis').find('input,select,textarea').attr("disabled",false);
        $("#mutasiaset-t-form").find('.not-dis').find('a,button,.add-on,.button-aksi').show();        
    });
    
    var verifikasi = (st) => {
        
        if (st == 'setuju')
            $(".is_disetujui").prop("checked",true);
        else
            $(".is_disetujui").prop("checked",false);
        
        $("#mutasiaset-t-form").submit();
        disableOnSubmit($(".btn_submit"));
        
    }
</script>