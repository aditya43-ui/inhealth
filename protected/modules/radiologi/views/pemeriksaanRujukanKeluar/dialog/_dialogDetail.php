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
        'zIndex'=>1002,
        'width' => 850,
        'height' => 500,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';

$this->endWidget();
?>