<?php
/** 
 * view ini digunakan untuk menampilkan semua form pada menu transaksi peminjaman barang
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rootwizard',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',

    'htmlOptions' => array(
        'class'=>'form-horizontal',
        'enctype'=>'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)'
        ),
    //'focus' => '#'.CHtml::activeId($model, 'tgl_publikasi').'',
));
?>
<style>
     .control-label{
        /**text-align:left !important;
        vertical-align: top !important;**/
    }        
    
    .form-wizard > ul > li.active a span{
        background: #0066cc;        
    }
    
    .form-wizard > ul > li.active a{        
        color: #0066cc;
    }
    
    .form-wizard > ul > li a span{
        color:#333;
    }
    
    .form-wizard > ul > li a{        
        color:#333;
    }
    
    li.next > a, li.previous > a{
        border:1px solid #333;
        border-radius: 70%; 
        background: #333;
        color:#fff; 
        padding:0px;
        
    }        
    
    li.next > a:hover, li.previous > a:hover{
        border:1px solid #333;
        border-radius: 70%; 
        background: #333;
        color:#fff; 
        padding:0px;
        
    }   
    
    li.next > a > span, li.previous > a > span{
        font-size: 30px;
    }
        
    .tab-content > .tab-pane > .col-sm-2, .tab-content > .tab-pane > .col-sm-10{
        padding:2px;
    }
</style>
<p>&nbsp;</p>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <b>Monitoring Intra Anestesi/Sedasi</b></div>
        <div class="panel-options">
            <?php //echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>	
        </div>
    </div>
    <div class="panel-body">        
        
        <div class="panel panel-success"  id='form-datakunjungan'>
            <div class="panel-heading">
                <div class="panel-title">
                    <span class="panel-title judul">Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body">                
                <?php echo $this->renderPartial($this->path_view.'_dataPasien',array('form'=>$form, 'modKunjungan'=>$modKunjungan, 'model'=>$model),true); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Monitoring Intra Anestesi</div>
            </div>
            <div class="panel-body  form-wizard">               
                <?php 
                    
                    echo $this->renderPartial($this->path_view.'form/index',array('form'=>$form, 'model'=>$model, 'modInput' => $modInput, 'modOutput' => $modOutput, 'loadInput'=>$loadInput, 'loadOutput' => $loadOutput),true); 
                    
                    
                    ?>
            </div>
        </div>
        
        <?php //echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model),true); ?>

        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modKunjungan' => $modKunjungan),true); ?>       

        <?php //echo $this->renderPartial($this->path_view.'_button',array('model'=>$model),true); ?>
            
        
        
    <?php 
    if (!empty($_GET['pasienanastesi_id']) || !empty($_GET['monitoringintraanastesi_id'])) {
        echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
    }
    ?>
    </div>
</div>
 <?php $this->endWidget();  ?>   
<script src="themes/neon/assets/js/jquery.bootstrap.wizard.min.js"></script>