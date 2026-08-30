<table class="table table-condensed table-bordered table-striped" id="tabel-hps">
    <thead>
        <th>No.</th>        
        <th>Jenis Barang/Jasa</th>
        <th>Satuan</th>
        <th>Volume<span class="required">*</span></th>
        <th>Harga (Rp)<span class="required">*</span></th>
        <th>Pajak (%)<span class="required">*</span></th>
        <th>Jumlah Harga (Rp)<span class="required">*</span></th>
    </thead>
    <tbody>
        <?php
            $total = 0;
            if (!empty($modDetail)){
                $i=0;
                foreach($modDetail as $detail){                  
        ?>
        <tr data-row="0">
            <td><?php echo $i+1;?></td>
            <td><?php echo $detail->persiapanpengadaandet_nama;?></td>
            <td><?php echo $detail->persiapanpengadaandet_satuan;?></td>
            <td style="text-align:right;"><?php echo $detail->persiapanpengadaandet_volume;?></td>
            <td style="text-align:right;"><?php echo "Rp ".number_format($detail->harga_estimasi,2,',','.');?></td>
            <td style="text-align:right;"><?php echo $detail->pajak_persen;?></td>
            <td style="text-align:right;"><?php echo "Rp ".number_format($detail->jumlah_harga,2,',','.');?></td>
        </tr>
        <?php
                $total = $total + $detail->jumlah_harga;
                $i++;
                }
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align: right;"><label>Total Harga</label></th>
            <th style="text-align:right;"><?php echo "Rp ".number_format($total,2,',','.');?></th>
        </tr>
    </tfoot>
</table>
<?php echo CHtml::hiddenField("tampung_id",'',array('readonly' => true)); ?>