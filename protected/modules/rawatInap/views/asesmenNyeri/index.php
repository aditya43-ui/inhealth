<?php 
if(!empty($modPendaftaran)) {
    if($modPendaftaran->validasiRekamMedis()) {
       echo CustomFunction::alertRekamMedis();
    }
}
?>
<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Asesmen Nyeri',
);
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
));

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>

<style>
    .disable-panel {
        margin: 0;
        padding: 0 !important;
        cursor: not-allowed;
        position: absolute;
        z-index: 99999;
        height: 96%;
        width: 97%;
    }

    select[disabled] {
        background: #eeeeee;
    }
</style>
<!--div class="white-container"-->
<!-- <div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-diagnoses'></i> Pemeriksaan <b>Asesmen Nyeri</b>
        </div>
    </div>
    <div class="panel-body"> -->

<?php
echo $this->renderPartial($this->path_view . '_tabelRiwayat', array(
    'model' => $modriwayat,
), true);
?>

<?php
// $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//     'id' => 'jenisobat',
//     'slide' => true,
//     'content' => array(
//         'content2' => array(
//             'multi' => 'multi',
//             'header' => 'Riwayat Asesmen Nyeri',
//             'isi' => $this->renderPartial($this->path_view . '_tabelRiwayat', array(
//                 'model' => $modriwayat,
//             ), true),
//             'active' => false,
//         ),
//     ),
// ));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="control-group" style="margin-top: 10px;">
    <?php echo $form->labelEx($model, 'tglpemeriksaannyeri', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => 'tglpemeriksaannyeri',
            'value' => null,
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'maxDate' => 'd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span3 htpd',
            ),
        ));
        ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Ada Keluhan Nyeri ?</label>
    <div class="controls" id="status-nyeri">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo $form->radioButton($model, 'keluhannyeri', array('id' => 'nyeriYes', 'value' => 1, 'onclick' => 'adaNyeri();', 'uncheckValue' => null)); ?> <label>Ada</label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo $form->radioButton($model, 'keluhannyeri', array('id' => 'nyeriNo', 'value' => 0, 'onclick' => 'adaNyeri();', 'uncheckValue' => null)); ?> <label>Tidak Ada</label>

    </div>
</div>

<?php
if ($model->is_keluhannyeribayi) {
    echo $this->renderPartial($this->path_view . 'form.anak._form', array(
        'form' => $form,
        'model' => $model,
    ), true);
} else {

?>


    <div class="panel panel-success panel_nyeri" id="nyeri_dewasa">
        <div class="panel-heading">
            <div class="panel-title"><?php echo $form->radioButton($model, 'is_keluhannyeri_dewasa', array('onclick' => 'pilihNyeri()', 'value' => 1, 'class' => 'pilih_nyeri', 'uncheckValue' => null)); ?> Asesmen Nyeri Dewasa</div>
        </div>
        <div class="panel-body">
            <h2 style="text-align:center;">Intensitas "WONG BAKER FACE SCALE"</h2>
            <br>
            <?php
            echo $this->renderPartial($this->path_view . 'form._formNyeri', array(
                'form' => $form,
                'model' => $model
            ), true);
            ?>

        </div>
    </div>

    <div class="panel panel-success panel_nyeri" id="nyeri_anak">
        <div class="panel-heading">
            <div class="panel-title"><?php echo $form->radioButton($model, 'is_keluhannyeri_dewasa', array('onclick' => 'pilihNyeri()', 'value' => 0, 'class' => 'pilih_nyeri', 'uncheckValue' => null)); ?> Asesmen Nyeri Anak < 6 Tahun</div>
            </div>
            <div class="panel-body">
                <?php
                echo $this->renderPartial($this->path_view . 'form._formNyeriFlaCcs', array(
                    'form' => $form,
                    'model' => $model,
                    'dataFlaCcs' => $dataFlaCcs,
                    'modFlaCcs' => $modFlaCcs,
                    'getFlaCcs' => $getFlaCcs,
                    'modNyeriAnakDet' => $modNyeriAnakDet
                ), true);
                ?>

            </div>
        </div>

        <?php /*
            <div class="panel panel-success" id="lokasi_nyeri">
                <div class="panel-heading">
                    <div class="panel-title">
                        Lokasi Nyeri
                    </div>
                </div>
                <div class="panel-body">
                    <div id="disableLokasiNyeri"><!--background-color:rgba(0, 0, 0, 0.1);-->                        
                    </div>   

                    <?php
                    echo $this->renderPartial($this->path_view . 'form._formLokasiNyeri', array(
                        'form' => $form,
                        'model' => $model,
                        'modGambarTubuh' => $modGambarTubuh,
                        'modPemeriksaanGambar' => $modPemeriksaanGambar
                            ), true);
                    ?>   

                </div>
            </div>

            <div class="panel panel-success"  id="periksa_nyeri">
                <div class="panel-heading">
                    <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan Nyeri</div>
                </div>
                <div class="panel-body">
                    <div id="disablePeriksaNyeri"><!--background-color:rgba(0, 0, 0, 0.1);-->                        
                    </div>

                    <?php
                    echo $this->renderPartial($this->path_view . 'form._formPemeriksaanNyeri', array(
                        'form' => $form,
                        'model' => $model,
                            ), true);
                    ?>   

                </div>
            </div>
             * 
             */ ?>

    <?php } ?>

    <div class="form-actions <?php echo isset($_GET['lihat']) ? 'hide' : '' ?>">
        <?php 
        if ($model->isNewRecord) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
            // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false;",'disabled'=>'true', 'style'=>'cursor:not-allowed;'));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => false));

            if ($edit == true) {
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Asesmen Nyeri', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('index', array('pendaftaran_id' => $idedit)), array('class' => 'btn btn-danger',));
            }
            // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printAsesmen();return false",'enabled'=>'true'));
        }
        ?>

        <?php
        // $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        // $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </div>
    <!-- </div>
</div> -->
    <?php echo $this->renderPartial($this->path_view . 'js._jsFunctions', array('modPendaftaran' => $modPendaftaran, 'modBagianTubuh' => $modBagianTubuh, 'model' => $model, 'modGambarTubuh' => $modGambarTubuh, 'modPemeriksaanGambar' => $modPemeriksaanGambar), true); ?>

    <?php $this->endWidget(); ?>

    <?php
    // ===========================Dialog Details=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogDetail',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Detail Riwayat',
            'autoOpen' => false,
            'minWidth' => 900,
            'height' => 320,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="frameDetail" style="width: 100%; height: 98%; border: none;"></iframe>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>