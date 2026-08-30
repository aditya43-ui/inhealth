<?php

/**
 * This is the model class for table "infokunjunganrd_v".
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'infokunjunganrd_v':
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperiksa
 * @property string $statusmasuk
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $alamat_pasien
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $rujukan_id
 */
class HDInfoKunjunganRDV extends InfokunjunganhdV {

    public $ceklis = false;
    public $tgl_awal, $tgl_akhir;
    public $tgl_awall, $tgl_akhirl;
    public $statusBayar, $tglhasilpemeriksaanlab, $pegawai_id, $pemeriksaanlab_nama,
            $hasilpemeriksaan, $nilairujukan, $hasilpemeriksaan_satuan, $namapemeriksaandet;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InfokunjunganrdV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchHD() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        // $criteria->join = 'JOIN konsulpoli_t kt ON kt.pendaftaran_id = t.pendaftaran_id';
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(carakeluar)', strtolower($this->carakeluar), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        // $criteria->addCondition("kt.is_verifikasi_hd = true");

        if (!empty($this->propinsi_id)) {
            $criteria->addCondition("propinsi_id = " . $this->propinsi_id);
        }
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        if (!empty($this->kabupaten_id)) {
            $criteria->addCondition("kabupaten_id = " . $this->kabupaten_id);
        }
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        if (!empty($this->kecamatan_id)) {
            $criteria->addCondition("kecamatan_id = " . $this->kecamatan_id);
        }
        if (!empty($this->status_hd)) {
            $criteria->addCondition("status_hd = '" . $this->status_hd . "' ");
        }

        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        }
            
        /*
        if ($this->ceklis && $this->ceklis == 1) {
            $criteria->addBetweenCondition('DATE(tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
        } else {
            $criteria->addBetweenCondition('DATE(tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
        }
        */

        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        if (!empty($this->kelurahan_id)) {
            $criteria->addCondition("kelurahan_id = " . $this->kelurahan_id);
        }
        if (!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $this->instalasi_id);
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if (!empty($this->carabayar_id)) {
            $criteria->addCondition("carabayar_id = " . $this->carabayar_id);
        }
        if (!empty($this->pegawai_id)) {
            $criteria->addCondition("pegawai_id = " . $this->pegawai_id);
        }
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if (!empty($this->penjamin_id)) {
            $criteria->addCondition("penjamin_id = " . $this->penjamin_id);
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        if (!empty($this->rujukan_id)) {
            $criteria->addCondition("rujukan_id = " . $this->rujukan_id);
        }
        if (!empty($this->shift_id)) {
            $criteria->addCondition("shift_id = " . $this->shift_id);
        }
        $criteria->addCondition('t.ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        $criteria->addCondition("carakeluar_id != " . PARAMS::CARAKELUAR_ID_MENINGGAL . " OR carakeluar_id is NULL");
//		$criteria->order = 'tgl_pendaftaran DESC';
        if (!isset($_GET[get_class($this) . "_sort"])) { //jika tidak diklik sorting dari header table
            $criteria->order = 't.no_urutantri ASC';
        }
        $criteria->addCondition('t.pasienmasukpenunjang_id is not null');

        // var_dump($criteria); die;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDialogKunjungan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $format = new MyFormatter();
//		$this->tgl_pendaftaran = empty($this->tgl_pendaftaran) ? date("Y-m-d") : $format->formatDateTimeForDb($this->tgl_pendaftaran); //filter grid
//		$criteria->addBetweenCondition("DATE(tgl_pendaftaran)",$this->tgl_pendaftaran." 00:00:00",$this->tgl_pendaftaran." 23:59:59");
        if (isset($this->tgl_pendaftaran)) {
            $tgl_pendaftaran = $this->tgl_pendaftaran;
            $Tgl1 = (explode(" - ", $tgl_pendaftaran));

            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl1[0] = DateTime::createFromFormat('m/d/Y', $Tgl1[0]);
            $Tgl1[0] = $Tgl1[0]->format('Y-m-d');
            $Tgl1[1] = DateTime::createFromFormat('m/d/Y', $Tgl1[1]);
            $Tgl1[1] = $Tgl1[1]->format('Y-m-d');

            $criteria->addCondition("DATE(tgl_pendaftaran) BETWEEN '" . $Tgl1[0] . "' AND '" . $Tgl1[1] . "'");
        }
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(carakeluar)', strtolower($this->carakeluar), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        if (!empty($this->propinsi_id)) {
            $criteria->addCondition("propinsi_id = " . $this->propinsi_id);
        }
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        if (!empty($this->kabupaten_id)) {
            $criteria->addCondition("kabupaten_id = " . $this->kabupaten_id);
        }
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        if (!empty($this->kecamatan_id)) {
            $criteria->addCondition("kecamatan_id = " . $this->kecamatan_id);
        }
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        if (!empty($this->kelurahan_id)) {
            $criteria->addCondition("kelurahan_id = " . $this->kelurahan_id);
        }
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $this->instalasi_id);
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if (!empty($this->carabayar_id)) {
            $criteria->addCondition("carabayar_id = " . $this->carabayar_id);
        }
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if (!empty($this->penjamin_id)) {
            $criteria->addCondition("penjamin_id = " . $this->penjamin_id);
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        if (!empty($this->rujukan_id)) {
            $criteria->addCondition("rujukan_id = " . $this->rujukan_id);
        }
        $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
//		$criteria->limit = 5;
//		$this->tgl_pendaftaran = $format->formatDateTimeForUser($this->tgl_pendaftaran);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
//			'pagination'=>false,
        ));
    }

    /**
     * menambah kondisi setalah pencarian
     * @return boolean
     */
    protected function afterFind() {
        foreach ($this->metadata->tableSchema->columns as $columnName => $column) {

            if (!strlen($this->$columnName))
                continue;

            if ($column->dbType == 'date') {
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'), 'medium', null);
            } elseif ($column->dbType == 'timestamp without time zone') {
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
            }
        }
        return true;
    }

    /**
     * digunakan untuk mendapatkan nama pasien nama bin
     */
    function getNamaPasienNamaBin() {
        return $this->nama_pasien . ' bin ' . $this->nama_bin;
    }

    /**
     * digunakan untuk mendapatkan instalasi ruangan
     * @return type string
     */
    public function getInsatalasiRuangan() {

        return $this->instalasi_nama . ' / ' . $this->ruangan_nama;
    }

