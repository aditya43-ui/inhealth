<style>
    .judul{
        text-align:center;
    }

    @media print {
        html, body {

            font-size:11px !important;
        }

        div{
            font-size:11px !important;
        }

        tr td {
            font-size:11px !important;
        }

    }
    .padding5{
        padding: 5px !important;
    }

    .borderclass{
        border: 1px solid black !important;
    }
</style>
<?php
    $groupObatInfus = array();
    $modObatInfus = CatatanpemberianobatT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'jenisinfus'=>'INFUS'));
    
    if(!empty($modObatInfus)){
        foreach($modObatInfus as $ori_infus){
            $modDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$ori_infus->catatanpemberianobat_id),array('order'=>'tanggal_pemberian ASC'));

            // $groupObatInfus[$ori_infus->obatalkes_id]['obatalkes_nama'] = $ori_infus->obatalkes->obatalkes_nama;

            if(!empty($modDet)){
                foreach($modDet as $ori_det){
                    $groupObatInfus[$ori_det->tanggal_pemberian][$ori_infus->obatalkes_id]['obatalkes_nama'] = $ori_infus->obatalkes->obatalkes_nama;
                    $groupObatInfus[$ori_det->tanggal_pemberian][$ori_infus->obatalkes_id]['detail'][] = array('jam'=>$ori_det->jam_pemberian);

                    // $groupObatInfus[$ori_infus->obatalkes_id]['detail'][$ori_det->tanggal_pemberian][] = array('jam'=>$ori_det->jam_pemberian);
                }
            }
        }
    }
    echo '<pre>';
    print_r($groupObatInfus);
    exit();

    $oriObatInfus = array();
    $oriObatInfusDetail = array();
    if(!empty($groupObatInfus)){
        $ind_infus = 0;
        $indx = 1;
        foreach($groupObatInfus as $i => $data_obat){
                echo $ind_infus.' = '.$indx.' == '.$i;
                   echo '<br/>'; 
            $oriObatInfus[$ind_infus]['tanggal'] = $data_obat;
            if($indx == 2){
                $indx = 1;
                $ind_infus++;
            }
            $ind_infus++;
            $indx++;
            // if(!empty($data_obat['detail'])){
            //     $indx = 1;
            //     $indDet = 0;
            //     $urut = 1;
                
            //     // $oriObatInfus[$ind_infus]['detail'][] = $data_obat['detail'];
            //     foreach($data_obat['detail'] as $i => $data_det){
            //         $oriObatInfus[$ind_infus]['obatalkes_id'] = $data_obat['obatalkes_nama'];
            //         $oriObatInfus[$ind_infus]['detail'][$i] = $data_det;
            //         $oriObatInfusDetail[$ind_infus][] = array('tanggal'=>$i,'rowspan'=>count($oriObatInfus[$ind_infus]['detail'][$i]));
            //         // $oriObatInfusDetail[$ind_infus][] = $urut;
            //         // $oriObatInfusDetail[$ind_infus]['rowspan'][] = $urut; 
            //         $urut++;
            //     //     echo $ind_infus.' = '.$indx.' == '.$i;
            //     //    echo '<br/>'; 
            //         if($indx == 2){
            //             $indx = 0;
            //             $ind_infus++;
            //             $indDet = 0;
            //             // $urut =0;
            //         }
            //         $indx++;
            //         $indDet++;
            //     }
            // }
            // $ind_infus++;
        }
    }

    echo '<pre>';
    print_r($oriObatInfus);
    exit();

    echo '<pre>';
    print_r($oriObatInfusDetail);
    exit();
?>


