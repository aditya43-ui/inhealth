<table class="table table-bordered table-condensed">
    <thead>
        <th>Tindakan</th>
        <th>Free Of Charge (FOC)</th>
        <th>Pemakaian Bahan</th>
        <th>Total Tarif</th>
        <th width="50">&nbsp;</th>
    </thead>
    <tbody>
        <?php foreach ($modTindakans as $i => $modTindakan) { ?>
            <tr>
                <td>
                    <?php echo CHtml::hiddenField("tindakan[$i][tindakanpelayanan_id]", $modTindakan->tindakanpelayanan_id, array('readonly' => true, 'class' => 'inputFormTabel lebar2')); ?>
                    <?php echo $modTindakan->tgl_tindakan; ?> <br>
                    <?php echo $modTindakan->tipePaket->tipepaket_nama; ?> <br>
                    <?php echo 'Kategori ' . (isset($modTindakan->daftartindakan->kategoritindakan->kategoritindakan_nama) ? $modTindakan->daftartindakan->kategoritindakan->kategoritindakan_nama : ""); ?>,

                    <?php echo CHtml::hiddenField("tindakan[$i][daftartindakan_id]", $modTindakan->daftartindakan_id, array('readonly' => true, 'class' => 'inputFormTabel lebar2')); ?>

                    <?php
                    if ($modTindakan->daftartindakan->daftartindakan_nama == 'Perawatan Rawat Inap' and $modTindakan->create_ruangan == Params::RUANGAN_ID_PERINATOLOGI) {
                        echo 'Ruang Perinatologi';
                    } else {
                        echo $modTindakan->daftartindakan->daftartindakan_nama;
                    }
                    ?>,
                    <?php //echo CHtml::textField("tindakan[$i][view_tarif_satuan]", $modTindakan->tarif_satuan,array('readonly'=>true,'class'=>'inputFormTabel integer')); 
                    ?>
                    <?php echo $modTindakan->qty_tindakan; ?>
                    <?php echo $modTindakan->satuantindakan; ?> <br>
                    <?php //echo $modTindakan->persenCyto; 
                    ?>
                    <?php //echo CHtml::dropDownList("tindakan[$i][view_cyto_tindakan]",$modTindakan->cyto_tindakan, array('0'=>'Tidak','1'=>'Ya'), array('disabled'=>true,'class'=>'inputFormTabel lebar2-5')) 
                    ?>
                    <?php //echo $modTindakan->cyto_tindakan; 
                    ?>
                    <?php //echo CHtml::textField("tindakan[$i][view_tarifcyto_tindakan]", $modTindakan->tarifcyto_tindakan,array('readonly'=>true,'class'=>'inputFormTabel integer')); 
                    ?>
                    <?php //echo CHtml::textField("tindakan[$i][view_jumlahTarif]", $modTindakan->JumlahTarif,array('readonly'=>true,'class'=>'inputFormTabel integer')); 
                    ?>

                    Pemeriksa :
                    <?php //echo CHtml::link("<i class='icon-plus-sign'></i>", '#', array('id'=>'btnAddDokter_0','onclick'=>'addDokter(this);return false;')); 
                    ?>
                    <?php echo (isset($modTindakan->dokter1->nama_pegawai) ? $modTindakan->dokter1->nama_pegawai : "");
                    echo (!empty($modTindakan->dokterpemeriksa1_id)) ? ',' : '';
                    ?>
                    <?php echo (isset($modTindakan->dokter2->nama_pegawai) ? $modTindakan->dokter2->nama_pegawai : "");
                    echo (!empty($modTindakan->dokterpemeriksa2_id)) ? ',' : '';
                    ?>
                    <?php echo (isset($modTindakan->dokterPendamping->nama_pegawai) ? $modTindakan->dokterPendamping->nama_pegawai : "");
                    echo (!empty($modTindakan->dokterpendamping_id)) ? ',' : '';
                    ?>
                    <?php echo (isset($modTindakan->dokterAnastesi->nama_pegawai) ? $modTindakan->dokterAnastesi->nama_pegawai : "");
                    echo (!empty($modTindakan->dokteranastesi_id)) ? ',' : '';
                    ?>
                    <?php echo (isset($modTindakan->dokterDelegasi->nama_pegawai) ? $modTindakan->dokterDelegasi->nama_pegawai : "");
                    echo (!empty($modTindakan->dokterdelegasi_id)) ? ',' : '';
                    ?>
                    <?php echo (isset($modTindakan->bidan->nama_pegawai) ? $modTindakan->bidan->nama_pegawai : "");
                    echo (!empty($modTindakan->bidan_id)) ? ',' : '';
                    ?>
                    <?php echo (isset($modTindakan->suster->nama_pegawai) ? $modTindakan->suster->nama_pegawai : "");
                    echo (!empty($modTindakan->suster_id)) ? ',' : '';
                    ?>
                    <?php echo (isset($modTindakan->perawat->nama_pegawai) ? $modTindakan->perawat->nama_pegawai : "");
                    echo (!empty($modTindakan->perawat_id)) ? ',' : '';
                    ?>
                    <?php echo (isset($modTindakan->perawat2->nama_pegawai) ? $modTindakan->perawat2->nama_pegawai : "");
                    echo (!empty($modTindakan->perawat2_id)) ? ',' : '';
                    ?>
                    <?php echo (isset($modTindakan->perawat3->nama_pegawai) ? $modTindakan->perawat3->nama_pegawai : "");
                    echo (!empty($modTindakan->perawat3_id)) ? ',' : '';
                    ?>
                </td>
                <td width="400px">
                    <?php if(!empty($modTindakan->tindakansudahbayar_id)){ echo "<center>Sudah Bayar</center>"; }else{  ?>
                    <div style="text-align: center;">
                        <?php 
                            echo CHtml::checkbox('foc_riwayat',false, array('onchange'=>'dialogFOC(this,'.$modTindakan->tindakanpelayanan_id.');'));
                        ?>
                    </div>
                    <div id="foc_transaksi_<?php echo $modTindakan->tindakanpelayanan_id; ?>" style="display: none;">
                        <div class="alert_pembebasan"></div>
                        <?php echo CHtml::hiddenField('tindakanpelayanan_id_pembebasan',$modTindakan->tindakanpelayanan_id); ?>
                        <table id="tbl_tindakanpembebasan" class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">Pilih</th>
                                    <th style="width: 18%">Komponen Tarif</th>
                                    <th style="width: 15%">Tarif</th>
                                    <th style="width: 15%">Jumlah Pembebasan</th>
                                    <th style="width: 15%">Tarif Setelah Pembebasan</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="text-align: right; font-weight: bold;">Total</td>
                                    <td><?php echo CHtml::textField('total_tarif_pembebasan',0,array('class'=>'span2 integer-decimal','readonly'=>true,'style'=>'text-align: right')); ?></td>
                                    <td><?php echo CHtml::textField('total_pembebasan',0,array('class'=>'span2 integer-decimal','readonly'=>true,'style'=>'text-align: right')); ?></td>
                                    <td><?php echo CHtml::textField('total_setalahpembebasan',0,array('class'=>'span2 integer-decimal','readonly'=>true,'style'=>'text-align: right')); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: right;" id="td_simpanpembebasan">
                                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick'=>'simpanPembebasan('.$modTindakan->tindakanpelayanan_id.')')); ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php } ?>
                </td>
                <td width="400px">
                    <?php if(!empty($modTindakan->tindakansudahbayar_id)){  ?>
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
                                    <th style="width: 15%">Harga Retur</th>
                                    <th style="width: 15%">Tarif Setelah Retur</th>
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
                    <?php } ?>
                </td>
                <td>
                    <?php
                    if (!empty($modViewBmhp)) {
                        $this->renderPartial($this->path_view.'_listObatAlkesPasien', array('modViewBmhp' => $modViewBmhp, 'modTindakan' => $modTindakan));
                    }
                    ?>
                </td>
                <td style="text-align: right">
                    <?php 
                        echo MyFormatter::formatNumberForPrint($modTindakan->tarif_tindakan,2);
                    ?>
                </td>
                <td style="vertical-align:middle;text-align:center">
                    <?php
                    if ($modTindakan->ruangan_id == Yii::app()->user->getState('ruangan_id')) {
                        // echo CHtml::link(
                        //     "<i class='icon-form-silang'></i>",
                        //     '#',
                        //     array(
                        //         'onclick' => 'deleteTindakan(this,' . $modTindakan->tindakanpelayanan_id . ');return false;',
                        //         'rel' => 'tooltip', 'title' => 'Klik untuk menghapus tindakan',
                        //         'data-placement' => 'left'
                        //     )
                        // );
                    }
                    ?>
                </td>
            </tr>

        <?php } ?>
    </tbody>
</table>