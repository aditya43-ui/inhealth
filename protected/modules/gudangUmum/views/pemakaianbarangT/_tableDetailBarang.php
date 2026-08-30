<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>                  
            <th>Tipe Barang</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Merk</th>  
            <th>Ukuran</th>
            <th>Tahun Ekonomis</th>
            <th>Harga Netto (Rp)</th>
            <th>Harga Satuan (Rp)</th>
            <th>Jumlah Pakai</th>            
            <!--<th>Satuan</th>-->
            <!--<th>Jumlah Dalam Kemasan</th>-->
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (isset($modDetails)){
        foreach ($modDetails as $i=>$detail){?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <td><?php 
                    echo CHtml::activeHiddenField($detail, '['.$i.']barang_id',array('class'=>'barang')); 
                    echo $modBarang->barang_type;
                    ?>
                </td>
                <td><?php echo $modBarang->barang_kode; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td><?php echo $modBarang->barang_merk; ?></td>         
                <td><?php echo $modBarang->barang_ukuran; ?></td>    
                <td><?php echo $modBarang->barang_ekonomis_thn; ?></td>    
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']harganetto', array('class'=>'span1 integer2 mutasi', 'onblur'=>'cekStok(this);'));
                    echo '<br>';
                    echo $form->error($detail, '['.$i.']harganetto');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']hargajual', array('class'=>'span1 integer2 mutasi', 'onblur'=>'cekStok(this);'));
                    echo '<br>';
                    echo $form->error($detail, '['.$i.']hargajual');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']jmlpakai', array('class'=>'span1 integer2 qty', 'onblur'=>'cekStok(this);'));
                    echo '<br>';
                    echo $form->error($detail, '['.$i.']jmlpakai');
                ?>
                </td>
                <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']satuanpakai', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
                <!--<td><?php //echo CHtml::activeTextField($detail, '['.$i.']jmldlmkemasan', array('class'=>'span1 integer qty', 'onblur'=>'cekStok(this);'));
                    //echo '<br>';
                    //echo $form->error($detail, '['.$i.']jmlpakai'); ?></td>-->                
                <td><?php //echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
</table>