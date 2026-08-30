
<div class="col-sm-6">
    <div class="block-tabel">
        <h6 style="color:green; "><u><b>Data Penerimaan</b></u></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(			
				array(
					'name'=>'noterima',
					'value'=>'Otomatis'
				),
                array(
					'name'=>'tglterima',
					'value' => $model->tglterima
				),
				array(
					'label'=>'Supplier',
					'value'=>$model->supplier->supplier_nama
				),
            ),
        )); ?>
    </div>    
	
	<?php 
		if ($model->is_langsungfaktur == 1){
			$wrFaktur = 'green'; 
			$label = 'Faktur Pembelian';
		}else{
			$wrFaktur = 'red'; 
			$label = 'Penerimaan Obat Alkes';
		}
	?>
    <?php /*
     * 
     // RSPMC-2133 FAKTUR DI NONAKTIFKAN
	 <div class="block-tabel">
        <h6 style="color:<?php echo $wrFaktur ?>; "><u><b>Data Faktur</b></u></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$modFaktur,
            'attributes'=>array(
				array(
					'name'=>'nofaktur',
					'value'=>$modFaktur->nofaktur
				),
                array(
					'name'=>'tgljatuhtempo',
					'value' => MyFormatter::formatDateTimeForUser($modFaktur->tgljatuhtempo)
				),				
            ),
        )); ?>
    </div>   
     * 
     */ ?> 
</div>
<div class="col-sm-6">
    <div class="block-tabel">
        <h6 style="color:green; "><u><b>Informasi Harga <?php echo $label; ?></b></u></h6>    
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                array(
                        'label'=>'Jumlah Uang Muka',
                        'value'=>((Params::cekHiddenHargaGudangFarmasi()==true)?number_format($model->jumlahuang,2,",","."):"Hidden")
                ),
                array(
                        'label'=>'Total Harga',
                        'value'=>((Params::cekHiddenHargaGudangFarmasi()==true)?number_format($model->harganetto,2,",","."):"Hidden")
                ),
                array(
                        'label'=>'Total Keringanan',
                        'value'=>((Params::cekHiddenHargaGudangFarmasi()==true)?number_format($model->jmldiscount,2,",","."):"Hidden")
                ),
                array(
                        'label'=>'Total PPN',
                        'value'=>((Params::cekHiddenHargaGudangFarmasi()==true)?number_format($model->totalpajakppn,2,",","."):"Hidden")
                ),
                array(
                        'label'=>'Total PPh',
                        'value'=>((Params::cekHiddenHargaGudangFarmasi()==true)?number_format($model->totalpajakpph,2,",","."):"Hidden")
                ),
                array(
                        'label'=>'Total Keseluruhan',
                        'value'=>((Params::cekHiddenHargaGudangFarmasi()==true)?number_format($model->totalharga,2,",","."):"Hidden")
                ),
            ),
        )); ?>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-12">
	<div class="block-tabel">
		<h6 style="color:green; "><u><b>Detail Obat & Alkes</b></u></h6>    
		<table class="table table-bordered table-condensed table-striped ">
			<tr>
				<th>No.</th>				
				<th>Kode</th>
				<th>No. Batch</th>
				<th>Tanggal Kadaluarsa</th>
				<th>Nama Obat & Alkes</th>
				<th>Isi Kemasan Satuan Besar</th>								
				<th>Jml Terima</th>
				<th>Harga Netto</th>
				<th>Keringanan  (%)</th>
                                <th>Keringanan (Rp)</th>
				<th>PPN (%)</th>
                                <th>PPN (Rp)</th>
                                <th>PPh (%)</th>
                                <th>PPh (Rp)</th>
				<th>HPP</th>
				<th>Subtotal</th>				
			</tr>
			<?php
				if (isset($modDet)){
					$i = 1;
					foreach ($modDet as $det){
						echo $this->renderPartial("_rowVerifObat",array('i'=>$i, 'det'=>$det),true);
						$i++;
					}					
				}
			?>
			<tr hidden>
				<td colspan="11" style="text-align: right;"><b>Grand Total<b></td>
				<td  style="text-align: right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($model->totalharga,2,",","."):"Hidden"; ?></td>
			</tr>
		</table>
	</div>
</div>
