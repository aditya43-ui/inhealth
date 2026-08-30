<span style="font-family: arial;font-size: 14pt;"><b><center>FAAAL HATI</center></b></span>
<table class="grid">
    <thead>
        <tr style="font-family: arial;font-size: 11pt;">
            <th width="3%">No.</th>
            <th width="20%">Pemeriksaan</th>
            <th width="30%">Hasil</th>
            <th width="15%">Satuan</th>
            <th width="15%">Normal</th>
            <th width="15%">Metode</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $idx = 1;
            $kelompok = "";
            $rows = '';
            foreach($params as $val)
            {
                $rows = '';
                if(count($val['pemeriksaan']) > 1)
                {
                    $namapemeriksaan = '';
                    $hasil = '';
                    $satuan = '';
                    $normal = '';
                    $metode = '';
                    
                    foreach($val['pemeriksaan'] as $temp)
                    {
                        if(empty($temp['hasil']))$temp['hasil'] = '-';
                        
                        $namapemeriksaan .= '<div>' . $temp['namapemeriksaan'] .'</div>';
                        $hasil .= '<div>'. $temp['hasil'] .'</div>';
                        $satuan .= '<div>'. $temp['satuan'] .'</div>';
                        $normal .= '<div>'. $temp['normal'] .'</div>';
                        $metode .= '<div>'. $temp['metode'] .'</div>';
                    }
                    $rows .= '<tr>';
                    $rows .= '<td>'. $idx .'</td>';
                    $rows .= '<td><b>'. $val['kelompok'] . '</b>'. $namapemeriksaan .'</td>';
                    $rows .= '<td><br>'. $hasil .'</td>';
                    $rows .= '<td><br>'. $satuan .'</td>';
                    $rows .= '<td><br>'. $normal .'</td>';
                    $rows .= '<td><br>'. $metode .'</td>';
                    $rows .= '</tr>';                    
                }else{
                    $row = '';
                    foreach($val['pemeriksaan'] as $temp)
                    {
                        if(empty($temp['hasil']))$temp['hasil'] = '-';
                        
                        $row .= '<tr>';
                        $row .= '<td>'. $idx .'</td>';
                        $row .= '<td><div>'. $temp['kelompok'] .'</div></td>';
                        $row .= '<td>'. $temp['hasil'] .'</td>';
                        $row .= '<td>'. $temp['satuan'] .'</td>';
                        $row .= '<td>'. $temp['normal'] .'</td>';
                        $row .= '<td>'. $temp['metode'] .'</td>';
                        $row .= '</tr>';
                    }
                    $rows = $row;
                }
                echo($rows);
                $kelompok = $val['kelompok'];
                $idx++;
            }

        ?>
   </tbody>
</table>