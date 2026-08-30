<table id="table-riwayat" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Pemeriksaan</th>
            <th>Dokter Pemeriksa</th>
            <th>Jenis Keperluan</th>
            <th>Cetak</th>
            <th>Detail</th>            
            <th>Ubah</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count((array)$modPemeriksaanjantungRiwayat) > 0 ) { 
          foreach ($modPemeriksaanjantungRiwayat as $data ) {
            $modPegawai = DokterV::model()->findByAttributes(array('pegawai_id'=>$data->dokterpemeriksa_id));
            ?>
        <tr>
            <td><?php echo $format->formatDateTimeForUser($data->tgl_pemeriksaan); ?></td>
            <td><?php echo !empty($modPegawai->namaLengkap)?$modPegawai->namaLengkap:'-'; ?></td>
            <th>
                <?php
                    $row = McuPemeriksaanumumT::model()->findAll("pendaftaran_id = ".$data->pendaftaran_id);
                    foreach($row as $k => $v){
                        echo '- '.$v->jeniskeperluanmcu.'<br/>';
                    }
                    
                ?>
            </th>
            <td style="text-align: center;">
                <a onclick="print('PRINT',<?php echo $data->checkup_jantung_id; ?>);return false;" rel="tooltip" href="javascript:void(0);"><i class="icon-form-print"></i></a>
            </td>
            <td><?php 
                    echo CHtml::link("<i class='".MyIcon::getIcons('lihat')."'></i>",'javascript:;',array('onclick'=>'print("frame",'.$data->checkup_jantung_id.')','rel'=>'tooltip','title'=>'Klik untuk melihat detail'));            
                ?> 
            </td>
            <td><?php echo CHtml::link("<i class='".MyIcon::getIcons('ubah')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/update",array("id"=>$data->checkup_jantung_id)),array('rel'=>'tooltip','title'=>'Klik untuk update data'));            
                                ?></td>

            <td><?php echo CHtml::Link("<span style='font-size:12px'><i class='glyphicon glyphicon-trash'></i></span>", '', array("class" => "",
                                                    "style"=>"Z-index: 9999999",
                                                    "onclick" => "setdelete($data->checkup_jantung_id);",
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk hapus",
                                                )); ?>
            </td>                        
        </tr>
        <?php
        }
        }
        ?>
    </tbody>
    
    
</table>