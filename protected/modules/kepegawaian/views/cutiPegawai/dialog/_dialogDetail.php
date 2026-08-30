<?php
/**
* - digunakan untuk memanggil dialog detail poin pegawai
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Permohonan Cuti',
        'autoOpen' => false,
         'modal' => true,
        'zIndex'=>1200,
        'width' => 846,
        'height' => 359,
        'zIndex'=>1200,
        'close'=>"js:function(){ $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
					data: $('#kpinfohukumanpoinpeg-v-search').serialize()
				}); }",
    ),
));

echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';

$this->endWidget();
?>