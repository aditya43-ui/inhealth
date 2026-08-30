<tr>
    <td><label class="nourut"><?php echo $i+1; ?></label></td>
    <td><label class="lbl_nama_barang"><?php echo $model->nama_barang; ?></label></td>
    <td><label class="lbl_satuan_barang"><?php echo $model->satuan_barang; ?></label></td>
    <td style="text-align:right;"><label class="lbl_jumlah_barang"><?php echo $model->jumlah_barang; ?></label></td>
    <td style="text-align:right;"><label class="lbl_harga_satuan"><?php echo number_format((float)$model->harga_satuan,2,",","."); ?></label></td>
    <td style="text-align:right;"><label class="lbl_jumlah_harga"><?php echo number_format((float)$model->jumlah_harga,2,",","."); ?></label></td>    
    <td>
        <?php
            echo CHtml::activeHiddenField($model, '['.$i.']suratdendadet_id',array('class'=>'suratdendadet_id'));
            echo CHtml::activeHiddenField($model, '['.$i.']jenis_barang',array('class'=>'jenis_barang'));
            echo CHtml::activeHiddenField($model, '['.$i.']nama_barang',array('class'=>'nama_barang'));
            echo CHtml::activeHiddenField($model, '['.$i.']satuan_barang',array('class'=>'satuan_barang'));
            echo CHtml::activeHiddenField($model, '['.$i.']jumlah_barang',array('class'=>'jumlah_barang'));
            echo CHtml::activeHiddenField($model, '['.$i.']harga_satuan',array('class'=>'harga_satuan'));
            echo CHtml::activeHiddenField($model, '['.$i.']jumlah_pajak',array('class'=>' integer-decimal jumlah_pajak'));
            echo CHtml::activeHiddenField($model, '['.$i.']jumlah_harga',array('class'=>' integer-decimal jumlah_harga'));
            echo CHtml::activeHiddenField($model, '['.$i.']pajak_persen',array('class'=>'flaot2 pajak_persen'));
            echo CHtml::activeHiddenField($model, '['.$i.']total_harga',array('class'=>' integer-decimal total_harga'));
            echo CHtml::activeHiddenField($model, '['.$i.']keterlambatan',array('class'=>'keterlambatan'));
            echo CHtml::activeHiddenField($model, '['.$i.']tanggal_pengiriman',array('class'=>'tanggal_pengiriman'));
            
        ?>
        <label class="lbl_tanggal_pengiriman"><?php echo $model->tanggal_pengiriman; ?></label>
    </td>
    <td style="text-align: right;"><label class="lbl_keterlambatan"><?php echo !empty($model->keterlambatan)?$model->keterlambatan.' hari':null; ?></label></td>
</tr>