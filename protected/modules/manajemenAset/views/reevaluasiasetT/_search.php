<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'mareevaluasiaset-t-search',
    'type' => 'horizontal',
        ));
?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::hiddenField('barang_id'); ?>
            <?php echo CHtml::hiddenField('barang_kode'); ?>
            <label class="control-label" for="namaObat">Nama Aset</label>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'barang_nama',
                    'source' => 'js: function(request, response) {
                                                                                                                       $.ajax({
                                                                                                                               url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
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
                        'select' => 'js:function( event, ui ) {
                                                                                                               $(this).val( ui.item.label);
                                                                                                               $("#barang_id").val(ui.item.barang_id);
                                                                                                               $("#barang_kode").val(ui.item.barang_kode);
                                                                                                                    return false;
                                                                                                            }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogAset', 'idTombol' => 'tombolDialogOa'),
                    'htmlOptions' => array('placeholder' => 'Ketik Nama Aset', "rel" => "tooltip", "title" => "Pencarian Data Asset", 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenis_aset', CHtml::listData(BarangV::model()->findAll(), 'barang_type', 'barang_type'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>	
    </div>

</div>

<div class="form-actions">
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
</div>

<?php $this->endWidget(); ?>
