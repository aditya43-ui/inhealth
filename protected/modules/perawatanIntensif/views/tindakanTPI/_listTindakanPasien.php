<table class="table table-bordered table-condensed">
    <thead>
        <th>Tindakan</th>
        <th>Pemakaian Bahan</th>
        <th width="50">&nbsp;</th>
    </thead>
    <tbody>
<?php foreach ($modTindakans as $i => $modTindakan) { ?>
    <tr>
        <td>
            <?php echo CHtml::hiddenField("tindakan[$i][tindakanpelayanan_id]", $modTindakan->tindakanpelayanan_id,array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
            <?php echo $modTindakan->tgl_tindakan; ?> <br>
            <?php echo $modTindakan->tipePaket->tipepaket_nama; ?> <br>
            <?php echo 'Kategori '.(isset($modTindakan->daftartindakan->kategoritindakan->kategoritindakan_nama) ? $modTindakan->daftartindakan->kategoritindakan->kategoritindakan_nama : ""); ?>,

            <?php echo CHtml::hiddenField("tindakan[$i][daftartindakan_id]", $modTindakan->daftartindakan_id,array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
          
            <?php 
              if ( $modTindakan->daftartindakan->daftartindakan_nama=='Perawatan Rawat Intensif' and $modTindakan->create_ruangan==Params::RUANGAN_ID_PERINATOLOGI){
                  echo 'Ruang Perinatologi';
              }else{
                  echo $modTindakan->daftartindakan->daftartindakan_nama;
              }
             ?>,
            <?php //echo CHtml::textField("tindakan[$i][view_tarif_satuan]", $modTindakan->tarif_satuan,array('readonly'=>true,'class'=>'inputFormTabel integer')); ?>
            <?php echo $modTindakan->qty_tindakan; ?>
            <?php echo $modTindakan->satuantindakan; ?> <br>
            <?php //echo $modTindakan->persenCyto; ?>
            <?php //echo CHtml::dropDownList("tindakan[$i][view_cyto_tindakan]",$modTindakan->cyto_tindakan, array('0'=>'Tidak','1'=>'Ya'), array('disabled'=>true,'class'=>'inputFormTabel lebar2-5')) ?>
            <?php //echo $modTindakan->cyto_tindakan; ?>
            <?php //echo CHtml::textField("tindakan[$i][view_tarifcyto_tindakan]", $modTindakan->tarifcyto_tindakan,array('readonly'=>true,'class'=>'inputFormTabel integer')); ?>
            <?php //echo CHtml::textField("tindakan[$i][view_jumlahTarif]", $modTindakan->JumlahTarif,array('readonly'=>true,'class'=>'inputFormTabel integer')); ?>

            Pelaksana : 
            <?php //echo CHtml::link("<i class='icon-plus-sign'></i>", '#', array('id'=>'btnAddDokter_0','onclick'=>'addDokter(this);return false;')); ?>
            <?php echo (isset($modTindakan->dokter1->nama_pegawai) ? $modTindakan->dokter1->nama_pegawai : ""); echo (!empty($modTindakan->dokterpemeriksa1_id)) ? ',' : ''; ?>
            <?php echo (isset($modTindakan->dokter2->nama_pegawai) ? $modTindakan->dokter2->nama_pegawai : ""); echo (!empty($modTindakan->dokterpemeriksa2_id)) ? ',' : ''; ?>
            <?php echo (isset($modTindakan->dokterPendamping->nama_pegawai) ? $modTindakan->dokterPendamping->nama_pegawai : ""); echo (!empty($modTindakan->dokterpendamping_id)) ? ',' : ''; ?>
            <?php echo (isset($modTindakan->dokterAnastesi->nama_pegawai) ? $modTindakan->dokterAnastesi->nama_pegawai : ""); echo (!empty($modTindakan->dokteranastesi_id)) ? ',' : ''; ?>
            <?php echo (isset($modTindakan->dokterDelegasi->nama_pegawai) ? $modTindakan->dokterDelegasi->nama_pegawai : ""); echo (!empty($modTindakan->dokterdelegasi_id)) ? ',' : ''; ?>
            <?php echo (isset($modTindakan->bidan->nama_pegawai) ? $modTindakan->bidan->nama_pegawai : ""); echo (!empty($modTindakan->bidan_id)) ? ',' : ''; ?>
            <?php echo (isset($modTindakan->suster->nama_pegawai) ? $modTindakan->suster->nama_pegawai : ""); echo (!empty($modTindakan->suster_id)) ? ',' : ''; ?>
            <?php echo (isset($modTindakan->perawat->nama_pegawai) ? $modTindakan->perawat->nama_pegawai : ""); echo (!empty($modTindakan->perawat_id)) ? ',' : ''; ?>
            <?php echo (isset($modTindakan->perawat2->nama_pegawai) ? $modTindakan->perawat2->nama_pegawai : ""); echo (!empty($modTindakan->perawat2_id)) ? ',' : ''; ?>
        </td>
        <td>
            <?php 
                if(!empty($modViewBmhp))
                {
                    $this->renderPartial('_listObatAlkesPasien',array('modViewBmhp'=>$modViewBmhp,'modTindakan'=>$modTindakan));
                }
            ?>
        </td>
        <td style="vertical-align:middle;text-align:center">
            <?php
//                if($modTindakan->ruangan_id == Yii::app()->user->getState('ruangan_id')) //komen karena jika dengan nursestation tidak dapat batal RSSP-384
//                {
                    echo CHtml::link("<i class='icon-form-silang'></i>", '#', 
                        array(
                            'onclick'=>'deleteTindakan(this,'.$modTindakan->tindakanpelayanan_id.');return false;',
                            'rel'=>'tooltip','title'=>'Klik untuk menghapus tindakan'
                        )
                    );                    
//                }
            ?>
        </td>
    </tr>

<?php } ?>
    </tbody>
</table>

