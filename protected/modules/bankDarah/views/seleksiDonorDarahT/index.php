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
       <div class="panel-title"><strong>Seleksi Donor Darah</strong></div>
        <span style="float: right; margin: 4px"><?php echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-left-bold"></i>')),Yii::app()->createUrl('bankDarah/InformasiDaftarPendonor/index'),array('class'=>'btn btn-success'));  ?></span>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'selksitab-pendonor-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        $this->renderPartial('_formDataPendonor', array('form'=>$form,
                                'model'=>$model,
                                'modKuesioner'=>$modKuesioner,
                                'modPendonor'=>$modPendonor,
                                'modDaftarDonasi'=> $modDaftarDonasi,
                                'modObservasi' => $modObservasi)); 
        ?> 
        <div class="clear"></div>
        <?php
        echo $this->renderPartial('_tabMenu',array('form'=>$form,
                                'model'=>$model,
                                'modKuesioner'=>$modKuesioner,
                                'modPendonor'=>$modPendonor,
                                'modDaftarDonasi'=>$modDaftarDonasi,)); 
        ?>               
        <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
        <?php
        $this->endWidget();                 
        echo $this->renderPartial('_jsFunction', array('form'=>$form,
                                'model'=>$model,
                                'modKuesioner'=>$modKuesioner,
                                'modPendonor'=>$modPendonor,
                                'modDaftarDonasi'=>$modDaftarDonasi,)); 
        ?>
        
        
    </div>
</div>