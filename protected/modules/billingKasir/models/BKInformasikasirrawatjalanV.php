<?php

/**
 * This is the model class for table "infokunjungan_rj".
 *
 * The followings are the available columns in table 'infokunjungan_rj':
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperiksa
 * @property string $statusmasuk
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $alamat_pasien
 * @property string $kelompokumur_nama
 * @property string $ruangan_nama
 * @property string $penjamin_nama
 * @property string $nama_pegawai
 * @property string $jeniskasuspenyakit_nama
 * @property integer $rujukan_id
 */
class BKInformasikasirrawatjalanV extends InformasikasirrawatjalanV
{
        public $instalasi_id, $instalasi_ids;
        public $statusBayar;
        public $total_belum;
        public $total_oa_belum;
        public $alokasidana_id;
        public $is_carabayarpenjaminan = false;
        public $tglpembayaran;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganRj the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRJ()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$format = new MyFormatter();

                $tb = "case when n.total_belum is null then 0 else n.total_belum end";
                $tt = "case when n.total_tindakan is null then 0 else n.total_tindakan end";
                $ob = "case when o.total_oa_belum is null then 0 else o.total_oa_belum end";
                $ot = "case when o.total_oa is null then 0 else o.total_oa end";
                
                $criteria->select = "t.*, "
                        . "${tb} as total_belum,
                            ${tt} as total_tindakan,
                            ${ob} as total_oa_belum,
                            ${ot} as total_oa";
                
                $criteria->join = "left join 
                (select 
                p.pendaftaran_id, 
                sum(case when p.tindakansudahbayar_id is null then 1 else 0 end) as total_belum,
                count(p.tindakanpelayanan_id) as total_tindakan

                from tindakanpelayanan_t p
                group by p.pendaftaran_id
                ) n on n.pendaftaran_id = t.pendaftaran_id

                left join 
                (select 
                p.pendaftaran_id, 
                sum(case when p.oasudahbayar_id is null and (true <> (p.penjualanresep_id is not null and p.penjamin_id = 1)) then 1 else 0 end) as total_oa_belum,
                count(p.obatalkespasien_id) as total_oa

                from obatalkespasien_t p
                group by p.pendaftaran_id
                ) o on o.pendaftaran_id = t.pendaftaran_id
                
                left join pendaftaran_t pp on pp.pendaftaran_id = t.pendaftaran_id
                ";
                
                //if ($this->statusBayar == "BELUM LUNAS") {
                //    $criteria->addCondition("(${tb}) > 0 or (${ob}) > 0 or (${tt}) = 0");
                //} else if ($this->statusBayar == "LUNAS") {
                //    $criteria->addCondition("(${tb}) = 0 and (${ob}) = 0 and (${tt}) > 0");
                //}
                
                
		$this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
		$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
//                $criteria->addCondition('t.pembayaranpelayanan_id IS NULL');
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('t.kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('t.kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		//$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
   		$criteria->order = 't.tgl_pendaftaran DESC';
		//$criteria->compare('LOWER(statusperiksa)',strtolower(Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
		
                $criteria->addCondition('pp.pasienadmisi_id is null');
                
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function searchDialogKunjunganSudahBayar() {
            $model = new InfopasienpengunjungV;
            
            if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = new InfokunjunganrjV;
            } else if ($this->instalasi_id == Params::INSTALASI_ID_RD || $this->instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
                $model = new InfokunjunganrdV;
            } else if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new InfokunjunganriV;
            } 


