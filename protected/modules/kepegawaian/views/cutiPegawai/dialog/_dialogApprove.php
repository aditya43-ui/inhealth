<?php
/**
* - digunakan untuk memanggil dialog approve permohonan cuti
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogApprove',
    'options' => array(
        'title' => 'Menyetujui?',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 600,
        'height' => 400,
         'zIndex'=>1002,
        'resizable' => true,
        'close'=>"js:function(){ $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
					data: $('#kpinfohukumanpoinpeg-v-search').serialize()
				}); }",
    ),
));

echo '<iframe src="" name="frameApprove" style="overflow:auto; width:100%; height: 98%;"></iframe>';

$this->endWidget();
?>