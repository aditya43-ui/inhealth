<?php
/**
* digunakan sebagai Laporan Skrining IMLTD
* @author Elham Budianto <elhambudianto1@gmail.com>
**/
?>
<?php
    if($data != null){
        $no_urut =1;
        foreach($data as $i=> $d){
        
?>
<tr>   
    <td><?php echo $no_urut;?></td>
    <td><?php echo MyFormatter::formatMonthForUser($i);?></td>
    <td><?php echo $d['jumlah_sampel'];?></td>
    <td><?php echo $d['hbsag'];?></td>
    <td>
        <?php echo round(($d['hbsag']*100)/$d['jumlah_sampel'],1).'%';
        ?>
    </td>
    <td><?php echo $d['hvc'];?></td>
    <td>
        <?php echo round(($d['hvc']*100)/$d['jumlah_sampel'],1).'%';
        ?>
    </td>
    <td><?php echo $d['hiv'];?></td>
    <td>
        <?php echo round(($d['hiv']*100)/$d['jumlah_sampel'],1).'%';
        ?>
    </td>
    <td><?php echo $d['sifilis'];?></td>
    <td>
        <?php echo round(($d['sifilis']*100)/$d['jumlah_sampel'],1).'%';
        ?>
    </td>
    <td><?php echo $d['reaktif'];?></td>
    <td>
        <?php echo round(($d['reaktif']*100)/$d['jumlah_sampel'],1).'%';
        ?>
    </td>
    <td><?php echo $d['kantong'];?></td>
    <td>
        <?php echo round(($d['kantong']*100)/$d['jumlah_sampel'],1).'%';
        ?>
    </td>
</tr>        
<?php
        $no_urut++;
        }
    }
?>
<?php
    if($data != null){
        $jumlahsampel = 0;
        $jumlahhbsag = 0;
        $jumlahantihiv = 0;
        $jumlahantihvc = 0;
        $jumlahsifilis = 0;
        $jumlahreaktif = 0;
        $jumlahkantong = 0;
        $persenhbsag = 0;
        $persenantihiv = 0;
        $persenantihvc = 0;
        $persensifilis = 0;
        $persenkantong = 0;
        $persenreaktif = 0;
        foreach($data as $i=> $d){
            $jumlahsampel = $jumlahsampel + $d['jumlah_sampel'];
            $jumlahhbsag = $jumlahantihiv + $d['hbsag'];
            $jumlahantihiv = $jumlahantihiv + $d['hiv'];
            $jumlahantihvc = $jumlahantihvc + $d['hvc'];
            $jumlahsifilis = $jumlahsifilis + $d['sifilis'];
            $jumlahreaktif = $jumlahreaktif + $d['reaktif'];
            $jumlahkantong = $jumlahkantong + $d['kantong'];
            
            $persenhbsag = $persenhbsag + round(($d['hbsag']*100)/$d['jumlah_sampel'],1);
            $persenantihiv = $persenantihiv + round(($d['hiv']*100)/$d['jumlah_sampel'],1);
            $persenantihvc = $persenantihvc + round(($d['hvc']*100)/$d['jumlah_sampel'],1);
            $persensifilis = $persensifilis + round(($d['sifilis']*100)/$d['jumlah_sampel'],1);
            $persenreaktif = $persenreaktif + round(($d['reaktif']*100)/$d['jumlah_sampel'],1);
            $persenkantong = $persenkantong + round(($d['kantong']*100)/$d['jumlah_sampel'],1);
        }
?>
<tr>   
    <td colspan="2"><center>Total Sampel</center></td>
    <td><?php echo $jumlahsampel;?></td>
    <td><?php echo $jumlahhbsag;?></td>
    <td><?php echo $persenhbsag.'%';?></td>
    <td><?php echo $jumlahantihvc;?></td>
    <td><?php echo $persenantihvc.'%';?></td>
    <td><?php echo $jumlahantihiv;?></td>
    <td><?php echo $persenantihiv.'%';?></td>
    <td><?php echo $jumlahsifilis;?></td>
    <td><?php echo $persensifilis.'%';?></td>
    <td><?php echo $jumlahreaktif;?></td>
    <td><?php echo $persenreaktif.'%';?></td>
    <td><?php echo $jumlahkantong;?></td>
    <td><?php echo $persenkantong.'%';?></td>
</tr>
<?php
    }
?>