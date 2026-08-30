<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
       // 'close' => "js:function(){ if (typeof approveDialog === 'function'){approveDialog();}  }"
    ),
));
?>

<iframe id="frameDetailDialog" src="" name="detailDialog" style="width: 100%; height: 98%;"></iframe>

<?php
$this->endWidget();