<?php

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjskriningGizi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekValidasi()'),
    'focus' => '#',
));
?>
<div class="row">
    <div class="col-sm-12">
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-gizi',
            'content' => array(
                'content-list-gizi' => array(
                    'header' => '<b>Riwayat Skrining Gizi Awal</b>',
                    'isi' => $this->renderPartial($this->path_view . "skriningGizi/_riwayat", array(
                        'modRiwayat' => $modRiwayat,
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        ?>
    </div>
</div>
<?php echo $this->renderPartial($this->path_view."skriningGizi/_table", array('model'=>$model, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'form'=>$form, 'data' => $data, 'modDetail' => $modDetail),true);?>
<?php echo $this->renderPartial($this->path_view."skriningGizi/_jsFunction", array('model'=>$model),true);?>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
    ?>
    <?php
    $tips = array(
        '0' => 'waktutime',
        '1' => 'autocomplete-search',
        '2' => 'simpan'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailGizi',
    'options' => array(
        'title' => 'Detail Skrining Awal Gizi',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 800,
        'resizable' => false,
        'position' => 'top',
    ),
));

echo '<div id="contentDetailGizi"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');