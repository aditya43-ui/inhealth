<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>                  
            <th>No</th>
            <th>No. Kantong Darah</th>
            <th>Jenis Komponen Darah</th>
            <th>Jenis Kantong</th>
            <th>Golongan Darah</th>
            <th>Rhesus</th>
        </tr>
    </thead>
    <tbody>
        <?php
          $format = new MyFormatter();
            $no = 1;
            $i = 0;
            $tr ='';
            if(count($modDistribusiDetail) > 0) {
                foreach($modDistribusiDetail as $data) {
                    $modDetail = new DistribusidarahdetT();
                    $modDetail->distribusidarahdet_id = $data->distribusidarahdet_id;
                    $komponenDarah = KomponendarahM::model()->findByPk($data->komponendarah_id);
                    $jenisKantong = JeniskantongdarahM::model()->findByPk($data->jeniskantongdarah_id);
                    ?>
                    <tr>
                        <td><?php echo !empty($no)?$no:"-"; ?> </td>
                        <td><?php echo CHtml::activeHiddenField($modDetail,"[$i]distribusidarahdet_id"); ?>
                            <?php echo !empty($data->nomorbarcode)?$data->nomorbarcode:"-"?>
                        </td>
                        <td><?php echo !empty($komponenDarah->singkatan_komp)?$komponenDarah->singkatan_komp:"-" ?> </td>
                        <td><?php echo !empty($jenisKantong->nama_jenis)?$jenisKantong->nama_jenis:"-"?> </td>
                        <td><?php echo !empty($data->golongan_darah)?$data->golongan_darah:"-" ?> </td>
                        <td><?php echo !empty($data->rhesus)?$data->rhesus:"-"?> </td>
                        
                    </tr>
                    <?php
                    $no++;
                    $i++;
                }
            }
        ?>
    </tbody>
</table>