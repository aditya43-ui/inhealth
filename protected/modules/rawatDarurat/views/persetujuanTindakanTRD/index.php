<?php
$arrMenu = array();

if (isset($_GET['pendaftaran_id'])) {
    $arrMenu["Daftar Pasien"] = $this->getReferrer();
}

$arrMenu[] = "Surat Persetujuan Tindakan";

$this->breadcrumbs = $arrMenu;


$frame = false;
if (isset($_GET['frame']) && $_GET['frame'] == 1) {
    $frame = true;
}
?>

<div class="panel panel-gradient">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI  ?>	
    <div class="panel-heading">    
        <div class="panel-title">Surat <?php echo ($modSuratPersetujuan->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "Persetujuan" : "Penolakan"; ?> Tindakan</div>
        <div class="panel-options">
            <?php
            if (!empty($this->getReferrer()) && !$frame) {
                echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', $this->getReferrer(), array('class' => 'btn btn-red', 'style' => 'color: white;'));
            }
            ?>	
        </div>
    </div> 
    <div class="panel-body">
        <?php
        
        
        echo $this->renderPartial($this->path_view . '_listSuratKeterangan', array(
            'pendaftaran_id' => $pendaftaran_id,
            'jenissurat' => $modSuratPersetujuan->jenissurat,
                ), true);
        ?>


        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'suratpersetujuantindakan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#nama_pasien',
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Surat Pesertujuan Tindakan berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        
        <div id="tab_form">
        <?php

        $pers = $this->action->id == 'index' ? 'Persetujuan Tindakan' : 'Penolakan Tindakan';
        
        $this->widget('bootstrap.widgets.BootMenu', array(
            'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
            'stacked'=>false, // whether this is a stacked menu
            'items'=>array(
                array('label'=>'Pemberian Informasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab_panel_informasi','onclick'=>"gotoPanel('panel_informasi');")),
                array('label'=> $pers, 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab_panel_persetujuan','onclick'=>"gotoPanel('panel_persetujuan');")),
            ),
        ));
        
        ?>
        </div>
        
        <div class="panel_form" id="panel_informasi">
            <?php
            $this->renderPartial($this->path_view . '_formInformasi', 
            array(
                'model' => $modSuratPersetujuan,
                'format' => $format,
                'form' => $form,
                'data' => $data,
                'modPasienAnestesi' => $modPasienAnestesi,
                'modPraAnestesi' => $modPraAnestesi,
                'modTindakanAnestesi' => $modTindakanAnestesi,
                'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'informasi' => $informasi,
            ));
            ?>
            
        </div>
        
        
        <div class="panel_form" id="panel_persetujuan">
            <?php
            $this->renderPartial($this->path_view . '_formSuratPersetujuan', array(
                'modSuratPersetujuan' => $modSuratPersetujuan,
                'format' => $format,
                'form' => $form,
                'data' => $data,
                'modPasienAnestesi' => $modPasienAnestesi,
                'modPraAnestesi' => $modPraAnestesi,
                'modTindakanAnestesi' => $modTindakanAnestesi,
                'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'informasi' => $informasi,
            ));
            ?>	



            <div class="form-actions">
                <?php
                if (!empty($_GET['suratpersetujuantm_id'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Create',
                                    array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => true));
                    echo "&nbsp";
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->action->id, array(
                                'pendaftaran_id' => $pendaftaran_id,
                                'frame' => $frame,
                            )),
                            array('class' => 'btn btn-danger', 'disabled' => false, 'type' => 'button'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Surat', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Informasi', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'printInformasi(\'PRINT\')'));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Create',
                                    array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
                    echo "&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Surat', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => true, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Informasi', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => true, 'type' => 'button', 'onclick' => 'printInformasi(\'PRINT\')'));
                }
                ?>
            </div>
        </div>
    </div></div>
<?php $this->endWidget(); ?>
<?php
$this->renderPartial($this->path_view . '_jsFunctions', array(
    'modSuratPersetujuan' => $modSuratPersetujuan,
    'format' => $format,
    'form' => $form,
    'data' => $data,
    'modPasienAnestesi' => $modPasienAnestesi,
    'modPraAnestesi' => $modPraAnestesi,
    'modTindakanAnestesi' => $modTindakanAnestesi,
    'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
    'modPendaftaran' => $modPendaftaran,
    'informasi' => $informasi,
    'modPasien' => $modPasien));
?>