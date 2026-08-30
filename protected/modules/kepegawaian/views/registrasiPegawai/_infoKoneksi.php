<legend class="rim">Informasi Koneksi</legend>
<style>
    
    #infokoneksi{
        margin:10px;
        float:left;
        display: box;
        width:200px;
        border:1px solid #cccccc;
        padding:5px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
    }
    
    #infokoneksi .control-label{
        width:50px;
    }
    
    #infokoneksi .controls{
        margin-left: 70px;
    }
    
</style>
<table style="border:1px solid #000000;border-collapse:collapse;">
    <tr>
        <td width="5">
            <?php
                $konfigFinger = AlatfingerM::model()->findAll();
                $myData = CHtml::encodeArray(CHtml::listData($konfigFinger, 'alatfinger_id', 'alatfinger_id'));
                echo Chtml::checkBoxList(
                    'alatfinger_id', false,
                    CHtml::listData($konfigFinger, 'alatfinger_id', 'namaalat'),
                    array(
                        'template'=>'<label class="checkbox inline">{input}{label}</label>',
                        'separator'=>'<br>',
                        'class'=>'span2',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onClick'=>'aktifkanFinger(this, false)',
                    )
                );
            ?>            
        </td>
        <td id="info_koneksi"></td>
    </tr>
</table>

<?

$getInformasi =  Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/informasiKoneksi');
$setInformasiFinger =  Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/updataStatusFinger');
$getFingerUser =  Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/getFingerUser');
$js = <<< JSCRIPT
function getInformasiUser(params)
{
    $('#tbl_info_user_finger').find('tbody').empty();
    $.ajax({
        dataType:"json",
        data: {idAlat:params},
        url: "${getFingerUser}",
        success:function(data)
        {
            $('#dlgInfoUser').dialog('open');
            if(data.status == 1)
            {
                $('#tbl_info_user_finger').find('tbody').append(data.form);
            }
        }
    });
}

function aktifkanFinger(obj, disconnect)
{
    var idAlat = $(obj).val();
    var data = {idAlat:idAlat};

    if($(obj).is(':checked', true))
    {
        if (jQuery.isNumeric(idAlat))
        {
            $.ajax({
                dataType:"json",
                data: data,
                url: "${getInformasi}",
                success:function(data)
                {
                    if(data.is_aktif)
                    {
                        $('#info_koneksi').append(data.form);
                        jQuery('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip({"placement":"bottom"});
                    }
                }
            });
        }
    }else{
        if (jQuery.isNumeric(idAlat))
        {
            $.ajax({
                dataType:"json",
                data: data,
                url: "${setInformasiFinger}",
                success:function(data)
                {
                    if(data)
                    {
                        $('#info_koneksi').find('div[tag="'+ idAlat +'"]').detach();
                    }
                }
            });
        }
    }
    
}
JSCRIPT;
Yii::app()->clientScript->registerScript('finger_form_function_onhead',$js,CClientScript::POS_HEAD);
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
    'id' => 'dlgInfoUser',
    'options' =>
        array(
            'title' => 'Informasi User Finger',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 450,
            'resizable' => false,
        ),
    )
);
?>
<div style='max-height:400px;overflow-y: scroll;'>
<table id="tbl_info_user_finger" class="table table-striped table-bordered table-condensed">
    <thead>
        <th width="10">No. </th>
        <th width="50">PIN</th>
        <th>Nama Pegawai</th>
    </thead>
    <tbody></tbody>
</table>
</div>
<?php $this->endWidget(); ?>