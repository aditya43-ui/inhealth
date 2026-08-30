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
        <div class="panel-title"> <b> Syarat-syarat Khusus Kontrak </b></div>        
    </div>
    <div class="panel-body">                        
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::hiddenField("jenisdialog","",array('readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("norow","",array('readonly'=>true)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Syarat - Syarat Khusus Kontrak</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'form/_1_formTemplate',array('model'=>$model, 'form'=>$form, 'dropSuratTemp'=>$dropSuratTemp)) ?>
            </div>
        </div>
        <div class="clear"></div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Korespondensi dan Wakil Sah Para Pihak</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'form/_2_formKorespondensi',array('model'=>$model, 'form'=>$form, 'profilRS'=>$profilRS, 'modSup' => $modSup)) ?>
            </div>
        </div>
        <div class="clear"></div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Syarat - Syarat Khusus Lainnya</div>
            </div>
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Jenis Kontrak</div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view.'form/_3_formSyaratLainnya',array('model'=>$model, 'form'=>$form)) ?>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Jadwal</div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view.'form/_4_formJadwal',array('model'=>$model, 'form'=>$form)) ?>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Ketentuan Lain</div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view.'form/_5_formKetentuanLain',array('model'=>$model, 'form'=>$form)) ?>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Penyesuaian Harga</div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view.'form/_6_formPenyesuaianHarga',array('model'=>$model, 'form'=>$form)) ?>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Tagihan dan Pembayaran</div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view.'form/_7_formTagihanPembayaran',array('model'=>$model, 'form'=>$form)) ?>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Denda, Sanksi dan Kahar</div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view.'form/_8_formDendaSanksi',array('model'=>$model, 'form'=>$form)) ?>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Lain - Lain</div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view.'form/_9_formLainLain',array('model'=>$model, 'form'=>$form)) ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        
        <?php echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model),true); ?>       
        
        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model),true); ?>       

        <?php echo $this->renderPartial($this->path_view.'_button',array('model'=>$model),true); ?>
                                      
    </div>
</div>
    
<?php $this->endWidget(); ?>
