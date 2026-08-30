<tr>
    <td class="askep_nik"></td>
    <td class="askep_nama"></td>
    <td style="width: 50px; text-align: center;">
        <?php echo CHtml::hiddenField('pegawai_askep[]', '', array('class'=>'pegawai_askep')); ?>
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            'onclick'=>'hapusPegawaiAskep(this); return false;',
        )); ?>
    </td>
</tr>
