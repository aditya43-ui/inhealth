<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* RSST-1471
* digunakan untuk menampilkan detail data 
*/
?>
<style>        
     .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }    

    textarea[disabled]{
        background: #eeeeee;
    }
</style>

        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pengujiankantongdarah-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
               
        echo $this->renderPartial($this->path_view.'_dataPasien',array('form'=>$form,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'model'=>$model),true);               
        
        echo $this->renderPartial($this->path_view.'form/_formPemeriksaan',array('model'=>$model,'form'=>$form),true);                
        
        echo $this->renderPartial($this->path_view.'form/_formLainnya',array('model'=>$model,'form'=>$form, 'modPendaftaran'=>$modPendaftaran),true);
        
        echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model),true);        
        ?>               
       
        <?php
        $this->endWidget();                 
        
       echo $this->renderPartial($this->path_view.'_jsFunction', array('model'=>$model), true);
        ?>

<script>
   $(document).ready(function(){
      $("input, select, textarea").each(function(){
         $(this).attr('disabled',true) ;
      });
      
      $(".add-on").each(function(){
         $(this).remove();
      });
   });
   
   $(".form-action").remove();
</script>