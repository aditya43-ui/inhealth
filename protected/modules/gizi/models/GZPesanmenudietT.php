<?php

class GZPesanmenudietT extends PesanmenudietT
{

    public $kelaspelayanan_id, $ruangan_id, $pasienadmisi_id;
    public $carabayar_id, $penjamin_id;
    public $temp_no, $jenismakanan_id;
    public $disabled;
    public $ruangantampil;
    public $instalasitampil;
    public $jeniskelamin, $noidentitas, $pegawai_id, $nama_pegawai, $no_rekam_medik, $no_pendaftaran, $pendaftaran_id, $nama_pasien;
    public $jeniswaktu_nama, $jeniswaktu_id, $tanggal_lahir, $umur, $statusperiksa;
    public $warna, $jumlah;
    public $kamarruangan_nokamar;
    public $kamarruangan_nobed, $menudiet_id, $jenis_waktu_combined, $ruangan_nama, $kelaspelayanan_nama;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getNamaModel()
    {
        return __CLASS__;
    }

    public static function jenisPesan()
    {
        $result = array();
        foreach (LookupM::getItems('jenispesanmenu') as $i => $value) {
            if ($i != Params::JENISPESANMENU_PASIEN) {
                $result[$i] = $value;
            }
        }
        return $result;
    }

    public function searchSuratPemberianMakanan()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "pasienadmisi_t.kelaspelayanan_id, pasien.nama_pasien, pasien.no_rekam_medik, t.*, r.kamarruangan_nokamar, r.kamarruangan_nobed,pasienadmisi_t.pasienadmisi_id, pasien.tanggal_lahir, pasienpeg.pendaftaran_id, STRING_AGG(pasienpeg.jeniswaktu_id::text, '" . ',' ."') AS jenis_waktu_combined";
        $criteria->join = " JOIN pesanmenudetail_t as pasienpeg ON pasienpeg.pesanmenudiet_id = t.pesanmenudiet_id JOIN pasienadmisi_t on pasienpeg.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id JOIN pasien_m as pasien on pasienpeg.pasien_id = pasien.pasien_id JOIN kamarruangan_m r ON r.kamarruangan_id = pasienadmisi_t.kamarruangan_id";
        $criteria->addCondition('pasienadmisi_t.pasienpulang_id IS NULL');
        $criteria->group = 't.pesanmenudiet_id, pasien.nama_pasien, pasien.no_rekam_medik, r.kamarruangan_nokamar, r.kamarruangan_nobed,pasienadmisi_t.pasienadmisi_id, pasien.tanggal_lahir, pasienpeg.pendaftaran_id, pasienadmisi_t.kelaspelayanan_id';

