<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai view utama untuk menampilkan data atau form inputan untuk 
* RSST-1515
*/
?>
<style>        
     .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }        
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengujian Konfirmasi Golongan Darah</div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pengujiankantongdarah-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        if(isset($_GET['nomorbarcode_sample'])){
            echo $this->renderPartial($this->path_view.'_dataKantongDarah',array('model'=>$modTerimaDet,'form'=>$form,'modTerima'=>$modTerima),true);               
        }else{
            echo $this->renderPartial($this->path_view.'_dataKantongDarah',array('model'=>$model,'form'=>$form,'modTerima'=>$modTerima),true);               
        }
        echo "<div id='pemeriksaankonfirmasi'>";
        echo $this->renderPartial($this->path_view.'form/_formPengujian',array('model'=>$model,'form'=>$form),true);                        
        //echo $this->renderPartial($this->path_view.'form/_formHasil',array('model'=>$model,'form'=>$form),true);
        
        echo "<p>&nbsp;</p><div id='banyakpengujian'></div>";
        echo "</div>";
        
        echo $this->renderPartial($this->path_view.'form/_formLainnya',array('model'=>$model,'form'=>$form,'modDet'=>$modTerimaDet,'modTerima'=>$modTerima),true);
        
        echo $this->renderPartial($this->path_view.'form/_button',array('model'=>$model,'link'=>$link),true);
        
        echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model),true);
        //echo $this->renderPartial($this->path_view.'form/_formObservasi',array('model'=>$model,'form'=>$form),true);
        
        echo $this->renderPartial($this->path_view.'_jsFunction', array('model'=>$model,'modDet'=>$modTerimaDet,'modTerima'=>$modTerima, 'form'=>$form), true);
        
        $this->endWidget();                 
        ?>   
        </div>
</div>
