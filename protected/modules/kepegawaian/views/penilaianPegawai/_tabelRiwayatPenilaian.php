
<table class="items table table-bordered table-striped table-condensed" id="tblInputAnamnesa">
    <thead>
        <tr>
            <th>Tanggal Penilaian</th>
            <th>Periode Penilaian</th>
            <th>Aspek Penilaian</th>
            <th>Total Nilai</th>
            <th>Rata - Rata</th>
            <th>Penilai</th>
            <!--<th>Total Score Level</th>
			<th>Rata-rata Level</th>
            <th>Performace Index</th>
            <th>Penilai</th>
            <th>Ubah</th>-->
        </tr>
    </thead>
    <?php 
    if($tabelPenilaian !=  null)
    {
        foreach ($tabelPenilaian as $i => $penilaian) { ?>
    <tr>
        <td><?php echo $format->formatDateTimeForUser($penilaian->tglpenilaian); ?></td>
        <td><?php echo $format->formatDateTimeForUser($penilaian->periodepenilaian)."-".$format->formatDateTimeForUser($penilaian->sampaidengan); ?></td>
		<td>
			<?php 
				echo $penilaian->getAspekPenilaian($penilaian->penilaianpegawai_id);
			?>
		</td>
		<td>
			<?php echo $penilaian->jumlahpenilaian; ?>
		</td>
		<td>
			<?php echo $penilaian->nilairatapenilaian; ?>
		</td>
		<td>
			<?php echo $penilaian->penilainama; ?>
		</td>
        <!--<td><?php //echo isset($penilaian->jumlahpenilaian)?$penilaian->jumlahpenilaian:"-"; ?></td>
        <td><?php //echo isset($penilaian->nilairatapenilaian)?$penilaian->nilairatapenilaian:"-"; ?></td>
        <td><?php //echo isset($penilaian->performanceindex)?$penilaian->performanceindex:"-"; ?></td>
        <td><?php //echo isset($penilaian->penilainama)?$penilaian->penilainama:"-"; ?></td>
        <td><p style="margin: 0; text-align: center;">
        <?php
            //echo CHtml::link("<i class='icon-pencil'></i>", 
                    //array('PenilaianPegawai/index', 'id'=>$penilaian->pegawai_id)); 
        ?>
        </p></td>-->
    </tr>
    <?php }
    }else{
        ?>
    
    <?php
    }
    ?>
</table>