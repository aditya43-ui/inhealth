<?php
$myicon = new MyIcon();
?>
<div class="panel panel-success">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI ?>	
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <div class="panel-heading">    
        <div class="panel-title">Informasi Tindakan Anestesi</div>
    </div> 
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'informasitindakananestesi-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Surat Informasi Tindakan Anestesi berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="row-fluid">
            <?php
            $this->renderPartial($this->path_view . '_form', 
            array(
                'modEvaluasi'=>$modEvaluasi,
                'form'=>$form
            ));
            ?>
        </div>

        <div class="form-actions">
            <?php
            if (!empty($_GET['rencanaanestesi_id'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => true));
                echo "&nbsp";
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                echo "&nbsp";
                if (isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('disabled'=>false,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print()')) . "&nbsp&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('disabled'=>false,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printpdf()')) . "&nbsp&nbsp"; 
                }else{
                    
                    if($modEvaluasi->isNewRecord){
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('disabled'=>true,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print()')) . "&nbsp&nbsp";
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('disabled'=>true,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printpdf()')) . "&nbsp&nbsp"; 
                    }else{
                         echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('disabled'=>false,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print()')) . "&nbsp&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('disabled'=>false,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printpdf()')) . "&nbsp&nbsp"; 
                    }
                }
                   
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
                echo "&nbsp";
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                echo "&nbsp";
                if (isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('disabled'=>false,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print()')) . "&nbsp&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('disabled'=>false,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printpdf()')) . "&nbsp&nbsp"; 
                }else{
                     if($modEvaluasi->isNewRecord){
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('disabled'=>true,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print()')) . "&nbsp&nbsp";
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('disabled'=>true,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printpdf()')) . "&nbsp&nbsp"; 
                    }else{
                         echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('disabled'=>false,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print()')) . "&nbsp&nbsp";
                         echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('disabled'=>false,'class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printpdf()')) . "&nbsp&nbsp"; 
                    }
                }    
                    
            }
            ?>
        </div>
    </div></div>
<?php $this->endWidget(); ?>
<script>
    function print(){
        window.open("<?php echo Yii::app()->createUrl("anestesi/InformasiTindakanAnestesi/Print", array("pendaftaran_id"=>$_GET['pendaftaran_id'],"pasienkirimkeunitlain_id"=>$_GET['pasienkirimkeunitlain_id'],"pasienanastesi_id"=>$_GET['pasienanastesi_id'],'print'=>"print")) ?>","",'location=_new, width=1024px');
    }
    function printpdf(){
        window.open("<?php echo Yii::app()->createUrl("anestesi/InformasiTindakanAnestesi/Print", array("pendaftaran_id"=>$_GET['pendaftaran_id'],"pasienkirimkeunitlain_id"=>$_GET['pasienkirimkeunitlain_id'],"pasienanastesi_id"=>$_GET['pasienanastesi_id'],'print'=>"pdf")) ?>","",'location=_new, width=1024px');
    }
</script>    

