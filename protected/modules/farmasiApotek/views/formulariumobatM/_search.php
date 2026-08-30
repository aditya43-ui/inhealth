<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'fakasuspenyakitobat-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Obat dan Alkes', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'obatalkes_id', array('class' => 'span3', 'maxlength' => 50)); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'obatalkes',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . Yii::app()->createUrl('ActionAutoComplete/ObatAlkes') . '",
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
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(\'#FAFormulariumobatM_obatalkes_id\').val(ui.item.value);
                            $(\'#obatalkes\').val(ui.item.label);
                            submitDiagnosaobat();
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Obat Alkes',
                        'size' => 13,
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObatalkes'),
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->DropDownListRow($model, 'jenisformularium', LookupM::getItems('jenisformularium'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <?php
            $carabayar = CarabayarM::model()->findAll(array(
                'condition' => 'carabayar_aktif = true',
                'order' => 'carabayar_nama ASC',
            ));
            foreach ($carabayar as $idx => $item) {
                $penjamins = PenjaminpasienM::model()->findByAttributes(
                    array(
                        'carabayar_id' => $item->carabayar_id,
                        'penjamin_aktif' => true,
                    ),
                    array('order' => 'penjamin_nama ASC')
                );
                if (empty($penjamins)) unset($carabayar[$idx]);
            }
            $penjamin = PenjaminpasienM::model()->findAll(array(
                'condition' => 'penjamin_aktif = true',
                'order' => 'penjamin_nama',
            ));
            echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                    'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                ),
            ));
            echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3'));
        ?>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'is_aktif', array('checked' => true)); ?>
                <?php echo $form->label($model,'is_aktif'); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    );
    ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>
<!--============================== Widget Dialog ObatAlkes ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObatalkes',
    'options' => array(
        'title' => 'Pencarian Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modObatalkes = new ObatalkesM;
$modObatalkes->unsetAttributes();
if (isset($_GET['ObatalkesM'])) {
    $modObatalkes->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-grid',
    'dataProvider' => $modObatalkes->searchObatFarmasi(),
    'filter' => $modObatalkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"",
                "id" => "a",
                "onClick" => "
                    $(\"#FAFormulariumobatM_obatalkes_id\").val(\"$data->obatalkes_id\");
                    $(\"#obatalkes\").val(\"$data->obatalkes_nama\");
                    $(\"#dialogObatalkes\").dialog(\"close\"); 
                    return false;
                "))',
        ),
        array(
            'header' => 'Kode Obat',
            'name' => 'obatalkes_kode',
            'value' => '$data->obatalkes_kode',
        ),
        array(
            'header' => 'Nama Obat',
            'name' => 'obatalkes_nama',
            'value' => '$data->obatalkes_nama',
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenisobatalkes_id',
            'value' => '(isset($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "-")',
            'filter' => CHtml::dropDownList('ObatalkesM[jenisobatalkes_id]', $modObatalkes->jenisobatalkes_id, CHtml::listData(JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC"), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Kategori',
            'name' => 'obatalkes_kategori',
            'value' => '$data->obatalkes_kategori',
            'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_kategori]', $modObatalkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Golongan',
            'name' => 'obatalkes_golongan',
            'value' => '$data->obatalkes_golongan',
            'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_golongan]', $modObatalkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--============================== endWidget Dialog ObatAlkes ====================================-->