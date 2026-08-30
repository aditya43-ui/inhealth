<?php
/**
* issue RSST-1515
* - digunakan sebagai view utama untuk menampilkan data atau form inputan untuk 
*  
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* 
*/
?>
<style>        
     .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }        
</style>

        <?php        
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pengujiankantongdarah-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
                        
        
        
        foreach ($modDet as $i => $det){            
            echo $this->renderPartial($this->path_view.'form/_formPengujian',array('model'=>$det,'form'=>$form,'i'=>$i),true);                        
            echo '<p>&nbsp;</p>';
        }
        
        echo $this->renderPartial($this->path_view.'form/_formLainnya',array('model'=>$model,'form'=>$form,),true);                
        
        $this->endWidget();                 
        ?>                      

<script>
    $(document).ready(function(){
        $("#pengujiankantongdarah-form").find('input, select, textarea').each(function(){
           $(this).attr('disabled',true);
        });
        
        $(".add-on").each(function(){
           $(this).remove();
        });
    });
</script>