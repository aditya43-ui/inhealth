    <table class="table table-condensed table-bordered table-striped" id="tabelRAB">
        <thead>
        <th style="text-align: center; vertical-align: middle">No.</th>        
        <th style="text-align: center; vertical-align: middle">Jenis Barang/Jasa</th>
        <th style="text-align: center; vertical-align: middle">Satuan</th>
        <th style="text-align: center; vertical-align: middle">Volume<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle">Harga (Rp)<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle">Pajak (%)<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle">Jumlah Harga (Rp)<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle">Sisa Pagu (Rp)<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle"> Aksi </th>
        </thead>
        <tbody>
            <?php
            $total = $total_sisapagu = 0;
            $i = 1;
            $det = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $_GET['id']));
            $tr = "";
            foreach ($det as $key => $value) {
                $sisa_pagu_unformat = 0;
                $detJumlah =  $value->rencanaumumpengadaandet_jumlah;
                $value->rencanaumumpengadaandet_jumlah = number_format($detJumlah,2,",",".");
                $value->rencanaumumpengadaandet_harga = number_format($value->rencanaumumpengadaandet_harga,2,",",".");
                $value->rencanaumumpengadaandet_pajak = number_format($value->rencanaumumpengadaandet_pajak,2,",","");                
                $value->rencanaumumpengadaandet_volume = number_format($value->rencanaumumpengadaandet_volume,2,",","");                
                $value->rencanaumumpengadaandet_jmlpajak = number_format($value->rencanaumumpengadaandet_jmlpajak,2,",","");                
                $sisa_pagu_unformat = $value->cariSisaPagu($value->rencanaumumpengadaandet_id, $value->dokumenpelaksanaananggarandet_id);
                $value->sisapagu_pengadaan = MyFormatter::formatNumberForPrint($sisa_pagu_unformat, 2);
                $tr .= $this->renderPartial($this->path_view_ubah."_rowRAB", array('modRAB' => $value, 'i' => $key), true);
                $total += $detJumlah;
                $total_sisapagu += $sisa_pagu_unformat;
            }
            echo $tr;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" style="text-align: right;"><label>Total Harga</label></th>
                <th>
                    <?php echo $form->hiddenField($model,'total_harga',array('readonly'=>true, 'value' => number_format($model->total_harga,2,",","."), 'class'=>'integer-decimal')); ?>
                    <?php echo $form->hiddenField($model,'total_pajak',array('readonly'=>true, 'value' => number_format($model->total_pajak,2,",","."), 'class'=>'integer-decimal')); ?>
                    <?php echo CHtml::hiddenField('jenis_trans',(($model->ispaket)?'paket':'nonpaket'),array('readonly'=>true, 'class'=>'')); ?>
                    <?php
                    echo CHtml::textField('total_hargaseluruhnya', number_format($total,2,",","."), array('readonly' => true, 'class' => 'required integer-decimal harga'));
                    ?>
                </th>
                <th>
                    <?php
                    echo CHtml::textField('total_sisapagu', number_format($total_sisapagu,2,",","."), array('readonly' => true, 'class' => 'required integer-decimal harga'));
                    ?>
                </th>
                <th></th>
            </tr>
        </tfoot>
    </table>
<?php echo CHtml::hiddenField("totItemRAB",count($det)); ?>
<table class="hide" id="tabelHapusRAB">
    <tbody>
        
    </tbody>
</table>