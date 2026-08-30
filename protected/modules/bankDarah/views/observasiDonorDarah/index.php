<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai view utama untuk memilih transaksi mana yang akan dilanjutkan skala nyeri, observasi donor darah atau kantong darah
* RSST-1498
*/
?>
<style>        
     .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }
    
    #data-seleksi  .span2, #tandavital .span2{
        width:99px !important; 
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Transaksi <b>Observasi Donor Darah</b>
        </div>
        <span style="float: right; margin: 4px"><?php echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-left-bold"></i>')),Yii::app()->createUrl('bankDarah/InformasiDaftarPendonor/index'),array('class'=>'btn btn-success'));  ?></span>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'observasi-pendonor-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
               
        echo $this->renderPartial($this->path_view.'_dataPendonor',array('modDaftarDonasi'=>$modDaftarDonasi,'modPendonor'=>$modPendonor,'form'=>$form),true);
        
        echo $this->renderPartial($this->path_view.'_dataSeleksiDonorDarah',array('modDaftarDonasi'=>$modDaftarDonasi,'modSeleksi'=>$modSeleksi,'form'=>$form),true);
        
//        echo $this->renderPartial($this->path_view.'_kantongdarah',array('cekKantong'=>$cekKantong,'form'=>$form),true);
        
        echo $this->renderPartial($this->path_view.'_tabMenu',array('modDaftarDonasi'=>$modDaftarDonasi,'modSeleksi'=>$modSeleksi,'form'=>$form));        
        //echo $this->renderPartial($this->path_view.'form/_formObservasi',array('model'=>$model,'form'=>$form),true);
        ?>               
        <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
        <?php
        $this->endWidget();                 
        
        echo $this->renderPartial($this->path_view.'_jsFunction', array('model'=>$model,'modSeleksi'=>$modSeleksi,'modDaftarDonasi'=>$modDaftarDonasi,'modPendonor'=>$modPendonor,), true);
        ?>
        
        
    </div>
</div>
