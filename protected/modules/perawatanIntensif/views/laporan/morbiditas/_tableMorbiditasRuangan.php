<table class="table table-striped table-condensed">
    <thead>
        <tr>
            <th style="text-align: center" rowspan="4">NO</th>
            <th style="text-align: center" rowspan="4">KODE ICD</th>
            <th style="text-align: center" rowspan="4">GOLONGAN SEBAB PENYAKIT</th>
            <th style="text-align: center" colspan="18">JUMLAH PASIEN HIDUP & MATI</th>
            <th style="text-align: center" rowspan="3" colspan="2">PASIEN (H+M) MENURUT SEX</th>
            <th style="text-align: center" rowspan="4">PASIEN KELUAR HIDUP</th>
            <th style="text-align: center" rowspan="4">PASIEN KELUAR MATI</th>
        </tr>
        <tr>
            <th style="text-align: center" colspan="18">GOLONGAN UMUR</th>
        </tr>
        <tr>
            <th style="text-align: center" colspan="2">0-6HR</th>
            <th style="text-align: center" colspan="2">>6-28HR</th>
            <th style="text-align: center" colspan="2">>28HR-1TH</th>
            <th style="text-align: center" colspan="2">>1-4TH</th>
            <th style="text-align: center" colspan="2">>4-14TH</th>
            <th style="text-align: center" colspan="2">>14-24TH</th>
            <th style="text-align: center" colspan="2">>24-44TH</th>
            <th style="text-align: center" colspan="2">>44-64TH</th>
            <th style="text-align: center" colspan="2">>64TH</th>
        </tr>
        <tr>
            <?php for($x=1;$x<=10;$x++){?>
                <?php echo '<th style="text-align: center">L</th>';?>
                <?php echo '<th style="text-align: center">P</th>';?>
            <?php }?>
        </tr>
        <tr>
            <?php for($x=1;$x<=25;$x++){?>
                <?php echo '<td style="text-align: center;background: orange;">'.$x.'</td>';?>
            <?php }?>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1;
        if(count((array)$models)){
        foreach ($models as $value) {
        ?>
        <tr>
            <td style="text-align: center"><?php echo $i;?></td>
            <td style="text-align: left"><?php echo $value->diagnosa_kode;?></td>
            <td style="text-align: left"><?php echo $value->diagnosa_nama;?></td>
            <td style="text-align: center"><?php echo $value->umur_0_6hr_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->umur_0_6hr_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->umur_6_28hr_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->umur_6_28hr_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->umur_28hr_1thn_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->umur_28hr_1thn_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->umur_1_4thn_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->umur_1_4thn_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->umur_5_14thn_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->umur_5_14thn_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->umur_15_24thn_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->umur_15_24thn_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->umur_25_44thn_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->umur_25_44thn_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->umur_45_64thn_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->umur_45_64thn_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->umur_65_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->umur_65_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->jml_lakilaki;?></td>
            <td style="text-align: center"><?php echo $value->jml_perempuan;?></td>
            <td style="text-align: center"><?php echo $value->pasienkeluarhidup;?></td>
            <td style="text-align: center"><?php echo $value->pasienkeluarmati;?></td>
        </tr>
        <?php 
        $i++;
        }
        }
        ?>
    </tbody>
</table>