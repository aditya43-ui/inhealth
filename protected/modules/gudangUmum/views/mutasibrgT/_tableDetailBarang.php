<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped datatable" id="tableDetailBarang">
    <thead>
        <tr>
            <!--th>Golongan</th>
            <th>Kelompok</th>
            <th>Sub Kelompok</th>
            <th>Bidang</th>-->
            <th>Tipe Barang</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Ukuran</th>
            <th>Tahun Ekonomis</th>
			<th>Stok</th>
            <?php //if (isset($_GET['id'])){ ?>
            <th>Jumlah Pesan</th>
            <?php //} ?>
            <th>Jumlah Mutasi</th>
           <!--<th>Satuan</th>-->
            
            <?php if ($model->isNewRecord){ ?>
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
                    echo CHtml::activeHiddenField($detail, '['.$i.']satuanbrg',array()); 
					echo CHtml::activeHiddenField($detail, '[]pesanbarangdetail_id', array('class' => 'id'));
                    //echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null; 
                    echo $modBarang->barang_type;
                    ?>
                </td>
                <td>
                    <?php //echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; 
                        echo $modBarang->barang_kode;
                    ?></td>
                <td><?php //echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; 
                    echo $modBarang->barang_nama;
                ?>                    
                </td>                
                <td><?php //echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; 
                    echo $modBarang->barang_merk;
                ?></td>                
                <td><?php echo $modBarang->barang_ukuran; ?></td>
                <td><?php echo $modBarang->barang_ekonomis_thn; ?></td>
                 <?php //if (isset($modPesan)){ ?>
				<td style="text-align:right;">
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']qty_stok', array('class'=>'span1 stok', 'readonly'=>true, 'style'=>'text-align:right;')).' '.$detail->satuanbrg;
                ?>
                </td>
                <td style="text-align:right;">
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']qty_pesan', array('class'=>'span1 pesan', 'readonly'=>true, 'style'=>'text-align:right;')).' '.$detail->satuanbrg;
                ?>
                </td>
                <?php //} ?>
                <td style="text-align:right;">
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']qty_mutasi', array('class'=>'span1 numbersOnly mutasi', 'onblur'=>'', 'style'=>'text-align:right;')).' '.$detail->satuanbrg;
                    echo '<br>';
                    echo $form->error($detail, '['.$i.']qty_mutasi');
                ?>
                </td>
               <!--<td><?php //echo CHtml::activeDropDownList($detail, '['.$i.']satuanbrg', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>-->
               
                <?php if ($model->isNewRecord){ ?>
                <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
                <?php } ?>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
</table>