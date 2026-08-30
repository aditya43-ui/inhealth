<?php
/**
 * Model untuk Informasi Sampel darah di modul Bank Darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @version 2.0.0
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDInformasisampeldarah extends KantongdarahT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokantongdarahV the static model class
	 */
        public $tgl_awal, $tgl_akhir; 
        public $rhesus, $gol_darah;
        public $nama_jenis, $jeniskantongdarah_id,$ruangan_nama,$ruanganterima_id,$pendonor_id;
        public $skrining, $hbsag, $antihiv, $antihvc, $sifilis;
        public $terimakantongdet_id;
        public $hasil_uji;
        public $tglterimakantong;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch(){
        /*
	 * @return CdbCriteria that can return criterias.
	 */
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('gol_darah',$this->gol_darah,true);
		$criteria->compare('rhesus',$this->rhesus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Pencarian sampel darah di informasi sampel darah
         * @return \CActiveDataProvider
         */
        public function searchSampelDarah(){
            $criteria=new CDbCriteria;
            $criteria->addCondition("t.terimakantongdarah_id IS NOT NULL "); 
            $criteria->addCondition("t.nomorbarcode_sample IS NOT NULL "); 
            $criteria->select = 't.*, t.kantongdarah_id, t.nomorbarcode_sample, t.kantongdarah_id, p.rhesus, p.gol_darah, jeniskantongdarah_m.nama_jenis, jeniskantongdarah_m.jeniskantongdarah_id, terima.terimakantongdet_id, skrining.skriningimltd_id, skrining.hbsag, skrining.antihiv, skrining.antihvc, skrining.sifilis, pengujiandarah_t.hasil_uji, terimakantongdarah_t.tglterimakantong';
            $criteria->join = ''
                            . ' LEFT JOIN daftardonasi_t ON t.daftarpendonor_id=daftardonasi_t.daftardonasi_id '
                            . ' LEFT JOIN pendonor_m as p ON daftardonasi_t.pendonor_id=p.pendonor_id '
                            . ' JOIN jeniskantongdarah_m ON t.jeniskantongdarah_id = jeniskantongdarah_m.jeniskantongdarah_id '
                            . ' LEFT JOIN terimakantongdet_t terima ON t.terimakantongdarah_id = terima.terimakantongdarah_id '
                            . ' LEFT JOIN terimakantongdarah_t ON t.terimakantongdarah_id = terimakantongdarah_t.terimakantongdarah_id '
                            . ' LEFT JOIN skriningimltd_t as skrining ON t.skriningimltd_id = skrining.skriningimltd_id '
                            . ' LEFT JOIN pengujiandarah_t ON t.pengujiandarah_id = pengujiandarah_t.pengujiandarah_id'; 
            $criteria->group = $criteria->select;
            $criteria->limit=10;
            $criteria->compare('p.gol_darah',$this->gol_darah);
            $criteria->compare('p.rhesus',$this->rhesus);
            $criteria->compare('LOWER(t.nomorbarcode_sample)', strtolower($this->nomorbarcode_sample), true);
            $criteria->compare('t.jeniskantongdarah_id',$this->jeniskantongdarah_id);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * Pencarian data sampel darah untuk transaksi pengujian darah
         * @return \CActiveDataProvider
         */
        public function searchInfoSampelDarah(){
            $criteria=new CDbCriteria;
            $criteria->addCondition("t.terimakantongdarah_id IS NOT NULL "); 
            $criteria->addCondition(" t.nomorbarcode_sample IS NOT NULL "); 
            $criteria->select = 't.*, t.kantongdarah_id, t.nomorbarcode_sample, t.kantongdarah_id, p.rhesus, p.gol_darah, '
                    . 'jeniskantongdarah_m.nama_jenis, jeniskantongdarah_m.jeniskantongdarah_id, '
                    . 'terima.terimakantongdet_id, skrining.skriningimltd_id, skrining.hbsag, '
                    . 'skrining.antihiv, skrining.antihvc, skrining.sifilis, pengujiandarah_t.hasil_uji,p.pendonor_id,'
                    . 'terimakantongdarah_t.tglterimakantong,ruangan.ruangan_nama,terimakantongdarah_t.ruanganterima_id';
            $criteria->join = 'LEFT JOIN kantongdarah_t as kantongdarah ON t.kantongdarah_id=kantongdarah.kantongdarah_id '
                            . ' LEFT JOIN daftardonasi_t ON kantongdarah.daftarpendonor_id=daftardonasi_t.daftardonasi_id '
                            . ' LEFT JOIN pendonor_m as p ON daftardonasi_t.pendonor_id=p.pendonor_id '
                            . ' JOIN jeniskantongdarah_m ON t.jeniskantongdarah_id = jeniskantongdarah_m.jeniskantongdarah_id '
                            . ' LEFT JOIN terimakantongdet_t terima ON t.terimakantongdarah_id = terima.terimakantongdarah_id '
                            . ' LEFT JOIN terimakantongdarah_t ON t.terimakantongdarah_id = terimakantongdarah_t.terimakantongdarah_id '
                            . ' LEFT JOIN skriningimltd_t as skrining ON t.skriningimltd_id = skrining.skriningimltd_id '
                            . ' LEFT JOIN pengujiandarah_t ON t.pengujiandarah_id = pengujiandarah_t.pengujiandarah_id '
                            . ' JOIN kirimkantongdarah_t kirim ON terimakantongdarah_t.kirimkantongdarah_id = kirim.kirimkantongdarah_id '
                            . ' JOIN ruangan_m ruangan ON kirim.ruangankirim_id = ruangan.ruangan_id'; 
            $criteria->group = $criteria->select;
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}