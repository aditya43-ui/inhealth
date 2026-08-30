<?php
/** 
 * view ini digunakan untuk menampilkan semua form pada menu transaksi jadwal pemeriksaan pekerjaan
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */


$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'jadwalpemeriksaanpekerjaan-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
        
	'htmlOptions' => array(
            //'enctype'=>'multipart/form-data',
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
    
    .lebarcustom{
        width:170px !important;
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
        <div class="panel-title">Jadwal Pemeriksaan Pekerjaan</div>
        <div class="panel-options">
            <?php //echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>	
        </div>
    </div>
    <div class="panel-body">        
        <?php echo CHtml::hiddenField("norow",0,array('readonly'=>true)); ?>
        <?php echo $this->renderPartial($this->path_view.'form/_formJadwalPemeriksaan',array('model'=>$model,'modDet'=>$modDet,'loadDet'=>$loadDet)); ?>
        <div class="clear"></div>
        <?php echo $this->renderPartial($this->path_view.'_riwayat',array( 'model'=>$modRiwayat),true); ?>
       
        
        <?php echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model),true); ?>

        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model, 'det'=>$modDet),true); ?>       

        <div class="row-fluid">
            <div class="form-actions">
            <?php echo $this->renderPartial($this->path_view.'_button',array('model'=>$model),true); ?>
            </div>
        </div>
        
        
    </div>
</div>
    
<?php $this->endWidget(); ?>
