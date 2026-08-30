<?php $instalasi = Yii::app()->user->getState('instalasi_id'); ?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][pemeriksaanlab_nama]"><?php echo (!empty($modPermintaan->pemeriksaanlab) ? $modPermintaan->pemeriksaanlab->pemeriksaanlab_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]permintaankepenunjang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tipepaket_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tarif_satuan',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tarif_tindakan',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]qty_tindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
   <td>
    <?= $modPermintaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama ?? '' ?>
   </td>
   <td>
    <?= $modPermintaan->samplelab->samplelab_nama ?? '' ?>
   </td>
</tr>

