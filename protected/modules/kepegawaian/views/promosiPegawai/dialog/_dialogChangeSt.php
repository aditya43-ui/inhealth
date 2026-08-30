<?php
/**
*       - digunakan untuk memanggil dialog box untuk mengubah status
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogChangeSt',
    'options'=>array(
        'title'=>'Change Status',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height' => 300,
        'zIndex'=>1002,
        'resizable'=>true,
    ),
));
?>
<div id="form-changest">
</div>
<?php
$this->endWidget();
?>

