<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfsupplier-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($model, 'supplier_kode'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'supplier_kode', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            <?php echo $form->textFieldRow($model, 'supplier_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'supplier_namalain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textAreaRow($model, 'supplier_alamat', array('rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model, 'supplier_kodepos', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model, 'longitude', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'longitude', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo CHtml::htmlButton(
                        '<i class="entypo-search"></i>',
                        array(
                            //						  'onclick'=>'$("#dialogLongitudeLatitude").dialog("open");return false;',
                            'class' => 'btn btn-danger',
                            'rel' => "tooltip",
                            'id' => 'yw1',
                            'title' => "Klik untuk mencari Longitude & Latitude",
                        )
                    ); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'latitude', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->dropDownListRow(
                $model,
                'supplier_propinsi',
                CHtml::listData($model->PropinsiItems, 'propinsi_nama', 'propinsi_nama'),
                array(
                    'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                )
            ); ?>
            <?php echo $form->dropDownListRow(
                $model,
                'supplier_kabupaten',
                CHtml::listData($model->KabupatenItems, 'kabupaten_nama', 'kabupaten_nama'),
                array(
                    'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                )
            ); ?>
            <?php echo $form->textFieldRow($model, 'supplier_telp', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'supplier_fax', array('class' => 'span2 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </td>
        <td><?php echo $form->textFieldRow($model, 'supplier_npwp', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'supplier_website', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'supplier_email', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'supplier_cp', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'supplier_norekening', array('class' => 'span2 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->dropDownListRow(
                $model,
                'supplier_jenis',
                CHtml::listData($model->JenisSupplierItems, 'lookup_value', 'lookup_name'),
                array(
                    'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                )
            ); ?>
            <div>
                <?php echo $form->checkBoxRow($model, 'supplier_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </td>
    </tr>
    <tr>
        <!--<td colspan="2">
                    <div class="control-group">
                        <?php //echo Chtml::label('Obat Alkes','Obat Alkes',array('class'=>'control-label'));
                        ?>
                        <div class="controls">
                           <?php
                            //                              $arrObatAlkes = array();
                            //                                   foreach($modObatSupplier as $data)
                            //                                     {
                            //                                        $arrObatAlkes[] = $data['obatalkes_id'];
                            //                                     }
                            //
                            //                                $this->widget('application.extensions.emultiselect.EMultiSelect',
                            //                                             array('sortable'=>true, 'searchable'=>true)
                            //                                        );
                            //                                echo CHtml::dropDownList(
                            //                                'obatalkes_id[]',
                            //                                $arrObatAlkes,
                            //                                CHtml::listData(GFObatAlkesM::model()->findAll('obatalkes_aktif=TRUE ORDER BY obatalkes_nama'), 'obatalkes_id', 'obatalkes_nama'),
                            //                                array('multiple'=>'multiple','key'=>'obatalkes_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                            //                                        );
                            ?>
                        </div>
                    </div>      
                </td>-->
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Supplier', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->widget('ext.LocationPicker2.CoordinatePicker', array(
    'model' => $model,
    'latitudeAttribute' => 'latitude',
    'longitudeAttribute' => 'longitude',
    //optional settings
    'editZoom' => 12,
    'pickZoom' => 7,
    'defaultLatitude' => $latitude,
    'defaultLongitude' => $longitude,
));
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('GFSupplierM_supplier_namalain').value = nama.value.toUpperCase();
    }
</script>