
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Pembayaran Kasir',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 1124,
        'height' => 510,
        'resizable' => true,
    ),
));
?>
<iframe src="" id="iframeDetail" name="iframeDetail" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>