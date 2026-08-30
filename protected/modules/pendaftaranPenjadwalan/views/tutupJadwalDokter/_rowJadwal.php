<tr>
    <td>
        <?php echo $model->jadwaldokter_hari.", ".MyFormatter::formatDateTimeForUser($model->jadwaldokter_tgl); ?>
    </td>
    <td>
        <?php echo $model->ruangan->ruangan_nama ?? "-"; ?>
    </td>
    <td>
        <?php echo date('H:i', strtotime($model->jadwaldokter_mulai))." - ".date('H:i', strtotime($model->jadwaldokter_tutup)); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($model, '['.$model->jadwaldokter_id.']pegawai_id', CHtml::listData(
            DokterV::model()->findAllByAttributes(array(
                'ruangan_id'=>$model->ruangan_id,'pegawai_aktif'=>true
            ), array(
                'order'=>'nama_pegawai',
                'condition'=>'pegawai_id <> '.$pegawai_id,
            )), 'pegawai_id', 'namaLengkap'), array(
                'empty'=>'-- Pilih --', 'class'=>'ceklis_pegawai',
            )); ?>
    </td>
    <td>
        <?php echo CHtml::activeCheckBox($model, '['.$model->jadwaldokter_id.']ceklis', array('class'=>'ceklis_jadwal')); ?>
    </td>

</tr>