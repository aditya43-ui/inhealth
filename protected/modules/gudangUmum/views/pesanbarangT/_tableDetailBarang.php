<!--Ditambahkan oleh David Yanuar agar sisi table tidak bersinggungan / menempel dengan well-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Barang yang Dipesan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>
        <table class="table table-condensed table-bordered table-striped" id="tableDetailBarang">
            <thead>
                <tr>
                    <!--<th>Golongan</th>
                <th>Bidang</th>
                <th>Kelompok</th>
                <th>Sub Kelompok</th>                
                <th>Sub Sub Kelompok</th>-->
                    <th>Tipe Barang</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Ukuran</th>
                    <th>Tahun Ekonomis</th>
                    <th>Jumlah Pemesanan</th>
                    <!--<th>Satuan</th>-->

                    <!--<th>Ukuran<br>Bahan</th>-->
                    <?php if ($model->isNewRecord) { ?>
                        <th>Batal</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($modDetail)) {
                    foreach ($modDetail as $i => $detail) { ?>
                        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
                        <tr>
                            <td><?php
                                echo CHtml::activeHiddenField($detail, '[' . $i . ']satuanbarang');
                                echo CHtml::activeHiddenField($detail, '[' . $i . ']barang_id');
                                // echo isset($modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama) ? $modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama : ''; 
                                echo isset($modBarang->barang_type) ? $modBarang->barang_type : null;
                                ?>
                            </td>
                            <td><?php echo isset($modBarang->barang_kode) ? $modBarang->barang_kode : null; ?>
                            </td>
                            <td><?php echo isset($modBarang->barang_nama) ? $modBarang->barang_nama : null; ?>
                            </td>
                            <td><?php echo isset($modBarang->barang_merk) ? $modBarang->barang_merk : null; ?><?php //echo isset($modBarang->bidang->bidang_nama) ? $modBarang->bidang->bidang_nama : ''; 
                                                                                                                ?></td>
                            <td><?php echo isset($modBarang->barang_ukuran) ? $modBarang->barang_ukuran : null; ?><br><?php //echo isset($modBarang->barang_bahan)?$modBarang->barang_bahan:''; 
                                                                                                                        ?></td>
                            <td><?php echo isset($modBarang->barang_ekonomis_thn) ? $modBarang->barang_ekonomis_thn : null; ?><br><?php //echo isset($modBarang->barang_bahan)?$modBarang->barang_bahan:''; 
                                                                                                                                    ?></td>
                            <!--<td></td>-->
                            <td>
                                <?php
                                echo CHtml::activeTextField($detail, '[' . $i . ']qty_pesan', array('class' => 'span1 numbersOnly', 'style' => 'text-align:right;')) . ' ' . $detail->satuanbarang;
                                echo '<br>';
                                echo $form->error($detail, '[' . $i . ']qty_pesan');
                                ?>
                            </td>
                            <!--<td><?php //echo CHtml::activeDropDownList($detail, '['.$i.']satuanbarang', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); 
                                    ?></td>-->
                            <?php if ($model->isNewRecord) { ?>
                                <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick' => 'batal(this);', 'style' => 'cursor:pointer;', 'class' => 'cancel')); ?></td>
                            <?php } ?>
                        </tr>
                <?php }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>