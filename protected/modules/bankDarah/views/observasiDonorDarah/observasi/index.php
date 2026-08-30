<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai view utama untuk mengelola transaksi obervasi donor darah
* RSST-1498
*/
       $this->widget('bootstrap.widgets.BootAlert');
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'observasi-pendonor-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));

    echo $this->renderPartial($this->path_view.'observasi/form/_formObservasi',array('model'=>$model,'form'=>$form,'modDaftarDonasi'=>$modDaftarDonasi,'getCeklis'=>$getCeklis),true);

    echo $this->renderPartial($this->path_view.'observasi/_dialog',array('model'=>$model,'form'=>$form),true);
    
    echo $this->renderPartial($this->path_view.'observasi/_jsFunctions',array('model'=>$model),true);
    
    $this->endWidget();               
?>


