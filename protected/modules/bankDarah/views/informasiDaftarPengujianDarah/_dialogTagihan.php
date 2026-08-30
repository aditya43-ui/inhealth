<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTagihan',
    'options' => array(
        'title' => 'Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 800,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('permintaandarah-r-grid', {
            data: $('#permintaandarah-r-search').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeTagihan' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>