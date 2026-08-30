<?php if(count($riwayatResep) > 0) : ?>
    <?php foreach ($riwayatResep as $i => $val) { ?>
        <tr>
            <td><?= $val->reseptur->tglresep_ok ?></td>
            <td><?= $val->reseptur->noresep_ok ?></td>
            <td><?= $val->reseptur->pendaftaran->pasien->nama_pasien ?></td>
            <td><?= $val->reseptur->petugasfarmasi->namaLengkap ?></td>
            <td><?= $val->obatalkes->obatalkes_nama ?></td>
            <td><?= $val->paket_obat ?></td>
            <td><?= $val->jumlah ?></td>
            <td>
                <?php 
                    echo CHtml::link('<i class="icon-form-print"></i>', '', [
                        'onclick' => "printEtiketOK('" . $val->resepturokdet_id . "')"
                    ]); 
                ?>
            </td>
            <td>
                <?php 
                    if($val->validasi) {
                        $html = CHtml::link('<i class="icon-form-ubah"></i>', 'javascript::', [
                            'onclick' => "window.parent.myAlert('Data Tidak Dapat Diubah Karena sudah di Validasi')"
                        ]);
                    } else {
                        $html = CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('ubah', ['resepturokdet_id' => $val->resepturokdet_id]), [
                            'target' => 'iframeUbah',
                            'onclick' => "$('#dialogUbah').dialog('open')"
                        ]);
                    }
    
                    echo $html;
                ?>
            </td>
            <!-- hapus -->
            <td>
                <?php 
                    
                    $html = "<center>" . CHtml::link("<i class='icon-trash'></i>",'javascript::', array('rel' => 'tooltip', 'title' => 'Klik untuk menghapus Reseptur', 'onclick' => 'hapusresep('.$val->resepturokdet_id.')' )) . "</center>";
                    
                    echo $html;
                ?>
            </td>
            <td>
                <?php 
                var_dump($val->validasi);
                    if($val->validasi) {
                        echo "<center>" . CHtml::link('<i class="fas fa-check-square" style="color:green !important"></i>','javascript::', array('rel' => 'tooltip', 'title' => 'Klik untuk validasi Reseptur', 'onclick' => 'validasiSingle('.$val->resepturokdet_id.', this)' )) . "</center>"; 
                        
                    } else {
                        echo "<center>" . CHtml::link('<i class="fas fa-check-square" style="color:red"></i>','javascript::', array('rel' => 'tooltip', 'title' => 'Klik untuk validasi Reseptur', 'onclick' => 'validasiSingle('.$val->resepturokdet_id.', this)' )) . "</center>"; 
                    }
                ?>
            </td>
            <td><?= $val->keterangan ?></td>
        </tr>
    <?php } ?>
<?php endif; ?>