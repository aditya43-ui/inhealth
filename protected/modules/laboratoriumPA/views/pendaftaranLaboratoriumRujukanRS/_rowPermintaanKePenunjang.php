<?php
    $modTindakan = LBTindakanPelayananT::model()->findByPk($modPermintaan->tindakanpelayanan_id);
    $kirim = PasienkirimkeunitlainT::model()->findByPk($modPermintaan->pasienkirimkeunitlain_id);
   
    if(empty($modTindakan)){
        
        $pemeriksaan = LBTarifpemeriksaanlabruanganV::model()->findByAttributes(array(
            'daftartindakan_id'=> $modPermintaan->daftartindakan_id,
            'ruangan_id' => $kirim->ruangan_id,
            'penjamin_id' => $penjamin_id,
            'kelaspelayanan_id' => $kirim->kelaspelayanan_id,
        ));
        
        $modTindakan = new LBTindakanPelayananT();
        if (!empty($pemeriksaan)) {
            $modTindakan->daftartindakan_id = $pemeriksaan->daftartindakan_id;
            $modTindakan->pemeriksaanlab_id = $pemeriksaan->pemeriksaanlab_id;
            $modTindakan->jenistarif_id = $pemeriksaan->jenistarif_id;
            $modTindakan->qty_tindakan = $modPermintaan->qtypermintaan;
            $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
            $modTindakan->tarif_satuan = $pemeriksaan->harga_tariftindakan;
            $modTindakan->tarif_tindakan = $pemeriksaan->harga_tariftindakan * $modTindakan->qty_tindakan;
        }
        
    }
?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:30px;')); ?>
    </td>
    <td>
        <span name="[ii][pemeriksaanlab_nama]"><?php echo (!empty($modPermintaan->daftartindakan_id) ? $modPermintaan->pemeriksaanlab->pemeriksaanlab_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]permintaankepenunjang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1 permintaan-penunjang_id')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]qty_tindakan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]satuantindakan',array('readonly'=>true,'class'=>'span2')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tarif_satuan',array('readonly'=>true,'class'=>'span2 integer')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modPermintaan,'['.$i.'][ii]qtypermintaan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php 
            //$satuan = LBTindakanPelayananT::model()->findByPk($modPermintaan->tindakanpelayanan_id);
            if(!empty($modPermintaan->tindakanpelayanan_id)){
                $satuantindakan = $modPermintaan->tindakanpelayanan->satuantindakan;
                echo $satuantindakan;
            }else{
                echo '<input type="text" name="satuantindakan" value="KALI" disabled="true" readonly class="span2">';
            }
            ?>
    </td>
	<td class="status_bayar">
		<?php
		if(!empty($modPermintaan->tindakanpelayanan_id)){
			if(!empty($modPermintaan->tindakanpelayanan->tindakansudahbayar_id)){
				echo "LUNAS";
			}else{
				echo "BELUM LUNAS";
			}
		}else{
			echo "BELUM DITAGIHKAN";
		}
		?>
	</td>
    <td>-</td>
</tr>

