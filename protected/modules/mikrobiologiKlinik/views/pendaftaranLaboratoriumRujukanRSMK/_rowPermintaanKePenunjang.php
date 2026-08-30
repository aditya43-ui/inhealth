<tr <?php echo ($modPermintaan->tarif_tindakan > 0) ? "Hidden" : "" ?>>
    <td>
        <?php if ($modPermintaan->tarif_tindakan == 0) {
            echo CHtml::textField('no_urut_penunjang',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); 
        }?>
    </td>
    <td hidden>
        <?php
            if($modPermintaan->pasienkirimkeunitlain->is_nonprogram) {
                echo 'NON PROGRAM';
            } else if($modPermintaan->pasienkirimkeunitlain->is_programtbc) {
                echo "TBC";
            } else if($modPermintaan->pasienkirimkeunitlain->is_programhiv) {
                echo "HIV";
            } else {
                echo "-";
            }
        ?>
    </td>
    <td hidden><?php echo $modPermintaan->subjenis_pemeriksaanlab_nama ?? "-"; ?></td>
    <td><?php echo $modPermintaan->jenispemeriksaanlab_nama ?? "-"; ?></td>
    <td>
        <span name="[ii][pemeriksaanlab_nama]"><?php echo (!empty($modPermintaan->daftartindakan_id) ? $modPermintaan->pemeriksaanlab->pemeriksaanlab_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]permintaankepenunjang_id',array('readonly'=>true,'class'=>'span1 permintaan_permintaankepenunjang_id')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1 permintaan_pemeriksaanlab_id')); ?>
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
    <td><?php
    echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]samplelab_id', array(
        'class'=>'permintaan_samplelab_id'
    ));
    $sample = SamplelabM::model()->findByPk($modPermintaan->samplelab_id);
    echo $sample->samplelab_nama ?? "-";

    ?></td>
    <td><?php
    echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]caraambilsampel_id', array(
        'class'=>'permintaan_caraambilsampel_id'
    ));
    $caraSampel = CaraambilsampelM::model()->findByPk($modPermintaan->caraambilsampel_id);
    echo $caraSampel->caraambilsampel_nama ?? "-";

    ?></td>
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
        <?php echo CHtml::hiddenField('is_ditambahkan',false,array('readonly'=>true,'class'=>'span1 integer nourut is_ditambahkan', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
            'class'=>'btn btn-success btn_permintaan_tambah',
            // 'disabled'=>true,
            'onclick'=>'tambahPeriksaPermintaan(this);',
        )); ?>
    </td>
</tr>

