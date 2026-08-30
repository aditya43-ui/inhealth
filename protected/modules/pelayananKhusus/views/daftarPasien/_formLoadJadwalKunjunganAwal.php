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
                    'value'=> date('Y-m-d h:i:s'),
                    'mode'=>'datetime',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:110px;','id'=>'JadwalKunjungan_tgljadwalrm_'.$x.''),
            )); 
                ?>
        </td>
        <td>
            <?php foreach ($tindakan as $i=>$tind)
                {
                    echo TindakanrmM::model()->with('jenistindakanrm')->findByPk($tind)->jenistindakanrm->jenistindakanrm_nama.'-';
                    echo TindakanrmM::model()->with('jenistindakanrm')->findByPk($tind)->tindakanrm_nama.'</br>';
                    echo CHtml::hiddenField("JadwalKunjungan[tindakanrm_id][$x][]", $tind,array('class'=>'inputFormTabel','readonly'=>true));
                } 
            ?>
        </td>
        <td>
            <?php echo CHtml::dropDownList('JadwalKunjungan[paramedis1_id][]', '' , CHtml::listData(RMPendaftaranT::model()->getParamedisItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Paramedis 1 --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 required')); ?>
            <?php echo CHtml::dropDownList('JadwalKunjungan[paramedis2_id][]', '' , CHtml::listData(RMPendaftaranT::model()->getParamedisItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Paramedis 2 --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 required')); ?>
        </td>
        <td>
            <?php echo CHtml::dropDownList('JadwalKunjungan[pegawai_id][]', '' , CHtml::listData(RMPendaftaranT::model()->getDokterItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
        </td>
    </tr>
<?php endfor; ?>
