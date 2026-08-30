<?php
/**
 * view utama menampilkan form - form inputan yang ada di menu asesmen nyari
 * RSST-1498
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
));


Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

?>

<style>
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }
    
    select[disabled]{
        background:#eeeeee;
    }
</style>
<!--div class="white-container"-->
<div class="panel panel-gradient panel-shadow">
	<div class="panel-heading">
		<div class="panel-title">Pemeriksaan <strong>Asesmen Nyeri</strong></div>
	</div>
	<div class="panel-body">
		<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
		
		<?php $this->widget('bootstrap.widgets.BootAlert');	?>        
                
                <div class="control-group">
                    <?php echo $form->labelEx($model,'tglperiksanyeri',array('class' => 'control-label')); ?>
                    <div class="controls">
                       <?php echo $form->textField($model,'tglperiksanyeri',array('readonly'=>true, 'class'=>'span3')) ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Ada Keluhan Nyeri ?</label>
                    <div class="controls" id="status-nyeri">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->radioButton($model,'keluhannyeri',array('id'=>'nyeriYes','value'=>true,'onclick'=>'adaNyeri(this);', 'uncheckValue'=>null,'readonly'=>true,'disabled'=>true)); ?>  <label>Ada</label>   
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->radioButton($model,'keluhannyeri',array('id'=>'nyeriNo','value'=>false, 'onclick'=>'adaNyeri(this);', 'uncheckValue'=>null,'readonly'=>true,'disabled'=>true)); ?> <label>Tidak Ada</label>
                    </div>
                </div>
                
                
               
               
                
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Skala Nyeri</div>
                    </div>
                    <div class="panel-body" >
                        <div id="disableDewasa" ><!--background-color:rgba(0, 0, 0, 0.1);-->                        
                        </div>
                        
                        <h2 style="text-align:center;">Intensitas "WONG BAKER FACE SCALE"</h2>
                        <br/>
                        <?php echo $this->renderPartial($this->path_view_nyeri.'form._formNyeri',array(					
                                                'form'=>$form,
                                                'model'=>$model
                                                ),true); ?>   
                        
                            
                    </div>
                </div>                                
                
                <div class="panel panel-success" >
                    <div class="panel-heading">
                        <div class="panel-title">Lokasi Nyeri</div>
                    </div>
                    <div class="panel-body">
                         <div id="disableLokasiNyeri"><!--background-color:rgba(0, 0, 0, 0.1);-->                        
                        </div>   
                        
                          <?php echo $this->renderPartial($this->path_view_nyeri.'form._formLokasiNyeri',array(					
                                                'form'=>$form,
                                                'model'=>$model,  
                                                'modGambarTubuh'=>$modGambarTubuh,
                                                'modPeriksaGambar' => $modPeriksaGambar
                                                ),true); ?>   
                        
                            
                    </div>
                </div>
                
                
                <div class="panel panel-success"  id="periksa_nyeri">
                    <div class="panel-heading">
                        <div class="panel-title">Pemeriksaan Nyeri</div>
                    </div>
                    <div class="panel-body">
                        <div id="disablePeriksaNyeri" ><!--background-color:rgba(0, 0, 0, 0.1);-->                        
                        </div>
                        
                          <?php echo $this->renderPartial($this->path_view_nyeri.'form._formPemeriksaanNyeri',array(					
                                                'form'=>$form,
                                                'model'=>$model,                                                
                                                ),true); ?>   
                        
                            
                    </div>
                </div>
                
        </div>
</div>    
<?php echo $this->renderPartial($this->path_view_nyeri.'js._jsFunctions',array('model'=>$model,'modGambarTubuh'=>$modGambarTubuh,'modPemeriksaanGambar'=>$modPeriksaGambar,'modBagianTubuh'=>$modBagianTubuh),true); ?>                                                    

<?php $this->endWidget(); ?>


