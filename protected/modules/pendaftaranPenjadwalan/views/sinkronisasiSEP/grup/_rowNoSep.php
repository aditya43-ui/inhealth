<tr>
    <td><?php echo $idx + 1; ?></td>
    <td><?php echo MyFormatter::formatDateTimeForUser($item->tgl_pendaftaran); ?></td>
    <td><?php echo $item->no_pendaftaran; ?></td>
    <td><?php echo $item->no_rekam_medik; ?></td>
    <td><?php echo $item->nama_pasien; ?></td>
    <td><?php echo $item->jnspelayanan; ?></td>
    <td><?php 
    echo CHtml::textField('list['.$item->pendaftaran_id.'][no_kartu]', $item->nokartuasuransi, array(
        'class'=>'list_no_kartu span3',
    )); 
    ?></td>
    <td><?php 
    echo CHtml::textField('list['.$item->pendaftaran_id.'][no_sep]', $nosep, array(
        'class'=>'list_no_sep span3',
    ));
    echo CHtml::hiddenField('list['.$item->pendaftaran_id.'][data_sep]', $sep_hasil, array(
        'class'=>'list_data_sep span3',
    ));
    
    // echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
    //     'class'=>'btn btn-primary', 'onclick'=>'cariNomorSep(this)', 'rel'=>'tooltip', 'title'=>'Cari No SEP berdasarkan Nomor Kartu'
    // ));
    ?></td>
</tr>