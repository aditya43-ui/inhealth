<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ubahPasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        )
);
?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pasien_id',array('readonly'=>true)); ?>
<!-- <p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p> -->
<table border="1">
    <tr>
        <td widht="50%">
            <table>
                <tr>
                    <td><?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => TRUE)); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->textFieldRow($model, 'tgl_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => TRUE)); ?></td>
                </tr>
                
            </table>
        </td>
        
    </tr>
</table>
<table class="table">
    <tr>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'no_identitas_pasien', array('class' => 'control-label','readonly' => TRUE)) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
                    ));
                    ?>   
                    <?php echo $form->textField($model, 'no_identitas_pasien', array('placeholder' => 'No Identitas', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>            
                    <?php echo $form->error($model, 'jenisidentitas'); ?><?php echo $form->error($model, 'no_identitas'); ?>
                </div>
            </div>
            <?php //echo $form->textFieldRow($model,'no_identitas_pasien',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'nama_pasien', array('class' => 'control-label')) ?>
                <div class="controls inline">

                    <?php
                    echo $form->dropDownList($model, 'namadepan', LookupM::getItems('namadepan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
                    ));
                    ?>   
                    <?php echo $form->textField($model, 'nama_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>            

<?php echo $form->error($model, 'namadepan'); ?><?php echo $form->error($model, 'nama_pasien'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nama_bin', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model, 'tempat_lahir', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                    <?php echo $form->labelEx($model, 'tanggal_lahir', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tanggal_lahir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
            <?php echo $form->error($model, 'tanggal_lahir'); ?>
                </div>
            </div>
                <?php echo $form->dropDownListRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
<?php echo $form->labelEx($model, 'golongandarah', array('class' => 'control-label')) ?>

                <div class="controls">

<?php echo $form->dropDownList($model, 'golongandarah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'));
?>   
                    <div class="radio inline">
                        <div class="form-inline">
                    <?php echo $form->radioButtonList($model, 'rhesus', LookupM::getItems('rhesus'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>            
                        </div>
                    </div>
<?php echo $form->error($model, 'golongandarah'); ?>
            <?php echo $form->error($model, 'rhesus'); ?>
                </div>
            </div>
            <?php
            echo $form->textFieldRow($model, 'nama_ibu', array(
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'placeholder' => 'Nama Ibu'
                    )
            );
            ?>
            <?php
            echo $form->textFieldRow($model, 'nama_ayah', array(
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'placeholder' => 'Nama Ayah'
                    )
            );
            ?>                            
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'alamat_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'rt', array('class' => 'control-label inline')) ?>

                <div class="controls">
                    <?php echo $form->textField($model, 'rt', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'maxlength' => 3)); ?>   / 
                    <?php echo $form->textField($model, 'rw', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'maxlength' => 3)); ?>            
                    <?php echo $form->error($model, 'rt'); ?>
                    <?php echo $form->error($model, 'rw'); ?>
                </div>
            </div>
            <?php
          //  echo $form->dropDownListRow($model, 'propinsi_id', CHtml::listData(PropinsiM::model()->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                //'ajax' => array('type' => 'POST',
                  //  'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => 'PPPasienM')),
                    //'update' => '#PPPasienM_kabupaten_id'
           /// )));
            ?>
            <?php
           //echo $form->dropDownListRow($model, 'kabupaten_id', CHtml::listData(KabupatenM::model()->getKabupatenItemsProp($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                //'ajax' => array('type' => 'POST',
                 //   'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => 'PPPasienM')),
                   // 'update' => '#PPPasienM_kecamatan_id'
          //  )));
            ?>
            <?php
            //echo $form->dropDownListRow($model, 'kecamatan_id', CHtml::listData(KecamatanM::model()->getKecamatanItemsKab($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
               // 'ajax' => array('type' => 'POST',
                   // 'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => 'PPPasienM')),
                   // 'update' => '#PPPasienM_kelurahan_id',
         //   )));
            ?>
            <?php //echo $form->dropDownListRow($model, 'kelurahan_id', CHtml::listData(KelurahanM::model()->getKelurahanItemsKec($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

<?php echo $form->textFieldRow($model, 'no_telepon_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($model, 'no_mobile_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
<?php
echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
?>
</div>



<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPasien()
    {
        var noRekamMedik = $('#temp_norekammedik').val();
        $.post("<?php echo Yii::app()->createUrl('ActionAjax/cariPasien') ?>", {norekammedik: noRekamMedik},
        function(data) {
            $('#PasienM_no_rekam_medik').val(data.no_rekam_medik);
            $('#PasienM_nama_pasien').val(data.nama_pasien);
             $('#PasienM_jenisidentitas').val(data.jenisidentitas);
            
            
            $('#PasienM_pasien_id').val(data.pasien_id);
            $('#PasienM_no_identitas_pasien').val(data.no_identitas_pasien);
      
            $('#PasienM_tgl_rekam_medik').val(data.tgl_rekam_medik);
            $('#PasienM_no_identitas').val(data.no_identitas);
            $('#PasienM_nama_bin').val(data.nama_bin);
            $('#PasienM_namadepan').val(data.namadepan);
            $('#PasienM_tempat_lahir').val(data.tempat_lahir);
            $('#PasienM_tanggal_lahir').val(data.tanggal_lahir);
            $('#PasienM_statusperkawinan').val(data.statusperkawinan);
            $('#PasienM_golongandarah').val(data.golongandarah);
            $('#PasienM_nama_ayah').val(data.nama_ayah);
            $('#PasienM_nama_ibu').val(data.nama_ibu);
            $('#PasienM_alamat_pasien').val(data.alamat_pasien);
            $('#PasienM_rt').val(data.rt);
            $('#PasienM_rw').val(data.rw);
            $('#PasienM_kabupaten_nama').val(data.kabupaten_nama);
            $('#PasienM_propinsi_nama').val(data.propinsi_nama);
            $('#PasienM_kecamatan_nama').val(data.kecamatan_nama);
            $('#PasienM_kelurahan_nama').val(data.kelurahan_nama);
        $('#PasienM_no_telepon_pasien').val(data.no_telepon_pasien);   
        $('#PasienM_no_mobile_pasien').val(data.no_mobile_pasien);
        $('#PasienM_jeniskelamin').val(data.jeniskelamin);
            $('#jk').val(data.jeniskelamin);
        }, "json");
    }
    loadDataPasien();
</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#photo_pasien')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


