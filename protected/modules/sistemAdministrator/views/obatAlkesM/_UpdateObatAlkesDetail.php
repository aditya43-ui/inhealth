
<fieldset class="">
    <legend>
        Obat Alkes Detail
    </legend>
    <div id="divObatalkesdetail" class="control-group">
        <?php
            $obatdetail = ObatalkesdetailM::model()->findByAttributes(array('obatalkes_id'=>$model->obatalkes_id));
        ?>
        <table>
            <tr>
                <td>
                    <div class="control-label">Indikasi</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$obatdetail,'attribute'=>'indikasi','name'=>'ObatalkesdetailM[indikasi]','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </td>
                <td>
                    <div class="control-label">Kontraindikasi</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$obatdetail,'attribute'=>'kontraindikasi','name'=>'ObatalkesdetailM[kontraindikasi]','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td>
                    <div class="control-label">Komposisi</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$obatdetail,'attribute'=>'komposisi','name'=>'ObatalkesdetailM[obatdetail]','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </td>
                <td>
                    <div class="control-label">Efek Samping</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$obatdetail,'attribute'=>'efeksamping','name'=>'ObatalkesdetailM[efeksamping]','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td>
                    <div class="control-label">Interaksi Obat</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$obatdetail,'attribute'=>'interaksiobat','name'=>'ObatalkesdetailM[interaksiobat]','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </td>
                <td>
                    <div class="control-label">Cara Penyimpanan</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$obatdetail,'attribute'=>'carapenyimpanan','name'=>'ObatalkesdetailM[carapenyimpanan]','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td>
                    <div class="control-label">Peringatan</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$obatdetail,'attribute'=>'peringatan','name'=>'ObatalkesdetailM[peringatan]','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </td>
                <td></td>
            </tr>
                        
        </table>
    </div>
</fieldset>

<?php
$enableInputobatdetail = ($model->formObatAlkesDetail) ? 1 : 0;
$js = <<< JS
if(${enableInputobatdetail}) {
    $('#divObatalkesdetail input').removeAttr('disabled');
    $('#divObatalkesdetail select').removeAttr('disabled');
}
else {
    $('#divObatalkesdetail input').attr('disabled','true');
    $('#divObatalkesdetail select').attr('disabled','true');
}

$('#formObatAlkesDetail').change(function(){
        if ($(this).is(':checked')){
                $('#divObatalkesdetail input').removeAttr('disabled');
                $('#divObatalkesdetail select').removeAttr('disabled');
        }else{
                $('#divObatalkesdetail input').attr('disabled','true');
                $('#divObatalkesdetail select').attr('disabled','true');
                $('#divObatalkesdetail input').attr('value','');
                $('#divObatalkesdetail select').attr('value','');
        }
        $('#divObatalkesdetail').slideToggle(500);
    });
JS;
Yii::app()->clientScript->registerScript('obatalkesdetail',$js,CClientScript::POS_READY);
?>