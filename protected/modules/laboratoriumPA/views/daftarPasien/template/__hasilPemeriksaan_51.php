<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <td colspan="4" align="center">
                <div style="text-align: center;font-size:14pt;">
                    <b><?=$jenisperiksa?></b>
                </div>
            </td>
        </tr>
        <tr style="font-family: arial;font-size: 11pt;">
            <th width="3%">No.</th>
            <th width="25%">Pemeriksaan</th>
            <th>Hasil</th>
            <th width="30%">Angka Normal</th>
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
                    $rows .= '<td valign="top">'. $idx .'</td>';
                    $rows .= '<td valign="top"><b>'. $val['kelompok'] . '</b>'. $namapemeriksaan .'</td>';
                    $rows .= '<td valign="top">'. $hasil .'</td>';
                    $rows .= '<td valign="top">'. $normal .'</td>';
                    $rows .= '</tr>';                    
                }else{
                    $row = '';
                    foreach($val['pemeriksaan'] as $temp)
                    {
                        if(empty($temp['hasil']))$temp['hasil'] = '-';
                        
                        $row .= '<tr>';
                        $row .= '<td valign="top">'. $idx .'</td>';
                        $row .= '<td valign="top"><div>'. $temp['namapemeriksaan'] .'</div></td>';
                        $row .= '<td valign="top">'. $temp['hasil'] .'</td>';
                        $row .= '<td valign="top">'. $temp['normal'] .'</td>';
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
</table><br>