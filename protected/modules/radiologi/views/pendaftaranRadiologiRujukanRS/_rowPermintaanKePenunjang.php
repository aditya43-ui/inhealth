<tr <?php echo ($modPermintaan->tarif_tindakan > 0) ? "Hidden" : "" ?>>
    <td>
        <?php if ($modPermintaan->tarif_tindakan == 0) {
            echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); 
        }?>
    </td>
    <td>
        <span name="[ii][pemeriksaanrad_nama]"><?php echo (!empty($modPermintaan->daftartindakan_id) ? $modPermintaan->pemeriksaanrad->pemeriksaanrad_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]permintaankepenunjang_id',array('readonly'=>true,'class'=>'span1 permintaan_permintaankepenunjang_id')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]pemeriksaanrad_id',array('readonly'=>true,'class'=>'span1 permintaan_pemeriksaanrad_id')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1 permintaan_daftartindakan_id')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tipepaket_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]jenistarif_id',array('readonly'=>true,'class'=>'span1 permintaan_jenistarif_id')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tarif_satuan',array('readonly'=>true,'class'=>'span1 permintaan_tarif_satuan')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tarif_tindakan',array('readonly'=>true,'class'=>'span1 permintaan_tarif_tindakan')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]qty_tindakan',array('readonly'=>true,'class'=>'span1 permintaan_qty_tindakan')); ?>
    </td>
    <td><?php echo $modPermintaan->daftartindakan->daftartindakan_kode ?? "-"; ?></td>
    <td class="row_permintaan_tarif">
        <?php echo MyFormatter::formatNumberForUser($modPermintaan->tarif_tindakan) ?>
    </td>
    <td>
        <?php 
        if ($modPermintaan->tarif_tindakan == 0) {
            echo CHtml::activeDropDownList($modPermintaan, '['.$i.'][ii]kelaspelayanan_id', CHtml::listData(
                KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true and kelaspelayanan_id <> 6 order by kelaspelayanan_nama asc'),
                'kelaspelayanan_id', 'kelaspelayanan_nama'
            ), array(
                'empty'=>'-- Pilih --', 'class'=>'span2 permintaan_kelaspelayanan_id', 'onchange'=>'cekHargaKelasPelayanan(this)',
            ));
        } else {
            $kelas = KelaspelayananM::model()->findByPk($modPermintaan->kelaspelayanan_id);
            echo $kelas->kelaspelayanan_nama ?? "-";
            echo CHtml::activeHiddenField($modPermintaan, '['.$i.'][ii]kelaspelayanan_id', array(
                'class'=>'span2',
            ));
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
    <td>
        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
            'class'=>'btn btn-success btn_permintaan_tambah',
            'disabled'=>true,
            'onclick'=>'tambahPeriksaPermintaan(this);',
        )); ?>
    </td>
</tr>

