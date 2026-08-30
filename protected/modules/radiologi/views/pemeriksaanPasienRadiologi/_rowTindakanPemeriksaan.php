<tr class="<?php if(!empty($modTindakan->tindakansudahbayar_id)){ echo "sudah_bayar"; } ?>">
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][pemeriksaanrad_nama]"><?php echo (!empty($modTindakan->daftartindakan_id) ? $modTindakan->getPemeriksaanRad()->pemeriksaanrad_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]pemeriksaanrad_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]qty_tindakan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td hidden> 
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'integer col-sm-6')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
    <td style="text-align: center;">
        <?php
        if (!empty($rujuk)) {
            $lab = LabklinikrujukanM::model()->findByPk($rujuk->labklinikrujukan_id);

            if(!empty($lab)){
                echo CHtml::link('<u>'.$lab->labklinikrujukan_nama.'</u>', $this->createUrl('detailRujukan', array('id'=>$rujuk->pemeriksaankeluar_id)), array(
                    'target'=>'frameDetailRujuk', 'onclick'=>'$("#dialogDetailRujuk").dialog("open");',
                    'rel'=>'tooltip', 'title'=>'Klik untuk melihat detail Rujukan Keluar.',
                ));
                echo "<br>";
            }
           
            
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
    <td width="400px">
        <?php 
            if(!empty($modTindakan->pasienmasukpenunjang_id) && !empty($modTindakan->tindakansudahbayar_id)){
                $modPasienunit = PasienkirimkeunitlainT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$modTindakan->pasienmasukpenunjang_id));

                // if(!empty($modPasienunit) && $modPasienunit->isbayarkekasirpenunjang== true){
                    ?>
                    <div style="text-align: center;">
                        <?php 
                            echo CHtml::checkbox('returtindakan_riwayat',false, array('onchange'=>'dialogReturTindakan(this,'.$modTindakan->tindakanpelayanan_id.','.$modTindakan->tindakansudahbayar_id.');'));
                        ?>
                    </div>
                    <div id="returtindakan_transaksi_<?php echo $modTindakan->tindakanpelayanan_id; ?>" style="display: none;">
                        <div class="alert_returtindakan"></div>
                        <?php echo CHtml::hiddenField('tindakanpelayanan_id_retur',$modTindakan->tindakanpelayanan_id); ?>
                        <?php echo CHtml::hiddenField('tindakansudahbayar_id_retur',$modTindakan->tindakansudahbayar_id); ?>
                        <table id="tbl_returtindakan" class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">Pilih</th>
                                    <th style="width: 18%">Komponen Tarif</th>
                                    <th style="width: 15%">Tarif</th>
                                    <th style="width: 15%">Harga Refund</th>
                                    <th style="width: 15%">Tarif Setelah Refund</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="text-align: right; font-weight: bold;">Total</td>
                                    <td><?php echo CHtml::textField('total_tarifretur',0,array('class'=>'span2 integer-decimal','readonly'=>true,'style'=>'text-align: right')); ?></td>
                                    <td><?php echo CHtml::textField('total_retur',0,array('class'=>'span2 integer-decimal','readonly'=>true,'style'=>'text-align: right')); ?></td>
                                    <td><?php echo CHtml::textField('total_setelahretur',0,array('class'=>'span2 integer-decimal','readonly'=>true,'style'=>'text-align: right')); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: right;" id="td_simpanretur">
                                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick'=>'simpanRetur('.$modTindakan->tindakanpelayanan_id.','.$modTindakan->tindakansudahbayar_id.')')); ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php
                // }
            }
        ?>
    </td>
    <td style="text-align: center;"><?php echo (!empty($modTindakan->tindakansudahbayar_id)) ? "-" : CHtml::link('<i class="entypo-cancel-circled"></i>', '#', array(
		'onclick'=>'delItemsAda(this, '.$modTindakan->tindakanpelayanan_id.'); return false;'
	)); ?></td>
</tr>

