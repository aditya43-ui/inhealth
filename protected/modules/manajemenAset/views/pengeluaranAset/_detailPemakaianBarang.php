<tr>   

    <td><?php 
    echo CHtml::activeHiddenField($modDetail, '[ii]invperalatan_id', array('class'=>'barang')); 
    echo $modBarang->invperalatan_namabrg;
    ?></td>
    <td><?php echo $modBarang->invperalatan_kode."/".$modBarang->invperalatan_noregister; ?></td>   
    <td><?php echo $modBarang->invperalatan_merk." / ".$modBarang->invperalatan_ukuran." / ".$modBarang->invperalatan_bahan;?></td>  
    <td><?php echo $modBarang->invperalatan_thnpembelian; ?></td>  
    <td>
        <?php echo CHtml::activeDropDownList($modDetail, '[ii]pengeluaranaset_keadaan', 
            LookupM::getItems('inventariskeadaan'),
            array(
                'class'=>'pengeluaranaset_keadaan span2'
            )); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modDetail, '[ii]ket_pengeluaranaset', array(
            'class'=>'ket_pengeluaranaset'
        )); ?>
    </td>
    <td><?php echo Chtml::link('<icon class="glyphicon glyphicon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        