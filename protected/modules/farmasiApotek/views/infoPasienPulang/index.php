<?php
$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'Search Patient'), 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form form').submit(function(){
	$.fn.yiiGridView.update('pencarianpasien-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Pasien Rawat Jalan', 'url' => ''),
        array('label' => 'Pasien Rawat Inap', 'url' => ''),
        array('label' => 'Pasien Rawat Darurat', 'url' => ''),
    ),
));
?>

<fieldset>
    <legend>Pilih Pasien Instalasi</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td><?php echo CHtml::radioButton('instalasi', $cekRJ, array('value' => 'RJ', 'onClick' => 'submitForm(this)', 'class' => 'ceklis')) ?> Rawat Jalan</td>
            <td><?php echo CHtml::radioButton('instalasi', $cekRI, array('value' => 'RI', 'onClick' => 'submitForm(this)', 'class' => 'ceklis')) ?> Rawat Inap</td>
            <td><?php echo CHtml::radioButton('instalasi', $cekRD, array('value' => 'RD', 'onClick' => 'submitForm(this)', 'class' => 'ceklis')) ?> Rawat Darurat</td>
        </tr>
    </table>
</fieldset>
<?php
if ($cekRJ == TRUE) {
    echo $this->renderPartial('_formCariRJ', array('model' => $modRJ, 'form' => $form, 'format' => $format,), true);
} elseif ($cekRI == TRUE) {

    echo $this->renderPartial('_formCariRI', array('model' => $modRI, 'form' => $form, 'format' => $format,), true);
} elseif ($cekRD == TRUE) {
    echo $this->renderPartial('_formCariRD', array('model' => $modRD, 'form' => $form, 'format' => $format,), true);
}
?>


<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>


<?php $this->endWidget(); ?>

<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenjualanResep',
    'options' => array(
        'title' => 'Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframePenjualanResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>