            $criteria = new CDbCriteria;
            $criteria->join = "left join (
                select distinct on (b.pendaftaran_id) b.pendaftaran_id, b.tglpembayaran 
                from pembayaranpelayanan_t b 
                where b.alokasidana_id is not null and b.orderbatalpembayaranpelayanan_id is null
                order by b.pendaftaran_id, b.tglpembayaran desc 
            ) by on by.pendaftaran_id = t.pendaftaran_id";

            
            $criteria->addCondition("by.pendaftaran_id is not null");

            $instalasi_id = $this->instalasi_id;
            if ($instalasi_id == Params::INSTALASI_ID_RI) {
                $instalasi_id = Params::grupInstalasiRIID();
            }

            $criteria->compare('t.instalasi_id', $instalasi_id);
            $criteria->compare('t.ruangan_id', $this->ruangan_id);
            $criteria->compare('t.ruangan_nama', $this->ruangan_nama);
            $criteria->compare('pj.carabayar_nama', $this->carabayar_nama);
            $criteria->compare('lower(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('lower(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('lower(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('lower(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
            


            return new CActiveDataProvider($model, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'by.tglpembayaran desc',
                ),
            ));
        }
        
        /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranTagihanPasienController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjungan()
        {
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
    
            $instalasi = $this->instalasi_id;

            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $instalasi = Params::grupInstalasiRIID();
            }
            
            $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                'ruangan_aktif' => true,
                'instalasi_id' => $instalasi,
            )), 'ruangan_id', 'ruangan_id');
    
            if (!in_array($this->ruangan_id, $ruangan)) {
                $this->ruangan_id = null;
            }

            $criteria->addCondition('t.pembayaranpelayanan_id is null');
    
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
    
            $criteria->addCondition("t.statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
    
            if ($this->instalasi_id != Params::INSTALASI_ID_HD) {
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
                }   
            } 

            // $criteria->addCondition('t.ruangan_id in (select ruangan_id from ruangan_m where instalasi_id in (2, 3, 4))');
    
            $criteria->compare('(t.ruangan_id)', ($this->ruangan_id));
            // $criteria->addInCondition('instalasi_id', [2, 3, 4]);
    
            if (!empty($this->carabayar_id)) {
                $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
            }
            $criteria->order = 't.tgl_pendaftaran DESC';
    
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
            }

            $modul = Yii::app()->user->getState('modul_id');

            if($modul == 97) {
                $criteria->addCondition('t.is_tindakan = true');
            }

            // var_dump($modul); die;
    
    
            // $criteria->limit = 5;
            if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = new BKInformasikasirrawatjalanV;
                //$criteria->addCondition('t.alihstatus = false');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
                $model = new BKInformasikasirrdpulangV;

                $criteria->select = "distinct on (t.pendaftaran_id) t.*";
                $criteria->order = "t.pendaftaran_id desc, t.tgl_pendaftaran desc";

                $criteria->join = "
                left join (
                    select a.pendaftaran_id, count(*) as total_tindakan, sum(case when a.isapprovaltindaklanjut is null or a.isapprovaltindaklanjut = false then 1 else 0 end) as total_pja from tindakanpelayanan_t a where a.verifikasitagihan_id is null and verifbataltindakan_id is null group by a.pendaftaran_id
                ) pja_tindakan on pja_tindakan.pendaftaran_id = t.pendaftaran_id
                left join (
                    select a.pendaftaran_id, count(*) as total_oa, sum(case when a.isapprovaltindaklanjut is null or a.isapprovaltindaklanjut = false then 1 else 0 end) as total_pja_oa from obatalkespasien_t a where a.verifikasitagihan_id is null group by a.pendaftaran_id
                ) pja_oa on pja_oa.pendaftaran_id = t.pendaftaran_id
                ";

                $criteria->addCondition('
                (
                    (case when pja_tindakan.total_tindakan is null then 0 else pja_tindakan.total_tindakan end) +
                    (case when pja_oa.total_oa is null then 0 else pja_oa.total_oa end) > 0
                )
                and (
                    (case when pja_tindakan.total_pja is null then 0 else pja_tindakan.total_pja end) +
                    (case when pja_oa.total_pja_oa is null then 0 else pja_oa.total_pja_oa end) = 0
                )
                ');

                // $criteria->addCondition('t.alihstatus = false');
                // $criteria->addCondition('t.pasienadmisi_id is null');
            } else if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new BKInformasikasirinappulangV;
                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                $criteria->addCondition('(t.tglpasienpulang is null or carakeluar_id = 4)');
                $criteria->select = "distinct on (t.pendaftaran_id) t.pendaftaran_id, *";
                $criteria->order = "t.pendaftaran_id desc";
                //$criteria->select = "t.*";

                // /*
                $criteria->join = "
                left join (
                    select a.pendaftaran_id, count(*) as total_tindakan, 
                    sum(case when a.isapprovaltindaklanjut is null or a.isapprovaltindaklanjut = false then 1 else 0 end) as total_pja 
                    from tindakanpelayanan_t a 
                    where a.verifikasitagihan_id is null 
                    and a.masukkamar_id is null
                    and a.verifbataltindakan_id is null group by a.pendaftaran_id
                ) pja_tindakan on pja_tindakan.pendaftaran_id = t.pendaftaran_id
                left join (
                    select a.pendaftaran_id, count(*) as total_oa, sum(case when a.isapprovaltindaklanjut is null or a.isapprovaltindaklanjut = false then 1 else 0 end) as total_pja_oa from obatalkespasien_t a where a.verifikasitagihan_id is null group by a.pendaftaran_id
                ) pja_oa on pja_oa.pendaftaran_id = t.pendaftaran_id
                left join (
                    select a.pendaftaran_id, count(*) as total_tindakan, 
                    sum(case when a.masukkamar_id is not null and (a.nopelayanan is null or a.nopelayanan = '-' or a.nopelayanan = '') then 1 else 0 end) as total_ako_belum 
                    from tindakanpelayanan_t a where a.verifikasitagihan_id is null and verifbataltindakan_id is null and a.masukkamar_id is not null group by a.pendaftaran_id
                ) akomodasi on akomodasi.pendaftaran_id = t.pendaftaran_id
                ";

                $criteria->addCondition('
                (
                    (case when pja_tindakan.total_tindakan is null then 0 else pja_tindakan.total_tindakan end) +
                    (case when pja_oa.total_oa is null then 0 else pja_oa.total_oa end) > 0
                )
                and (
                    (case when pja_tindakan.total_pja is null then 0 else pja_tindakan.total_pja end) +
                    (case when pja_oa.total_pja_oa is null then 0 else pja_oa.total_pja_oa end) = 0
                )
                and (case when akomodasi.total_tindakan is null then 0 else akomodasi.total_tindakan end) > 0
                and (case when akomodasi.total_ako_belum is null then 0 else akomodasi.total_ako_belum end) = 0
                ');
                // */

            } else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_REHAB))) {
                $model = new InformasikasirrehabmedisV;
                // $criteria->compare('instalasi_id', $this->instalasi_id);
                $criteria->addCondition('t.pasienkirimkeunitlain_id is null');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
                $model = new InformasikasirhemodialisaV();
                $criteria->addInCondition(
                    'status_hd',
                    array(
                        Params::STATUS_HD_SELESAI,
                        Params::STATUS_HD_TIDAK_SELESAI
                    )
                );
                $criteria->addCondition('t.pembayaranpelayanan_id is null');
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.status_hd)', strtolower($this->statusperiksa), true);
                }
            } else if ($this->instalasi_id == Params::INSTALASI_ID_REHAB) {
                $model = new InformasikasirrehabmedisV();
            }else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_MCU2))) {
                $model = new InformasikasirmcuV;
//                $criteria->compare('instalasi_id', $this->instalasi_id);                
            }else{
                $model = new BKPembayarantagihanpenunjangV();
            }

            if($this->is_carabayarpenjaminan) {
                $criteria->addCondition('t.carabayar_id <> ' . Params::CARABAYAR_ID_MEMBAYAR);
            }
    
            // echo "<pre>";
            // var_dump($criteria);
            // die;
            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                // 'pagination'=>false,
            ));
        }

        /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranTagihanPasienController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjunganBatalVerifikasi()
        {
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
    
            $instalasi = $this->instalasi_id;

            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $instalasi = Params::grupInstalasiRIID();
            }
            
            $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                'ruangan_aktif' => true,
                'instalasi_id' => $instalasi,
            )), 'ruangan_id', 'ruangan_id');
    
            if (!in_array($this->ruangan_id, $ruangan)) {
                $this->ruangan_id = null;
            }

            $criteria->addCondition('t.pembayaranpelayanan_id is null');
    
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
    
            $criteria->addCondition("t.statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
    
            if ($this->instalasi_id != Params::INSTALASI_ID_HD) {
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
                }   
            } 

            // $criteria->addCondition('t.ruangan_id in (select ruangan_id from ruangan_m where instalasi_id in (2, 3, 4))');
    
            $criteria->compare('(t.ruangan_id)', ($this->ruangan_id));
            // $criteria->addInCondition('instalasi_id', [2, 3, 4]);
    
            if (!empty($this->carabayar_id)) {
                $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
            }
            $criteria->order = 't.tgl_pendaftaran DESC';
    
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
            }

            $modul = Yii::app()->user->getState('modul_id');

            if($modul == 97) {
                $criteria->addCondition('t.is_tindakan = true');
            }

            // var_dump($modul); die;
    
    
            // $criteria->limit = 5;
            if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = new BKInformasikasirrawatjalanV;
                //$criteria->addCondition('t.alihstatus = false');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
                $model = new BKInformasikasirrdpulangV;

                $criteria->select = "distinct on (t.pendaftaran_id) t.*";
                $criteria->order = "t.pendaftaran_id desc, t.tgl_pendaftaran desc";

                $criteria->join = "
                left join (
                    select a.pendaftaran_id, count(*) as total_tindakan from tindakanpelayanan_t a 
                    where a.verifbataltindakan_id is null 
                    and a.tindakansudahbayar_id is null
                    group by a.pendaftaran_id
                ) pja_tindakan on pja_tindakan.pendaftaran_id = t.pendaftaran_id
                left join (
                    select a.pendaftaran_id, count(*) as total_oa from obatalkespasien_t a 
                    where a.oasudahbayar_id is null
                    group by a.pendaftaran_id
                ) pja_oa on pja_oa.pendaftaran_id = t.pendaftaran_id
                ";

                $criteria->addCondition('
                (
                    (case when pja_tindakan.total_tindakan is null then 0 else pja_tindakan.total_tindakan end) +
                    (case when pja_oa.total_oa is null then 0 else pja_oa.total_oa end) > 0
                )
                ');

                // $criteria->addCondition('t.alihstatus = false');
                // $criteria->addCondition('t.pasienadmisi_id is null');
            } else if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new BKInformasikasirinappulangV;
                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                $criteria->addCondition('(t.tglpasienpulang is null or carakeluar_id = 4)');
                $criteria->select = "distinct on (t.pendaftaran_id) t.*";
                $criteria->order = "t.pendaftaran_id desc";

                // /*
                $criteria->join = "
                left join (
                    select a.pendaftaran_id, count(*) as total_tindakan 
                    from tindakanpelayanan_t a 
                    where a.verifikasitagihan_id is not null 
                    and a.tindakansudahbayar_id is null
                    and a.verifbataltindakan_id is null 
                    group by a.pendaftaran_id
                ) pja_tindakan on pja_tindakan.pendaftaran_id = t.pendaftaran_id
                left join (
                    select a.pendaftaran_id, count(*) as total_oa
                    from obatalkespasien_t a 
                    where a.verifikasitagihan_id is not null 
                    and a.oasudahbayar_id is null
                    group by a.pendaftaran_id
                ) pja_oa on pja_oa.pendaftaran_id = t.pendaftaran_id
                ";

                $criteria->addCondition('
                (
                    (case when pja_tindakan.total_tindakan is null then 0 else pja_tindakan.total_tindakan end) +
                    (case when pja_oa.total_oa is null then 0 else pja_oa.total_oa end) > 0
                )
                ');
                // */

            } else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_REHAB))) {
                $model = new InformasikasirrehabmedisV;
                // $criteria->compare('instalasi_id', $this->instalasi_id);
                $criteria->addCondition('t.pasienkirimkeunitlain_id is null');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
                $model = new InformasikasirhemodialisaV();
                $criteria->addInCondition(
                    'status_hd',
                    array(
                        Params::STATUS_HD_SELESAI,
                        Params::STATUS_HD_TIDAK_SELESAI
                    )
                );
                $criteria->addCondition('t.pembayaranpelayanan_id is null');
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.status_hd)', strtolower($this->statusperiksa), true);
                }
            } else if ($this->instalasi_id == Params::INSTALASI_ID_REHAB) {
                $model = new InformasikasirrehabmedisV();
            }else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_MCU2))) {
                $model = new InformasikasirmcuV;
//                $criteria->compare('instalasi_id', $this->instalasi_id);                
            }else{
                $model = new BKPembayarantagihanpenunjangV();
            }

            if($this->is_carabayarpenjaminan) {
                $criteria->addCondition('t.carabayar_id <> ' . Params::CARABAYAR_ID_MEMBAYAR);
            }
    
            // echo "<pre>";
            // var_dump($criteria);
            // die;
            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                // 'pagination'=>false,
            ));
        }

        /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranTagihanPasienController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjunganBatalTindakan()
        {
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
    
            $instalasi = $this->instalasi_id;

            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $instalasi = Params::grupInstalasiRIID();
            }
            
            $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                'ruangan_aktif' => true,
                'instalasi_id' => $instalasi,
            )), 'ruangan_id', 'ruangan_id');
    
            if (!in_array($this->ruangan_id, $ruangan)) {
                $this->ruangan_id = null;
            }

            $is_hitung_ruangan = false;
            $ruangan_login = Yii::app()->user->getState('ruangan_id');
            $instalasi_login = Yii::app()->user->getState('instalasi_id');

            if (Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_KASIR2) {
                $is_hitung_ruangan = true;
                // $criteria->compare("t.ruangan_id", Yii::app()->user->getState('ruangan_id'));
            }

            $criteria->addCondition('t.pembayaranpelayanan_id is null');
    
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
    
            $criteria->addCondition("t.statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
    
            if ($this->instalasi_id != Params::INSTALASI_ID_HD) {
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
                }   
            } 

            // $criteria->addCondition('t.ruangan_id in (select ruangan_id from ruangan_m where instalasi_id in (2, 3, 4))');
    
            $criteria->compare('(t.ruangan_id)', ($this->ruangan_id));
            // $criteria->addInCondition('instalasi_id', [2, 3, 4]);
    
            if (!empty($this->carabayar_id)) {
                $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
            }
            $criteria->order = 't.tgl_pendaftaran DESC';
    
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
            }

            $modul = Yii::app()->user->getState('modul_id');

            if($modul == 97) {
            //    $criteria->addCondition('t.is_tindakan = true');
            }

            // var_dump($modul); die;
    
    
            // $criteria->limit = 5;
            if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = new BKInformasikasirrawatjalanV;

                if ($is_hitung_ruangan) {

                    if ($instalasi_login == Params::INSTALASI_ID_FARMASI) {
                        $criteria->join = "join (
                            select a.pendaftaran_id from tindakanpelayanan_t a 
                            where a.create_ruangan = ".$ruangan_login." 
                            and a.penjualanresep_id is not null
                            and a.isverifbataltindakan = false
                            group by a.pendaftaran_id
                        ) tindakan on tindakan.pendaftaran_id = t.pendaftaran_id";

                    } else {
                        $criteria->join = "join (
                            select a.pendaftaran_id from tindakanpelayanan_t a 
                            where a.create_ruangan = ".$ruangan_login." 
                            and a.isverifbataltindakan = false
                            group by a.pendaftaran_id
                        ) tindakan on tindakan.pendaftaran_id = t.pendaftaran_id";

                    }

                }

                //$criteria->addCondition('t.alihstatus = false');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
                $model = new BKInformasikasirrdpulangV;

                $criteria->select = "distinct on (t.pendaftaran_id) t.*";
                $criteria->order = "t.pendaftaran_id desc, t.tgl_pendaftaran desc";

                $criteria->join = "
                left join (
                    select a.pendaftaran_id, count(*) as total_tindakan from tindakanpelayanan_t a 
                    where a.verifrenctindakan_id is null 
                    and a.verifbataltindakan_id is null 
                    and a.tindakansudahbayar_id is null
                    group by a.pendaftaran_id
                ) pja_tindakan on pja_tindakan.pendaftaran_id = t.pendaftaran_id
                left join (
                    select obatalkespasien_t.pendaftaran_id, count(*) as total_oa from obatalkespasien_t 
                    where obatalkespasien_t.oasudahbayar_id is null
                    group by obatalkespasien_t.pendaftaran_id
                ) pja_oa on pja_oa.pendaftaran_id = t.pendaftaran_id
                ";
                if ($is_hitung_ruangan) {

                    if ($instalasi_login == Params::INSTALASI_ID_FARMASI) {
                        $criteria->join .= " join (
                            select a.pendaftaran_id from tindakanpelayanan_t a 
                            where a.create_ruangan = ".$ruangan_login." 
                            and a.penjualanresep_id is not null
                            and a.isverifbataltindakan = false
                            group by a.pendaftaran_id
                        ) tindakan on tindakan.pendaftaran_id = t.pendaftaran_id";

                    } else {
                        $criteria->join .= " join (
                            select a.pendaftaran_id from tindakanpelayanan_t a 
                            where a.create_ruangan = ".$ruangan_login." 
                            and a.isverifbataltindakan = false
                            group by a.pendaftaran_id
                        ) tindakan on tindakan.pendaftaran_id = t.pendaftaran_id";

                    }
                }

                $criteria->addCondition('
                (
                    (case when pja_tindakan.total_tindakan is null then 0 else pja_tindakan.total_tindakan end) +
                    (case when pja_oa.total_oa is null then 0 else pja_oa.total_oa end) > 0
                )
                ');

                

                // $criteria->addCondition('t.alihstatus = false');
                // $criteria->addCondition('t.pasienadmisi_id is null');
            } else if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new BKInformasikasirinappulangV;
                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                $criteria->addCondition('(t.tglpasienpulang is null or carakeluar_id = 4)');
                $criteria->select = "distinct on (t.pendaftaran_id) t.*";
                $criteria->order = "t.pendaftaran_id desc";

                // /*
                $criteria->join = "
                left join (
                    select a.pendaftaran_id, count(*) as total_tindakan 
                    from tindakanpelayanan_t a 
                    where a.verifrenctindakan_id is null 
                    and a.tindakansudahbayar_id is null
                    and a.verifbataltindakan_id is null 
                    group by a.pendaftaran_id
                ) pja_tindakan on pja_tindakan.pendaftaran_id = t.pendaftaran_id
                left join (
                    select a.pendaftaran_id, count(*) as total_oa
                    from obatalkespasien_t a 
                    where a.oasudahbayar_id is null
                    group by a.pendaftaran_id
                ) pja_oa on pja_oa.pendaftaran_id = t.pendaftaran_id
                ";

                $criteria->addCondition('
                (
                    (case when pja_tindakan.total_tindakan is null then 0 else pja_tindakan.total_tindakan end) +
                    (case when pja_oa.total_oa is null then 0 else pja_oa.total_oa end) > 0
                )
                ');


                if ($is_hitung_ruangan) {

                    if ($instalasi_login == Params::INSTALASI_ID_FARMASI) {
                        $criteria->join .= " join (
                            select a.pendaftaran_id from tindakanpelayanan_t a 
                            where a.create_ruangan = ".$ruangan_login." 
                            and a.penjualanresep_id is not null
                            and a.isverifbataltindakan = false
                            group by a.pendaftaran_id
                        ) tindakan on tindakan.pendaftaran_id = t.pendaftaran_id";

                    } else {
                        $criteria->join .= " join (
                            select a.pendaftaran_id from tindakanpelayanan_t a 
                            where a.create_ruangan = ".$ruangan_login." 
                            and a.isverifbataltindakan = false
                            group by a.pendaftaran_id
                        ) tindakan on tindakan.pendaftaran_id = t.pendaftaran_id";

                    }

                }

                // */

            } else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_REHAB))) {
                $model = new InformasikasirrehabmedisV;
                // $criteria->compare('instalasi_id', $this->instalasi_id);
                $criteria->addCondition('t.pasienkirimkeunitlain_id is null');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
                $model = new InformasikasirhemodialisaV();
                $criteria->addInCondition(
                    'status_hd',
                    array(
                        Params::STATUS_HD_SELESAI,
                        Params::STATUS_HD_TIDAK_SELESAI
                    )
                );
                $criteria->addCondition('t.pembayaranpelayanan_id is null');
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.status_hd)', strtolower($this->statusperiksa), true);
                }
            } else if ($this->instalasi_id == Params::INSTALASI_ID_REHAB) {
                $model = new InformasikasirrehabmedisV();
            }else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_MCU2))) {
                $model = new InformasikasirmcuV;
//                $criteria->compare('instalasi_id', $this->instalasi_id);                
            }else{
                $model = new BKPembayarantagihanpenunjangV();
            }

            if($this->is_carabayarpenjaminan) {
                $criteria->addCondition('t.carabayar_id <> ' . Params::CARABAYAR_ID_MEMBAYAR);
            }
    
            // echo "<pre>";
            // var_dump($criteria);
            // die;
            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                // 'pagination'=>false,
            ));
        }

        /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranTagihanPasienController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjunganAkomodasi()
        {
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
            $criteria->select = "distinct on (t.pendaftaran_id) t.*";
    
            $instalasi = $this->instalasi_id;

            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $instalasi = Params::grupInstalasiRIID();
            }
            
            $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                'ruangan_aktif' => true,
                'instalasi_id' => $instalasi,
            )), 'ruangan_id', 'ruangan_id');
    
            if (!in_array($this->ruangan_id, $ruangan)) {
                $this->ruangan_id = null;
            }

            $criteria->addCondition('t.pembayaranpelayanan_id is null');
    
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
    
            $criteria->addCondition("t.statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
    
            if ($this->instalasi_id != Params::INSTALASI_ID_HD) {
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
                }   
            } 

            // $criteria->addCondition('t.ruangan_id in (select ruangan_id from ruangan_m where instalasi_id in (2, 3, 4))');
    
            $criteria->compare('(t.ruangan_id)', ($this->ruangan_id));
            // $criteria->addInCondition('instalasi_id', [2, 3, 4]);
    
            if (!empty($this->carabayar_id)) {
                $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
            }
            $criteria->order = 't.tgl_pendaftaran DESC';
    
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
            }

            $modul = Yii::app()->user->getState('modul_id');

            if($modul == 97) {
                $criteria->addCondition('t.is_tindakan = true');
            }

            // var_dump($modul); die;
    
    
            // $criteria->limit = 5;
            if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new BKInformasikasirinappulangV;
                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                $criteria->addCondition('(t.tglpasienpulang is null or carakeluar_id = 4)');
                $criteria->order = "t.pendaftaran_id desc";
                


                $criteria->join = "
                left join (
                    select a.pendaftaran_id, count(*) as total_tindakan, 
                    sum(case when a.isapprovaltindaklanjut is null or a.isapprovaltindaklanjut = false then 1 else 0 end) as total_pja 
                    from tindakanpelayanan_t a 
                    where a.verifikasitagihan_id is null 
                    and a.masukkamar_id is null
                    and a.verifbataltindakan_id is null group by a.pendaftaran_id
                ) pja_tindakan on pja_tindakan.pendaftaran_id = t.pendaftaran_id
                left join (
                    select a.pendaftaran_id, count(*) as total_oa, sum(case when a.isapprovaltindaklanjut is null or a.isapprovaltindaklanjut = false then 1 else 0 end) as total_pja_oa from obatalkespasien_t a where a.verifikasitagihan_id is null group by a.pendaftaran_id
                ) pja_oa on pja_oa.pendaftaran_id = t.pendaftaran_id
                ";

                $criteria->addCondition('
                (
                    (case when pja_tindakan.total_tindakan is null then 0 else pja_tindakan.total_tindakan end) +
                    (case when pja_oa.total_oa is null then 0 else pja_oa.total_oa end) > 0
                )
                and (
                    (case when pja_tindakan.total_pja is null then 0 else pja_tindakan.total_pja end) +
                    (case when pja_oa.total_pja_oa is null then 0 else pja_oa.total_pja_oa end) = 0
                )
                ');


                // */

            } else{
                $model = new BKPembayarantagihanpenunjangV();
            }

            if($this->is_carabayarpenjaminan) {
                $criteria->addCondition('t.carabayar_id <> ' . Params::CARABAYAR_ID_MEMBAYAR);
            }
    
            // echo "<pre>";
            // var_dump($criteria);
            // die;
            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                // 'pagination'=>false,
            ));
        }

        /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranTagihanPasienController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjungan2()
        {
            $format = new MyFormatter();
            $criteria = new CDbCriteria();

            $controller = Yii::app()->controller->id;
    
            $instalasi = $this->instalasi_id;
            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $instalasi = Params::grupInstalasiRIID();
            }
            
            $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                'instalasi_id' => $instalasi
            )), 'ruangan_id', 'ruangan_id');
    
            if (!in_array($this->ruangan_id, $ruangan)) {
                $this->ruangan_id = null;
            }
    
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
    
            $criteria->addCondition("t.statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
    
            if ($this->instalasi_id != Params::INSTALASI_ID_HD) {
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
                }   
            } 
    
            $criteria->compare('(t.ruangan_id)', ($this->ruangan_id));
    
            if (!empty($this->carabayar_id)) {
                $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
            }
            $criteria->order = 't.tgl_pendaftaran DESC';
    
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
            }

            $kondisiAdmisi = "a.pasienadmisi_id is null";
            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $kondisiAdmisi = "a.pasienadmisi_id is not null";
            }

            $criteria->addCondition($kondisiAdmisi);
    
    
            // $criteria->limit = 5;
            if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = new InformasipembayaranrawatjalanV;
                $criteria->join = "join alokasidana_t a on a.alokasidana_id = t.alokasidana_id
                left join orderbatalalokasi_t ba on ba.alokasidana_id = a.alokasidana_id 
                join carabayar_m c on c.carabayar_id = a.carabayar_id 
                join penjaminpasien_m p on p.penjamin_id = a.penjamin_id 
                left join pembayaranpelayanan_t b on b.alokasidana_id = a.alokasidana_id and b.orderbatalpembayaranpelayanan_id is null";
                $criteria->addCondition('ba.alokasidana_id is null and b.pembayaranpelayanan_id is null');
                // $criteria->addCondition('t.alihstatus = false');
                $criteria->order = 'tglalokasi desc';
                $criteria->group = 't.pendaftaran_id, t.no_pendaftaran, t.instalasi_id, t.penjamin_id, t.tglalokasi, t.tgl_pendaftaran,
                t.no_rekam_medik, t.namadepan, t.nama_pasien, t.jeniskelamin, t.instalasi_id, t.ruangan_id,
                t.ruangan_nama, t.carabayar_id, t.carabayar_nama, t.statusperiksa';
                $criteria->select = $criteria->group;
                $criteria->order = "t.tglalokasi desc";
            } else if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
                $model = new BKInformasikasirrdpulangV;
                $criteria->join = "join alokasidana_t a on a.alokasidana_id = t.alokasidana_id
                left join orderbatalalokasi_t ba on ba.alokasidana_id = a.alokasidana_id 
                join carabayar_m c on c.carabayar_id = a.carabayar_id 
                join penjaminpasien_m p on p.penjamin_id = a.penjamin_id 
                left join pembayaranpelayanan_t b on b.alokasidana_id = a.alokasidana_id and b.orderbatalpembayaranpelayanan_id is null";
                // $criteria->addCondition('t.alihstatus = false');
                //$criteria->addCondition('t.pasienadmisi_id is null and b.pembayaranpelayanan_id is null');
                $criteria->addCondition('b.pembayaranpelayanan_id is null');
                $criteria->group = 't.pendaftaran_id, t.no_pendaftaran,  t.instalasi_id, t.penjamin_id, t.tglalokasi, t.tgl_pendaftaran,
                t.no_rekam_medik, t.namadepan, t.nama_pasien, t.jeniskelamin, t.instalasi_id, t.ruangan_id,
                t.ruangan_nama, t.carabayar_id, t.carabayar_nama, t.statusperiksa, t.pasien_id';
                $criteria->select = $criteria->group;
                $criteria->order = "t.tglalokasi desc";
            } else if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new BKInformasikasirinappulangV;
                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                $criteria->addCondition('(t.tglpasienpulang is null or carakeluar_id = 4)');
                $criteria->join = "join alokasidana_t a on a.alokasidana_id = t.alokasidana_id 
                left join orderbatalalokasi_t ba on ba.alokasidana_id = a.alokasidana_id 
                join carabayar_m c on c.carabayar_id = a.carabayar_id 
                join penjaminpasien_m p on p.penjamin_id = a.penjamin_id 
                left join pembayaranpelayanan_t b on b.alokasidana_id = a.alokasidana_id and b.orderbatalpembayaranpelayanan_id is null";
                $criteria->addCondition('ba.alokasidana_id is null and b.pembayaranpelayanan_id is null');
                $criteria->group = 't.pendaftaran_id, t.no_pendaftaran, t.instalasi_id, t.penjamin_id, t.tglalokasi, t.tgl_pendaftaran,
                t.no_rekam_medik, t.namadepan, t.nama_pasien, t.jeniskelamin, t.instalasi_id, t.ruangan_id,
                t.ruangan_nama, t.carabayar_id, t.carabayar_nama, t.statusperiksa, t.pasien_id';
                $criteria->select = $criteria->group;
                $criteria->order = "t.tglalokasi desc";
            } /* else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_REHAB))) {
                $model = new InformasikasirrehabmedisV;
                // $criteria->compare('instalasi_id', $this->instalasi_id);
                $criteria->addCondition('t.pasienkirimkeunitlain_id is null');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
                $model = new InformasikasirhemodialisaV();
                $criteria->addInCondition(
                    'status_hd',
                    array(
                        Params::STATUS_HD_SELESAI,
                        Params::STATUS_HD_TIDAK_SELESAI
                    )
                );
                $criteria->addCondition('t.pembayaranpelayanan_id is null');
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.status_hd)', strtolower($this->statusperiksa), true);
                }
            } else if ($this->instalasi_id == Params::INSTALASI_ID_REHAB) {
                $model = new InformasikasirrehabmedisV();
            }else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_MCU2))) {
                $model = new InformasikasirmcuV;
//                $criteria->compare('instalasi_id', $this->instalasi_id);                
            }else{
                $model = new BKPembayarantagihanpenunjangV();
            } */
    
            // echo "<pre>";
            // var_dump($criteria);
            // die;
            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                // 'pagination'=>false,
            ));
        }

        public function searchDialogKunjungan3()
        {
            $format = new MyFormatter();
            $criteria = new CDbCriteria();

            $controller = Yii::app()->controller->id;
    
            $instalasi = $this->instalasi_id;
            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $instalasi = Params::grupInstalasiRIID();
            }
    

            $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                'instalasi_id' => $instalasi
            )), 'ruangan_id', 'ruangan_id');
    
            if (!in_array($this->ruangan_id, $ruangan)) {
                $this->ruangan_id = null;
            }

            
    
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
    
            $criteria->addCondition("t.statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
    
            if ($this->instalasi_id != Params::INSTALASI_ID_HD) {
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
                }   
            } 
    
            $criteria->compare('(t.ruangan_id)', ($this->ruangan_id));
    
            $carabayar_tab = "t.";

            
            $criteria->order = 't.tgl_pendaftaran DESC';
    
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
            }

            $kondisiAdmisi = "a.pasienadmisi_id is null";
            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $kondisiAdmisi = "a.pasienadmisi_id is not null";
            }

            $criteria->addCondition($kondisiAdmisi);
    
    
            // $criteria->limit = 5;
            if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = new InformasipembayaranrawatjalanV;
                // $criteria->addCondition('t.alihstatus = false');

                if($this->is_carabayarpenjaminan) {
                    $criteria->addCondition('a.carabayar_id <> 1');
                } else {
                    $criteria->addCondition('a.carabayar_id = 1');
                }
                
                $criteria->join = "join alokasidana_t a on a.alokasidana_id = t.alokasidana_id 
                left join orderbatalalokasi_t ba on ba.alokasidana_id = a.alokasidana_id 
                join carabayar_m c on c.carabayar_id = a.carabayar_id 
                join penjaminpasien_m p on p.penjamin_id = a.penjamin_id 
                left join pembayaranpelayanan_t b on b.alokasidana_id = a.alokasidana_id and b.orderbatalpembayaranpelayanan_id is null";
                $criteria->addCondition('ba.alokasidana_id is null and b.pembayaranpelayanan_id is null and a.pasienadmisi_id is null');
                $criteria->select = "t.*, c.carabayar_id, c.carabayar_nama, p.penjamin_id, p.penjamin_nama";
                $carabayar_tab = "a.";
                $criteria->order = 'tglalokasi desc';
            } else if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
                $model = new BKInformasikasirrdpulangV;
                // $criteria->addCondition('t.alihstatus = false');

                if($this->is_carabayarpenjaminan) {
                    $criteria->addCondition('a.carabayar_id <> 1');
                } else {
                    $criteria->addCondition('a.carabayar_id = 1');
                }

                $criteria->join = "join alokasidana_t a on a.alokasidana_id = t.alokasidana_id 
                left join orderbatalalokasi_t ba on ba.alokasidana_id = a.alokasidana_id 
                join carabayar_m c on c.carabayar_id = a.carabayar_id 
                join penjaminpasien_m p on p.penjamin_id = a.penjamin_id 
                left join pembayaranpelayanan_t b on b.alokasidana_id = a.alokasidana_id and b.orderbatalpembayaranpelayanan_id is null";
                $criteria->addCondition('ba.alokasidana_id is null and b.pembayaranpelayanan_id is null and a.pasienadmisi_id is null');
                $criteria->select = "distinct on (t.pendaftaran_id, t.tgl_pendaftaran, a.alokasidana_id) t.*, c.carabayar_id, c.carabayar_nama, p.penjamin_id, p.penjamin_nama";
                $criteria->order = 't.tgl_pendaftaran DESC, t.pendaftaran_id, a.alokasidana_id';
                $carabayar_tab = "a.";

                // $criteria->addCondition('t.pasienadmisi_id is null');
            } else if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new BKInformasikasirinappulangV;

                if($this->is_carabayarpenjaminan) {
                    $criteria->addCondition('a.carabayar_id <> 1');
                } else {
                    $criteria->addCondition('a.carabayar_id = 1');
                }


                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                // $criteria->addCondition('(t.tglpasienpulang is null or carakeluar_id = 4)');
                $criteria->join = "join alokasidana_t a on a.alokasidana_id = t.alokasidana_id 
                left join orderbatalalokasi_t ba on ba.alokasidana_id = a.alokasidana_id 
                join carabayar_m c on c.carabayar_id = a.carabayar_id 
                join penjaminpasien_m p on p.penjamin_id = a.penjamin_id 
                left join pembayaranpelayanan_t b on b.alokasidana_id = a.alokasidana_id and b.orderbatalpembayaranpelayanan_id is null and a.pasienadmisi_id is not null";
                $criteria->addCondition('ba.alokasidana_id is null and b.pembayaranpelayanan_id is null');
                $criteria->select = "distinct on (t.pendaftaran_id, t.tgl_pendaftaran, a.alokasidana_id) t.*, c.carabayar_id, c.carabayar_nama, p.penjamin_id, p.penjamin_nama";
                $criteria->order = 't.tgl_pendaftaran DESC, t.pendaftaran_id, a.alokasidana_id';
                $carabayar_tab = "a.";
            } else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_REHAB))) {
                $model = new InformasikasirrehabmedisV;
                // $criteria->compare('instalasi_id', $this->instalasi_id);
                $criteria->addCondition('t.pasienkirimkeunitlain_id is null');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
                $model = new InformasikasirhemodialisaV();
                $criteria->addInCondition(
                    'status_hd',
                    array(
                        Params::STATUS_HD_SELESAI,
                        Params::STATUS_HD_TIDAK_SELESAI
                    )
                );
                $criteria->addCondition('t.pembayaranpelayanan_id is null');
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.status_hd)', strtolower($this->statusperiksa), true);
                }
            } else if ($this->instalasi_id == Params::INSTALASI_ID_REHAB) {
                $model = new InformasikasirrehabmedisV();
            }else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_MCU2))) {
                $model = new InformasikasirmcuV;
//                $criteria->compare('instalasi_id', $this->instalasi_id);                
            }else{
                $model = new BKPembayarantagihanpenunjangV();
            }

            if (!empty($this->carabayar_id)) {
                $criteria->addCondition($carabayar_tab.'carabayar_id = ' . $this->carabayar_id);
            }
            if (!empty($this->penjamin_id)) {
                $criteria->addCondition($carabayar_tab.'penjamin_id = ' . $this->penjamin_id);
            }
    
            // echo "<pre>";
            // var_dump($criteria);
            // die;
            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                // 'pagination'=>false,
            ));
        }


          /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranTagihanPasienController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogOrderBatal()
        {
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
    
    
            $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true), array(
                'condition' => 'instalasi_id ' . $this->instalasi_ids
            )), 'ruangan_id', 'ruangan_id');
    
            if (!in_array($this->ruangan_id, $ruangan)) {
                $this->ruangan_id = null;
            }

            $criteria->addCondition('t.pembayaranpelayanan_id is null');
    
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
    
            $criteria->addCondition("t.statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
    
            if ($this->instalasi_id != Params::INSTALASI_ID_HD) {
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
                }   
            } 

            //$criteria->addCondition('t.ruangan_id in (select ruangan_id from ruangan_m where instalasi_id = ' . $this->instalasi_id . ')');
    
            $criteria->compare('(t.ruangan_id)', ($this->ruangan_id));
            // $criteria->compare('instalasi_id', $this->instalasi_id);
    
            if (!empty($this->carabayar_id)) {
                $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
            }
            $criteria->order = 't.tgl_pendaftaran DESC';
    
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
            }

            $modul = Yii::app()->user->getState('modul_id');

            if($modul == 97) {
                $criteria->addCondition('t.is_tindakan = true');
            }    
    
            // $criteria->limit = 5;

            if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new OrderbataltindakanriV;
                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                $criteria->join = "left join (
                    select a.pendaftaran_id, count(*) as total_tindakan_akomodasi
                    from tindakanpelayanan_t a
                    join daftartindakan_m d on d.daftartindakan_id = a.daftartindakan_id
                    where d.daftartindakan_akomodasi = true and a.nopelayanan is not null and a.tindakansudahbayar_id IS NULL and a.verifbataltindakan_id is null
                    group by a.pendaftaran_id
                ) tindakan_ako on tindakan_ako.pendaftaran_id = t.pendaftaran_id";
                $criteria->addCondition("tindakan_ako.total_tindakan_akomodasi is not null and tindakan_ako.total_tindakan_akomodasi > 0");
                // $criteria->addCondition('(t.tglpasienpulang is null or carakeluar_id = 4)');
            }else{
                $model = new BKPembayarantagihanpenunjangV();
            }

            if($this->is_carabayarpenjaminan) {
                $criteria->addCondition('t.carabayar_id <> ' . Params::CARABAYAR_ID_MEMBAYAR);
            }

            // vaR_dump($criteria); die;
    
            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                // 'pagination'=>false,
            ));
        }

        /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranTagihanPasienController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjunganAlokasiDana()
        {
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
    
            $instalasi = $this->instalasi_id;

            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $instalasi = Params::grupInstalasiRIID();
            }
    
            $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                'instalasi_id' => $instalasi
            )), 'ruangan_id', 'ruangan_id');
    
            if (!in_array($this->ruangan_id, $ruangan)) {
                $this->ruangan_id = null;
            }

            $criteria->group = 't.pendaftaran_id, t.no_pendaftaran, t.instalasi_id, t.penjamin_id, t.tgl_pendaftaran,
            t.no_rekam_medik, t.namadepan, t.nama_pasien, t.jeniskelamin, t.instalasi_id, t.ruangan_id,
            t.ruangan_nama, t.carabayar_id, t.carabayar_nama, t.statusperiksa, v.verifikasitagihan_id, v.update_time';
            $criteria->select = $criteria->group;

            $criteria->join = "left join (
                select distinct on (a.pendaftaran_id, a.pasienadmisi_id) a.pendaftaran_id, a.pasienadmisi_id, a.update_time, a.verifikasitagihan_id
                from verifikasitagihan_t a order by a.pendaftaran_id, a.pasienadmisi_id, a.update_time desc, a.verifikasitagihan_id desc
            ) v on v.pendaftaran_id = t.pendaftaran_id 
            left join (
                select b.pendaftaran_id from tindakanpelayanan_t b 
                where b.nopelayanan is not null and b.verifrenctindakan_id IS NOT NULL and b.alokasidanadetailtindakan_id IS NULL
                group by b.pendaftaran_id
            ) vt on vt.pendaftaran_id = t.pendaftaran_id
            left join (
                select b.pendaftaran_id from obatalkespasien_t b 
                where b.qty_oa > 0 and b.verifikasitagihan_id is not null and b.alokasidanadetailoa_id IS NULL
                group by b.pendaftaran_id
            ) vo on vo.pendaftaran_id = t.pendaftaran_id";
    
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
    
            $criteria->addCondition("t.statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
            $criteria->addCondition("vt.pendaftaran_id is not null or vo.pendaftaran_id is not null");
    
            if ($this->instalasi_id != Params::INSTALASI_ID_HD) {
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
                }   
            } 
    
            $criteria->compare('(t.ruangan_id)', ($this->ruangan_id));
    
            if (!empty($this->carabayar_id)) {
                $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
            }
            $criteria->order = '(case when v.verifikasitagihan_id is null then 0 else 1 end) desc, v.update_time desc, v.verifikasitagihan_id desc, t.tgl_pendaftaran DESC';
    
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
            }

            $kondisiAdmisi = "v.pasienadmisi_id is null";
            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $kondisiAdmisi = "v.pasienadmisi_id is not null";
            }
    
            $criteria->addCondition($kondisiAdmisi);
    
            // $criteria->limit = 5;
            if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {

                $model = new InformasialokasidanaV;
                // $criteria->addCondition('t.alihstatus = false');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
                $model = new BKInformasikasirrdpulangV;
                // $criteria->addCondition('t.alihstatus = false');
                // $criteria->addCondition('t.pasienadmisi_id is null');
            } else if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new BKInformasikasirinappulangV;
                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                $criteria->addCondition('(t.tglpasienpulang is null or t.carakeluar_id = 4)');
            } else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_REHAB))) {
                $model = new InformasikasirrehabmedisV;
                // $criteria->compare('instalasi_id', $this->instalasi_id);
                $criteria->addCondition('t.pasienkirimkeunitlain_id is null');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
                $model = new InformasikasirhemodialisaV();
                $criteria->addInCondition(
                    't.status_hd',
                    array(
                        Params::STATUS_HD_SELESAI,
                        Params::STATUS_HD_TIDAK_SELESAI
                    )
                );
                $criteria->addCondition('t.pembayaranpelayanan_id is null');
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.status_hd)', strtolower($this->statusperiksa), true);
                }
            } else if ($this->instalasi_id == Params::INSTALASI_ID_REHAB) {
                $model = new InformasikasirrehabmedisV();
            }else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_MCU2))) {
                $model = new InformasikasirmcuV;
//                $criteria->compare('instalasi_id', $this->instalasi_id);                
            }else{
                $model = new BKPembayarantagihanpenunjangV();
            }

            if($this->is_carabayarpenjaminan) {
                $criteria->addCondition('t.carabayar_id <> ' . Params::CARABAYAR_ID_MEMBAYAR);
            }
    
            // echo "<pre>";
            // var_dump($criteria); die;
            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                // 'pagination'=>false,
            ));
        }
        
        /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranUangMukaController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjunganUangMuka(){
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
    
            $instalasi = $this->instalasi_id;

            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                $instalasi = Params::grupInstalasiRIID();
            }
            
            $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                'ruangan_aktif' => true,
                'instalasi_id' => $instalasi,
            )), 'ruangan_id', 'ruangan_id');
    
            if (!in_array($this->ruangan_id, $ruangan)) {
                $this->ruangan_id = null;
            }

            $criteria->addCondition('t.pembayaranpelayanan_id is null');
    
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
    
            $criteria->addCondition("t.statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
    
            if ($this->instalasi_id != Params::INSTALASI_ID_HD) {
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
                }   
            } 

            // $criteria->addCondition('t.ruangan_id in (select ruangan_id from ruangan_m where instalasi_id in (2, 3, 4))');
    
            $criteria->compare('(t.ruangan_id)', ($this->ruangan_id));
            // $criteria->addInCondition('instalasi_id', [2, 3, 4]);
    
            if (!empty($this->carabayar_id)) {
                $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
            }
            $criteria->order = 't.tgl_pendaftaran DESC';
    
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
            }

            $modul = Yii::app()->user->getState('modul_id');

            if($modul == 97) {
                $criteria->addCondition('t.is_tindakan = true');
            }

            // var_dump($modul); die;
    
    
            // $criteria->limit = 5;
            if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = new BKInformasikasirrawatjalanV;
                //$criteria->addCondition('t.alihstatus = false');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
                $model = new BKInformasikasirrdpulangV;

                $criteria->select = "distinct on (t.pendaftaran_id) t.*";
                $criteria->order = "t.pendaftaran_id desc, t.tgl_pendaftaran desc";


                // $criteria->addCondition('t.alihstatus = false');
                // $criteria->addCondition('t.pasienadmisi_id is null');
            } else if (in_array($this->instalasi_id, Params::grupInstalasiRIID())) {
                $model = new BKInformasikasirinappulangV;
                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                $criteria->addCondition('(t.tglpasienpulang is null or carakeluar_id = 4)');
                $criteria->select = "distinct on (t.pendaftaran_id) t.pendaftaran_id, *";
                $criteria->order = "t.pendaftaran_id desc";
                $criteria->select = "t.*";


            } else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_REHAB))) {
                $model = new InformasikasirrehabmedisV;
                // $criteria->compare('instalasi_id', $this->instalasi_id);
                $criteria->addCondition('t.pasienkirimkeunitlain_id is null');
            } else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
                $model = new InformasikasirhemodialisaV();
                $criteria->addInCondition(
                    'status_hd',
                    array(
                        Params::STATUS_HD_SELESAI,
                        Params::STATUS_HD_TIDAK_SELESAI
                    )
                );
                $criteria->addCondition('t.pembayaranpelayanan_id is null');
                if (!empty($this->statusperiksa)) {
                    $criteria->compare('LOWER(t.status_hd)', strtolower($this->statusperiksa), true);
                }
            } else if ($this->instalasi_id == Params::INSTALASI_ID_REHAB) {
                $model = new InformasikasirrehabmedisV();
            }else if (in_array($this->instalasi_id, array(Params::INSTALASI_ID_MCU2))) {
                $model = new InformasikasirmcuV;
//                $criteria->compare('instalasi_id', $this->instalasi_id);                
            }else{
                $model = new BKPembayarantagihanpenunjangV();
            }

            if($this->is_carabayarpenjaminan) {
                $criteria->addCondition('t.carabayar_id <> ' . Params::CARABAYAR_ID_MEMBAYAR);
            }
    
            // echo "<pre>";
            // var_dump($criteria);
            // die;
            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                // 'pagination'=>false,
            ));
        }
        
         public function getTanggal()
        {
            $format = new MyFormatter(); 
            return $format->formatDateTimeForUser($this->tgl_pendaftaran);
        }
        
        public function getRuanganItems($instalasi_id=null)
        {
            if($instalasi_id==null){
            return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
            }else{
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id, 'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));   
            }
        }
}