<table width="100%"class="tab_page" >
    <thead>
        <tr>
            <td >
                <div class="header"><div style="text-align:right; font-weight: bold" class="">FRM/90.1/RSBM</div></div>

            </td>
        </tr>
		<?php echo $this->renderPartial($this->path_view.'_headerSurat',array('judulLaporan'=>$judulLaporan, 'colspan'=>'','modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran)); ?>
    </thead>
    <tbody>
        <table width="100%" border="1px" style="margin-top:3px;">
            <tr>
                <td>Keterangan :</td>
            </tr>
            <tr>
                <td>

                    <table width="100%">
                        <tr>
                            <td style="padding:5px; vertical-align:top; width:30%; ">
                                <div style="margin-left:10px;" >
                                    Jadwal Pemberian Obat:<br>
                                    1x1 Pagi 06-07<br>
                                    1x1 Malam 21-22<br>
                                    2x1 06-07 18-19<br>
                                    3x1 06-07 12-13 19-20<br>
                                    4x1 06-07 12-13 19-20<br>
                                    5x1 05-07 10-11 15-16 20-21 23-24<br>
                                    6x1 05-06 09-10 13-14 17-18 21-22 01-02<br>
                                </div>

                            <td style="padding:5px; vertical-align:top;">
                                Tuliskan pada kolom tanda "tanda"
                                <table>
                                    <tr>
                                        <td><i class="icon-ok icon-black"></i></td>
                                        <td>:</td>
                                        <td>Setelah Obat diberikan</td>
                                    </tr>
                                    <tr>
                                        <td>T</i></td>
                                        <td>:</td>
                                        <td>Pasien Menolak</td>
                                    </tr>
                                    <tr>
                                        <td>K</i></td>
                                        <td>:</td>
                                        <td>Obat ditunda karena kondisi pasien</td>
                                    </tr>
                                    <tr>
                                        <td>S</i></td>
                                        <td>:</td>
                                        <td>Obat distop oleh dokter</td>
                                    </tr>
                                    <tr>
                                        <td>A</i></td>
                                        <td>:</td>
                                        <td>Reaksi Alergi</td>
                                    </tr>
                                    <tr>
                                        <td>ESO</i></td>
                                        <td>:</td>
                                        <td>Reaksi Efek Samping Setelah Pemberian</td>
                                    </tr>
                                    <tr>
                                        <td>TAP</td>
                                        <td>:</td>
                                        <td>Obat Tidak Tersedia</td>
                                    </tr>
                                </table>

                            </td>
                            <td style="padding:5px; vertical-align:top;">
                                Riwayat Alergi:
                                <div style="width:150px; height:150px; border:1px solid;">
                                    <?php if (isset($modAdmisi->pasienadmisi_id)){
                                        $anmnesa = AnamnesisawalT::model()->findbyattributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
                                        echo isset($anmnesa->riwayatalergi_obat) ? $anmnesa->riwayatalergi_obat : '';
                                    }else{
                                        $anmnesa = AnamnesaT::model()->findbyattributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
                                        echo isset($anmnesa->riwayatalergiobat) ? $anmnesa->riwayatalergiobat : '';
                                    }?>

                                </div>

                            </td>
                            <td style="padding:5px; vertical-align:top;">
                                Ruangan:
                                <div style="width:150px; height:25px; border:1px solid; padding:3px; ">
                                    <?php if (isset($modAdmisi->pasienadmisi_id)){
                                        echo $modAdmisi->ruangan->ruangan_nama;
                                    }else{
                                        echo $modPendaftaran->ruangan->ruangan_nama;
                                    }?>
                                </div>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="">
            <?php if(!empty($oriObatInfus)){ ?>
           <tr>
               <td>
                   OBAT INFUS
               </td>
           </tr> 
           <tr>
               <td>
                   <table width="100%" border="1">
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

                               ?>
                               <th width="100px">
                                    Keterangan Reaksi Obat
                               </th>
                           </tr>
                       </thead>
                   </table>
               </td>
           </tr>
           <?php } ?>                         
        </table>                            
	</tbody>
    <tfoot>
        <tr>
            <td>
                INGAT 8B.1W Pemberian OBAT 
            </td>
        </tr>
        <tr>
            <td>
               <table>
                   <tr>
                       <td width="100px">Benar Pasien</td>
                       <td width="100px">Benar Aturan</td>
                       <td>Benar Informasi</td>
                   </tr>
                   <tr>
                       <td width="100px">Benar Obat</td>
                       <td width="100px">Benar Rute</td>
                       <td>Benar Dokumentasi</td>
                   </tr>
                   <tr>
                       <td width="100px">Benar Dosis</td>
                       <td width="100px">Benar Expired</td>
                       <td>Waspada Efek Samping</td>
                   </tr>
               </table>
            </td>
        </tr>
    </tfoot>    
</table>
