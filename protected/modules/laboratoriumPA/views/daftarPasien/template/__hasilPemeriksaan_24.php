<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <td colspan="7" align="center">
                <div style="text-align: center;font-size:14pt;">
                    <b><?=$jenisperiksa?></b>
                </div>
            </td>
        </tr>
        <tr style="font-family: arial;font-size: 11pt;">
            <th width="3%">No.</th>
            <th width="25%" colspan="2">Pemeriksaan</th>
            <th>Hasil</th>
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
                    $val_pem = true;
                    foreach($val['pemeriksaan'] as $temp)
                    {
                        if(empty($temp['hasil']))$temp['hasil'] = '-';
                        
                        $rows .= '<tr>';
                        if($val_pem)
                        {
                            $rows .= '<td valign="top" rowspan="'. count($val['pemeriksaan']) .'">'. $idx .'</td>';
                            $rows .= '<td valign="top" width="10%" rowspan="'. count($val['pemeriksaan']) .'"><b>'. $val['kelompok'] . '</b></td>';
                            $val_pem = false;
                        }
                        $rows .= '<td valign="top" width="10%">'. $temp['namapemeriksaan'] . '</td>';
                        $rows .= '<td valign="top">'. $temp['hasil'] .'</td>';
                        $rows .= '<td valign="top">'. $temp['satuan'] .'</td>';
                        $rows .= '<td valign="top">'. $temp['normal'] .'</td>';
                        $rows .= '<td valign="top">'. $temp['metode'] .'</td>';
                        $rows .= '</tr>';
                    }
                }else{
                    $row = '';
                    foreach($val['pemeriksaan'] as $temp)
                    {
                        if(empty($temp['hasil']))$temp['hasil'] = '-';
                        
                        $row .= '<tr>';
                        $row .= '<td valign="top">'. $idx .'</td>';
                        $row .= '<td valign="top" colspan="2"><div>'. $temp['kelompok'] .'</div></td>';
                        $row .= '<td valign="top">'. $temp['hasil'] .'</td>';
                        $row .= '<td valign="top">'. $temp['satuan'] .'</td>';
                        $row .= '<td valign="top">'. $temp['normal'] .'</td>';
                        $row .= '<td valign="top">'. $temp['metode'] .'</td>';
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