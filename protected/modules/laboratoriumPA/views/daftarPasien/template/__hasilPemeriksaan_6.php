<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <td colspan="3" align="center">
                <div style="text-align: center;font-size:14pt;">
                    <b><?=$jenisperiksa?></b>
                </div>
            </td>
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
                    $rows .= '<thead><tr>';
                    $rows .= '<th colspan="3" style="text-align:left;"><b>'. $val['kelompok'] .'</b></th>';
                    $rows .= '</tr></thead>';
                    
                    $rows .= '<tbody><tr>';
                    $rows .= '<td valign="top" width="3%">'. $idx .'</td>';
                    $rows .= '<td valign="top" width="25%">'. $namapemeriksaan .'</td>';
                    $rows .= '<td valign="top">'. $hasil .'</td>';
                    $rows .= '</tr></tbody>';
                }else{
                    $row = '';
                    foreach($val['pemeriksaan'] as $temp)
                    {
                        if(empty($temp['hasil']))$temp['hasil'] = '-';
                        
                        $row .= '<tr>';
                        $row .= '<td valign="top" width="3%">'. $idx .'</td>';
                        $row .= '<td valign="top" width="25%"><div>'. $temp['namapemeriksaan'] .'</div></td>';
                        $row .= '<td valign="top">'. $temp['hasil'] .'</td>';
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