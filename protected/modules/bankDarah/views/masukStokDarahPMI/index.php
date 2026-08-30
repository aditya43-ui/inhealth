<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Masukan Stok Kantong Darah dari PMI
        </div>
    </div>
    <div class="panel-body">
        
        <?php 
        
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'stok-penerimaan-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event);',
                'onsubmit'=>'return requiredCheck(this);',
            ),
        )); ?>
    
        <?php echo $this->renderPartial($this->path_view."_penerimaan", array(
            'form'=>$form,
            'modelPenerimaan'=>$modelPenerimaan,
        ), true); ?>
        
        <?php echo $this->renderPartial($this->path_view."_detailPenerimaanDarah", array(
            'form'=>$form,
            'modelPenerimaan'=>$modelPenerimaan,
            'modelDetail'=>$modelDetail,
            'modKantong'=>$modKantong,
        ), true); ?>
            
        <div class="form-actions">
            <?php
            
            $disabled = isset($_GET['sukses'])? TRUE : FALSE;
            
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary '.($disabled ? '' :'submit'), 
                'disabled'=>$disabled,
                'type' => 'button',
                'onclick' => 'cekDetail(); return false;'));
            ?>
        </div>    
        
        <?php $this->endWidget(); ?>
        
    </div>
</div>

<script>
    function cekSemua(obj){
        if($(obj).is(":checked")){
            $('.check').each(function(){
                $(this).attr('checked',true);
            });
        }else{
            $('.check').each(function(){
                $(this).removeAttr('checked');
            });
        }
    }
    
    function cekDetail(){
        cek = 0;
        $("#detail > tbody > tr").find('input[type="checkbox"]').each(function(){
            if($(this).is(":checked")){
                cek++;
            }
        });
        
        if(cek==0){
            myAlert("Silakan pilih detail kantong darah");
        }else{
            $('#stok-penerimaan-form').submit();
        }
    }
    
    $(document).ready(function() {
        <?php if(isset($_GET['sukses'])){ ?>
            $("input, select, textarea").attr("disabled",true);
        <?php } ?>
    });
</script>