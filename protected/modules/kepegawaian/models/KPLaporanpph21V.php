<?php

/**
 * This is the model class for table "laporanpph21_v".
 *
 * The followings are the available columns in table 'laporanpph21_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $no_kartupegawainegerisipil
 * @property string $no_karis_karsu
 * @property string $no_taspen
 * @property string $no_askes
 * @property string $jenisidentitas
 * @property string $noidentitas
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $nama_keluarga
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property string $kode_pos
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $warganegara_pegawai
 * @property string $jeniswaktukerja
 * @property integer $suku_id
 * @property string $suku_nama
 * @property integer $statuskepemilikanrumah_id
 * @property string $statuskepemilikanrumah_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $profilrs_id
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $kelompokjabatan
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $esselon_id
 * @property string $esselon_nama
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property string $kategoripegawai
 * @property string $kategoripegawaiasal
 * @property string $photopegawai
 * @property string $nofingerprint
 * @property double $tinggibadan
 * @property double $beratbadan
 * @property string $kemampuanbahasa
 * @property string $warnakulit
 * @property string $nip_lama
 * @property string $no_rekening
 * @property string $bank_no_rekening
 * @property string $npwp
 * @property string $tglditerima
 * @property string $tglberhenti
 * @property integer $penggajianpeg_id
 * @property string $tglpenggajian
 * @property string $nopenggajian
 * @property string $keterangan
 * @property string $mengetahui
 * @property string $menyetujui
 * @property double $totalterima
 * @property double $totalpajak
 * @property double $totalpotongan
 * @property double $penerimaanbersih
 * @property string $periodegaji
 * @property double $gajipertahun
 * @property double $biayajabatan
 * @property double $potonganpensiun
 * @property double $gajikotor
 * @property string $kodeptkp
 * @property double $ptkppertahun
 * @property double $ptkpperbulan
 * @property double $pkp
 * @property double $persentasepph21
 * @property double $pph21pertahun
 * @property double $pph21perbulan
 */
class KPLaporanpph21V extends Laporanpph21V
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Laporanpph21V the static model class
	 */
	public $tgl_awal;
	public $tgl_akhir;
	public $unit_perusahaan;
	public $total;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(tglpenggajian)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		//$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(kode_pos)',strtolower($this->kode_pos),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		if(!empty($this->suku_id)){
			$criteria->addCondition('suku_id = '.$this->suku_id);
		}
		$criteria->compare('LOWER(suku_nama)',strtolower($this->suku_nama),true);
		if(!empty($this->statuskepemilikanrumah_id)){
			$criteria->addCondition('statuskepemilikanrumah_id = '.$this->statuskepemilikanrumah_id);
		}
		$criteria->compare('LOWER(statuskepemilikanrumah_nama)',strtolower($this->statuskepemilikanrumah_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(nokode_rumahsakit)',strtolower($this->nokode_rumahsakit),true);
		$criteria->compare('LOWER(nama_rumahsakit)',strtolower($this->nama_rumahsakit),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		if(!empty($this->golonganpegawai_id)){
			$criteria->addCondition('golonganpegawai_id = '.$this->golonganpegawai_id);
		}
		$criteria->compare('LOWER(golonganpegawai_nama)',strtolower($this->golonganpegawai_nama),true);
		if(!empty($this->pangkat_id)){
			$criteria->addCondition('pangkat_id = '.$this->pangkat_id);
		}
		$criteria->compare('LOWER(pangkat_nama)',strtolower($this->pangkat_nama),true);
		if(!empty($this->jabatan_id)){
			$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		}
		$criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);
		if(!empty($this->esselon_id)){
			$criteria->addCondition('esselon_id = '.$this->esselon_id);
		}
		$criteria->compare('LOWER(esselon_nama)',strtolower($this->esselon_nama),true);
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
		}
		$criteria->compare('LOWER(kelompokpegawai_nama)',strtolower($this->kelompokpegawai_nama),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(nip_lama)',strtolower($this->nip_lama),true);
		$criteria->compare('LOWER(no_rekening)',strtolower($this->no_rekening),true);
		$criteria->compare('LOWER(bank_no_rekening)',strtolower($this->bank_no_rekening),true);
		$criteria->compare('LOWER(npwp)',strtolower($this->npwp),true);
		$criteria->compare('LOWER(tglditerima)',strtolower($this->tglditerima),true);
		$criteria->compare('LOWER(tglberhenti)',strtolower($this->tglberhenti),true);
		if(!empty($this->penggajianpeg_id)){
			$criteria->addCondition('penggajianpeg_id = '.$this->penggajianpeg_id);
		}
		$criteria->compare('LOWER(tglpenggajian)',strtolower($this->tglpenggajian),true);
		$criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(mengetahui)',strtolower($this->mengetahui),true);
		$criteria->compare('LOWER(menyetujui)',strtolower($this->menyetujui),true);
		$criteria->compare('totalterima',$this->totalterima);
		$criteria->compare('totalpajak',$this->totalpajak);
		$criteria->compare('totalpotongan',$this->totalpotongan);
		$criteria->compare('penerimaanbersih',$this->penerimaanbersih);
		$criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
		$criteria->compare('gajipertahun',$this->gajipertahun);
		$criteria->compare('biayajabatan',$this->biayajabatan);
		$criteria->compare('potonganpensiun',$this->potonganpensiun);
		$criteria->compare('gajikotor',$this->gajikotor);
		$criteria->compare('LOWER(kodeptkp)',strtolower($this->kodeptkp),true);
		$criteria->compare('ptkppertahun',$this->ptkppertahun);
		$criteria->compare('ptkpperbulan',$this->ptkpperbulan);
		$criteria->compare('pkp',$this->pkp);
		$criteria->compare('persentasepph21',$this->persentasepph21);
		$criteria->compare('pph21pertahun',$this->pph21pertahun);
		$criteria->compare('pph21perbulan',$this->pph21perbulan);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
					'pagination'=>false,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
		
		public function getTotalPph21($pph)
		{
			$criteria=new CDbCriteria;
			if($pph=='pph21perbulan'){
				$criteria->select = 'sum(t.pph21perbulan) as total';
			}
			$criteria->addBetweenCondition('DATE(tglpenggajian)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->pegawai_id)){
				$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
			}
			
			$jumlah = KPLaporanpph21V::model()->find($criteria)->total;
        
			if (empty($jumlah)){
                $jumlah = 0;
            }
            return $jumlah;
        }
			
}