<ul id="browser" class="filetree treeview">
    <li id="tree_rekening_satu">
        <?php

            $criteria=new CDbCriteria;
            $params = array('rekening1_aktif' => true);
            $criteria->order = 't.kdrekening1';
            $criteria->join = 'join kelrekening_m k on k.kelrekening_id = t.kelrekening_id';
            $result = $rekeningSatu->findAllByAttributes($params, $criteria);
            $parent_satu = '';
            foreach($result as $val)
            {
                $params_dua = array(
                    'rekening2_aktif' => true,
                    'rekening1_id' => $val->rekening1_id,
                );
                $kel = KelrekeningM::model()->findByPk($val->kelrekening_id);
                $criteria->order = 'kdrekening2';
                $criteria->join = '';
                $result_dua = $rekeningDua->findAllByAttributes($params_dua, $criteria);
                $parent_dua = '';
                
                $debit_kredit = $val->rekening1_nb;
                
                foreach($result_dua as $val_dua)
                {
                    $params_tiga = array(
                        'rekening3_aktif' => true,
//                                        'rekening1_id' => $val_dua->rekening1_id,
                        'rekening2_id' => $val_dua->rekening2_id,
                    );
                    $criteria->order = 'kdrekening3';
                    $result_tiga = $rekeningTiga->findAllByAttributes($params_tiga, $criteria);
                    $parent_tiga = '';
                    foreach($result_tiga as $val_tiga)
                    {
                        $params_empat = array(
                            'rekening4_aktif' => true,
//                                            'rekening1_id' => $val_tiga->rekening1_id,
//                                            'rekening2_id' => $val_tiga->rekening2_id,
                            'rekening3_id' => $val_tiga->rekening3_id,
                        );
                        $criteria->order = 'kdrekening4';
                        $result_empat = $rekeningEmpat->findAllByAttributes($params_empat, $criteria);
                        $parent_empat = '';
                        foreach($result_empat as $val_empat)
                        {
                            $params_lima = array(
                                'rekening5_aktif' => true,
//                                                'rekening1_id' => $val_empat->rekening1_id,
//                                                'rekening2_id' => $val_empat->rekening2_id,
//                                                'rekening3_id' => $val_empat->rekening3_id,
                                'rekening4_id' => $val_empat->rekening4_id,
                            );
                            $criteria->order = 'kdrekening5';
                            $result_lima = $rekeningLima->findAllByAttributes($params_lima, $criteria);
                            $parent_lima = '';
                            foreach($result_lima as $val_lima)
                            {
                                $parent_lima .= "<li><span class='file'>". $val_lima->kdrekening5." - ".$val_lima->nmrekening5 ."<span style='float:right'><a value='". $val_lima->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_lima->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";
                            }

                            $kode_kelompok_lima = $val->kdrekening1 . '_' . $val_dua->kdrekening2 . '_' . $val_tiga->kdrekening3 . '_' . $val_empat->kdrekening4;
                            $id_kelompok_lima = $val->rekening1_id . '_' . $val_dua->rekening2_id . '_' . $val_tiga->rekening3_id . '_' . $val_empat->rekening4_id;
                            if(count((array)$result_lima) > 0)
                            {
                                $parent_empat .= "<li><span class='folder'>". $val_empat->kdrekening4." - ".$val_empat->nmrekening4 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_lima->kdrekening5 ."' id_rek='". $id_kelompok_lima ."' kode_rek='". $kode_kelompok_lima ."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_empat->rekening4_id ."' kode_rek='". $kode_kelompok_lima ."'  href='#' onclick='editObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_lima ."</ul></li>";
                            }else{
                                $parent_empat .= "<li class='expandable'><span class='folder'>". $val_empat->kdrekening4." - ".$val_empat->nmrekening4 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_empat->kdrekening4 ."00' id_rek='". $id_kelompok_lima ."' kode_rek='". $kode_kelompok_lima ."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_empat->rekening4_id ."' href='#' onclick='editObyekRekening(this);return false;' kode_rek='". $kode_kelompok_lima ."' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span></li>";                                            
                            }
                        }
//                                    
                        $kode_kelompok_empat = $val->kdrekening1 . '_' . $val_dua->kdrekening2 . '_' . $val_tiga->kdrekening3;
                        $id_kelompok_empat = $val->rekening1_id . '_' . $val_dua->rekening2_id . '_' . $val_tiga->rekening3_id;
                        if(count((array)$result_empat) > 0)
                        {
                            $parent_tiga .= "<li><span class='folder'>". $val_tiga->kdrekening3." - ".$val_tiga->nmrekening3 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_empat->kdrekening4 ."' id_rek='". $id_kelompok_empat ."' kode_rek='". $kode_kelompok_empat ."' href='#' onclick='tambahObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Pos'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->rekening3_id ."' href='#' onclick='editJenisRekening(this);return false;' kode_rek='". $kode_kelompok_empat ."' rel='tooltip' data-original-title='Klik untuk edit Kelompok Pos'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_empat ."</ul></li>";
                        }else{
                            $parent_tiga .= "<li class='expandable'><span class='folder'>". $val_tiga->kdrekening3." - ".$val_tiga->nmrekening3 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_tiga->kdrekening3 ."00' id_rek='". $id_kelompok_empat ."' kode_rek='". $kode_kelompok_empat ."' href='#' onclick='tambahObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Pos'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->rekening3_id ."' href='#' onclick='editJenisRekening(this);return false;' kode_rek='". $kode_kelompok_empat ."' rel='tooltip' data-original-title='Klik untuk edit Kelompok Pos'><i class='icon-pencil-brown'></i></a></span></span></li>";
                        }

                    }

                    $kode_kelompok = $val->kdrekening1 . '_' . $val_dua->kdrekening2;
                    $id_kelompok = $val_dua->rekening1_id . '_' . $val_dua->rekening2_id;
                    if(count((array)$result_tiga) > 0)
                    {
                        $parent_dua .= "<li id='". $id_kelompok ."'><span class='folder'>". $val_dua->kdrekening2." - ".$val_dua->nmrekening2 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_tiga->kdrekening3 ."' id_rek='". $id_kelompok ."' kode_rek='". $kode_kelompok ."' href='#' onclick='tambahJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Kelompok Pos'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->rekening2_id ."' href='#' onclick='editKelompokRekening(this);return false;' kode_rek='". $kode_kelompok ."' rel='tooltip' data-original-title='Klik untuk edit Unsur'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_tiga ."</ul></li>";
                    }else{
                        $parent_dua .= "<li id='". $id_kelompok ."' class='expandable'><span class='folder'>". $val_dua->kdrekening2." - ".$val_dua->nmrekening2 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_dua->kdrekening2 ."00' id_rek='". $id_kelompok ."' kode_rek='". $kode_kelompok ."' href='#' onclick='tambahJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Kelompok Pos'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->rekening2_id ."' href='#' onclick='editKelompokRekening(this);return false;' kode_rek='". $kode_kelompok ."' rel='tooltip' data-original-title='Klik untuk edit Unsur'><i class='icon-pencil-brown'></i></a></span></span></li>";
                    }

                }

                $value_kode = $val->kdrekening1;
                $value_id = $val->rekening1_id;
                if(count((array)$result_dua) > 0)
                {
                    $parent_satu .= "<li id='". $value_id ."'><span class='folder'>". $val->kdrekening1." - ".$val->nmrekening1 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_dua->kdrekening2 ."' id_rek='". $value_id ."' kode_rek='". $value_kode ."' href='#' onclick='tambahKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Unsur'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->rekening1_id ."' href='#' onclick='editStrukturRekening(this);return false;' kode_rek='". $value_kode ."' rel='tooltip' data-original-title='Klik untuk edit Komponen'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_dua ."</ul></li>";
                }else{
                    $parent_satu .= "<li id='". $value_id ."' class='expandable'><span class='folder'>". $val->kdrekening1." - ".$val->nmrekening1 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val->kdrekening1."00' id_rek='". $value_id ."' kode_rek='". $value_kode ."' href='#' onclick='tambahKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Unsur'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->rekening1_id ."' href='#' onclick='editStrukturRekening(this);return false;' kode_rek='". $value_kode ."' rel='tooltip' data-original-title='Klik untuk edit Komponen'><i class='icon-pencil-brown'></i></a></span></span></li>";
                }
            }
        ?>
        <span class="folder">
            Struktur Akun
            <span style="float:right"><a max_kode = "<?php echo isset($val->kdrekening1) ? $val->kdrekening1 : null; ?>" href="#" onclick="tambahStrukturRekening(this);return false;" rel="tooltip" data-original-title="Klik untuk menambah Komponen"><i class="icon-plus-sign"></i></a></span>
        </span>
        <?php
            if(count((array)$result) > 0)
            {
                echo '<ul>';
                echo $parent_satu;
                echo '</ul>';
            }                    
        ?>
    </li>
</ul>