        $criteria->addBetweenCondition('DATE(tglpesanmenu)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('t.ruangan_id = ' . $this->ruangan_id);
        }
        if(!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('pasienadmisi_t.kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(jenispesanmenu)', strtolower("Pasien"), true);
        $criteria->compare('LOWER(nopesanmenu)', strtolower($this->nopesanmenu), true);
        $criteria->compare('LOWER(adaalergimakanan)', strtolower($this->adaalergimakanan), true);
        $criteria->compare('LOWER(keterangan_pesan)', strtolower($this->keterangan_pesan), true);
        $criteria->compare('LOWER(nama_pemesan)', strtolower($this->nama_pemesan), true);
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('totalpesan_org', $this->totalpesan_org);
        if (!empty($this->status_terima)) {
            if ($this->status_terima == '1') {
                $criteria->addCondition(" status_terima IS TRUE ");
            } elseif ($this->status_terima == '2') {
                $criteria->addCondition(" status_terima IS FALSE ");
            }
        }
        $criteria->order = 'r.kamarruangan_nokamar, r.kamarruangan_nobed asc';
        // echo '<pre>';var_dump($criteria);die;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchInformasi()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('DATE(tglpesanmenu)', $this->tgl_awal, $this->tgl_akhir);
        //$criteria->addCondition('kirimmenudiet_id is null');
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(jenispesanmenu)', strtolower("Pegawai"), true);
        $criteria->compare('LOWER(nopesanmenu)', strtolower($this->nopesanmenu), true);
        $criteria->compare('LOWER(adaalergimakanan)', strtolower($this->adaalergimakanan), true);
        $criteria->compare('LOWER(keterangan_pesan)', strtolower($this->keterangan_pesan), true);
        $criteria->compare('LOWER(nama_pemesan)', strtolower($this->nama_pemesan), true);
        $criteria->compare('totalpesan_org', $this->totalpesan_org);
        //  var_dump($this->status_terima);
        if (!empty($this->status_terima)) {
            if ($this->status_terima == '1') {
                $criteria->addCondition(" status_terima IS TRUE ");
            } elseif ($this->status_terima == '2') {
                var_dump($this->status_terima);
                $criteria->addCondition(" status_terima IS FALSE ");
            }
        }
        $criteria->order = 'tglpesanmenu ASC';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchInformasiPendamping()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('DATE(tglpesanmenu)', $this->tgl_awal, $this->tgl_akhir);
        //$criteria->addCondition('kirimmenudiet_id is null');
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(jenispesanmenu)', strtolower("Pendamping"), true);
        //		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
        $criteria->compare('LOWER(nopesanmenu)', strtolower($this->nopesanmenu), true);
        $criteria->compare('LOWER(adaalergimakanan)', strtolower($this->adaalergimakanan), true);
        $criteria->compare('LOWER(keterangan_pesan)', strtolower($this->keterangan_pesan), true);
        $criteria->compare('LOWER(nama_pemesan)', strtolower($this->nama_pemesan), true);
        $criteria->compare('totalpesan_org', $this->totalpesan_org);
        //  var_dump($this->status_terima);
        if (!empty($this->status_terima)) {
            if ($this->status_terima == '1') {
                $criteria->addCondition(" status_terima IS TRUE ");
            } elseif ($this->status_terima == '2') {
                var_dump($this->status_terima);
                $criteria->addCondition(" status_terima IS FALSE ");
            }
        }
        $criteria->order = 'tglpesanmenu DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchInformasiPasien()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('DATE(tglpesanmenu)', $this->tgl_awal, $this->tgl_akhir);
        //$criteria->addCondition('kirimmenudiet_id is null');
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(jenispesanmenu)', strtolower("Pasien"), true);
        //		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
        $criteria->compare('LOWER(nopesanmenu)', strtolower($this->nopesanmenu), true);
        $criteria->compare('LOWER(adaalergimakanan)', strtolower($this->adaalergimakanan), true);
        $criteria->compare('LOWER(keterangan_pesan)', strtolower($this->keterangan_pesan), true);
        $criteria->compare('LOWER(nama_pemesan)', strtolower($this->nama_pemesan), true);
        $criteria->compare('totalpesan_org', $this->totalpesan_org);
        //  var_dump($this->status_terima);
        if (!empty($this->status_terima)) {
            if ($this->status_terima == '1') {
                $criteria->addCondition(" status_terima IS TRUE ");
            } elseif ($this->status_terima == '2') {
                var_dump($this->status_terima);
                $criteria->addCondition(" status_terima IS FALSE ");
            }
        }

        // if (empty($this->pesanmenudiet_id)) {
        //     # code...
        //     // $criteria->addCondition("pesanmenudiet_id")
        // }
        $criteria->order = 'tglpesanmenu DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchInformasiMenuPasienPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 'pasien.nama_pasien, pasien.no_rekam_medik, t.*, r.kamarruangan_nokamar, r.kamarruangan_nobed,pasienadmisi_t.pasienadmisi_id';
        $criteria->join = " JOIN pesanmenudetail_t as pasienpeg ON pasienpeg.pesanmenudiet_id = t.pesanmenudiet_id JOIN pasienadmisi_t on pasienpeg.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id JOIN pasien_m as pasien on pasienpeg.pasien_id = pasien.pasien_id JOIN kamarruangan_m r ON r.kamarruangan_id = pasienadmisi_t.kamarruangan_id";
        $criteria->addCondition('pasienadmisi_t.pasienpulang_id IS NULL');
        $criteria->group = 't.pesanmenudiet_id, pasien.nama_pasien, pasien.no_rekam_medik, r.kamarruangan_nokamar, r.kamarruangan_nobed,pasienadmisi_t.pasienadmisi_id';

        $criteria->addBetweenCondition('DATE(tglpesanmenu)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('t.ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(jenispesanmenu)', strtolower("Pasien"), true);
        $criteria->compare('LOWER(nopesanmenu)', strtolower($this->nopesanmenu), true);
        $criteria->compare('LOWER(adaalergimakanan)', strtolower($this->adaalergimakanan), true);
        $criteria->compare('LOWER(keterangan_pesan)', strtolower($this->keterangan_pesan), true);
        $criteria->compare('LOWER(nama_pemesan)', strtolower($this->nama_pemesan), true);
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('totalpesan_org', $this->totalpesan_org);
        if (!empty($this->status_terima)) {
            if ($this->status_terima == '1') {
                $criteria->addCondition(" status_terima IS TRUE ");
            } elseif ($this->status_terima == '2') {
                $criteria->addCondition(" status_terima IS FALSE ");
            }
        }
        $criteria->order = 'r.kamarruangan_nokamar, r.kamarruangan_nobed asc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    public function searchInformasiMenuPasienPrintModel()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 'pasien.nama_pasien, pasien.no_rekam_medik, t.*, r.kamarruangan_nokamar, r.kamarruangan_nobed,pasienadmisi_t.pasienadmisi_id, pasien.tanggal_lahir, pasienpeg.pendaftaran_id';
        $criteria->join = " JOIN pesanmenudetail_t as pasienpeg ON pasienpeg.pesanmenudiet_id = t.pesanmenudiet_id JOIN pasienadmisi_t on pasienpeg.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id JOIN pasien_m as pasien on pasienpeg.pasien_id = pasien.pasien_id JOIN kamarruangan_m r ON r.kamarruangan_id = pasienadmisi_t.kamarruangan_id";
        $criteria->addCondition('pasienadmisi_t.pasienpulang_id IS NULL');
        $criteria->group = 't.pesanmenudiet_id, pasien.nama_pasien, pasien.no_rekam_medik, r.kamarruangan_nokamar, r.kamarruangan_nobed,pasienadmisi_t.pasienadmisi_id, pasien.tanggal_lahir, pasienpeg.pendaftaran_id';

        $criteria->addBetweenCondition('DATE(tglpesanmenu)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('kamarruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(jenispesanmenu)', strtolower("Pasien"), true);
        $criteria->compare('LOWER(nopesanmenu)', strtolower($this->nopesanmenu), true);
        $criteria->compare('LOWER(adaalergimakanan)', strtolower($this->adaalergimakanan), true);
        $criteria->compare('LOWER(keterangan_pesan)', strtolower($this->keterangan_pesan), true);
        $criteria->compare('LOWER(nama_pemesan)', strtolower($this->nama_pemesan), true);
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('totalpesan_org', $this->totalpesan_org);
        if (!empty($this->status_terima)) {
            if ($this->status_terima == '1') {
                $criteria->addCondition(" status_terima IS TRUE ");
            } elseif ($this->status_terima == '2') {
                $criteria->addCondition(" status_terima IS FALSE ");
            }
        }
        $criteria->order = 'r.kamarruangan_nokamar, r.kamarruangan_nobed asc';

        return self::model()->findAll($criteria);
    }

    /**
     * Mengambil daftar semua kelaspelayanan
     * @return CActiveDataProvider 
     */
    public function getKelasPelayananItems($ruangan_id = null)
    {
        if ($ruangan_id == '') {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        $criteria = new CdbCriteria();
        if (Yii::app()->controller->module->id != 'gizi') {
            $criteria->addCondition('kelasruangan_m.ruangan_id = ' . $ruangan_id);
            $criteria->join = "JOIN kelasruangan_m ON t.kelaspelayanan_id = kelasruangan_m.kelaspelayanan_id";
        }

        $criteria->addCondition('t.kelaspelayanan_aktif = true');
        $criteria->order = "t.urutankelas";
        return KelaspelayananM::model()->findAll($criteria);
    }

    /**
     * Mengambil daftar semua carabayar
     * @return CActiveDataProvider 
     */
    public function getCaraBayarItems()
    {
        return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif' => true), array('order' => 'carabayar_nourut'));
    }

    /**
     * Mengambil daftar semua penjamin
     * @return CActiveDataProvider 
     */
    public function getPenjaminItems($carabayar_id = null)
    {
        if (!empty($carabayar_id)) {
            return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama'));
        } else {
            return array();
        }
    }

    public function getRuanganItems($instalasi_id = null)
    {
        if (!empty($instalasi_id)) {
            return RuanganM::model()->findAllByAttributes(array('instalasi_id' => $instalasi_id, 'ruangan_aktif' => true), array('order' => 'ruangan_nama'));
        } else {
            return RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true), array('order' => 'ruangan_nama'));
        }
    }

    /**
     * menampilkan instalasi untuk pesan menu diet pasien
     * @return array
     */
    public function getInstalasiItems()
    {

        $criteria = new CDbCriteria();
        if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) {
            $criteria->addInCondition(
                'instalasi_id',
                Params::grupInstalasiRIID()
            );
        } else {
            $criteria->addInCondition(
                'instalasi_id',
                array(
                    Yii::app()->user->getState('instalasi_id')
                )
            );
        }

        $criteria->addCondition('instalasi_aktif = true');
        $criteria->order = "instalasi_nama ASC";
        $modInstalasis = InstalasiM::model()->findAll($criteria);
        if (count((array) $modInstalasis) > 0)
            return $modInstalasis;
        else
            return array();
    }

