<?php 
// Dialog untuk kirim dokumen RM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsesmen',
    'options' => array(
        'title' => '<span id="judul"></span>',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 1250,
        'height' => 600,
        'resizable' => true,
        //'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
          //  data: $('#daftarPasien-form').serialize()
        //}); }",
    ),
));
?>
<iframe id='frameAsesmen' width="100%" height="100%"></iframe>
<?php $this->endWidget(); 
// end ============== ?>


<?php 
// Dialog untuk kirim dokumen RM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsesmenRevisiRencana',
    'options' => array(
        'title' => '<span id="judul-tambah"></span>',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 1000,
        'height' => 600,
        'resizable' => true,
        'close'=>"js:function(){refreshIframe();}",
    ),
));
?>

<?php $this->endWidget(); 
// end ============== ?>