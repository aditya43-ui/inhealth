<?php
/**
* digunakan sebagai Laporan Skrining IMLTD
* @author Elham Budianto <elhambudianto1@gmail.com>
**/
?>
<?php 
    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
         $row = '$row+1';
        //$data = $model->searchTable();
        //$template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
        
        $itemCssClass = 'table border';
        
    } else{
        //$data = $model->searchTable();
         //$template = "{summary}\n{items}\n{pager}";
    }
?>

<div>
    <table width="100%" class="table table-bordered table-condensed" border="1px" style="text-align:center; font-weight: bold" id="table-laporan">
        <thead>
            <tr>
                <td rowspan="2" style="text-align:center;">No</td>
                <td rowspan="2" style="text-align:center;">Bulan</td>
                <td rowspan="2" style="text-align:center;">Jumlah Sampel</td>
                <td colspan="8" style="text-align:center;">Parameter</td>
                <td colspan="2"style="text-align:center;">Reaktif</td>
                <td colspan="2" style="text-align:center;">Kantong</td>
            </tr>
            <tr>
                <td style="text-align:center;">HBsAg</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">HCV</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">HIV</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">Sipilis</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">Total</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">Total</td>
                <td style="text-align:center;">%</td>
            </tr>
        </thead>
        <tbody>
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
        <?php
            if($d['hbsag'] != 0){
                echo round(($d['hbsag']*100)/$d['jumlah_sampel'],1).'%';
            }else{
                echo '0 %';
            }
        ?>
    </td>
    <td><?php echo $d['hvc'];?></td>
    <td>
        <?php
            if($d['hvc'] != 0){
                echo round(($d['hvc']*100)/$d['jumlah_sampel'],1).'%';
            }else{
                echo '0 %';
            }
        ?>
    </td>
    <td><?php echo $d['hiv'];?></td>
    <td>
        <?php
            if($d['hiv'] != 0){
                echo round(($d['hiv']*100)/$d['jumlah_sampel'],1).'%';
            }else{
                echo '0 %';
            }
        ?>
    </td>
    <td><?php echo $d['sifilis'];?></td>
    <td>
       <?php
            if($d['sifilis'] != 0){
                echo round(($d['sifilis']*100)/$d['jumlah_sampel'],1).'%';
            }else{
                echo '0 %';
            }
        ?>
    </td>
    <td><?php echo $d['reaktif'];?></td>
    <td>
        <?php
            if($d['reaktif'] != 0){
                echo round(($d['reaktif']*100)/$d['jumlah_sampel'],1).'%';
            }else{
                echo '0 %';
            }
        ?>
    </td>
    <td><?php echo $d['kantong'];?></td>
    <td>
        <?php
            if($d['kantong'] != 0){
                echo round(($d['kantong']*100)/$d['jumlah_sampel'],1).'%';
            }else{
                echo '0 %';
            }
        ?>
    </td>
</tr>        
<?php
        $no_urut++;
        }
    }
?>   <?php
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
            
            if($d['hbsag'] != 0){
                $persenhbsag = $persenhbsag + round(($d['hbsag']*100)/$d['jumlah_sampel'],1);
            }else{
                $persenhbsag = $persenhbsag + 0;
            }
             if($d['hiv'] != 0){
                $persenantihiv = $persenantihiv + round(($d['hiv']*100)/$d['jumlah_sampel'],1);
            }else{
                $persenantihiv = $persenantihiv + 0;
            }
             if($d['hvc'] != 0){
                $persenantihvc = $persenantihvc + round(($d['hvc']*100)/$d['jumlah_sampel'],1);
            }else{
                $persenantihvc = $persenantihvc + 0;
            }
             if($d['sifilis'] != 0){
                $persensifilis = $persensifilis + round(($d['sifilis']*100)/$d['jumlah_sampel'],1);
            }else{
                $persensifilis = $persensifilis + 0;
            }
             if($d['reaktif'] != 0){
                $persenreaktif = $persenreaktif + round(($d['reaktif']*100)/$d['jumlah_sampel'],1);
            }else{
                $persenreaktif = $persenreaktif + 0;
            }
             if($d['kantong'] != 0){
                $persenkantong = $persenkantong + round(($d['kantong']*100)/$d['jumlah_sampel'],1);
            }else{
                $persenkantong = $persenkantong + 0;
            }
        }
?>
<tr>   
    <td colspan="2"><center>Total Sampel</center></td>
    <td><?php echo $jumlahsampel;?></td>
    <td><?php echo $jumlahhbsag;?></td>
    <td><?php echo $persenhbsag.'%';?></td>
    <td><?php echo $jumlahantihiv;?></td>
    <td><?php echo $persenantihiv.'%';?></td>
    <td><?php echo $jumlahantihvc;?></td>
    <td><?php echo $persenantihvc.'%';?></td>
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
        </tbody>
    </table>
</div>