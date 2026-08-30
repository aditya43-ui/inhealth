<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$modul_id = Yii::app()->user->getState('modul_id');
$readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");

?>

<?php
if (Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_PERSALINAN) {
    $menu_list = array();
    foreach ($kelahiran_list as $item) {
        $menu_list[] = array(
            'label'=>$item->namabayi,
            'url'=>$this->createUrl('suratLahir', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'kelahiranbayi_id'=>$item->kelahiranbayi_id)),
            'itemOptions'=>array('class'=>$kelahiranbayi_id == $item->kelahiranbayi_id ? "active" : ""),
        );
    }
            
    
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>$menu_list,
        'htmlOptions'=>array(
            'id'=>'tab_bayi',
        )
    ));
}

$this->breadcrumbs=array(
	'Istirahat',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'suratketerangan-r-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#nama_pasien',
)); ?>
<style>
.groupUkurans{
    display:inline;
}
 table > tbody > tr > td > input{
        margin-top:5px;
    }
</style>
    <?php 
        $this->renderPartial($this->path_view.'lahir/suratLahirV2',array('model'=>$model,'modPasien'=>$modPasien,
                'modKelahiran'=>$modKelahiran,
                'modPendaftaran'=>$modPendaftaran));
    ?>
    <div class="form-actions" <?=$hidden?>>
        <?php
            $tombol_kembali = "";
            if (isset($this->is_persalinan) && !empty($this->is_persalinan) && $this->is_persalinan == true) {
                $tombol_kembali = CHtml::link('<i class="entypo-back"></i> Kembali', 
                        Yii::app()->createUrl('/persalinan/daftarPasien/detailKelahiranBayi', array('kelahiranbayi_id'=>$modKelahiran->kelahiranbayi_id)),
                        array(
                    'class'=>'btn btn-danger'
                ));
            }
        
            if(!empty($_GET['suratketerangan_id'])){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
                array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>true)); 
                echo " ".$tombol_kembali." ";
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
                array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
                echo " ".$tombol_kembali." ";
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            }
        ?>
    </div>

<?php $this->endWidget(); ?>
<?php
if(!empty($_GET['suratketerangan_id'])){
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintSuratLahir&pendaftaran_id='.$model->pendaftaran_id.'&suratketerangan_id='.$_GET['suratketerangan_id'].'');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=980px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
}
?>