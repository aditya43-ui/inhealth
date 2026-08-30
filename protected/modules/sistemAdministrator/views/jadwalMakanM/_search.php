
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    	'id'=>'sajadwalmakan-m-search',
        'type'=>'horizontal',
        ));
?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->hiddenField($model, 'jenisdiet_id'); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'jenisdiet_id', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model'=>$model,
                            'attribute' => 'jenisdiet_nama',
                            'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/Jenisdiet') . '",
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
                                'focus' => 'js:function( event, ui )
                                                   {
                                                    $(this).val(ui.item.label);
                                                    return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                   $("#'.CHtml::activeId($model, 'jenisdiet_id').'").val(ui.item.jenisdiet_id);
                                                    return false;
                                                }',
                            ),
                            'htmlOptions' => array(
                                'readonly' => false,
                                'placeholder' => 'Jenis Diet',
                                'size' => 13,
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                        ));
                        ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'tipediet_id'); ?>
                <?php echo $form->labelEx($model, 'tipediet_id', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model'=>$model,
                                'attribute' => 'tipediet_nama',
                                'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . Yii::app()->createUrl('ActionAutoComplete/TipeDiet') . '",
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
                                    'focus' => 'js:function( event, ui )
                                                               {
                                                                $(this).val(ui.item.label);
                                                                return false;
                                                                }',
                                    'select' => 'js:function( event, ui ) {
                                                               $("#'.CHtml::activeId($model, 'tipediet_id').'").val(ui.item.tipediet_id);
                                                                return false;
                                                            }',
                                    'blur'=>'js:function(event, ui){
                                        if ($(this).val() == "")
                                            $("#'.CHtml::activeId($model, 'tipediet_id').'").val();
                                        }'
                                ),
                                'htmlOptions' => array(
                                    'readonly' => false,
                                    'placeholder' => 'Tipe Diet',
                                    'size' => 13,
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                            ));
                            ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'menudiet_id') ?>
                <?php echo $form->labelEx($model, 'menudiet_id', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model'=>$model,
                                'attribute' => 'menudiet_nama',
                                'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/MenuDiet') . '",
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
                                    'focus' => 'js:function( event, ui )
                                                   {
                                                    $(this).val(ui.item.label);
                                                    return false;
                                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                   $("#menudiet_id").val(ui.item.menudiet_id);
                                                   $("#menudiet_id_0").val(ui.item.menudiet_id);
                                                   $("#menudiet_id_1").val(ui.item.menudiet_id);
                                                   $("#menudiet_id_2").val(ui.item.menudiet_id);
                                                   $("#menudietpagi").val(ui.item.menudiet_nama);
                                                   $("#menudietsiang").val(ui.item.menudiet_nama);
                                                   $("#menudietmalam").val(ui.item.menudiet_nama);
                                                    return false;
                                                }',

                                ),
                                'htmlOptions' => array(
                                    'readonly' => false,
                                    'placeholder' => 'Menu Diet',
                                    'size' => 13,
                                ),
                            ));
                            ?>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>

