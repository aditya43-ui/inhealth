<tr>
    <td><?php echo isset($data->pasien_id) ? $modPasien->nama_pasien : ' '; ?></td> 
    <td><?php echo isset($data->surveilans_tgl) ? MyFormatter::formatDateTimeForUser($data->surveilans_tgl) : ''; ?></td> 
    <td><?php echo ($data->ett == true) ? 1 : 0; ?></td>  
    <td><?php echo ($data->ivl == true) ? 1 : 0; ?></td>  
    <td><?php echo ($data->cvl == true) ? 1 : 0; ?></td>  
    <td><?php echo ($data->uc == true) ? 1 : 0; ?></td>  
    <td><?php echo ($data->cdl == true) ? 1 : 0; ?></td> 
    <td><?php echo ($data->vap == true) ? 1 : 0; ?></td>  
    <td><?php echo ($data->iad == true) ? 1 : 0; ?></td>  
    <td><?php echo ($data->pleb == true) ? 1 : 0; ?></td>  
    <td><?php echo ($data->isk == true) ? 1 : 0; ?></td>  
    <td><?php echo ($data->deku == 'Ya') ? 1 : 0; ?></td>  
    <td><?php echo isset($data->sputum) ? $data->sputum : ''; ?></td>  
    <td><?php echo isset($data->darah) ? $data->darah : ''; ?></td>  
    <td><?php echo isset($data->urine) ? $data->urine : ''; ?></td>  
    <td><?php echo isset($data->antibiotik) ? $data->antibiotik : ''; ?></td> 
    <td> 
        <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'batalSurveilans(' . $data->surveilans_id . ',' . $data->pasien_id . ');return false;')); ?>
    </td>             
</tr>