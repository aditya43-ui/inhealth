<?php 
echo '<table>
<tr>
<td>'.CHtml::hiddenField('filter', 'wilayah').'<label>Propinsi</label></td><td>'.$form->dropDownList($modPPInfoKunjunganV, 'propinsi_id', CHtml::listData($modPPInfoKunjunganV->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => ''.get_class($modPPInfoKunjunganV).'')),
                                                                'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'kabupaten_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'
</td>
</tr><tr><td><label>Kabupaten</label></td><td>'.
                                                        $form->dropDownList($modPPInfoKunjunganV, 'kabupaten_id', array(), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                            'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => ''.get_class($modPPInfoKunjunganV).'')),
                                                            'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'kecamatan_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'
                                                        .$form->dropDownList($modPPInfoKunjunganV, 'kecamatan_id', array(), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => ''.get_class($modPPInfoKunjunganV).'')),
                                                                'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'kelurahan_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
                                                        $form->dropDownList($modPPInfoKunjunganV, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>'; ?>