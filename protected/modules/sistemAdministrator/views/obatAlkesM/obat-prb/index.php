<div class="control-group ">
    <?php echo CHtml::label('Kode Obat Program Rujuk Balik BPJS', 'kodeobatbpjs_prb', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->hiddenField($model, 'kodeobatbpjs_prb', array('class' => 'kodeobatbpjs_prb')); ?>
        <?php echo $form->hiddenField($model, 'namaobatbpjs_prb', array('class' => 'namaobatbpjs_prb')); ?>
        <?php        
        $this->widget('MyJuiAutoComplete', array(
            'model'=>$model,
            'attribute' => 'obat_prb',
            'source' => 'js: function(request, response) {
                $.ajax({
                    url: "' . $this->createUrl('autoCompleteObatPrb') . '",
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 2,
                'focus' => 'js:function( event, ui ){
                    $(this).val(ui.item.label);
                    return false;
                }',
                'select' => 'js:function( event, ui ) {
                    pilihObatPRB(ui.item);
                    return false;
                }',
            ),
            'htmlOptions' => array(
                'readonly' => false,
                'placeholder' => 'Ketikkan kode nama obat prb',                
                'class' => 'span3',
                'onkeypress' => "return $(this).focusNextInputField(event);",
                'onblur' => 'if (this.value==""){$(".kodeobatbpjs_prb").val("");$(".namaobatbpjs_prb").val("")}'
            ),
            'tombolDialog' => array('idDialog' => 'dialogObatPRB'),
        ));
        ?>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatPRB',
    'options' => array(
        'title' => 'Pencarian Obat Generik PRB',
        'autoOpen' => false,
        'modal' => true,
        'width' => 530,
        'height' => 450,
        'resizable' => false,
    ),
));

echo '<div id="form-list-obat-prb" class="form-horizontal" style="padding:10px;">';
echo '<br/>';
echo '
    <div class="control-group">
        <label class="control-label">Nama Obat Generik</label>
        <div class="controls">
            '.CHtml::textField('fieldKodeObatPRB','',['class'=>'span3 required']).'
        </div>
        <div class="controls">
            '.CHtml::htmlButton("<span class='entypo-Search'></span> Cari",['class'=>'btn btn-primary', 'onclick'=>'refObatPRB();']).'
        </div>
    </div>
';

echo $this->renderPartial('sistemAdministrator.views.obatAlkesM.obat-prb/_table');

echo '</div>';

$this->endWidget();

$urlTambahInfoRs = $this->createUrl('/actionAjax/tambahLookup');
$jscript = <<< JS
            
    var cekData = () => {
        const message = $(".message-bpjs").data('message');
        
        if (message != ''){            
            myAlert(message,"Perhatian!");
        }
    }
        
    const refObatPRB = () => {
        if (requiredCheck($("#form-list-obat-prb"))){
            const kode = $("#fieldKodeObatPRB").val();
           
            $.fn.yiiGridView.update('daftar-obat-prb-grid',{
                data:{
                    'ARCustomModel[obatprb]':kode
                }
            })
        }
    }
        
    const pilihObatPRB = (data) => {
        $("#obat_prb").val(data.kode+" - "+data.nama);
        $(".kodeobatbpjs_prb").val(data.kode);
        $(".namaobatbpjs_prb").val(data.nama);
        
        $("#dialogObatPRB").dialog("close");
    }            
JS;

Yii::app()->clientScript->registerScript('master-obat-alkes-list-obat-prb', $jscript, CClientScript::POS_HEAD);
?>