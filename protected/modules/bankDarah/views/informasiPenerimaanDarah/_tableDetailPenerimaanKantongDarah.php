<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>                  
            <th>No.</th>
            <th class="hide">No.Identitas Pendonor</th>
            <th class="hide">No. Formulir</th>
            <th>No. Kantong Utama / No. Sample</th>
            <th class="hide">No. Sampel Konfirmasi Gol. Darah </th>
            <th class="hide">No. Sampel Skrining IMLTD</th>
            <th>Golongan Darah</th>
            <th>Rhesus</th>
            <th>Jenis Kantong</th>
            <th class="hide">No.Komponen Darah</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i=1;
            foreach($modDetail as $det ){
                
        ?>
        <tr>
            <td><?php echo $i?></td>
            <td class="hide"><?php echo $det->no_identitas ?></td>
            <td class="hide"><?php echo $det->no_formulir ?></td>
            <td><?php echo $det->nomorbarcode_utama ?></td>
            <td class="hide"><?php echo $det->nomorbarcode_sample ?></td>
            <td class="hide"><?php echo $det->nomorbarcode_sample_imltd ?></td>
            <td><?php echo $det->gol_darah ?></td>
            <td><?php echo $det->rhesus ?></td>
            <td><?php echo $det->nama_jenis ?></td>
            <td class="hide"><?php 
            if(!empty($det->terimakantongdarah_id) && !empty($det->daftardonasi_id)){
               $komponen=InfokantongdarahV::model()->findAllByAttributes(array('terimakantongdarah_id'=>$det->terimakantongdarah_id,'daftardonasi_id'=>$det->daftardonasi_id));
               echo "<ul>";
               foreach($komponen as $row){
                   echo "<li>".$row->nomorbarcode."</li>";
               }
               echo "</ul>";
            }else{
                echo "";
            }       
            ?></td> 
        </tr>        
        <?php
        $i++;
            }
        ?>
    </tbody>
</table>