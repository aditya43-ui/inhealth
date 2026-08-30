<?php
/**
* - digunakan untuk memanggil dialog approve permohonan cuti
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
//    'id' => 'dialogApprove',
//    'options' => array(
//        'title' => 'Proses Tanda Bukti Kas Keluar',
//        'autoOpen' => false,
//        'modal' => true,
//        'zIndex'=>1002,
//        'width' => 1100,
//        'height' => 550,
//        'resizable' => false,
//        'close'=>"js:function(){ $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
//					data: $('#kpinfohukumanpoinpeg-v-search').serialize()
//				}); }",
//    ),
//));
//
//echo '<iframe src="" name="frameApprove" width="100%" height="100%">
//</iframe>';
//
//$this->endWidget();
?>

<!--Dialog untuk mengetahui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMengetahui',
        'options' => array(
            'title' => 'Approvement Pegawai Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
            'close'=>"js:function(){ $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
                            data: $(this).serialize()
                    }); }",
        ),
));
?>
<iframe name='frameMengetahui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<!--Dialog untuk menyetujui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMenyetujui',
        'options' => array(
            'title' => 'Approvement Pegawai Menyetujui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 500,
            'resizable' => false,
            'close'=>"js:function(){ $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
                            data: $(this).serialize()
                    }); }",
        ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>