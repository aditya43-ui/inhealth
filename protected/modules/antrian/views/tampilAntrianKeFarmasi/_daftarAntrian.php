<table width="100%">
    <thead>
        <th>NO. ANTRIAN</th>
        <th>NO. RESEP</th>
        <th>NAMA PASIEN</th>
        <!--<th>Jumlah Obat</th>-->
    </thead>
    <tbody>
        <?php 
        if(count($data) > 0){ 
            foreach($data AS $i => $antrian){
                $tr_style = "";
                if(($i+1) % 2 == 0){
                    $tr_style = "background-color:transparent";
                }else{
                    $tr_style = "background-color:#999999";
                }
                echo "<tr style=".$tr_style.">"
                        ."<td>".strtoupper($antrian["racikanantrian_singkatan"]."-".$antrian["noantrian"])."</td>"
                        ."<td>".$antrian["noresep"]."</td>"
                        ."<td>".strtoupper($antrian["namadepan"].$antrian["nama_pasien"])."</td>"
//                        ."<td>".$antrian["jumlahoa"]."</td>"
                    ."</tr>";
            }
        } 
        ?>
    </tbody>
</table>
 