    public function searchInformasiPegawai()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->select = "t.status_terima, t.pesanmenudiet_id, t.tglpesanmenu, t.nopesanmenu, t.ruangan_id,t.nama_pemesan, peg.nama_pegawai, peg.jeniskelamin, peg.noidentitas, peg.pegawai_id,t.jenispesanmenu";
        $criteria->group = "t.status_terima, t.pesanmenudiet_id, t.tglpesanmenu, t.nopesanmenu, t.ruangan_id, t.nama_pemesan,peg.nama_pegawai, peg.jeniskelamin, peg.noidentitas, peg.pegawai_id,t.jenispesanmenu";
        $criteria->join = "JOIN pesanmenupegawai_t as pesanpeg ON pesanpeg.pesanmenudiet_id = t.pesanmenudiet_id"
            . " JOIN pegawai_m as peg ON peg.pegawai_id = pesanpeg.pegawai_id";

        $criteria->addBetweenCondition('DATE(t.tglpesanmenu)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(t.jenispesanmenu)', strtolower("Pegawai"), true);
        $criteria->compare('LOWER(t.nopesanmenu)', strtolower($this->nopesanmenu), true);
        $criteria->compare('LOWER(t.adaalergimakanan)', strtolower($this->adaalergimakanan), true);
        $criteria->compare('LOWER(t.keterangan_pesan)', strtolower($this->keterangan_pesan), true);
        $criteria->compare('LOWER(t.nama_pemesan)', strtolower($this->nama_pemesan), true);
        //		$criteria->compare('t.totalpesan_org',$this->totalpesan_org);

