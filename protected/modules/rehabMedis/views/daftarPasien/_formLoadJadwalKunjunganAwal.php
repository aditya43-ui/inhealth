<?php for ($x = 0; $x < $lamaTerapi; $x++) : ?>
    <tr id="tindakan_<?php echo $x; ?>">
    <?php if($x < 1){ ?>
            <td>
                <?php echo $x + 1 ?>
                <?php foreach ($idHasil as $idHasilNya)
                    {
                        echo CHtml::hiddenField("JadwalKunjungan[hasilpemeriksaanrm_id][]", $idHasilNya,array('class'=>'inputFormTabel','readonly'=>true));
                    } 
                ?>
            </td>
    <?php 
    }
    else{
    ?>
		<td>
			<?php echo $x + 1 ?>
		</td>
    <?php } ?>
        <td>
            <?php   
                $this->widget('MyDateTimePicker',array(
                    'name'=>'JadwalKunjungan[tgljadwalrm][]',
                    'value'=> MyFormatter::formatDateTimeForUser(date('Y-m-d')),
                    'mode'=>'date',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 tgljadwalrm', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:110px;','id'=>'JadwalKunjungan_tgljadwalrm_'.$x.''),
            )); 
                ?>
        </td>
        <td>
            <?php foreach ($tindakan as $i=>$tind)
                {
                    echo TindakanrmM::model()->with('jenistindakanrm')->findByPk($tind)->jenistindakanrm->jenistindakanrm_nama.'-';
                    echo TindakanrmM::model()->with('jenistindakanrm')->findByPk($tind)->tindakanrm_nama.'</br><br/>';
                    echo CHtml::hiddenField("JadwalKunjungan[tindakanrm_id][$x][]", $tind,array('class'=>'inputFormTabel','readonly'=>true));
                } 
            ?>
        </td>
        <!-- <td>
            <?php //echo CHtml::dropDownList('JadwalKunjungan[paramedis1_id][]', '' , CHtml::listData(RMPendaftaranT::model()->getParamedisItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Paramedis 1 --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 required')); ?>
            <?php //echo CHtml::dropDownList('JadwalKunjungan[paramedis2_id][]', '' , CHtml::listData(RMPendaftaranT::model()->getParamedisItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Paramedis 2 --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 required')); ?>
        </td> -->
        <!-- <td>
            <?php //echo CHtml::dropDownList('JadwalKunjungan[pegawai_id][]', '' , CHtml::listData(RMPendaftaranT::model()->getDokterItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
        </td> -->
        <td>
            <?php
            // echo CHtml::hiddenField('JadwalKunjungan[slotbed_id][]', '', array('class' => 'control-label'));
            // echo $form->dropDownList(
            //     $model,
            //     'propinsi_id',
            //     CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
            //     array(
            //         'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            //         'ajax' => array(
            //             'type' => 'POST',
            //             'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
            //             'update' => "#" . CHtml::activeId($model, 'kabupaten_id'),
            //         ),
            //         'onchange' => "setClearSlotBed();",
            //     )
            // );
        // $model = 'JadwalKunjungan';
        // $type_list = CHtml::listData(SlotbedM::model()->findAllByAttributes(array('slotbed_aktif' => true), array('order' => 'slotbed_nobed ASC')), 'slotbed_id', 'slotbed_nobed');
        //     echo CHtml::dropDownList('JadwalKunjungan[slotbed_id][]', '' , $type_list ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
        //     'ajax' => array(
        //         'type' => 'POST',
        //         'url' => $this->createUrl('SetDropdownSlotBed', array('encode' => false, 'model_nama' => get_class($model))),
        //         'update' => "#" . CHtml::activeId($model, 'kabupaten_id'),
        //     ),
        //     'onchange' => "setClearSlotBed();",
        // ));
    // if (!empty($pindahkamar->ruangan_id)) {
        $slotbedList = SlotbedM::getSlotBed(date('Y-m-d'), $kunjungan->kelaspelayanan_id, Yii::app()->user->getState('instalasi_id'));//KamarDanTempatTidur
   
            echo CHtml::dropDownList('JadwalKunjungan[slotbed_noslot][]', '' , $slotbedList ,array(
                'empty'=>'-- Pilih --',
                'onkeypress'=>"return $(this).focusNextInputField(event)",
                'class'=>'nobed',
                'onchange'=>'cekSlotTersedia(this);'
            ));
            // $type_list = CHtml::listData(ShiftM::model()->findAllByAttributes(array('shift_aktif' => true), array('order' => 'shift_urutan ASC')), 'shift_id', 'shift_nama');
            // echo CHtml::dropDownList('JadwalKunjungan[shift_id][]', '' , $type_list ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
            <?php
//            $type_list = CHtml::listData(ShiftM::model()->findAllByAttributes(array('shift_aktif' => true), array('order' => 'shift_urutan ASC')), 'shift_id', 'shift_nama');
//            echo CHtml::checkBoxList('JadwalKunjungan[shift_id][]', $selected_Array = array(), $type_list);
            ?>
        </td>
        <td>
            <?php
            $type_list = array(); //CHtml::listData(SlotbedM::model()->findAllByAttributes(array('slotbed_aktif' => true), array('order' => 'slotbed_noslot ASC')), 'slotbed_id', 'SlotBedKet'); // 'slotbed_id' =>$slotbedList, untuk hide data dipesan
            echo CHtml::dropDownList('JadwalKunjungan[slotbed_id][]', '' , $type_list ,array(
                'empty'=>'-- Pilih --',
                'onkeypress'=>"return $(this).focusNextInputField(event)",
                'class'=>'slotbed',
                'onchange'=>'cekValidasiSlotBed(this)',
            ));
            ?>
        </td>
    </tr>
<?php endfor; ?>
