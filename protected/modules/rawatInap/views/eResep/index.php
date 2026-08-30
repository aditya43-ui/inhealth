<?php
$this->breadcrumbs = array(
    'Penulisan e-Resep',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Penulisan e-Resep
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pelayananpasien-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);',
                'onsubmit' => 'return beforeSubmit(this);',
            ), //DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#instalasi_id',
        )); ?>
        <?php
        //check apakah Prescribing atau tidak;
        if ($this->init_modul == 'FA') {
        ?>
            <?php echo $this->renderPartial($this->path_view . '_ringkasDataPasienPC', array('form' => $form, 'modKunjungan' => $modKunjungan), true); ?>
        <?php
        } else {
        ?>
            <?php echo $this->renderPartial($this->path_view . '_ringkasDataPasien', array('form' => $form, 'modKunjungan' => $modKunjungan), true); ?>
        <?php
        }
        ?>

        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Riwayat Resep Pasien
                </div>
            </div>
            <div class="panel-body table-responsive" id="list-rujukankeluar">
                <?php echo $this->renderPartial($this->path_view . '_listResep', array(
                    'modRiwayatResep' => $modRiwayatResep,
                ), true); ?>
            </div>
        </div>

        <?php echo $this->renderPartial($this->path_view . '_formInputObat', array('form' => $form, 'modReseptur' => $modReseptur), true); ?>
        <?php echo $this->renderPartial($this->path_view . '_dpjp', array('form' => $form, 'modReseptur' => $modReseptur), true); ?>
        <?php echo $this->renderPartial($this->path_view . '_jsFunction', array('form' => $form, 'modReseptur' => $modReseptur, 'modKunjungan' => $modKunjungan), true); ?>
        <div class="clear"></div>
        <div class="form-actions">
            <?php /* <input type="button" value="Cari" class="btn" style="padding:3px;" margin="6px;" width="50px;" onclick="location.href='Scanner:';" /> */ ?>
            <?php
            if (!$modReseptur->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger submit', 'id' => 'btn_submit', 'disabled' => true)
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'title' => 'Ulang',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                //echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRecordTerakhir(\'PRINT\')')); 
                //echo CHtml::htmlButton(Yii::t('mds','{icon} eResep',array('{icon}'=>'<i class="'.MyIcon::getIcons('gambar').'"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'viewDetailResep('.$modReseptur->reseptur_id.','.$modReseptur->pendaftaran_id.')')); 
                echo CHtml::link('<i class="' . MyIcon::getIcons('gambar') . '"></i> eResep', Yii::app()->controller->createUrl("detailGambar", array("reseptur_id" => $modReseptur->reseptur_id, "frame" => 1)), array(
                    'rel' => 'tooltip',
                    'onclick' => '$("#dialogGallery").dialog("open")',
                    "target" => "iframeGallery",
                    'data-placement' => 'left',
                    'class' => 'btn btn-info',
                    'title' => 'Klik untuk melihat gambar eResep'
                ));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan','class' => 'btn btn-danger', 'id' => 'btn_submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        //'disabled'=>true,
                        'title' => 'Ulang',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                //echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-info', 'type'=>'button','disabled'=>'disabled')); 
                echo CHtml::htmlButton(Yii::t('mds', '{icon} eResep', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
            }
            ?>

            <?php $content = $this->renderPartial('rawatInap.views.tips.tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content)); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogGallery',
    'options' => array(
        'title' => 'Gambar eResep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
        // 'close'=>"js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
        //               data: $('#caripasien-form').serialize()
        //         }); }",
    ),
));
?>
<iframe src="" name="iframeGallery" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>

<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLihatImg',
    'options' => array(
        'title' => 'Lihat Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 400,
        'height' => 500,
        'resizable' => false,
        // 'close'=>"js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
        //               data: $('#caripasien-form').serialize()
        //         }); }",
    ),
));
?>
<?php echo CHtml::image('', 'alt', array('id' => 'imageeResep', 'width' => '100%', 'height' => '100%')) ?>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>