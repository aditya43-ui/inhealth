<tr>
    <td style="text-align: right;"><?php echo $no; ?></td>
    <td><?php echo $detail->nomorbarcode; ?></td>
    <td><?php 
        $jenis = KomponendarahM::model()->findByPk($detail->komponendarah_id);
        echo $jenis->singkatan_komp;
    
    ?></td>
    <td><?php
            $kantong = JeniskantongdarahM::model()->findByPk($detail->jeniskantongdarah_id);
            echo $kantong->nama_jenis;
    ?></td>
    <td><?php echo $detail->golongan_darah; ?></td>
    <td><?php echo $detail->rhesus; ?></td>
    <td></td>
</tr>
