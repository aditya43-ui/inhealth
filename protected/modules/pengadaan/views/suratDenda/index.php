<link rel="stylesheet" href="assets/js/wysihtml5/bootstrap-wysihtml5.css">
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/themes/neon/assets/js/wysihtml5/bootstrap-wysihtml5_custom2.js', CClientScript::POS_END);

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'notadinasppk-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',        
	'htmlOptions' => array(
            //'enctype'=>'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)',
            'onsubmit' => 'return requiredCheck(this);'
        ),
	'focus' => '#'.CHtml::activeId($model, 'nomor_notadinas').'',
    ));
?>
<style>     
    .close{
        color:#333 !important;
        font-size: 30px !important;
    }  
</style>
<p>&nbsp;</p>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"> <b><?php echo empty($model->suratdenda_id)?'':'Ubah'; ?> Surat Denda </b></div>        
    </div>
    <div class="panel-body">                        
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::hiddenField("jenisdialog","",array('readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("norow","",array('readonly'=>true)); ?>
        
        <div class="panel-group joined" id="accordion-test-2">		
            <div class="panel panel-success">
                <div class="panel-heading" style="background:#bdedbc;">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2">
                            Riwayat Surat Denda
                        </a>
                    </h4>
                </div>
                <div id="collapseOne-2" class="panel-collapse collapse in">
                    <div class="panel-body  overflow-x">
                        <?php echo $this->renderPartial($this->path_view.'form/_0_riwayat',array('model'=>$model)); ?>
                    </div>
                </div>
            </div>								
	</div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Surat Denda</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'form/_1_formSuratDenda',array('model'=>$model, 'form'=>$form)) ?>
            </div>
        </div>
        <div class="clear"></div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Barang/Jasa</div>
            </div>
            <div class="panel-body formbarangjasa">
                <?php echo $this->renderPartial($this->path_view.'form/_2_formBarangJasa',array('model'=>$model, 'form'=>$form)) ?>
            </div>
        </div>
        <div class="clear"></div>                
        
        <?php echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model),true); ?>       
        
        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model),true); ?>       

        <?php echo $this->renderPartial($this->path_view.'_button',array('model'=>$model),true); ?>
                                      
    </div>
</div>
    
<?php $this->endWidget(); ?>
<script>
    $(document).ready(function(){    
        $('.integer-decimal').each(function(){
           $(this).val(formatThousandDecimal(parseFloat($(this).val())));
        });
        loadRincian('<?php echo $model->suratperjanjiankerja_id; ?>', '<?php echo $model->suratdenda_id; ?>');
        
        <?php if (empty($model->suratdenda_id)){ ?>
            setTimeout(function(){
                setTanggalTerlambat();
                hitungTotal();
            },500);            
        <?php } ?>
    });
</script>
