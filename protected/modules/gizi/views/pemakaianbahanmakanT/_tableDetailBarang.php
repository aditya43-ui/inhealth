<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>                  
            <th>Golongan</th>
            <th>Jenis</th>
            <th>Kelompok</th>
            <th>Nama Bahan Makanan</th>  
            <th>Tanggal Kedaluwarsa</th>
            <th>Harga Netto (Rp)</th>
            <th>Jumlah Pakai</th>            
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
//        echo 'aaaaa========== '.count((array)$modDetails);
//        exit();
        if (isset($modDetails)){
            $format = new MyFormatter();
        foreach ($modDetails as $i=>$detail){?>
        <?php $modBhnMkn = BahanmakananM::model()->findByPk($detail->bahanmakanan_id); ?>
            <tr>   
                <td><?php 
        echo CHtml::hiddenField('no_urut', '', array('class'=>'')); 
        echo CHtml::activeHiddenField($detail, '['.$i.']bahanmakanan_id', array('class'=>'bahanmakanan')); 
        echo CHtml::activeHiddenField($detail, '['.$i.']satuanbahan', array()); 
        $detail->harganetto = number_format($modBhnMkn->harganettobahan,0,"",".");
//        echo CHtml::activeHiddenField($modDetail, '[ii]ppn', array('class'=>'ppn')); 
//        echo CHtml::activeHiddenField($modDetail, '[ii]disc', array('class'=>'disc')); 
//        echo CHtml::activeHiddenField($modDetail, '[ii]hpp', array('class'=>'hpp'));
        echo $modBhnMkn->golbahanmakanan->golbahanmakanan_nama;
        ?>
    </td>
    <td><?php echo $modBhnMkn->jenisbahanmakanan; ?></td>
    <td><?php echo $modBhnMkn->kelbahanmakanan; ?></td>
        <td><?php echo $modBhnMkn->namabahanmakanan; ?></td>    
    <td><?php echo $format->formatDateTimeForUser($modBhnMkn->tglkadaluarsabahan); ?></td>
    <!--<td><?php // echo number_format($modBahanmkn->harganettobahan,0,"","."); ?></td>-->
    <!--<td><?php // echo CHtml::activeTextField($detail, '['.$i.']harganetto', array('class'=>'span2 float beli',)); ?> </td>-->
    <td><?php echo (Params::cekHiddenHargaGizi()==true)?CHtml::activeTextField($detail, '['.$i.']harganetto', array('class'=>'span2 float beli', 'readonly'=>true)):CHtml::activePasswordField($detail, '['.$i.']harganetto', array('class'=>'span2 float beli', 'readonly'=>true)); ?></td>
    <td><?php echo CHtml::activeTextField($detail, '['.$i.']jmlpemakaianbhnmkn', array('class'=>'span1 float qty', )); ?></td>
    <!--<td><?php //echo CHtml::activeDropDownList($modDetail, '[ii]satuanpakai', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>-->    
    <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
<!--<td><?php 
//                    echo CHtml::activeHiddenField($detail, '['.$i.']barang_id',array('class'=>'barang')); 
//                    echo $modBarang->barang_type;
                    ?>
                </td>
                <td><?php // echo $modBarang->barang_kode; ?></td>
                <td><?php // echo $modBarang->barang_nama; ?></td>
                <td><?php // echo $modBarang->barang_merk; ?></td>         
                <td><?php // echo $modBarang->barang_ukuran; ?></td>    
                <td><?php // echo $modBarang->barang_ekonomis_thn; ?></td>    
                <td>
                <?php 
//                    echo (Params::cekHiddenHargaGudangUmum()==true || Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($detail, '['.$i.']harganetto', array('class'=>'span1 integer2 mutasi', 'onblur'=>'cekStok(this);')):CHtml::activePasswordField($detail, '['.$i.']harganetto', array('class'=>'span1 integer2 mutasi', 'onblur'=>'cekStok(this);'));
//                    echo '<br>';
//                    echo $form->error($detail, '['.$i.']harganetto');
                ?>
                </td>
                <td>
                <?php 
//                    echo (Params::cekHiddenHargaGudangUmum()==true || Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($detail, '['.$i.']hargajual', array('class'=>'span1 integer2 mutasi', 'onblur'=>'cekStok(this);')):CHtml::activePasswordField($detail, '['.$i.']hargajual', array('class'=>'span1 integer2 mutasi', 'onblur'=>'cekStok(this);'));
//                    echo '<br>';
//                    echo $form->error($detail, '['.$i.']hargajual');
                ?>
                </td>
                <td>
                <?php 
//                    echo CHtml::activeTextField($detail, '['.$i.']jmlpakai', array('class'=>'span1 integer2 qty', 'onblur'=>'cekStok(this);'));
//                    echo '<br>';
//                    echo $form->error($detail, '['.$i.']jmlpakai');
                ?>
                </td>
                <td><?php // echo CHtml::activeDropDownList($detail, '['.$i.']satuanpakai', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
                 <td><?php //echo CHtml::activeTextField($detail, '['.$i.']jmldlmkemasan', array('class'=>'span1 integer qty', 'onblur'=>'cekStok(this);'));
                    //echo '<br>';
                    //echo $form->error($detail, '['.$i.']jmlpakai'); ?></td>                 
                <td><?php //echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>-->
            </tr>   
        <?php }
        }
        ?>
    </tbody>
</table>