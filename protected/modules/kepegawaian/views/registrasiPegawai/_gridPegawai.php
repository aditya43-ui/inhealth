<legend class="rim">Data Pegawai</legend>
<div style='max-height:300px;overflow-y: scroll;'>
    <?php
        $this->widget('ext.bootstrap.widgets.BootGridView',
            array(
                'id'=>'sapegawai-m-grid',
                'dataProvider'=>$model->searchRegistrasi(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'header' => 'No.',
                        'value' => '$row+1'
                    ),
                    'nomorindukpegawai',
                    'nama_pegawai',
                    'jeniskelamin',
                    'kelompokpegawai.kelompokpegawai_nama',
                    'jabatan.jabatan_nama',
                    array(
                        'header'=>'<div class="test" style="cursor:pointer;" onclick="openDialogini()"> No. Finger Print <icon class="icon-list"></icon></div>',
                        'value'=>'CHtml::textField("KPRegistrasifingerprint[$data->pegawai_id]no", $data->nofingerprint, array("class"=>"span1 numbersOnly nofinger"))',
                        'type'=>'raw',
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )
        );
    ?>
</div>

<?php
    // ===========================Dialog Details Tarif=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogDetails',
            'options'=>array(
                'title'=>'No. Finger Print',
                'autoOpen'=>false,
                'width'=>170,
                'height'=>140,
                'resizable'=>false,
                'scroll'=>false,
                'modal'=>true
            ),
        )
    );
?>
<div class="awawa" width="100%" height="100%">
    <?php echo CHtml::textField('fisiks', 0, array('class'=>'numbersOnly span2')); ?>
    <?php echo CHtml::button('submit', array('class' => 'btn btn-danger', 'onclick'=>'setVolume();', 'id'=>'submitJumlahVolume')); ?>
</div>
<?php $this->endWidget(); ?>

<?php
$js = <<< JSCRIPT
function openDialogini()
{
    $("#dialogDetails").dialog("open");
}

function setVolume()
{
    var value = $("#fisiks").val();
    $("#sapegawai-m-grid").find(".nofinger").each(function(){
        $(this).val(value);
        value++;
    });
}
JSCRIPT;
Yii::app()->clientScript->registerScript('finger_grid_function_onhead',$js,CClientScript::POS_HEAD);
?>