<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed" id="tableDetailBarang">
    <thead>
        <tr>
            <th>Golongan</th>
            <th>Kelompok</th>
            <th>Sub Kelompok</th>
            <th>Bidang</th>
            <th>Barang</th>
            <th>Harga Beli</th>
            <th>Harga Satuan</th>
            <th>Jumlah Beli</th>
            <th>Satuan</th>
            <th>Jumlah Dalam Kemasan</th>
			<?php if ($model->isNewRecord) { ?>
            <th>Batal</th>
			<?php } ?>
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
                    echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null; 
                    ?>
                </td>
                <td><?php echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; ?></td>
				<td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; ?></td>
				<td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']hargabeli', array('class'=>'span1 numbersOnly mutasi', 'onblur'=>'cekStok(this);'));
                    echo '<br>';
                    echo $form->error($detail, '['.$i.']hargabeli');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']hargasatuan', array('class'=>'span1 numbersOnly mutasi', 'onblur'=>'cekStok(this);'));
                    echo '<br>';
                    echo $form->error($detail, '['.$i.']hargasatuan');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']jmlbeli', array('class'=>'span1 numbersOnly qty', 'onblur'=>'cekStok(this);'));
                    echo '<br>';
                    echo $form->error($detail, '['.$i.']jmlbeli');
                ?>
                </td>
                <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
                <td><?php echo CHtml::activeTextField($detail, '['.$i.']jmldlmkemasan', array('class'=>'span1 numbersOnly qty', 'onblur'=>'cekStok(this);'));
                    echo '<br>';
                    echo $form->error($detail, '['.$i.']jmlbeli'); ?></td>
				<?php if ($model->isNewRecord) { ?>
                <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
				<?php } ?>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
</table>