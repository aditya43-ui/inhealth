<table id="table-riwayat" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Pemeriksaan</th>
            <th>Pemeriksa</th>
            <th>Detail</th>
            <th>Ubah</th>
            <th>Hapus</th>

        </tr>
    </thead>
    <tbody>
        <?php if(count((array)$modHearingTestRiwayat) > 0 ) { 
          foreach ($modHearingTestRiwayat as $data ) {
        ?>
        <tr>
            <td><?php echo $format->formatDateTimeForUser($data->tglhearingtest); ?></td>
            <td><?php echo $data->namapemeriksa_hearingtest; ?></td>
            <td>
                <?php 
                    echo CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("id"=>$data->hearingtest_id)),array('rel'=>'tooltip','title'=>'Klik untuk melihat detail')); 
                ?> 
            </td>
            <td><?php echo CHtml::link("<i class='".MyIcon::getIcons('ubah')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/update",array("id"=>$data->hearingtest_id)),array('rel'=>'tooltip','title'=>'Klik untuk update data'));            
                                ?></td>
            <td>
                <?php 
                    echo CHtml::Link("<span style='font-size:12px'><i class='glyphicon glyphicon-trash'></i></span>", '', array("class" => "",
                        "style"=>"Z-index: 9999999",
                        "onclick" => "setdelete($data->hearingtest_id);",
                        "rel" => "tooltip",
                        "title" => "Klik untuk hapus",
                    )); 
                ?>
            </td>
        </tr>
        <?php
            }
        }
        ?>
    </tbody>
    
    
</table>
