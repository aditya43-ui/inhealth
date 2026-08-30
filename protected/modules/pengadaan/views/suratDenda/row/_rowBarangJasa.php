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
            echo CHtml::activeHiddenField($model, '['.$i.']harga_satuan',array('class'=>'harga_satuan integer-decimal'));
            echo CHtml::activeHiddenField($model, '['.$i.']jumlah_pajak',array('class'=>'jumlah_pajak integer-decimal'));
            echo CHtml::activeHiddenField($model, '['.$i.']jumlah_harga',array('class'=>'jumlah_harga integer-decimal'));
            echo CHtml::activeHiddenField($model, '['.$i.']pajak_persen',array('class'=>'pajak_persen float2'));
            echo CHtml::activeHiddenField($model, '['.$i.']total_harga',array('class'=>'total_harga integer-decimal'));
            echo CHtml::activeHiddenField($model, '['.$i.']keterlambatan',array('class'=>'keterlambatan'));
        
            echo $this->widget('MyDateTimePicker', array(
                'model'=>$model, 
                'attribute'=>'['.$i.']tanggal_pengiriman',                                
                'mode' => 'date',                                 
                'htmlOptions' => array(                                       
                    'style'=>'width:100px',
                    'readonly'=>true,
                    'class'=>'tanggal_pengiriman'
                ),
                'options' => array(  // (#3)                    
                    'dateFormat' => Params::DATE_FORMATV2,                    
                    'maxDate' => 'd',
                    'onSelect'=>'js:function(){setKeterlambatan(this);}',
                ),       
                
            ), 
            true);
        ?>
    </td>
    <td style="text-align: right;"><label class="lbl_keterlambatan"><?php echo !empty($model->keterlambatan)?$model->keterlambatan.' hari':null; ?></label></td>
    <td style="text-align: center;">
        <?php                
            echo CHtml::link('<span style="font-size:20px;color:red;"><i class="glyphicon glyphicon-minus"></i></span>', "javascript:;", array('class'=>'btnhapus','onclick'=>'hapusBaris(this); return false;', 'rel'=>'tooltip', 'data-original-title'=>'Klik untuk menghapus data ini', 'data-placement'=>'left'));        
            //echo "&nbsp;&nbsp;&nbsp;";
            //echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', "javascript:;", array('class'=>'btntambah ','onclick'=>'tambahBaris(this); return false;'));                
        ?>
    </td>
</tr>