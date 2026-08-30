<?php 
$modKepalaUnit = UnitkerjaM::model()->findByAttributes(array('unitkerja_id' => Params::UNITKERJA_ID_SEKSI_PENGEMBANGAN_MUTU_KEPERAWATAN));
if (!empty($modKepalaUnit) && $modKepalaUnit->kepalaunitpeg_id == Yii::app()->user->getState('pegawai_id')) {
    echo CHtml::activeRadioButtonList($model, 'jenis', array('Unit' => 'Unit', 'Pegawai' => 'Pegawai', 'Semua' => 'Rumah Sakit'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setPerawat();'));
} else {
    echo CHtml::activeRadioButtonList($model, 'jenis', array('Unit' => 'Unit', 'Pegawai' => 'Pegawai'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setPerawat();'));
}
?>
<br>
<br>
<?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3 pegawai_id')); 

$this->widget('MyJuiAutoComplete', array(
    'attribute' => 'nama_perawat',
    'model' => $model,
    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutoCompleteGetPerawat') . '",
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
                                $(this).val("");
                                return false;
                            }',
        'select' => "js:function( event, ui ) {
                $(this).val(ui.item.nama_pegawai);
                $('#ASOppekehadiranT_pegawai_id').val(ui.item.pegawai_id);
                $('#ASOppekehadiranT_nama_perawat').val(ui.item.nama_pegawai);
                $('#ASOppekehadiranT_nip_perawat').val(ui.item.nomorindukpegawai);  
                $('#ASOppekehadiranT_perawat_unitkerja_id').val(ui.item.unitkerja_id);  
                $('#ASOppekehadiranT_namaunitkerja').val(ui.item.namaunitkerja); 
                return false;
            }",
    ),
    'htmlOptions' => array(
        'placeholder' => '',
        'class' => 'span3 custom-only',
        'onkeyup' => "return $(this).focusNextInputField(event)",
    ),
    'tombolDialog' => array('idDialog' => 'dialogPerawat', 'jsFunction' => 'setJenis();'),
));
?>