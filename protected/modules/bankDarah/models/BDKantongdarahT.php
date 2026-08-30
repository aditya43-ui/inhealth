<?php

/**
 * Model berisi fungsi2 untuk model Bank Darah
 * 
 * @author     Deni Hamdani <denihamdani@ppiindonesia.co.id>
 * @package    application.models.bankDarah
 * @subpackage models
 * @category   Controller
 */
class BDKantongdarahT extends KantongdarahT
{
    public $gol_darah;
    public $rhesus;
    public $singkatan_komp;
    public $no_penggunaan_coolbox, $coolboxdarah_nama;
    public $cekBulan, $cekTahun;
    public $disable_tgl = false;
    
     /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KarcisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * Pencarian kantong darah yang sudah di-uji.
     * 
     * @return \CActiveDataProvider
     */
    public function searchKantongUntukDistribusi() {
        // Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.kantongdarah_id',$this->kantongdarah_id);
		$criteria->compare('t.pendonor_id',$this->pendonor_id);
		$criteria->compare('t.daftarpendonor_id',$this->daftarpendonor_id);
		$criteria->compare('t.komponendarah_id',$this->komponendarah_id);
		$criteria->compare('lower(k.singkatan_komp)',strtolower($this->singkatan_komp));
		$criteria->compare('t.tglpencatatan',$this->tglpencatatan,true);
		$criteria->compare('lower(t.no_kantongdarah)',strtolower($this->no_kantongdarah),true);
		$criteria->compare('t.petugaspencatat_id',$this->petugaspencatat_id);
		$criteria->compare('t.jeniskantongdarah_id',$this->jeniskantongdarah_id);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.create_ruangan',$this->create_ruangan);

        
            $criteria->join = 'join periksakomponendarah_t p on p.kantongdarah_id = t.kantongdarah_id '
            . "join luluskomponendarah_t l on l.kantongdarah_id = t.kantongdarah_id and l.statuspelulusan = 'LULUS' "
            . 'join pendonor_m d on d.pendonor_id = t.pendonor_id '
            . 'join komponendarah_m k on k.komponendarah_id = t.komponendarah_id';
        $criteria->addCondition(''
            . "((lower(p.komponen_wb) = 'berhasil' and t.komponendarah_id = 7) or "
            . "(lower(p.komponen_prc) = 'berhasil' and t.komponendarah_id in (8, 10)) or "
            . "(lower(p.komponen_tc) = 'berhasil' and t.komponendarah_id in (14, 12)) or "
            . "(lower(p.komponen_ffp) = 'berhasil' and t.komponendarah_id in (9, 11, 13)) or "
            . "(lower(p.komponen_pcr) = 'berhasil' and t.komponendarah_id = 15))"
        );
        $criteria->addCondition('distribusidarah_id is null');
        $criteria->addCondition('batalkantongdarah_id is null');
        $criteria->addCondition("l.statuspelulusan = 'LULUS'");
        $criteria->compare('d.gol_darah', $this->gol_darah);
        $criteria->compare('lower(d.rhesus)', strtolower($this->rhesus));
        
        $criteria->select = 'distinct on (kantongdarah_id) t.*, d.gol_darah, d.rhesus';
        $criteria->order = "t.kantongdarah_id, l.luluskomponendarah_id desc";
        
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }

    /**
     * Search kantong pada transaksi masuk coolbox
     * @return \CArrayDataProvider
     */
    public function searchKantongBaru() {

        $cekDet = PenggunaanCoolboxdetT::model()->findAll('nomorbarcode_utama IS NOT NULL AND penggunaan_coolbox_id IS NOT NULL');
        $barcode_utama = array();

        foreach ($cekDet as $val):
            $barcode_utama[] = $val->nomorbarcode_utama;
        endforeach;

        $cri = new CDbCriteria;
        $cri->select = " t.*, jeniskantongdarah_m.nama_jenis, donor.gol_darah, donor.rhesus";
        $cri->join = ' LEFT JOIN jeniskantongdarah_m ON jeniskantongdarah_m.jeniskantongdarah_id = t.jeniskantongdarah_id '
                . ' LEFT JOIN pendonor_m donor ON donor.pendonor_id = t.pendonor_id ';
        $cri->addNotInCondition('t.nomorbarcode_utama', $barcode_utama);
        $cri->compare("LOWER(t.nomorbarcode_utama)", strtolower($this->nomorbarcode_utama), true);
        $cri->compare("LOWER(t.nomorbarcode_sample)", strtolower($this->nomorbarcode_sample), true);
        $cri->addCondition('t.daftarpendonor_id is not null');
        $kantong = KantongdarahT::model()->findAll($cri);

        $res = array();

        $awal = '';
        foreach ($kantong as $det) {
            $res[$det->nomorbarcode_utama]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
            $res[$det->nomorbarcode_utama]['daftarpendonor_id'] = $det->daftarpendonor_id;
            $res[$det->nomorbarcode_utama]['nama_jenis'] = $det->nama_jenis;
            $res[$det->nomorbarcode_utama]['gol_darah'] = $det->gol_darah;
            $res[$det->nomorbarcode_utama]['rhesus'] = $det->rhesus;
            $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
            $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_sample'] = $det->nomorbarcode_sample;
            $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['jeniskantongdarah_id'] = $det->jeniskantongdarah_id;
            $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['komponendarah_id'] = $det->komponendarah_id;
            $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah;
            $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah;
        }

        $data = array();

        $i = 0;
        foreach ($res as $a => $val) {
            $data[$i] = $val;
            $data[$i] = $val;
            $i++;
        }

        return new CArrayDataProvider($data, array(
            'keyField' => 'nomorbarcode_utama',
            'id' => 'data_laporan',
            'totalItemCount' => count($data),
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'page'
            ),
        ));
    }

    /**
     * Load informasi barcode 
     * @return \CArrayDataProvider
     */
    public function searchInformasiBarcode() {

        $dt = $this->criteriaInformasiBarcode();

        return new CArrayDataProvider($dt, array(
            'keyField' => 'no_urut',
            'id' => 'data_laporan',
            'totalItemCount' => count($dt),
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'page'
            ),
        ));
    }

    /**
     * Load informasi barcode 
     * @return type
     */
    public function criteriaInformasiBarcode() {
        $cri = new CDbCriteria();
        $cri->select = " t.*, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gelar.gelarbelakang_nama) as petugaspencatat_nama, t.create_time, jenis.nama_jenis as jeniskantongdarah_nama, komp.singkatan_komp, jenis.jeniskantongdarah_id ";
        $cri->join = " JOIN pegawai_m peg ON peg.pegawai_id = t.petugaspencatat_id "
                . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id "
                . " JOIN jeniskantongdarah_m jenis ON jenis.jeniskantongdarah_id = t.jeniskantongdarah_id  "
                . " JOIN komponendarah_m komp ON komp.komponendarah_id = t.komponendarah_id ";
        if ($this->disable_tgl == false) {
            $cri->addBetweenCondition("DATE(t.create_time)", $this->tgl_awal, $this->tgl_akhir);
        }
        $cri->compare('LOWER(jenis.nama_jenis)', strtolower($this->jeniskantongdarah_nama), true);
        if (is_array($this->nomorbarcode_utama)) {
            $cri->addInCondition('nomorbarcode_utama', $this->nomorbarcode_utama);
        } else {
            $cri->compare('LOWER(nomorbarcode_utama)', strtolower($this->nomorbarcode_utama), true);
        }
        $cri->compare('LOWER(no_kantongdarah)', strtolower($this->no_kantongdarah), true);
        $cri->addCondition(" t.batalkantongdarah_id IS NULL AND t.jeniskantongdarah_id IS NOT NULL ");
        $cri->order = ' t.create_time DESC, jenis.nama_jenis ASC, nomorbarcode_utama DESC ';
        $model = BDKantongdarahT::model()->findAll($cri);

        $dt = array();
        $no = 0;
        $nosebelum = 1;
        $i = 1;
        foreach ($model as $det) {
            $number_only = preg_replace('/[^0-9]/', '', $det->nomorbarcode_utama);
            $bulan = MyFormatter::getMonthId(substr($number_only, 0, 2));
            $tahun = substr($number_only, 2, 2);
            if ($nosebelum != $det->nomorbarcode_utama) {
                $no++;
            }

            $dt[$i]['no_urut'] = $i;
            $dt[$i]['no'] = $no;
            $dt[$i]['tglcetak'] = MyFormatter::formatDateTimeForUser($det->create_time);
            $dt[$i]['jeniskantongdarah_nama'] = $det->jeniskantongdarah_nama;
            $dt[$i]['jeniskantongdarah_id'] = $det->jeniskantongdarah_id;
            $dt[$i]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
            $dt[$i]['no_kantongdarah'] = $det->no_kantongdarah;
            $dt[$i]['petugas_cetak'] = $det->petugaspencatat_nama;
            $dt[$i]['kantongdarah_id'] = $det->kantongdarah_id;
            $dt[$i]['bulan'] = $bulan;
            $dt[$i]['tahun'] = $tahun;

            $nosebelum = $det->nomorbarcode_utama;
            $i++;
        }

        // Jika filter bukan aktif maka menghilangkan informasi yang bulannya tidak sama 
        if ($this->cekBulan == 1) {
            foreach ($dt as $ii => $det) {
                if ($det['bulan'] != $this->bulan) {
                    unset($dt[$ii]);
                }
            }
        }
        
        /**
         * Jika filter tahun aktif maka menghilangkan informasi yang tahunnya tidak sama
         * tahun hanya diambil 2 angka di belakangnya saja (sudah di convert di controller) 
         */
        if ($this->cekTahun == 1) {
            foreach ($dt as $ii => $det) {
                if ($det['tahun'] != $this->tahun) {
                    unset($dt[$ii]);
                }
            }
        }

        return $dt;
    }

    /**
     * Search kantong pada detail di informasi daftar pendonor 
     * @return \CActiveDataProvider
     */
    public function searchKantongDarahuntukPendonor() {
        $criteria = new CDbCriteria;
        $criteria->join = " JOIN komponendarah_m k ON k.komponendarah_id = t.komponendarah_id ";
        $criteria->compare('t.kantongdarah_id', $this->kantongdarah_id);
        $criteria->compare('t.pendonor_id', $this->pendonor_id);
        $criteria->compare('t.daftarpendonor_id', $this->daftarpendonor_id);
        $criteria->compare('t.komponendarah_id', $this->komponendarah_id);
        $criteria->compare('lower(k.singkatan_komp)', strtolower($this->singkatan_komp));
        $criteria->compare('t.tglpencatatan', $this->tglpencatatan, true);
        $criteria->compare('lower(t.no_kantongdarah)', strtolower($this->no_kantongdarah), true);
        $criteria->compare('t.petugaspencatat_id', $this->petugaspencatat_id);
        $criteria->compare('t.jeniskantongdarah_id', $this->jeniskantongdarah_id);
        $criteria->compare('t.create_time', $this->create_time, true);
        $criteria->compare('t.update_time', $this->update_time, true);
        $criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('t.update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('t.create_ruangan', $this->create_ruangan);

        $criteria->addCondition('pendonor_id is null and daftarpendonor_id is null and penerimaandarahpmidet_id is null');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}