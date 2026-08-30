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
	'id' => 'peminjamanbrg-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
        
	'htmlOptions' => array(
            'enctype'=>'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)'
            ),
	'focus' => '#'.CHtml::activeId($model, 'tgl_publikasi').'',
    ));
?>
<style>
     .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }        
</style>
<p>&nbsp;</p>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Peminjaman Barang</b></div>
        <div class="panel-options">
            <?php //echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>	
        </div>
    </div>
    <div class="panel-body">        
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="glyphicon glyphicon-file"></i>Data Peminjam</div>
            </div>
            <div class="panel-body">
                <?php echo CHtml::hiddenField('no_row','',array('readonly' => true)); ?>
                <?php echo $this->renderPartial($this->path_view.'form/_formPeminjam',array('form'=>$form, 'model'=>$model),true); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="glyphicon glyphicon-file"></i>Peminjaman</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'form/_formAsetPinjam',array('form'=>$form, 'model'=>$model, 'modDet'=>$modDet),true); ?>
            </div>
        </div>
        
        <?php echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model),true); ?>

        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'form'=>$form),true); ?>       
<div class="form-actions">
        <?php echo $this->renderPartial($this->path_view.'_button',array('model'=>$model),true); ?>
</div>
        
        
    </div>
</div>
    
<?php $this->endWidget(); ?>