        if (!empty($this->status_terima)) {
            if ($this->status_terima == '1') {
                $criteria->addCondition(" t.status_terima IS TRUE ");
            } elseif ($this->status_terima == '2') {
                var_dump($this->status_terima);
                $criteria->addCondition(" t.status_terima IS FALSE ");
            }
        }

        //$criteria->addCondition('kirimmenudiet_id is null');
        //		if(!empty($this->ruangan_id)){
        //			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
        //		}
        //                $criteria->compare('LOWER(jenispesanmenu)',strtolower("Pegawai"),true);
        //		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
        //		$criteria->compare('LOWER(nopesanmenu)',strtolower($this->nopesanmenu),true);
        //		$criteria->compare('LOWER(adaalergimakanan)',strtolower($this->adaalergimakanan),true);
        //		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
        //		$criteria->compare('LOWER(nama_pemesan)',strtolower($this->nama_pemesan),true);
        //		$criteria->compare('totalpesan_org',$this->totalpesan_org);
        //  var_dump($this->status_terima);
        //                if (!empty($this->status_terima)){
        //                    if ($this->status_terima == '1'){                        
        //                        $criteria->addCondition(" status_terima IS TRUE ");
        //                    }elseif ($this->status_terima == '2'){
        //                        var_dump($this->status_terima);
        //                        $criteria->addCondition(" status_terima IS FALSE ");
        //                    }
        //                }
        $criteria->order = 't.tglpesanmenu DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getMenuDiet($pesanmenudiet_id, $pegawai_id, $jeniswaktu_id, $typemenu)
    {
        $data = "";
        if ($typemenu == Params::JENISPESANMENU_PEGAWAI) {
            $pesanmenu = PesanmenupegawaiT::model()->findByAttributes(array('pesanmenudiet_id' => $pesanmenudiet_id, 'pegawai_id' => $pegawai_id, 'jeniswaktu_id' => $jeniswaktu_id));
        } else if ($typemenu == Params::JENISPESANMENU_PASIEN) {
            $pesanmenu = PesanmenudetailT::model()->findByAttributes(array('pesanmenudiet_id' => $pesanmenudiet_id, 'pendaftaran_id' => $pegawai_id, 'jeniswaktu_id' => $jeniswaktu_id));
        }
        if (isset($pesanmenu)) {
            $menudiet = MenuDietM::model()->findByAttributes(array('menudiet_id' => $pesanmenu->menudiet_id));
            $data = isset($menudiet) ? $menudiet->menudiet_nama : "";
        }
        return $data;
    }

