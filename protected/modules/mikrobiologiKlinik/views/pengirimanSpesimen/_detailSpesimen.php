<tr>   
    <td><?php echo CHtml::textField('no_urut', '', array('class' => 'span1', 'readonly' => true)); ?></td>
    <td><?php echo $modSpesimen['no_spesimen']; ?></td>
    <td><?php echo $modKirimSpesimenDetail['nama_pasien']; ?></td>
    <td><?php echo $modKirimSpesimenDetail['no_rekam_medik']; ?></td>
    <td><?php echo $modKirimSpesimenDetail['ruangan_nama']; ?></td>
    <td><?php echo MyFormatter::formatDateTimeId($modSpesimen['waktu_pengambilan_spesimen']); ?></td>
    <td><?php echo $modKirimSpesimenDetail['jenis_spesimen']; ?></td>      
    <td><?php echo $modKirimSpesimenDetail['jenis_pemeriksaan']; ?></td>    
    <td>
        <?php echo $modSpesimen['status']; ?>
        <?php echo CHtml::activeHiddenField($modKirimSpesimenDetail, '[ii]tindakanpelayanan_id', array());?>
        <?php echo CHtml::activeHiddenField($modKirimSpesimenDetail, '[ii]pasien_id', array());?>
        <?php echo CHtml::activeHiddenField($modKirimSpesimenDetail, '[ii]samplelab_id', array());?> 
        <?php echo CHtml::activeHiddenField($modKirimSpesimenDetail, '[ii]spesimen_id', array('class' => 'spesimen_id'));?>
        <?php echo CHtml::activeHiddenField($modKirimSpesimenDetail, '[ii]no_spesimen', array('class'=>'no_spesimen')); ?> 
    </td>    
    <td><?php echo Chtml::link('<icon class="glyphicon glyphicon-remove"></icon>', '', array('onclick' => 'batal(this);', 'style' => 'cursor:pointer;', 'class' => 'cancel')); ?></td>
</tr>        