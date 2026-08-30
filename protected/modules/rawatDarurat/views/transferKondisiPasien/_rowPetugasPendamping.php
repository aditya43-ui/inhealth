<tr>
    <td>
        <?php echo CHtml::hiddenField('pegawai_id',(!empty($dataPegPendamping->pegawai_id)?$dataPegPendamping->pegawai_id:""),array('class'=>'pegawai_id')); ?>
        <?php echo CHtml::textField('pegawai_nama',(!empty($dataPegPendamping->pegawai_nama)?$dataPegPendamping->pegawai_nama:""),array('readonly'=>true,'class'=>'pegawai_nama', 'style'=>'width: 300px')); ?>
    </td>
    <td>
        <a onclick="batalPegawaiPendamping(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Petugas Pendamping"><i class="icon-remove"></i></a>
    </td>
</tr>