//        public function getStatus($status,$id){
//            if($status == Params::STATUSPERIKSA_ANTRIAN){
//                $status = '<button id="red" class="btn btn-primary" name="yt1">'.$status.'</button>';
//
//            }else if($status == Params::STATUSPERIKSA_SEDANG_PERIKSA){
//				
//				//RSKG-264
//				$modDiagnosaNotif = HDPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$id));
//				$modAnamnesaNotif = HDAnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$id));
//				$modTindakanNotif = HDTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id'=>$id));
////				$modResepNotif = HDResepturT::model()->findByAttributes(array('pendaftaran_id'=>$id));
//				if(empty($modDiagnosaNotif)){
//					$status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setWarningStatus(\'Diagnosis Pemeriksaan\')">'.$status.'</button>';
//				}elseif(empty($modAnamnesaNotif)){
//					$status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setWarningStatus(\'Anamnesis Pemeriksaan\')">'.$status.'</button>';
//				}elseif(empty($modTindakanNotif)){
//					$status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setWarningStatus(\'Tindakan Pemeriksaan\')">'.$status.'</button>';
//				}
////dicomment karena RSKG-289
////				elseif(COUNT($modResepNotif) < 1){
////					$status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setWarningStatus(\'Reseptur Pemeriksaan\')">'.$status.'</button>';
////				}
//				else{
//					$status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
//				}
//				
//            }else if($status == Params::STATUSPERIKSA_SUDAH_PULANG){
//                $status = '<button id="blue" class="btn btn-danger-yellow" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
//            }else if($status == Params::STATUSPERIKSA_SUDAH_DIPERIKSA){
//                $status = '<button id="red" class="btn btn-danger-red" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
//            }else{
//                $status = '<button id="orange" class="btn btn-danger-blue"  name="yt1">'.$status.'</button>';
//            }
//            return $status;
//        }

    /**
     * digunakan untuk mendapatkan tindak lanjut RI
     * @param type integer $instalasi_id
     * @param type integer $pendaftaran_id
     * @return string
     */
    public function getTindakLanjutRI($instalasi_id, $pendaftaran_id) {
        //RSKG-264
        $modDiagnosaNotif = HDPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modAnamnesaNotif = HDAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modTindakanNotif = HDTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        if (empty($modDiagnosaNotif)) {
            $status = '<i class=\'icon-form-ri\' onclick="setWarningStatus(\'Diagnosis Pemeriksaan\')"></i>';
        } elseif (empty($modAnamnesaNotif)) {
            $status = '<i class=\'icon-form-ri\' onclick="setWarningStatus(\'Anamnesis Pemeriksaan\')"></i>';
        } elseif (empty($modTindakanNotif)) {
            $status = '<i class=\'icon-form-ri\' onclick="setWarningStatus(\'Tindakan Pemeriksaan\')"></i>';
        } else {
            $status = '<a href="index.php?r=hemodialisa/TindakLanjutDariHD/tindakLanjutRI&pendaftaran_id=' . $pendaftaran_id . '&instalasi_id=' . $instalasi_id . '" rel=\"tooltip" 
                                onclick="$(\'#dialogTindakLanjut\').dialog(\'open\');" target="frameTindakLanjut" 
                                    data-original-title="Klik untuk Proses Tindak Lanjut Pasien"><i class="icon-form-ri"></i></a>';
        }
        return $status;
    }

    public function getTindakLanjutRINew($instalasi_id, $pendaftaran_id) {
        $modDiagnosaNotif = HDPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modTindakanNotif = HDTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        if (empty($modDiagnosaNotif)) {
            $status = '<i class=\'icon-form-ri\' onclick="setWarningStatus(\'Diagnosis Pemeriksaan\')"></i>';
        } elseif (empty($modTindakanNotif)) {
            $status = '<i class=\'icon-form-ri\' onclick="setWarningStatus(\'Tindakan Pemeriksaan\')"></i>';
        } else {
            $status = '<a href="index.php?r=hemodialisa/TindakLanjutDariHD/tindakLanjutRI&pendaftaran_id=' . $pendaftaran_id . '&instalasi_id=' . $instalasi_id . '" rel=\"tooltip" 
                                onclick="$(\'#dialogTindakLanjut\').dialog(\'open\');" target="frameTindakLanjut" 
                                    data-original-title="Klik untuk Proses Tindak Lanjut Pasien"><i class="icon-form-ri"></i></a>';
        }
        return $status;
    }

    /**
     * 
     * @param type string $status
     * @param type integer $id
     * @param type string $bayar
     * @param type string $nopen
     * @param type boolean $alih
     * @return string
     */
    public function getPeriksaPasien($status, $id, $bayar, $nopen, $alih) {
        if ($bayar != null) {
            $status = '<center><a id=' . $nopen . ' href="#"  onclick="cekStatus(\'' . $status . '\')" rel="tooltip" 
                            data-original-title="Klik untuk Pemeriksaan Pasien"><i class="icon-list-alt"></i></a></center>';
        } else {
            if ($status == "ANTRIAN") {
                $status = "<center><a id=" . $nopen . " href=\"index.php?r=hemodialisa/anamnesaTHD&pendaftaran_id=" . $id . "\" rel=\"tooltip\" data-original-title=\"Klik untuk Pemeriksaan Pasien\">
                            <i class=\"icon-list-alt\"></i>
                            </a></center>";
            } else if ($status == "SEDANG PERIKSA") {
                $status = "<center><a id=" . $nopen . " href=\"index.php?r=hemodialisa/anamnesaTHD&pendaftaran_id=" . $id . "\" rel=\"tooltip\" data-original-title=\"Klik untuk Pemeriksaan Pasien\">
                            <i class=\"icon-list-alt\"></i>
                            </a></center>";
            } else if ($status == "BATAL PERIKSA" || $status == "DIBATALKAN" || $status == "SEDANG DIRAWAT INAP" || $alih == true || $status == "SUDAH PULANG") {
                $status = '<center><a id=' . $nopen . ' href="#"  onclick="cekStatus(\'' . $status . '\')" rel="tooltip" 
                                data-original-title="Klik untuk Pemeriksaan Pasien"><i class="icon-list-alt"></i></a></center>';
            } else {
                $status = "<center><a id=" . $nopen . " href=\"index.php?r=hemodialisa/anamnesaTHD&pendaftaran_id=" . $id . "\" rel=\"tooltip\" data-original-title=\"Klik untuk Pemeriksaan Pasien\">
                            <i class=\"icon-list-alt\"></i>
                            </a></center>";
            }
        }

        return $status;
    }

    /**
     * digunakan untuk tindak lanjut
     * @param type string $status
     * @param type integer $id
     * @param type string $nopen
     * @param type model $pasienpulang
     * @param type string $carakeluar
     * @param type  boolean $alih
     * @return string
     */
    public function getTindakLanjut($status, $id, $nopen, $pasienpulang, $carakeluar, $alih) {
        if ($status == "ANTRIAN" || $status == "BATAL PERIKSA" || $status == "DIBATALKAN" || $status == "SEDANG DIRAWAT INAP") {
            $status = '<center><a href="#"  onclick="cekStatus(\'' . $status . '\')"
                                     rel="tooltip" data-original-title="Klik Untuk Menindak Lanjuti Pasien"><i class="icon-pencil"></i></a></center>';
        } else if ($status == "SEDANG PERIKSA" || $status == "SUDAH PULANG") {
            $status = '<center><a href="index.php?r=hemodialisa/daftarPasien/PasienPulang&pendaftaran_id=' . $id . '&dialog=1" 
                                 onclick="$(\'#dialogPasienPulang\').dialog(\'open\');" target="iframePasienPulang" 
                                     rel="tooltip" data-original-title="Klik Untuk Menindak Lanjuti Pasien"><i class="icon-pencil"></i></a></center>';
        } else if (!empty($pasienpulang) && ($carakeluar == "DIRAWAT INAP") OR ( $carakeluar == "DIPULANGKAN") OR ( $carakeluar == "DIRUJUK")) {
            $status = '<center>' . $carakeluar . '<br>
                            <a href="index.php?r=hemodialisa/daftarPasien/BatalRawatInap&pendaftaran_id=' . $id . '" rel=\"tooltip" 
                                onclick="$(\'#dialogBatalRawatInap\').dialog(\'open\');" target="iframeBatalRawatInap" 
                                    data-original-title="Klik Untuk Batal ' . $carakeluar . '"><i class="icon-remove"></i></a></center>';
        } else {
            $status = '<center><a href="index.php?r=hemodialisa/daftarPasien/PasienPulang&pendaftaran_id=' . $id . '&dialog=1" 
                                 onclick="$(\'#dialogPasienPulang\').dialog(\'open\');" target="iframePasienPulang" 
                                     rel="tooltip" data-original-title="Klik Untuk Menindak Lanjuti Pasien"><i class="icon-pencil"></i></a></center>';
        }
        return $status;
    }

    /**
     * digunakan untuk mendapatkan nama kamar
     * @return type string 
     */
    public function getNamaKamar() {
        $modMasukKamar = PasienadmisiT::model()->findByAttributes(array('pasienadmisi_id' => $this->pasienadmisi_id));
        $modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id' => $modMasukKamar['ruangan_id']));
        return "Ruangan : " . $modRuangan['ruangan_nama'];
    }

    /**
     * digunakan untuk mendapatkan no antrian pasien
     * @param type integer $ruangan_id
     * @return string
     */
    public function getNoAntrianPasien($ruangan_id) {
        $modAntrian = RuanganM::model()->findByAttributes(array('ruangan_id' => $ruangan_id));
        $noAntrian = '';
        if (!empty($modAntrian)) {
            if (!empty($modAntrian->ruangan_singkatan)) {
                $noAntrian = $modAntrian->ruangan_singkatan . '-';
            }
        }
        return $noAntrian;
    }

    /**
     * digunakan untuk mendapatkan no bed
     * @return string
     */
    public function getNoBed() {
        $modMasukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id' => $this->pasienadmisi_id), array('order' => 'masukkamar_id desc'));
        $modKamar = KamarruanganM::model()->findByAttributes(array('kamarruangan_id' => $modMasukKamar['kamarruangan_id']));
        if (!empty($modMasukKamar) && !empty($modKamar))
            return "<span>No.Kamar : " . $modKamar['kamarruangan_nokamar'] . "<br> No.Bed : " . $modKamar['kamarruangan_nobed'] . "</span>";
        else
            return "";
    }

    /**
     * untuk status dokumen rekam medis
     */
    public function getStatusDokumen($pengirimanrm_id, $status, $pendaftaran_id) {
        $status_dokumen = '';
        $statusruangan = '';
        $tombol = '';
        $status_dok = $status;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        if (empty($status) && empty($pengirimanrm_id)) {
            $status = 'BELUM DIKIRIM';
        } else if (empty($status) || !empty($pengirimanrm_id)) {
            $status = 'SUDAH DIKIRIM';
        }

        if (!empty($pengirimanrm_id)) {
            $modPengiriman = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'pengirimanrm_id desc'));
            $ruanganpenerima_id = $modPengiriman->ruanganpenerima_id;
            if (!empty($modPengiriman)) {
                if (!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id == Yii::app()->user->getState('ruangan_id')) {
                    $statusruangan = " DARI " . strtoupper($modPengiriman->ruanganpengirim->ruangan_nama);
                    $status = 'SUDAH DIKIRIM' . $statusruangan;
                    $status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="penerimaanDokumen(this,' . $pengirimanrm_id . ',\'' . $status_dok . '\',' . $pendaftaran_id . ')">' . $status . '</button>';
                    $tombol = "";
                } else if (!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id != Yii::app()->user->getState('ruangan_id')) {
                    $statusruangan = " KE- " . strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
                    $status = 'SUDAH DIKIRIM' . $statusruangan;
                    if (empty($ruanganpenerimaan_id)) {
                        $ruanganpenerima_id = 99;
                    }
                    $status_dokumen = '<button id="red" class="btn btn-success" name="yt1" onclick="setPenerimaan(this,' . $pengirimanrm_id . ',' . $ruanganpenerima_id . ',\'' . $status_dok . '\',' . $pendaftaran_id . ')">' . $status . '</button>';
                }
            }
        }

        if (!empty($modPendaftaran)) {
            if (!empty($modPendaftaran->pengirimanrm_id)) {
//				$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="setStatusDokumen(this,'.$pengirimanrm_id.',\''.$status.'\','.$pendaftaran_id.')">'.$status.'</button>';
                $status_dokumen = $status_dokumen;
            } else {
                $status_dokumen = '<button id="green" class="btn btn-danger" name="yt1">' . $status . '</button>';
            }
        }
        return $status_dokumen;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDaftarPasienRincian() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->addCondition('t.ruangan_id=' . Yii::app()->user->getState('ruangan_id'));
        $criteria->order = 't.tgl_pendaftaran DESC';
        if ($this->statusBayar == 'LUNAS') {

            $criteria->addCondition('pendaftaran.pembayaranpelayanan_id is not null');
        } else if ($this->statusBayar == 'BELUM LUNAS') {
            $criteria->addCondition('pendaftaran.pembayaranpelayanan_id is null');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * digunakan untuk mengambil status
     * @param type string $status
     * @param type integer $id
     * @return string
     */
    public function getStatus($status, $id) {
        $pendaftaran = PendaftaranT::model()->findByPk($id);
        $selisih = time() - strtotime($pendaftaran->tgl_pendaftaran);
        $selisih_waktuperiksa = time() - strtotime($pendaftaran->waktumulaiperiksa);
        $pulang = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id' => $id,
            'pasienbatalpulang_id' => null,
//                    'kondisikeluar_id'=>Params::KONDISIKELUAR_ID_RAWATINAP,
        ));


        if (!empty($pulang)) {
            $format = new MyFormatter();
            $tgl_pulang = $format->formatDateTimeForDb($pulang->tglpasienpulang);
            $selisih = time() - strtotime($tgl_pulang);
        }

        // untuk antrian di ambil dari tgl pendaftaran sampe tanggal antrian
        if ($selisih < 60) {
            $selisih = $selisih . "d";
        } else if ($selisih < 3600) {
            $selisih = floor($selisih / 60) . "m";
        } else if ($selisih < (3600 * 24)) {
            $selisih = floor($selisih / 3600) . "j";
        } else {
            $selisih = floor($selisih / (3600 * 24)) . "h";
        }
        // end 
        // untuk antrian di ambil dari tgl pendaftaran sampe tanggal antrian
        if ($selisih_waktuperiksa < 60) {
            $selisih_waktuperiksa = $selisih_waktuperiksa . "d";
        } else if ($selisih_waktuperiksa < 3600) {
            $selisih_waktuperiksa = floor($selisih_waktuperiksa / 60) . "m";
        } else if ($selisih_waktuperiksa < (3600 * 24)) {
            $selisih_waktuperiksa = floor($selisih_waktuperiksa / 3600) . "j";
        } else {
            $selisih_waktuperiksa = floor($selisih_waktuperiksa / (3600 * 24)) . "h";
        }
        //end

        $status = trim($status);
        if ($status == Params::STATUSPERIKSA_SEDANG_PERIKSA) {
            $badge = '<span class="badge badge-info pull-right badge-status">' . $selisih_waktuperiksa . '</span>';
            $status = '<button id="red" class="btn btn-gold nohover btn-status" name="yt1" onclick="setStatus(this,\'' . $status . '\',' . $id . ')">' . $status . '</button>';
            $status = '<div class="button-status">' . $badge . $status . '</div>';
        } else if ($status == Params::STATUSPERIKSA_ANTRIAN) {
            $badge = '<span class="badge badge-info pull-right badge-status">' . $selisih . '</span>';
            $status = '<button id="green" class="btn btn-black nohover btn-status" name="yt1" onclick="setStatus(this,\'' . $status . '\',' . $id . ')">' . $status . '</button>';
            $status = '<div class="button-status">' . $badge . $status . '</div>';
        } else if ($status == Params::STATUSPERIKSA_SUDAH_PULANG) {
            $status = '<button id="blue" class="btn btn-green nohover btn-status" name="yt1" onclick="setStatus(this,\'' . $status . '\',' . $id . ')">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
            $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP || $status == Params::STATUSPERIKSA_DIRAWAT_INAP) {
            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $id));
            $selisih = ceil((time() - strtotime($admisi->tgladmisi)) / (3600 * 24)) . "h";
            $badge = '<span class="badge badge-info pull-right badge-status">' . $selisih . '</span>';
            $status = '<button id="orange" class="btn btn-purple nohover btn-status"  name="yt1">' . $status . '</button>';
            $status = '<div class="button-status">' . $badge . $status . '</div>';
        } else if ($status == Params::STATUSPERIKSA_MENUNGGU_ADMISI || $status == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO || $status == "MENUNGGU ADMISI PASIEN") {
            $badge = '<span class="badge badge-info pull-right badge-status">' . $selisih . '</span>';
            $status = '<button id="orange" class="btn btn-orange nohover btn-status"  name="yt1">' . $status . '</button>';
            $status = '<div class="button-status">' . $badge . $status . '</div>';
        } else if ($status = 'TIDAK SELESAI') {
            $status = '<button id="red" class="btn btn-red nohover btn-status" name="yt1" onclick="setStatus(this,\'' . $status . '\',' . $id . ')">' . $status . '</button>';
            // $status = '<div class="button-status">'.$badge.$status.'</div>';
        } else {
            $status = '<button id="orange" class="btn btn-gold nohover btn-status"  name="yt1">' . $status . '</button>';
        }
        return $status;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDialogEresep() {

        $criteria = new CDbCriteria;
        $criteria->join = " LEFT JOIN pasienadmisi_t pa ON pa.pendaftaran_id =  t.pendaftaran_id ";
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(t.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->addCondition(' t.ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        $criteria->addCondition("t.statusperiksa NOT IN ('" . Params::STATUSPERIKSA_SUDAH_PULANG . "', '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "', '" . Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO . "') ");
        $criteria->addCondition(" pa.pasienadmisi_id IS NULL   ");
        $criteria->order = 't.tgl_pendaftaran ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchAsesmen() {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPemeriksaanLab($pasien_id = null) {
        $criteria = new CDbCriteria;
        $criteria->select = "hasil.hasilpemeriksaanlab_id, p.tgl_pendaftaran, p.no_pendaftaran, hasil.tglhasilpemeriksaanlab "
                            . ", nilai.namapemeriksaandet, ruangan_m.ruangan_nama, instalasi_m.instalasi_nama, pegawai_m.pegawai_id, pegawai_m.nama_pegawai, "
                            . "pemeriksaanlab_m.pemeriksaanlab_nama, det.hasilpemeriksaan, det.nilairujukan, det.hasilpemeriksaan_satuan";
        if (!empty($pasien_id)) {

            $criteria->addCondition('t.pasien_id = ' . $pasien_id);
        } else {
            $criteria->addCondition('t.pasien_id is null ');
        }
        $criteria->join = " join hasilpemeriksaanlab_t hasil on hasil.pasien_id = t.pasien_id "
                . " join pendaftaran_t p on hasil.pendaftaran_id = p.pendaftaran_id  "
                . " join detailhasilpemeriksaanlab_t det on hasil.hasilpemeriksaanlab_id = det.hasilpemeriksaanlab_id"
                . " join pemeriksaanlab_m on det.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id "
                . " join pemeriksaanlabdet_m p_det on det.pemeriksaanlabdet_id = p_det.pemeriksaanlabdet_id
                    join nilairujukan_m nilai on p_det.nilairujukan_id = nilai.nilairujukan_id "
                . " join pasienmasukpenunjang_t ps on hasil.pasienmasukpenunjang_id = ps.pasienmasukpenunjang_id "
                . " join ruangan_m on ps.ruangan_id = ruangan_m.ruangan_id "
                . " join instalasi_m on ruangan_m.instalasi_id = instalasi_m.instalasi_id "
                . " join pegawai_m on pegawai_m.pegawai_id = ps.pegawai_id ";

        $criteria->compare('lower(p.no_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('lower(ruangan_m.ruangan_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('lower(instalasi_m.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('lower(pegawai_m.nama_pegawai)', strtolower($this->pegawai_id), true);
        $criteria->compare('lower(nilai.namapemeriksaandet)', strtolower($this->namapemeriksaandet), true);
        $criteria->compare('lower(pemeriksaanlab_nama)', strtolower($this->pemeriksaanlab_nama), true);
        $criteria->compare('lower(hasilpemeriksaan)', strtolower($this->hasilpemeriksaan), true);
        $criteria->compare('lower(nilairujukan)', strtolower($this->nilairujukan), true);
        $criteria->compare('lower(hasilpemeriksaan_satuan)', strtolower($this->hasilpemeriksaan_satuan), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
