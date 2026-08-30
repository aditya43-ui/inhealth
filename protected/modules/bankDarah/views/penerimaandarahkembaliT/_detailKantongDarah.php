<tr>   
    <td>
        <?php 
            echo CHtml::textField('no_urut',0,array('class'=>'span1','readonly'=>true)); 
            echo CHtml::hiddenField('det[ii][ujikompatibilitas_id]',$det['ujikompatibilitas_id'], array('class'=>'ujikompatibilitas_id')); 
            echo CHtml::hiddenField('det[ii][no_kantongdarah]',$det['no_kantongdarah'], array('class'=>'no_kantongdarah')); 
        ?>
    </td>
    <td><?php echo $det['no_kantongdarah']; ?></td>       
    <td><?php echo $det['nama_pasien']; ?></td>       
    <td><?php echo $det['no_rekam_medik']; ?></td>       
    <td><?php echo $det['ruangan_nama']; ?></td>       
    <td><?php echo $det['jenis_komponen_darah']; ?></td>       
    <td><?php echo $det['golongan_darah']; ?></td>       
    <td><?php echo Chtml::link('<icon class="glyphicon glyphicon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        