<?php
/** 
 * view ini digunakan untuk menampilkan semua form pada menu transaksi persiapan pengadaan
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); 

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'persiapanpengadaan-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
        
	'htmlOptions' => array(
            'enctype'=>'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)'
            ),
	//'focus' => '#'.CHtml::activeId($model, 'persiapanpengadaan_tanggal').'',
    ));
?>
<style>
     .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }        
    
    .close{
        color:#333 !important;
        font-size: 30px !important;
    }
    .fileinput-filename{
        color:red !important;
        text-decoration: underline;
    }
</style>
<p>&nbsp;</p>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><?php echo (empty($model->persiapanpengadaan_id)?'Transaksi':'Ubah'); ?> <b>Persiapan Pengadaan</b></div>
        <div class="panel-options">
            <?php //echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>	
        </div>
    </div>
    <div class="panel-body">        
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Persiapan Pengadaan</div>
                </div>
                <div class="panel-body">                
                    <?php echo $this->renderPartial($this->path_view.'form/_formPersiapan',array('form'=>$form, 'model'=>$model),true); ?>
                    <div class="clear"></div>
                    <hr/>                
                    <?php echo $this->renderPartial($this->path_view.'form/_formLanjutan',array('form'=>$form, 'model'=>$model),true); ?>                
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">HPS</div>
                </div>
                <div class="panel-body overflow-x">
                    <?php echo $this->renderPartial($this->path_view.'form/_formHPS',array('form'=>$form, 'model'=>$model, 'modDet'=>$modDet),true); ?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Dokumen RUP</div>
                    </div>
                    <div class="panel-body" >
                        <i><label ><span class="required">Maksimal Ukuran file adalah 2000kb/2mb</span></label></i>
                        
                        <table class="table table-bordered table-striped table-condensed" id="form-dokrup">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Jenis Dokumen</th>
                                    <th style="text-align: center;">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>                
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-success">
                   <div class="panel-heading">
                       <div class="panel-title">Dokumen Persiapan Pengadaan</div>
                   </div>
                   <div class="panel-body" >
                       <i><label ><span class="required">Maksimal Ukuran file adalah 2000kb/2mb</span></label></i>

                       <table class="table table-bordered table-striped table-condensed" id="form-dokpendukung">
                           <thead>
                               <tr>
                                   <th style="text-align: center;">Jenis Dokumen</th>
                                   <th style="text-align: left;">File</th>
                               </tr>
                           </thead>
                           <tbody>
                               <?php

                               ?>
                           </tbody>
                       </table>                
                   </div>
               </div>
            </div>
        </div>
        <?php 
            if (!empty($model->persiapanpengadaan_id)){                 
        ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Catatan</div>
                    </div>
                    <div class="panel-body">       
                        <?php echo $this->renderPartial($this->path_view.'form/_formCatatan',array('form'=>$form, 'model'=>$modRiwayat),true); ?>
                    </div>
                </div>
        
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-riwayat',
                        'content'=>array(
                                'content-riwayat'=>array(
                                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pengadaan')).'<b>Riwayat</b>',
                                        'isi'=> $this->renderPartial($this->path_view.'_riwayat',array('form'=>$form, 'model'=>$modRiwayat),true),
                                        'active'=>false,
                                        ),   
                                ),
                )); ?>
        <?php } ?>
        
        <?php echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model),true); ?>

        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'form'=>$form, 'dok' => $dok, 'modRiwayat'=>$modRiwayat),true); ?>       

        <?php echo $this->renderPartial($this->path_view.'_button',array('model'=>$model),true); ?>
            
        
        
    </div>
</div>
    
<?php $this->endWidget(); ?>
