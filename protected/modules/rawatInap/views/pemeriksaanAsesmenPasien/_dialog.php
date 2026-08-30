<?php 
// Dialog untuk kirim dokumen RM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsesmen',
    'options' => array(
        'title' => 'Asesmen Pasien',
        'autoOpen' => false,
        // 'modal' => true,
        'zIndex'=>1002,
        'width' => 1200,
        'height' => 500,
        'resizable' => true,
        //'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
          //  data: $('#daftarPasien-form').serialize()
        //}); }",
    ),
));
?>
<iframe id='frameAsesmen' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); 
// end ============== ?>

<?php 
// Dialog untuk kirim dokumen RM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsesmenRevisiRencana',
    'options' => array(
        'title' => 'Asesmen Pasien IPOC',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'close'=>"js:function(){refreshIframe();}",
    ),
));
?>

<iframe id='frameTambah' width="100%" height="98%" src=""></iframe>

<?php $this->endWidget(); 
// end ============== ?>