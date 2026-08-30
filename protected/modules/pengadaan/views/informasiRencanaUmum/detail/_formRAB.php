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
        $i = 1;
        $det = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id'=>$_GET['id']));
        $tr = "";
            foreach ($det as $key => $value) {
                $value->jumlah = number_format($value->rencanaumumpengadaandet_jumlah,2,",", ".");
                $value->harga = number_format($value->rencanaumumpengadaandet_harga,2,",", ".");
                $value->rencanaumumpengadaandet_volume = number_format($value->rencanaumumpengadaandet_volume,2,",", ".");
                $value->rencanaumumpengadaandet_pajak = number_format($value->rencanaumumpengadaandet_pajak,2,",", ".");
                $tr .= $this->renderPartial("detail/_rowRAB", array('modRAB' => $value, 'i'=>$i++), true);
                $total+= $value->rencanaumumpengadaandet_jumlah;
            }
            echo $tr;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align: right;"><label>Total Harga</label></th>
            <th>
                <?php 
                    echo CHtml::textField('total_hargaseluruhnya', number_format($total, 2, ",","."), array('readonly' => true,'class' => 'required integer-decimal harga')); 
                ?>
            </th>
        </tr>
    </tfoot>
</table>
<?php echo CHtml::hiddenField("tampung_id",'',array('readonly' => true)); ?>