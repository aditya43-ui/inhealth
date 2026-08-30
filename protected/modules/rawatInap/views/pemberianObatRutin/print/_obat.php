<table width="100%">
    <tr>
        <td class="borderclass padding5 bordertopnoneclass borderbottomnoneclass">
            <?php echo $headerpanel; ?>
        </td>
    </tr>
    <tr>
        <td style="padding: 0px !important; margin: 0px !important;">
            <table width="100%" class="tablecustom">
                <thead>
                    <tr>
                        <th width="50px">
                            NO
                        </th>
                        <th width="150px">
                            NAMA OBAT
                        </th>
                        <th  width="80px">
                            DOSIS
                        </th>
                        <th width="100px">
                            ATURAN PAKAI
                        </th>
                        <th width="100px">
                            CARA PEMBERIAN
                        </th>
                        <th width="100px">
                            PARAF DOKTER
                        </th>
                        <th width="50px">
                            &nbsp;
                        </th>
                        <?php 
                        
                            if(!empty($modObat)){
                                foreach($modObat as $tgl){
                                    $colspan = "";
                                    if(!empty($groupObatInfus)){
                                        foreach($groupObatInfus as $grp_oa){
                                            if(!empty($grp_oa[$tgl['tanggal']])){
                                                $colspan = count($grp_oa[$tgl['tanggal']]);
                                            }
                                        }
                                    }
                                    

                                    echo '<th colspan="'.$colspan.'">';
                                    echo MyFormatter::formatDateTimeForUser($tgl['tanggal']);
                                    echo '</th>';
                                }
                            }
                        ?>
                        <th width="100px">
                            Keterangan Reaksi Obat
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        if(!empty($groupObatInfus)){
                            $no = 1;
                            foreach($groupObatInfus as $grp_oa){
                                $obat_nama = "";
                                $dosisobat = "";
                                $aturanpakaiobat = "";
                                $catatanpemberian = "";
                                $keteragan = "";
                                $jamS = array();

                                if(!empty($modObat)){
                                    foreach($modObat as $tgl){
                                        if(!empty($grp_oa[$tgl['tanggal']])){
                                            foreach($grp_oa[$tgl['tanggal']] as $dataGrp){
                                                $obat_nama = $dataGrp['obatalkes_nama'];
                                                $dosisobat = $dataGrp['dosisobat'];
                                                $aturanpakaiobat = $dataGrp['aturanpakaiobat'];
                                                $catatanpemberian = $dataGrp['catatanpemberian'];
                                                $keteragan = $dataGrp['keteragan'];
                                                
                                            }   
                                        }
                                    }
                                }
                                
                                if(!empty($obat_nama)){
                                    echo '<tr>';
                                    echo '<td rowspan="3"> '.$no++;
                                    echo '</td>';
                                    echo '<td rowspan="3">';
                                    echo $obat_nama;
                                    echo '</td>';
                                    echo '<td rowspan="3">';
                                    echo $dosisobat;
                                    echo '</td>';
                                    echo '<td rowspan="3">';
                                    echo $aturanpakaiobat;
                                    echo '</td>';
                                    echo '<td rowspan="3">';
                                    echo $catatanpemberian;
                                    echo '</td>';
                                    echo '<td rowspan="3"> &nbsp;';
                                    echo '</td>';
                            
                                   
                                    echo '<td>JAM</td>';
                                    if(!empty($modObat)){
                                        foreach($modObat as $tgl){
                                            $colspanTgl = "";
                                            $isck = false;
                                          
                                            if(!empty($grp_oa[$tgl['tanggal']])){
                                                foreach($grp_oa[$tgl['tanggal']] as $dataGrp){
                                                    echo '<td>';
                                                    echo $dataGrp['jam'];
                                                    echo '</td>';
                                                }
                                                 
                                            }else{
                                                foreach($modObat as $tgl){
                                                    echo '<td> &nbsp;';
                                                    echo '</td>';
                                                }
                                            }
                                        }
                                    }
                                    echo '<td rowspan="3">';
                                    echo $keteragan;
                                    echo '</td>';
                                    echo '</tr>';
                                    

                                    echo '<tr>';
                                    echo '<td>TANDA</td>';
                                    if(!empty($modObat)){
                                        foreach($modObat as $tgl){
                                            $colspanTgl = "";
                                            $isck = false;
                                          
                                            if(!empty($grp_oa[$tgl['tanggal']])){
                                                foreach($grp_oa[$tgl['tanggal']] as $dataGrp){
                                                    $tanda = "";

                                                    if(!empty($dataGrp['tanda'])){
                                                        if($dataGrp['tanda'] == 'Setelah Obat Diberikan'){
                                                            $tanda = "<i class='fa fa-check'></i>";
                                                        }else if($dataGrp['tanda'] == 'Pasien Menolak'){
                                                            $tanda = "T";
                                                        }else if($dataGrp['tanda'] == 'Obat ditunda karena kondisi pasien'){
                                                            $tanda = "K";
                                                        }else if($dataGrp['tanda'] == 'Obat distop oleh dokter'){
                                                            $tanda = "S";
                                                        }else if($dataGrp['tanda'] == 'Reaksi Alergi'){
                                                            $tanda = "A";
                                                        }else if($dataGrp['tanda'] == 'Reaksi efek samping setelah pemberian'){
                                                            $tanda = "ESO";
                                                        }else if($dataGrp['tanda'] == 'Obat tidak tersedia'){
                                                            $tanda = "TAP";
                                                        }
                                                    }

                                                    echo '<td class="textcenter">';
                                                    echo $tanda;
                                                    echo '</td>';
                                                }
                                                 
                                            }else{
                                                foreach($modObat as $tgl){
                                                    echo '<td> &nbsp;';
                                                    echo '</td>';
                                                }
                                            }
                                        }
                                    }
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '<td>INITITAL</td>';
                                    if(!empty($modObat)){
                                        foreach($modObat as $tgl){
                                            $colspanTgl = "";
                                            $isck = false;
                                          
                                            if(!empty($grp_oa[$tgl['tanggal']])){
                                                foreach($grp_oa[$tgl['tanggal']] as $dataGrp){
                                                    echo '<td>';
                                                    echo  $dataGrp['initial'];
                                                    echo '</td>';
                                                }
                                                 
                                            }else{
                                                foreach($modObat as $tgl){
                                                    echo '<td> &nbsp;';
                                                    echo '</td>';
                                                }
                                            }
                                        }
                                    }
                                    echo '</tr>';
                                }
                               
                            }
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            TANDA TERIMA PASIEN/ KELUARGA
                        </td>
                        <td></td>
                        <?php
                        
                        if(!empty($modObat)){
                            foreach($modObat as $tgl){
                                $inLengt = 0;
                                if(!empty($groupObatInfus)){
                                    foreach($groupObatInfus as $grp_oa){
                                        if(!empty($grp_oa[$tgl['tanggal']])){
                                            $inLengt = count($grp_oa[$tgl['tanggal']]);
                                        }
                                    }
                                }
                                
                                for($a =0; $a < $inLengt; $a++){
                                    echo '<td> &nbsp;';
                                    echo '</td>';
                                }
                            }
                        }
                        
                        ?>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </td>
    </tr>
</table>