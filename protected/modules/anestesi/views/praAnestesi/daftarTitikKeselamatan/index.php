<?php
/** 
 * view ini digunakan untuk menampilkan semua form pada menu transaksi daftar titik keselamatan pasien
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
	//'focus' => '#'.CHtml::activeId($model, 'teknikinduksi_master_o2_keterangan').'',
    ));
?>
<style>
    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }        
    input,textarea{
        border: 1px solid #333 !important;
    }
    
    table > tbody > tr > td {
        margin: 15px !important;        
        padding:2px;
    }
</style>
<p>&nbsp;</p>

<div class="panel panel-gradient">    
    <div class="panel-body">        
                            
        <?php echo $this->renderPartial($this->path_view.'form/_formTitik',array('model' => $model)); ?>
                    
        <div class="clear"></div>
        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model),true); ?>       

        <?php echo $this->renderPartial($this->path_view.'_button',array('model'=>$model),true); ?>
            
        
        
    </div>
</div>
    
<?php $this->endWidget(); ?>
