<?php
$myicon = new MyIcon();
?>
<div class="panel panel-success">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI ?>	
    <div class="panel-heading">    
        <div class="panel-title">Persetujuan Tindakan Anastesi</div>
    </div> 
    <div class="panel-body">
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
        <div class="row-fluid">
            <?php
            $this->renderPartial($this->path_view . '_formSuratPersetujuan', array(
                'model' => $model,
                'modPasienAnestesi' => $modPasienAnestesi,
                'modPasien' => $modPasien,
                'modPendaftaran' => $modPendaftaran,
                'diagnosa' => $diagnosa,
                'modRencanaOperasi' => $modRencanaOperasi,
                'format' => $format,
                'form' => $form
            ));
            ?>
        </div>

        <div class="form-actions">
            <?php
            $cekPersetujuan = ATPersetujuananestesiT::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            if (!empty($cekPersetujuan)) {
                if (!empty($_GET['persetujuananestesi_id'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => false));
                    echo "&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print PDF', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger submit', 'disabled' => false, 'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
                    echo "&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print PDF', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                }
            } else {
               echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger submit', 'disabled' => false, 'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
                    echo "&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'disabled' => true, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print PDF', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'disabled' => true, 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
            }
            ?>
        </div>
    </div></div>
<?php $this->endWidget(); ?>
<?php
$this->renderPartial($this->path_view . '_jsFunctions',array('model' => $model));
?>
<script>

/**
 * Untuk validasi radio jenis anestesi
 */
function CekJenisAnestesi(obj,jenis){
    $(".jnsanestesi").removeAttr('checked');
    $(obj).attr('checked',true);
    if(jenis == "regional"){
        $(".regional").removeAttr('disabled');
        $(".regional").removeAttr('checked');
    }else{
        $(".regional").attr('disabled',true);
        $(".regional").removeAttr('checked');
    }
    
    if(jenis == "sedasiberatsedang"){
        $(".regional").attr('disabled',true);
        $(".regional").removeAttr('checked');
        $(".umum").attr('disabled',true);
        $(".umum").removeAttr('checked');
        $(".kombinasi").attr('disabled',true);
        $(".kombinasi").removeAttr('checked');
    }else if(jenis == "umum"){
        $(".regional").attr('disabled',true);
        $(".regional").removeAttr('checked');
        $(".sedasiberatsedang").attr('disabled',true);
        $(".sedasiberatsedang").removeAttr('checked');
        $(".kombinasi").attr('disabled',true);
        $(".kombinasi").removeAttr('checked');
    }else if(jenis == "kombinasi"){
        $(".regional").attr('disabled',true);
        $(".regional").removeAttr('checked');
        $(".sedasiberatsedang").attr('disabled',true);
        $(".sedasiberatsedang").removeAttr('checked');
        $(".umum").attr('disabled',true);
        $(".umum").removeAttr('checked');
    }
}

$( document ).ready(function(){
    var regional_sedasi = $('#jnsanestesi_regional_sedasi');
    var regional_tnpsedasi = $('#jnsanestesi_regional_tnpsedasi');
    var regional_sab = $('#jnsanestesi_regional_sab');
    var regional_epidural = $('#jnsanestesi_regional_epidural');
    var regional_blokperifer = $('#jnsanestesi_regional_blokperifer');
    var regional_kombinasi = $('#jnsanestesi_regional_kombinasi');
    
    if( regional_sedasi.is(" :checked") || regional_tnpsedasi.is(" :checked") || regional_sab.is(" :checked") || regional_epidural.is(" :checked") || regional_blokperifer.is(" :checked") || regional_kombinasi.is(" :checked")){
        $(".regional").attr('disabled',false);
    }else{
        $(".regional").attr('disabled',true);
    }
    
<?php if(!empty($_GET['persetujuananestesi_id'])){ ?>

<?php } ?> 
    
        $('form').bind('click keyup select change', function(event) {
                cekDisabled(this);
        });
        $(document).on('click keyup select change',function(){
                cekDisabled('form');
        }); 
        cekDisabled('form');
});
</script>