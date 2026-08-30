<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:30px;')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <span name="[ii][pemeriksaanlab_nama]"><?php echo (!empty($modTindakan->daftartindakan_id) ? $modTindakan->getPemeriksaanLab()->pemeriksaanlab_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]qty_tindakan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]satuantindakan',array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?> <?php echo Params::HIDDEN_HARGA ?>>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_satuan',array('readonly'=>true,'class'=>'span2 integer')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?> <?php echo Params::HIDDEN_HARGA ?>>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
    <td style="text-align: center;">
        <?php
        if (!empty($rujuk)) {
            $lab = LabklinikrujukanM::model()->findByPk($rujuk->labklinikrujukan_id);
            echo CHtml::link('<u>'.$lab->labklinikrujukan_nama.'</u>', $this->createUrl('detailRujukan', array('id'=>$rujuk->pemeriksaankeluar_id)), array(
                'target'=>'frameDetailRujuk', 'onclick'=>'$("#dialogDetailRujuk").dialog("open");',
                'rel'=>'tooltip', 'title'=>'Klik untuk melihat detail Rujukan Keluar.',
            ));
            echo "<br/>";
            echo CHtml::link('<i class="entypo-cancel-circled"></i>', '#', array(
                'onclick'=>'batalRujukKeluar('.$rujuk->pemeriksaankeluar_id.');',
                'rel'=>'tooltip', 'title'=>'Klik untuk membatalkan Rujukan Keluar.',
            ));
            
        } else {
            echo CHtml::link('<i class="entypo-logout"></i>', '#', array(
                'onclick'=>'setRujukan('.$modTindakan->tindakanpelayanan_id.'); return false;',
                'rel'=>'tooltip', 'title'=>'Klik untuk melakukan Rujukan Keluar.'
            ));
        }
        
        ?>
    </td>
    <td></td>
</tr>

