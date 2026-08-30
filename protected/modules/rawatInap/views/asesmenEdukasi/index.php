<style>
    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }


    .group-title{

        position: relative;
        top:-10px;       
        left:15px;               
        color:#001F3E;
        background: #fff;
        padding:10px;
    }    

    .panel-darkk {
        border-color: #001F3E;
        -webkit-border-radius: 3px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 3px;
        -moz-background-clip: padding;
        border-radius: 3px;
        background-clip: padding-box;
    }    

</style>
<?php
$myicon = new MyIcon();
?>
<div class="panel panel-gradient">
<div class="panel-heading">
        <div class="panel-title">
            Asesmen Edukasi
            <?php if (!empty($_GET['pendaftaran_id'])) {?>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), array('/hemodialisa/pemeriksaanAsesmenPerawat', 'pendaftaran_id' => $_GET['pendaftaran_id'], 'konsulpoli_id' => isset($_GET['konsulpoli_id']) ? $_GET['konsulpoli_id'] : null), array('class' => 'btn btn-sm btn-danger')); ?>
            </span>
        <?php } ?>
        </div>
    </div>    
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'asesmenedukasi-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => ' return requiredCheck(this);'
            ),
        ));

        if (isset($_GET['is_pendaftaran'])) { //kondisi untuk assesmen edukasi setelah pendaftaran RI
            $formRencana = "form/_rencanaKebutuhan_pendaftaranRI";
            $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
            if (empty($model->asesmenedukasi_id)) {
                $model->instalasiawal_id = $instalasi_id;
            }
        } elseif (isset($_GET['ubah'])) {
            $formRencana = "form/_rencanaKebutuhanubah";
        } else {
            $formRencana = "form/_rencanaKebutuhan";
        }

        echo $this->renderPartial($this->path_view . '_dataPasien', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
                ), true);

        echo $this->renderPartial($this->path_view . 'form/_dataForm', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'form' => $form,
            'modPenunjang' => $modPenunjang
        ), true);

        echo $this->renderPartial($this->path_view . 'form/_formBiodata', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'form' => $form
                ), true);

        echo $this->renderPartial($this->path_view . $formRencana, array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'form' => $form,
            'modDet' => $modDet,
            'getDet' => $getDet,
            'getDet2' => $getDet2
                ), true);
        ?>
        <div class="row-fluid">
            <div class="form-actions">
              
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan',));
                    echo "&nbsp;&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-success', 'onclick' => "return false;", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'lepasDisabled();', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => false));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-success', 'onclick' => 'print();'));
                    echo "&nbsp;";
                }
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index/&pendaftaran_id=' . $_GET['pendaftaran_id']), array('class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'));
                ?>
                <?php
                $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                ?>
            </div>
        </div>     
                <?php
                $this->endWidget();

                echo $this->renderPartial($this->path_view . '_jsFunction', array('model' => $model, 'getDet' => $getDet), true);
                ?>
    </div> 
    
</div>

<div class="panel panel-gradient">
    <div class="panel-body">
<?php
echo $this->renderPartial($this->path_view . 'form/_catatanInformasi', array(
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien,
    'model' => $model,
    'form' => $form,
    'modDet' => $modDet,
    'getDet' => $getDet
        ), true);
?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><strong>Riwayat Asesmen Edukasi</strong></div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view.'_riwayatEdukasi', array('modelRiwayat'=>$modelRiwayat,'modPendaftaran'=>$modPendaftaran)); ?>
    </div>
</div>


<script>

    function printEdukasi(id) {
        window.open('<?php echo $this->createUrl('print', array('id' => $modPendaftaran->pendaftaran_id)); ?>&asesmen_id=' + id, 'printwin', 'left=100,top=100,width=640,height=480');
    }

    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $modPendaftaran->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
</script>