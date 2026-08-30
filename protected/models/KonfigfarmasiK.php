<?php

/**
 * This is the model class for table "konfigfarmasi_k".
 *
 * The followings are the available columns in table 'konfigfarmasi_k':
 * @property integer $konfigfarmasi_id
 * @property string $tglberlaku
 * @property double $persenppn
 * @property double $persenpph
 * @property boolean $bayarlangsung
 * @property string $pesandistruk
 * @property string $pesandifaktur
 * @property string $formulajasadokter
 * @property string $formulajasaparamedis
 * @property string $hargaygdigunakan
 * @property double $pembulatanharga
 * @property double $ri_persjualppn
 * @property double $rd_persjualppn
 * @property double $rj_persjualppn
 * @property boolean $konfigfarmasi_aktif
 * @property double $administrasi
 * @property double $persjualbebas
 * @property boolean $hargajualglobal
 * @property double $persdiskpasien
 * @property boolean $otomatismargin
 * @property double $persenmargin
 * @property string $metodeantrian
 * @property double $persenppnjual
 * @property double $nilai_vital
 * @property double $nilai_esensial
 * @property double $nilai_nonesensial
 * @property double $nilai_a_persen
 * @property double $nilai_b_persen
 * @property double $nilai_c_persen
 */
class KonfigfarmasiK extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KonfigfarmasiK the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'konfigfarmasi_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglberlaku, persenppn, persenpph, ri_persjualppn, rd_persjualppn, rj_persjualppn', 'required'),
			array('persenppn, persenpph, pembulatanharga, ri_persjualppn, rd_persjualppn, rj_persjualppn, administrasi, persjualbebas, persdiskpasien, persenmargin, persenppnjual, nilai_vital, nilai_esensial, nilai_nonesensial, nilai_a_persen, nilai_b_persen, nilai_c_persen, discountkaryawan, discountdokter, marginpenjualanlangsung, marginpenjualanresepumum, marginpenjualandokter, marginpenjualankaryawan', 'numerical'),

			array('formulajasadokter, formulajasaparamedis', 'length', 'max'=>100),
			array('hargaygdigunakan, metode_pemberian', 'length', 'max'=>50),
			array('metodeantrian', 'length', 'max'=>200),
			array('persehargajual, totalpersenhargajual, admracikan, marginresep, marginnonresep, bayarlangsung, pesandistruk, pesandifaktur, konfigfarmasi_aktif, hargajualglobal, otomatismargin, persensubsidirspegawai, penanggungjawab_apoterker_id, isstokfarmasiminus, isstokminimalfarmasi, ishargajualhet, ishargaperpenjamin', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('konfigfarmasi_id, tglberlaku, persenppn, persenpph, bayarlangsung, pesandistruk, pesandifaktur, formulajasadokter, formulajasaparamedis, hargaygdigunakan, pembulatanharga, ri_persjualppn, rd_persjualppn, rj_persjualppn, konfigfarmasi_aktif, administrasi, persjualbebas, hargajualglobal, persdiskpasien, otomatismargin, persenmargin, metodeantrian, persenppnjual, nilai_vital, nilai_esensial, nilai_nonesensial, nilai_a_persen, nilai_b_persen, nilai_c_persen, penanggungjawab_apoterker_id, isstokfarmasiminus, isstokminimalfarmasi, ishargajualhet, discountkaryawan, discountdokter, ishargaperpenjamin, marginpenjualanlangsung, marginpenjualanresepumum, marginpenjualandokter, marginpenjualankaryawan, metode_pemberian', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(

			'konfigfarmasi_id' => 'ID',
			'tglberlaku' => 'Tanggal Berlaku',
			'persenppn' => 'PPN Pembelian (%)',
			'persenpph' => 'PPh Pembelian (%)',
			'bayarlangsung' => 'Bayar Langsung',
			'pesandistruk' => 'Pesan Di Struk',
			'pesandifaktur' => 'Pesan Di Faktur',
			'formulajasadokter' => 'Formula Jasa Dokter',
			'formulajasaparamedis' => 'Formula Jasa Paramedis',
			'hargaygdigunakan' => 'Harga yang digunakan',
			'pembulatanharga' => 'Pembulatan Harga',
			'ri_persjualppn' => 'PPN Jual RI (%)',
            'rd_persjualppn' => 'PPN Jual RD (%)',
            'rj_persjualppn' => 'PPN Jual RJ (%)',
			'konfigfarmasi_aktif' => 'Konfig Farmasi Aktif',
			'administrasi' => 'Biaya Administrasi (Rp)',
			'persjualbebas'=>'Persentase Harga Jual Bebas',
			'hargajualglobal'=>'Harga Jual Global',
			'persdiskpasien'=>'Persen Keringanan Pasien',
			'otomatismargin'=>'Otomatis Margin',
			'persenmargin'=>'Margin (%)',
			'metodeantrian'=>'Metode Antrian',
			'persenppnjual' => 'PPN Jual umum (%)',
			'pembulatanretail'=>'Pembulatan Retail',
			'nilai_vital' => 'Nilai Vital',
			'nilai_esensial' => 'Nilai Esensial',
			'nilai_nonesensial' => 'Nilai Nonesensial',
			'nilai_a_persen' => 'Golongan VEN A (%)',
			'nilai_b_persen' => 'Golongan VEN B (%)',
			'nilai_c_persen' => 'Golongan VEN C (%)',
			'persensubsidirspegawai' => '% Asuransi RS Penjualan Pegawai',
			'persehargajual' => 'Persen Harga Jual (%)',
			'totalpersenhargajual' => 'Total Persen Harga Jual (%)',
			'admracikan' => 'Administrasi Racikan (Rp)',
			'marginresep'=>'Margin Resep (%)',
			'marginnonresep'=>'Margin Non Resep (%)',
      'isstokfarmasiminus'=>'Stok Farmasi Minus',
			'discountkaryawan'=>'Keringanan Penjualan Karyawan (%)',
			'marginpenjualanlangsung' => 'Margin Penjualan Langsung (%)',
			'marginpenjualanresepumum' => 'Margin Penjualan Resep Umum (%)',
			'marginpenjualandokter' => 'Margin Penjualan Resep Dokter (%)',
			'marginpenjualankaryawan' => 'Margin Penjualan Resep Karyawan (%)',
			'metode_pemberian' => 'Metode Pemberian',
		);
	}

	public function attributeTooltips()
	{
		return array(
			'konfigfarmasi_id' => 'ID',
			'tglberlaku' => 'Tanggal berlaku konfigurasi',
			'persenppn' => 'Pajak Pertambahan Nilai (%) ketika penerimaan dari supplier',
			'persenpph' => 'Pajak penghasilan (%) ketika penerimaan dari supplier',
			'bayarlangsung' => 'Transaksi penjualan resep langsung bayar',
			'pesandistruk' => 'Pesan teks di bawah setruk',
			'pesandifaktur' => 'Pesan teks di bawah faktur',
			'formulajasadokter' => 'Formula perhitungan jasa dokter',
			'formulajasaparamedis' => 'Formula perhitungan jasa paramedis',
			'hargaygdigunakan' => 'Harga yang digunakan',
			'pembulatanharga' => 'Pembulatan total tagihan per resep',
			'ri_persjualppn' => 'Persen PPN untuk penjualan resep rawat inap',
            'rd_persjualppn' => 'Persen PPN untuk penjualan resep gawat darurat',
            'rj_persjualppn' => 'Persen PPN untuk penjualan resep rawat jalan',
			'konfigfarmasi_aktif' => 'Aktifkan konfigurasi farmasi',
			'persjualbebas'=>'Persentase harga penjualan bebas',
			'hargajualglobal'=>'Mengguna	kan harga jual global yang ada di master obat alkes',
			'metodeantrian'=>'Metode antrian stok obat alkes',
			'pembulatanretail'=>'Pembulatan retail',
			'persdiskpasien'=>'Persen diskon penjualan resep',
			'persenmargin'=>'Persen margin ketika penerimaan obat dari supplier',
			'otomatismargin'=>'Otomatis margin ketika penerimaan obat dari supplier',
			'persenppnjual' => 'Persen PPN penjualan bebas',
			'administrasi' => 'Biaya administrasi (Rp)',
		);
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

		if(!empty($this->konfigfarmasi_id)){
			$criteria->addCondition('konfigfarmasi_id = '.$this->konfigfarmasi_id);
		}
		$criteria->compare('LOWER(tglberlaku)',strtolower($this->tglberlaku),true);
		$criteria->compare('persenppn',$this->persenppn);
		$criteria->compare('persenpph',$this->persenpph);
		$criteria->compare('bayarlangsung',$this->bayarlangsung);
		$criteria->compare('LOWER(pesandistruk)',strtolower($this->pesandistruk),true);
		$criteria->compare('LOWER(pesandifaktur)',strtolower($this->pesandifaktur),true);
		$criteria->compare('LOWER(formulajasadokter)',strtolower($this->formulajasadokter),true);
		$criteria->compare('LOWER(formulajasaparamedis)',strtolower($this->formulajasaparamedis),true);
		$criteria->compare('LOWER(hargaygdigunakan)',strtolower($this->hargaygdigunakan),true);
		$criteria->compare('pembulatanharga',$this->pembulatanharga);
		$criteria->compare('ri_persjualppn',$this->ri_persjualppn);
		$criteria->compare('rd_persjualppn',$this->rd_persjualppn);
		$criteria->compare('rj_persjualppn',$this->rj_persjualppn);
		$criteria->compare('konfigfarmasi_aktif',$this->konfigfarmasi_aktif);
		$criteria->compare('administrasi',$this->administrasi);
		$criteria->compare('persjualbebas',$this->persjualbebas);
		$criteria->compare('hargajualglobal',$this->hargajualglobal);
		$criteria->compare('persdiskpasien',$this->persdiskpasien);
		$criteria->compare('otomatismargin',$this->otomatismargin);
		$criteria->compare('persenmargin',$this->persenmargin);
		$criteria->compare('LOWER(metodeantrian)',strtolower($this->metodeantrian),true);
		$criteria->compare('persenppnjual',$this->persenppnjual);
		$criteria->compare('nilai_vital',$this->nilai_vital);
		$criteria->compare('nilai_esensial',$this->nilai_esensial);
		$criteria->compare('nilai_nonesensial',$this->nilai_nonesensial);
		$criteria->compare('nilai_a_persen',$this->nilai_a_persen);
		$criteria->compare('nilai_b_persen',$this->nilai_b_persen);
		$criteria->compare('nilai_c_persen',$this->nilai_c_persen);
		$criteria->compare('metode_pemberian',$this->metode_pemberian,true);

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
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
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

		public function getAttributeTooltip($attribute)
		{
			$labels=$this->attributeTooltips();
			if(isset($labels[$attribute]))
				return $labels[$attribute];
			else if(strpos($attribute,'.')!==false)
			{
				$segs=explode('.',$attribute);
				$name=array_pop($segs);
				$model=$this;
				foreach($segs as $seg)
				{
					$relations=$model->getMetaData()->relations;
					if(isset($relations[$seg]))
						$model=CActiveRecord::model($relations[$seg]->className);
					else
						break;
				}
				return $model->getAttributeLabel($name);
			}
			else
				return $this->generateAttributeLabel($attribute);
		}
}
