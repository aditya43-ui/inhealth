<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailPenjualan',
    'options'=>array(
        'title'=>'Detail Penjulan',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'height' => 500,
        'resizable'=>false,
    ),
));

?>
<iframe src="" name="iframeDetail" style="width: 100%; height:98%"></iframe>
<?php

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogUbah',
    'options'=>array(
        'title'=>'Ubah Jumlah',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'height' => 400,
        'resizable'=>false,
        'close' => 'js:function(){  $.fn.yiiGridView.update("reseppasien-grid") }'
    ),
));

?>
<iframe src="" name="iframeUbah" style="width: 100%; height:98%"></iframe>
<?php

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>