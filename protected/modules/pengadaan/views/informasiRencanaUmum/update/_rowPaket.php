<tr rowdata="0">
    <td><label class="no-urut"><?php echo $no++ ?></label>        
        <?php
            echo CHtml::hiddenField('paket[0][paketpekerjaan_id]',$model->paketpekerjaan_id,array('readonly'=>true, 'class'=>'paketpekerjaan_id'));            
            echo CHtml::hiddenField('paket[0][mappingrekeninganggaran_id]','',array('readonly'=>true, 'class'=>'mappingrekeninganggaran_id'));            
        ?>                         
    </td>
    <td>        
        <?php echo !empty($model->paketpekerjaan->kode_paketpekerjaan) ? $model->paketpekerjaan->kode_paketpekerjaan : '-'; ?>
    </td>   
</tr>