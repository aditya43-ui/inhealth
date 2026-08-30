<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogCetakUlang',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Cetak Ulang</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 400,
        'resizable' => true
    ),
));
?>
<iframe name='iframeCetakUlang' width="100%" height="100%" id="iframeCetakUlang"></iframe>
<?php $this->endWidget(); ?>