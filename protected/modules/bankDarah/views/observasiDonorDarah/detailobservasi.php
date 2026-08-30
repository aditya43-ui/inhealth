<?php
/**
 * -Digunakan untuk menampilkan detail observasi
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * RSST-1534
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
<?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'detail-kantong-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
               
        //echo $this->renderPartial('bankDarah.views.observasiDonorDarah._dataPendonor',array('modDaftarDonasi'=>$modDaftarDonasi,'modPendonor'=>$modPendonor,'form'=>$form),true);
        
        echo $this->renderPartial('bankDarah.views.observasiDonorDarah.observasi.form._formDetailObservasi',array('modDaftarDonasi'=>$modDaftarDonasi,'model'=>$model,'form'=>$form, 'format'=>$format),true);

        $this->endWidget();                 
        ?>