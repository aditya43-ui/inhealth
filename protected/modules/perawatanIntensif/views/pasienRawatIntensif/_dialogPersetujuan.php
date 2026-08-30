<?php 
// GENERAL CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogGeneralConsent',
    'options' => array(
        'title' => 'General Consent',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
    ),
));
?>
<iframe name='frameGeneralConsent' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

    <?php 
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogInformConsent',
    'options' => array(
        'title' => 'Inform Consent',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
    ),
));
?>
<iframe name='frameInformConsent' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php 
// TINDAKAN ANESTESI =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTindakanAnestesi',
    'options' => array(
        'title' => 'Persetujuan Tindakan Anestesi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
    ),
));
?>
<iframe name='frameTindakanAnestesi' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php 
// TINDAKAN =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPersetujuanTindakan',
    'options' => array(
        'title' => 'Detail Persetujuan & Penolakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
    ),
));
?>
<iframe name='framePersetujuanTindakan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>