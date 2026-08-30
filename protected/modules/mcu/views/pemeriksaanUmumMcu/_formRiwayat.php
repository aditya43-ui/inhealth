<table id="table-riwayat" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Pemeriksaan</th>
            <th>Dokter Pemeriksa</th>
            <th>Jenis Keperluan</th>          
            <th>Print</th>
            <th>Lihat Detail</th>            
            <th>Ubah</th>
            <th>Hapus</th>

        </tr>
    </thead>
    <br>
    <tbody>
        <?php if(count((array)$modpemeriksaanumumRiwayat) > 0 ) { 
          foreach ($modpemeriksaanumumRiwayat as $data ) {
            $modPegawai = DokterV::model()->findByAttributes(array('pegawai_id'=>$data->dokterpemeriksa_id));
            $modMcu = KesimpulanmcuT::model()->findAllByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
            ?>
        <tr>
            <td><?php echo $format->formatDateTimeForUser($data->tgl_pemeriksaan); ?></td>
            <td><?php echo $modPegawai->namaLengkap; ?></td>
            <td><?php echo $modpemeriksaanumum->jeniskeperluanmcu ?? '-' ; ?></td>                        
            <td style="text-align: center;">
                <a onclick="print('PRINT',<?php echo $data->mcu_pemeriksaanumum_id; ?>);return false;" rel="tooltip" href="javascript:void(0);"><i class="icon-form-print"></i></a>
            </td>
            <td><?php 
                    echo CHtml::link("<i class='".MyIcon::getIcons('lihat')."'></i>",'javascript:void(0);',array('onclick'=>'printing("frame",'.$data->mcu_pemeriksaanumum_id.')','rel'=>'tooltip','title'=>'Klik untuk melihat detail'));            
                ?> 
            </td>
            <td><?php echo CHtml::link("<i class='".MyIcon::getIcons('ubah')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/update",array("id"=>$data->mcu_pemeriksaanumum_id)),array('rel'=>'tooltip','title'=>'Klik untuk update data'));            
                                ?></td>

            <td><?php echo CHtml::Link("<span style='font-size:12px'><i class='glyphicon glyphicon-trash'></i></span>", '', array("class" => "",
                                                    "style"=>"Z-index: 9999999",
                                                    "onclick" => "setdelete($data->mcu_pemeriksaanumum_id);",
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk hapus",
                                                )); ?></td>
        </tr>
        <?php
        }
        }
        ?>
    </tbody>
    
    
</table>