    public function searchInformasiMenuPasien()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->select = "pasien.nama_pasien, pasien.no_rekam_medik, t.*,pasienadmisi_t.pasienadmisi_id";
        $criteria->join = "JOIN pesanmenudetail_t as pasienpeg ON pasienpeg.pesanmenudiet_id = t.pesanmenudiet_id JOIN pasienadmisi_t on pasienpeg.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id JOIN pasien_m as pasien on pasienpeg.pasien_id = pasien.pasien_id JOIN kamarruangan_m on pasienadmisi_t.kamarruangan_id = kamarruangan_m.kamarruangan_id JOIN ruangan_m on ruangan_m.ruangan_id = pasienadmisi_t.ruangan_id";
        $criteria->addCondition('pasienadmisi_t.pasienpulang_id IS NULL');
        $criteria->group = 't.pesanmenudiet_id, pasien.nama_pasien, pasien.no_rekam_medik,pasienadmisi_t.pasienadmisi_id, pasienadmisi_t.kamarruangan_id,kamarruangan_m.kamarruangan_nobed,kamarruangan_m.kamarruangan_nokamar,ruangan_m.ruangan_nama';
        // $criteria->group='pasienadmisi_t.kamarruangan_id,pasien.nama_pasien';
        $criteria->addBetweenCondition('DATE(t.tglpesanmenu)', $this->tgl_awal, $this->tgl_akhir);
        //$criteria->addCondition('kirimmenudiet_id is null');
        if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_GIZI) {
            // semua ruangan muncul kecuali ada filter
            if (!empty($this->ruangan_id)) {
                $criteria->addCondition('t.ruangan_id = ' . $this->ruangan_id);
            }
            if (!empty($this->instalasi_id)) {
                $criteria->addCondition('ruangan_m.instalasi_id = ' . $this->instalasi_id);
            }
        } else {
            // jika login selain modul gizi maka sesuai dengan ruangan login
            $criteria->addCondition('t.ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        }
        $criteria->compare('LOWER(t.jenispesanmenu)', strtolower("Pasien"), true);
        //		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
        $criteria->compare('LOWER(t.nopesanmenu)', strtolower($this->nopesanmenu), true);
        $criteria->compare('LOWER(t.adaalergimakanan)', strtolower($this->adaalergimakanan), true);
        $criteria->compare('LOWER(t.keterangan_pesan)', strtolower($this->keterangan_pesan), true);
        $criteria->compare('LOWER(t.nama_pemesan)', strtolower($this->nama_pemesan), true);
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        //		$criteria->compare('totalpesan_org',$this->totalpesan_org);
        if (!empty($this->status_terima)) {
            if ($this->status_terima == '1') {
                $criteria->addCondition(" t.status_terima IS TRUE ");
            } elseif ($this->status_terima == '2') {
                var_dump($this->status_terima);
                $criteria->addCondition(" t.status_terima IS FALSE ");
            }
        }

        // 30 bed 2 // $criteria->order = 't.tglpesanmenu DESC';

        $criteria->order = 't.tglpesanmenu DESC';
        // $criteria->order = 'DATE(t.tglpesanmenu) DESC,ruangan_m.ruangan_nama ASC, kamarruangan_m.kamarruangan_nokamar ASC,kamarruangan_nobed ASC';

        // echo "<pre>";
        // var_dump($criteria);
        // die;

        // $criteria->order = 't.tglpesanmenu DESC ,t.ruangan_id  DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false
        ));
    }

    public function getJumlahPorsiSatuan($pesanmenudiet_id, $pendaftaran_id, $type, $typemenu)
    {
        $data = "";
        // if ($type == 'jumlah') {
        //     $jml = 'jml_pesan_porsi';
        // } else if ($type == 'satuan') {
        //     $jml = 'satuanjml_urt';
        // }

        // if ($typemenu == Params::JENISPESANMENU_PASIEN) {
        //     $pesanmenu = PesanmenudetailT::model()->findByAttributes(array('pesanmenudiet_id' => $pesanmenudiet_id));
        //     $criteria = new CDbCriteria;
        //     $criteria->compare('pesanmenudiet_id', $pesanmenudiet_id);
        //     $criteria->select = 'sum(' . $jml . ') as jml_pesan_porsi';
        //     $pesanmenu = PesanmenudetailT::model()->find($criteria);

        //     $data = $pesanmenu->jml_pesan_porsi;
        // }

        return $data;
    }

    public function searchInformasiPendampingPrint()
    {
        $prov = $this->searchInformasiPendamping();
        $prov->pagination = false;
        return $prov;
    }

    public static function getRencanaPulang($pesanmenudiet_id)
    {
        $modPesan = PesanmenudietT::model()->findByPk($pesanmenudiet_id);
        $modDet = PesanmenudetailT::model()->findAllByAttributes(['pesanmenudiet_id' => $modPesan->pesanmenudiet_id]);

        $hitung = 0;
        if (!empty($modDet)) {
            foreach ($modDet as  $key => $det) {
                $modAdmisi = PasienadmisiT::model()->findByAttributes(['pendaftaran_id' => $det['pendaftaran_id']]);

                if (!empty($modAdmisi->rencanapulang)) {
                    $hitung++;
                }
            }
        }

        $data = array();

        $data['jumlah_rencana'] = $hitung;

        return $data;
    }

    public static function getWarnaCreate($pesanmenudiet_id)
    {
        $data = [];
        $model = PesanmenudietT::model()->findByPk($pesanmenudiet_id);

        $konfig = KonfigsystemK::model()->find();
        $create_time = MyFormatter::formatDateTimeForDb($model->create_time);
        $est_warnapesandiet = '+' . $konfig->est_warnapesandiet . ' hours';
        $tgl_batas = date('Y-m-d H:i:s', strtotime($est_warnapesandiet, strtotime($create_time)));

        $data['warna'] = (date('Y-m-d H:i:s') < $tgl_batas) ? '#FFDEAD' : '';

        return $data;
    }

    public static function getWarnaUpdate($pesanmenudiet_id)
    {
        $data = [];
        $model = PesanmenudietT::model()->findByPk($pesanmenudiet_id);

        $konfig = KonfigsystemK::model()->find();
        $update_time = MyFormatter::formatDateTimeForDb($model->update_time);
        $est_warnapesandiet = '+' . $konfig->est_warnapesandiet . ' hours';
        $tgl_batas = date('Y-m-d H:i:s', strtotime($est_warnapesandiet, strtotime($update_time)));

        $data['warna'] = (date('Y-m-d H:i:s') < $tgl_batas) ? '#6495ED' : '';

        return $data;
    }
}
