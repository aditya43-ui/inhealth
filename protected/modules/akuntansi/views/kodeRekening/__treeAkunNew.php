<ul id="browser" class="filetree treeview">
    <li id="tree_rekening_satu">
        <?php

            $criteria=new CDbCriteria;
            $params = array('rekening5_aktif' => true,'levelrek' => 1);
            $criteria->order = 't.kdrekening5';
            $criteria->join = 'join kelrekening_m k on k.kelrekening_id = t.kelrekening_id';
            $result = $rekeningLima->findAllByAttributes($params, $criteria);
            $parent_satu = '';
            foreach($result as $val)
            {
                $params_dua = array(
                    'levelrek' => 2,
                    'parent_id'=>$val->rekening5_id
                );
                $kel = KelrekeningM::model()->findByPk($val->kelrekening_id);
                $criteria->order = 'kdrekening5';
                $criteria->join = '';
                $result_dua = $rekeningLima->findAllByAttributes($params_dua, $criteria);
                $parent_dua = '';

                $debit_kredit = $val->rekening5_nb;

                foreach($result_dua as $val_dua)
                {
                    // var_dump((int)$val_dua->kdrekening5);die;
                    $params_tiga = array(
                        'levelrek' => 3,
                        'parent_id'=> (int)$val_dua->rekening5_id
                    );
                    $criteria->order = 'kdrekening5';
                    $result_tiga = $rekeningLima->findAllByAttributes($params_tiga, $criteria);
                    $parent_tiga = '';
                    foreach($result_tiga as $val_tiga)
                    {
                        $params_empat = array(
                            'levelrek' => 4,
                            'parent_id'=>$val_tiga->rekening5_id

                        );
                        $criteria->order = 'kdrekening5';
                        $result_empat = $rekeningLima->findAllByAttributes($params_empat, $criteria);
                        $parent_empat = '';
                        foreach($result_empat as $val_empat)
                        {
                            $params_lima = array(
                                'rekening5_aktif' => true,
                                'levelrek' => 5,
                                'parent_id'=>$val_empat->rekening5_id
                            );
                            $criteria->order = 'kdrekening5';
                            $result_lima = $rekeningLima->findAllByAttributes($params_lima, $criteria);
                            $parent_lima = '';
                                foreach($result_lima as $val_lima){
                                     $params_enam = array(
                                        'levelrek' => 6,
                                        'parent_id'=>$val_lima->rekening5_id
                                    );
                                    $criteria->order = 'kdrekening5';
                                    $result_enam = $rekeningLima->findAllByAttributes($params_enam, $criteria);
                                    $parent_enam = '';

                                    foreach($result_enam as $val_enam){
                                        $params_tujuh = array(
                                            'levelrek' => 7,
                                            'parent_id'=>$val_enam->rekening5_id
                                        );
                                        $criteria->order = 'kdrekening5';
                                        $result_tujuh = $rekeningLima->findAllByAttributes($params_tujuh, $criteria);
                                        $parent_tujuh = '';


                                        foreach($result_tujuh as $val_tujuh){
                                            $params_delapan = array(
                                                'levelrek' => 8,
                                                'parent_id'=>$val_tujuh->rekening5_id
                                            );
                                            $criteria->order = 'kdrekening5';
                                            $result_delapan = $rekeningLima->findAllByAttributes($params_delapan, $criteria);
                                            $parent_delapan = '';

                                            foreach($result_delapan as $val_delapan){
                                                $params_sembilan = array(
                                                    'levelrek' => 9,
                                                    'parent_id'=>$val_delapan->rekening5_id
                                                );
                                                $criteria->order = 'kdrekening5';
                                                $result_sembilan = $rekeningLima->findAllByAttributes($params_sembilan, $criteria);
                                                $parent_sembilan = '';
                                                foreach($result_sembilan as $val_sembilan){
                                                    $params_sepuluh = array(
                                                        'levelrek' => 10,
                                                        'parent_id'=>$val_sembilan->rekening5_id
                                                    );
                                                    // $parent_sembilan .= "<li><span class='file'>". $val_sembilan->kdrekening5." - ".$val_sembilan->nmrekening5 ."<span style='float:right'><a value='". $val_sembilan->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_sembilan->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                                                    $criteria->order = 'kdrekening5';
                                                    $result_sepuluh= $rekeningLima->findAllByAttributes($params_sepuluh, $criteria);
                                                    $parent_sepuluh = '';
                                                    foreach($result_sepuluh as $val_sepuluh)
                                                    {
                                                        $params_sepuluh = array(
                                                            'levelrek' => 10,
                                                            'parent_id'=>$val_sembilan->rekening5_id
                                                        );

                                                        $parent_sembilan .= "<li><span class='file'>". $val_sepuluh->kdrekening5." - ".$val_sepuluh->nmrekening5 ."<span style='float:right'><a value='". $val_sepuluh->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_sepuluh->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";
                                                    }
                        $kode_kelompok_sepuluh = $val->kdrekening5 . '_' . $val_dua->kdrekening5 . '_' . $val_tiga->kdrekening5 . '_' . $val_empat->kdrekening5.'_'. $val_lima->kdrekening5.'_'. $val_enam->kdrekening5.'_'. $val_tujuh->kdrekening5.'_'. $val_delapan->kdrekening5;
                        $id_kelompok_sepuluh = $val->rekening5_id . '_' . $val_dua->rekening5_id . '_' . $val_tiga->rekening5_id . '_' . $val_empat->rekening5_id.'_'. $val_lima->rekening5_id.'_'. $val_enam->kdrekening5.'_'. $val_tujuh->kdrekening5.'_'. $val_delapan->kdrekening5;
                        //LEVEL 9
                        if ($kel->levelterakhir == $val_sembilan->levelrek) {
                            $parent_sembilan .= "<li><span class='file'>". $val_sembilan->kdrekening5." - ".$val_sembilan->nmrekening5 ."<span style='float:right'><a value='". $val_sembilan->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_sembilan->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                        }else{

                            if(count((array)$result_sepuluh) > 0)
                            {
                                $parent_sembilan .= "<li><span class='folder'>". $val_sembilan->kdrekening5." - ".$val_sembilan->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_sepuluh->kdrekening5 ."' data-levelrek='10' data-namarek='".$val_sembilan->nmrekening5."'   data-tiperekening='".$val_sembilan->tiperekening_id."' data-parentid='".$val_sembilan->rekening5_id."'  data-kelrekening='".$val_sembilan->kelrekening_id."' id_rek='". $id_kelompok_sepuluh ."' kode_rek='". $kode_kelompok_sepuluh ."' parentkode_rek='". $val_sembilan->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_sembilan->rekening5_id ."' kode_rek='". $kode_kelompok_sepuluh ."'  href='#' onclick='editObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_sepuluh ."</ul></li>";
                            }else{
                                $parent_sembilan .= "<li class='expandable'><span class='folder'>". $val_sembilan->kdrekening5." - ".$val_sembilan->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_sembilan->kdrekening5 ."00' data-levelrek='10' data-namarek='".$val_sembilan->nmrekening5."'  data-tiperekening='".$val_sembilan->tiperekening_id."' data-kelrekening='".$val_sembilan->kelrekening_id."' data-parentid='".$val_sembilan->rekening5_id."' id_rek='". $id_kelompok_sepuluh ."' kode_rek='". $kode_kelompok_sepuluh."' parentkode_rek='". $val_sembilan->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_sembilan->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok_sepuluh ."' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span></li>";
                            }
                        }
                    }
                        $kode_kelompok_sembilan = $val->kdrekening5 . '_' . $val_dua->kdrekening5 . '_' . $val_tiga->kdrekening5 . '_' . $val_empat->kdrekening5.'_'. $val_lima->kdrekening5.'_'. $val_enam->kdrekening5.'_'. $val_tujuh->kdrekening5.'_'. $val_delapan->kdrekening5;
                        $id_kelompok_sembilan = $val->rekening5_id . '_' . $val_dua->rekening5_id . '_' . $val_tiga->rekening5_id . '_' . $val_empat->rekening5_id.'_'. $val_lima->rekening5_id.'_'. $val_enam->kdrekening5.'_'. $val_tujuh->kdrekening5.'_'. $val_delapan->kdrekening5;
                        //LEVEL 8
                        if ($kel->levelterakhir == $val_delapan->levelrek) {
                            $parent_delapan .= "<li><span class='file'>". $val_delapan->kdrekening5." - ".$val_delapan->nmrekening5 ."<span style='float:right'><a value='". $val_delapan->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_delapan->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                        }else{

                            if(count((array)$result_sembilan) > 0)
                            {
                                $parent_delapan .= "<li><span class='folder'>". $val_delapan->kdrekening5." - ".$val_delapan->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_sembilan->kdrekening5 ."' data-levelrek='9' data-namarek='".$val_delapan->nmrekening5."'   data-tiperekening='".$val_delapan->tiperekening_id."' data-parentid='".$val_delapan->rekening5_id."'  data-kelrekening='".$val_delapan->kelrekening_id."' id_rek='". $id_kelompok_sembilan ."' kode_rek='". $kode_kelompok_sembilan ."' parentkode_rek='". $val_delapan->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_delapan->rekening5_id ."' kode_rek='". $kode_kelompok_sembilan ."'  href='#' onclick='editObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_sembilan ."</ul></li>";
                            }else{
                                $parent_delapan .= "<li class='expandable'><span class='folder'>". $val_delapan->kdrekening5." - ".$val_delapan->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_delapan->kdrekening5 ."0' data-levelrek='9' data-namarek='".$val_delapan->nmrekening5."'  data-tiperekening='".$val_delapan->tiperekening_id."' data-kelrekening='".$val_delapan->kelrekening_id."' data-parentid='".$val_delapan->rekening5_id."' id_rek='". $id_kelompok_sembilan ."' kode_rek='". $kode_kelompok_sembilan ."' parentkode_rek='". $val_delapan->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_delapan->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok_sembilan ."' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span></li>";
                            }
                        }
                    }
                        $kode_kelompok_delapan = $val->kdrekening5 . '_' . $val_dua->kdrekening5 . '_' . $val_tiga->kdrekening5 . '_' . $val_empat->kdrekening5.'_'. $val_lima->kdrekening5.'_'. $val_enam->kdrekening5.'_'. $val_tujuh->kdrekening5;
                        $id_kelompok_delapan = $val->rekening5_id . '_' . $val_dua->rekening5_id . '_' . $val_tiga->rekening5_id . '_' . $val_empat->rekening5_id.'_'. $val_lima->rekening5_id.'_'. $val_enam->kdrekening5.'_'. $val_tujuh->kdrekening5;
                        //LEVEL 7
                        if ($kel->levelterakhir == $val_tujuh->levelrek) {
                            $parent_tujuh .= "<li><span class='file'>". $val_tujuh->kdrekening5." - ".$val_tujuh->nmrekening5 ."<span style='float:right'><a value='". $val_tujuh->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_tujuh->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                        }else{

                            if(count((array)$result_delapan) > 0)
                            {
                                $parent_tujuh .= "<li><span class='folder'>". $val_tujuh->kdrekening5." - ".$val_tujuh->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_delapan->kdrekening5 ."'  data-kelrekening='".$val_tujuh->kelrekening_id."' data-levelrek='8' data-namarek='".$val_tujuh->nmrekening5."'  data-tiperekening='".$val_tujuh->tiperekening_id."' data-parentid='".$val_tujuh->rekening5_id."' id_rek='". $id_kelompok_delapan ."' kode_rek='". $kode_kelompok_delapan ."' parentkode_rek='". $val_tujuh->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tujuh->rekening5_id ."' kode_rek='". $kode_kelompok_delapan ."'  href='#' onclick='editObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_delapan ."</ul></li>";
                            }else{
                                $parent_tujuh .= "<li class='expandable'><span class='folder'>". $val_tujuh->kdrekening5." - ".$val_tujuh->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_tujuh->kdrekening5 ."0'  data-kelrekening='".$val_tujuh->kelrekening_id."' data-levelrek='8' data-namarek='".$val_tujuh->nmrekening5."'  data-tiperekening='".$val_tujuh->tiperekening_id."' data-parentid='".$val_tujuh->rekening5_id."' id_rek='". $id_kelompok_delapan ."' kode_rek='". $kode_kelompok_delapan ."' parentkode_rek='". $val_tujuh->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tujuh->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok_delapan ."' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span></li>";
                            }
                        }
                    }

                        $kode_kelompok_tujuh = $val->kdrekening5 . '_' . $val_dua->kdrekening5 . '_' . $val_tiga->kdrekening5 . '_' . $val_empat->kdrekening5.'_'. $val_lima->kdrekening5.'_'. $val_enam->kdrekening5;
                        $id_kelompok_tujuh = $val->rekening5_id . '_' . $val_dua->rekening5_id . '_' . $val_tiga->rekening5_id . '_' . $val_empat->rekening5_id.'_'. $val_lima->rekening5_id.'_'. $val_enam->kdrekening5;

                        //LEVEL 6
                        if ($kel->levelterakhir == $val_enam->levelrek) {
                            $parent_enam .= "<li><span class='file'>". $val_enam->kdrekening5." - ".$val_enam->nmrekening5 ."<span style='float:right'><a value='". $val_enam->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_enam->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                        }else{
                            if(count((array)$result_tujuh) > 0)
                            {
                                $parent_enam .= "<li><span class='folder'>". $val_enam->kdrekening5." - ".$val_enam->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_tujuh->kdrekening5 ."' data-levelrek='7' data-namarek='".$val_enam->nmrekening5."'  data-tiperekening='".$val_enam->tiperekening_id."' data-parentid='".$val_enam->rekening5_id."'  data-kelrekening='".$val_enam->kelrekening_id."' id_rek='". $id_kelompok_tujuh ."' kode_rek='". $kode_kelompok_tujuh ."' parentkode_rek='". $val_enam->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_enam->rekening5_id ."' kode_rek='". $kode_kelompok_tujuh ."'  href='#' onclick='editObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_tujuh ."</ul></li>";
                            }else{
                                $parent_enam .= "<li class='expandable'><span class='folder'>". $val_enam->kdrekening5." - ".$val_enam->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_enam->kdrekening5 ."0' data-levelrek='7'  data-namarek='".$val_enam->nmrekening5."'  data-tiperekening='".$val_enam->tiperekening_id."' data-kelrekening='".$val_enam->kelrekening_id."' data-parentid='".$val_enam->rekening5_id."' id_rek='". $id_kelompok_tujuh ."' kode_rek='". $kode_kelompok_tujuh ."' parentkode_rek='". $val_enam->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_enam->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok_tujuh ."' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span></li>";
                            }
                        }
                    }
                        $kode_kelompok_enam = $val->kdrekening5 . '_' . $val_dua->kdrekening5 . '_' . $val_tiga->kdrekening5 . '_' . $val_empat->kdrekening5.'_'. $val_lima->kdrekening5;
                        $id_kelompok_enam = $val->rekening5_id . '_' . $val_dua->rekening5_id . '_' . $val_tiga->rekening5_id . '_' . $val_empat->rekening5_id.'_'. $val_lima->rekening5_id;
                        //LEVEL 5
                        if ($kel->levelterakhir == $val_lima->levelrek) {
                            $parent_lima .= "<li><span class='file'>". $val_lima->kdrekening5." - ".$val_lima->nmrekening5 ."<span style='float:right'><a value='". $val_lima->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_lima->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                        }else{

                            if(count((array)$result_enam) > 0)
                            {
                                $parent_lima .= "<li><span class='folder'>". $val_lima->kdrekening5." - ".$val_lima->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_enam->kdrekening5 ."'  data-kelrekening='".$val_lima->kelrekening_id."' data-levelrek='6' data-namarek='".$val_lima->nmrekening5."'  data-tiperekening='".$val_lima->tiperekening_id."' data-parentid='".$val_lima->rekening5_id."' id_rek='". $id_kelompok_enam ."' kode_rek='". $kode_kelompok_enam ."' parentkode_rek='". $val_lima->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_lima->rekening5_id ."' kode_rek='". $kode_kelompok_enam ."'  href='#' onclick='editObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_enam ."</ul></li>";
                            }else{
                                $parent_lima .= "<li class='expandable'><span class='folder'>". $val_lima->kdrekening5." - ".$val_lima->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_lima->kdrekening5 ."0'  data-kelrekening='".$val_lima->kelrekening_id."' data-levelrek='6' data-namarek='".$val_lima->nmrekening5."'  data-tiperekening='".$val_lima->tiperekening_id."' data-parentid='".$val_lima->rekening5_id."' id_rek='". $id_kelompok_enam ."' kode_rek='". $kode_kelompok_enam ."' parentkode_rek='". $val_lima->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_lima->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok_enam ."' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span></li>";
                            }
                        }

                    }
                        $kode_kelompok_lima = $val->kdrekening5 . '_' . $val_dua->kdrekening5 . '_' . $val_tiga->kdrekening5 . '_' . $val_empat->kdrekening5;
                        $id_kelompok_lima = $val->rekening5_id . '_' . $val_dua->rekening5_id . '_' . $val_tiga->rekening5_id . '_' . $val_empat->rekening5_id;
                        //LEVEL 4
                        if ($kel->levelterakhir == $val_empat->levelrek) {
                            $parent_empat .= "<li><span class='file'>". $val_empat->kdrekening5." - ".$val_empat->nmrekening5 ."<span style='float:right'><a value='". $val_empat->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_empat->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                        }else{

                            if(count((array)$result_lima) > 0)
                            {
                                $parent_empat .= "<li><span class='folder'>". $val_empat->kdrekening5." - ".$val_empat->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_lima->kdrekening5 ."'  data-kelrekening='".$val_empat->kelrekening_id."' data-levelrek='5' data-namarek='".$val_empat->nmrekening5."'  data-tiperekening='".$val_empat->tiperekening_id."' data-parentid='".$val_empat->rekening5_id."' id_rek='". $id_kelompok_lima ."' kode_rek='". $kode_kelompok_lima ."' parentkode_rek='". $val_empat->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_empat->rekening5_id ."' kode_rek='". $kode_kelompok_lima ."'  href='#' onclick='editObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_lima ."</ul></li>";
                            }else{
                                $parent_empat .= "<li class='expandable'><span class='folder'>". $val_empat->kdrekening5." - ".$val_empat->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_empat->kdrekening5 ."0' data-levelrek='5' data-namarek='".$val_empat->nmrekening5."'  data-tiperekening='".$val_empat->tiperekening_id."' data-parentid='".$val_empat->rekening5_id."'  data-kelrekening='".$val_empat->kelrekening_id."' id_rek='". $id_kelompok_lima ."' kode_rek='". $kode_kelompok_lima ."' parentkode_rek='". $val_empat->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Akun'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_empat->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok_lima ."' rel='tooltip' data-original-title='Klik untuk edit Pos'><i class='icon-pencil-brown'></i></a></span></span></li>";
                            }
                        }
                    }

                        $kode_kelompok_empat = $val->kdrekening5 . '_' . $val_dua->kdrekening5 . '_' . $val_tiga->kdrekening5;
                        $id_kelompok_empat = $val->rekening5_id . '_' . $val_dua->rekening5_id . '_' . $val_tiga->rekening5_id;
                        //LEVEL 3
                        if ($kel->levelterakhir == $val_tiga->levelrek) {
                            $parent_tiga .= "<li><span class='file'>". $val_tiga->kdrekening5." - ".$val_tiga->nmrekening5 ."<span style='float:right'><a value='". $val_tiga->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_tiga->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                        }else{
                            if(count((array)$result_empat) > 0)
                            {
                                $parent_tiga .= "<li><span class='folder'>". $val_tiga->kdrekening5." - ".$val_tiga->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_empat->kdrekening5 ."' data-levelrek='4' data-namarek='".$val_tiga->nmrekening5."'  data-tiperekening='".$val_tiga->tiperekening_id."' data-kelrekening='".$val_tiga->kelrekening_id."' data-parentid='". $val_tiga->rekening5_id."' id_rek='". $id_kelompok_empat ."' kode_rek='". $kode_kelompok_empat ."' parentkode_rek='". $val_tiga->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Pos'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok_empat ."' rel='tooltip' data-original-title='Klik untuk edit Kelompok Pos'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_empat ."</ul></li>";
                            }else{
                                $parent_tiga .= "<li class='expandable'><span class='folder'>". $val_tiga->kdrekening5." - ".$val_tiga->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' data-levelrek='4' data-namarek='".$val_tiga->nmrekening5."'  data-tiperekening='".$val_tiga->tiperekening_id."' data-kelrekening='".$val_tiga->kelrekening_id."' data-parentid='". $val_tiga->rekening5_id."' max_kode='".$val_tiga->kdrekening5 ."0' id_rek='". $id_kelompok_empat ."' kode_rek='". $kode_kelompok_empat ."' parentkode_rek='". $val_tiga->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this, \"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Pos'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok_empat ."' rel='tooltip' data-original-title='Klik untuk edit Kelompok Pos'><i class='icon-pencil-brown'></i></a></span></span></li>";
                            }
                        }

                    }

                    $kode_kelompok = $val->kdrekening5 . '_' . $val_dua->kdrekening5;
                    $id_kelompok = $val_dua->rekening5_id . '_' . $val_dua->rekening5_id;
                    //LEVEL 2
                    if ($kel->levelterakhir == $val_dua->levelrek) {
                        $parent_dua .= "<li><span class='file'>". $val_dua->kdrekening5." - ".$val_dua->nmrekening5 ."<span style='float:right'><a value='". $val_dua->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val_dua->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                    }else{

                        if(count((array)$result_tiga) > 0)
                        {
                            $parent_dua .= "<li id='". $id_kelompok ."'><span class='folder'>". $val_dua->kdrekening5." - ".$val_dua->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_tiga->kdrekening5 ."'  data-kelrekening='".$val_dua->kelrekening_id."' id_rek='". $id_kelompok ."' data-levelrek='3' data-namarek='".$val_dua->nmrekening5."' data-tiperekening='".$val_dua->tiperekening_id."' data-parentid='".$val_dua->rekening5_id."' kode_rek='". $kode_kelompok ."' parentkode_rek='". $val_dua->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this,\"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Kelompok Pos'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok ."' rel='tooltip' data-original-title='Klik untuk edit Unsur'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_tiga ."</ul></li>";
                        }else{
                            $parent_dua .= "<li id='". $id_kelompok ."' class='expandable'><span class='folder'>". $val_dua->kdrekening5." - ".$val_dua->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val_dua->kdrekening5 ."0'  data-kelrekening='".$val_dua->kelrekening_id."' data-levelrek='3' data-namarek='".$val_dua->nmrekening5."' data-tiperekening='".$val_dua->tiperekening_id."' data-parentid='".$val_dua->rekening5_id."' id_rek='". $id_kelompok ."' data-parentid='".$val_dua->kdrekening5."' kode_rek='". $kode_kelompok ."' parentkode_rek='". $val_dua->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this,\"".$kel->saldonormal."\");return false;' rel='tooltip' data-original-title='Klik untuk menambah Kelompok Pos'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $kode_kelompok ."' rel='tooltip' data-original-title='Klik untuk edit Unsur'><i class='icon-pencil-brown'></i></a></span></span></li>";
                        }
                    }

                }

                $value_kode = $val->kdrekening5;
                $value_id = $val->rekening5_id;
                // var_dump($result_dua);die;
                //LEVEL 1
                if ($kel->levelterakhir == $val->levelrek) {
                    $parent_satu .= "<li><span class='file'>". $val->kdrekening5." - ".$val->nmrekening5 ."<span style='float:right'><a value='". $val->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' kode_rek='". $val->kdrekening5 ."' rel='tooltip' data-original-title='Klik untuk edit Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";

                }else{
                    if(count((array)$result_dua) > 0)
                    {
                        $parent_satu .= "<li id='". $value_id ."'><span class='folder'>". $val->kdrekening5." - ".$val->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='". $val_dua->kdrekening5 ."' id_rek='". $value_id ."'  data-kelrekening='".$val->kelrekening_id."' data-levelrek='2' data-namarek='".$val->nmrekening5."' data-tiperekening='".$val->tiperekening_id."' data-parentid='".$value_id."'  kode_rek='". $value_kode ."' parentkode_rek='". $val->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Unsur'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this,\"".$kel->saldonormal."\");return false;' kode_rek='". $value_kode ."' rel='tooltip' data-original-title='Klik untuk edit Komponen'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_dua ."</ul></li>";
                    }else{
                        $parent_satu .= "<li id='". $value_id ."' class='expandable'><span class='folder'>". $val->kdrekening5." - ".$val->nmrekening5 ."<span style='float:right'><a data-debitkredit='".$debit_kredit."' max_kode='".$val->kdrekening5."0' id_rek='". $value_id ."' data-kelrekening='".$val->kelrekening_id."' data-levelrek='2' data-namarek='".$val->nmrekening5."' data-tiperekening='".$val->tiperekening_id."'  data-parentid='".$value_id."' kode_rek='". $value_kode ."' parentkode_rek='". $val->kdrekening5."' href='#' onclick='tambahObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Unsur'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this,\"".$kel->saldonormal."\");return false;' kode_rek='". $value_kode ."' rel='tooltip' data-original-title='Klik untuk edit Komponen'><i class='icon-pencil-brown'></i></a></span></span></li>";
                    }
                }

            }
        ?>
        <span class="folder">
            Struktur Akun
            <span style="float:right"><a max_kode = "<?php echo isset($val->kdrekening5) ? $val->kdrekening5 : null; ?>" href="#" data-levelrek="1" onclick="tambahObyekDetailRekening(this);return false;" rel="tooltip" data-original-title="Klik untuk menambah Komponen"><i class="icon-plus-sign"></i></a></span>
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
