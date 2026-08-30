<?php

/**
 * This is the model class for table "informasicopyresep_v".
 *
 * The followings are the available columns in table 'informasicopyresep_v':
 * @property integer $copyresep_id
 * @property string $tglcopy
 * @property string $keterangancopy
 * @property integer $jmlcopy
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pendaftaran_id
 * @property integer $penjamin_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $kelaspelayanan_id
 * @property integer $carabayar_id
 * @property integer $kelompokumur_id
 * @property integer $golonganumur_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property string $tglreseptur
 * @property string $noresep
 * @property integer $ruanganreseptur_id
 * @property string $fileresep
 * @property integer $resepturdetail_id
 * @property integer $obatalkes_id
 * @property integer $racikan_id
 * @property integer $satuankecil_id
 * @property integer $sumberdana_id
 * @property integer $reseptur_id
 * @property string $r
 * @property integer $rke
 * @property double $permintaan_reseptur
 * @property integer $jmlkemasan_reseptur
 * @property integer $kekuatan_reseptur
 * @property string $satuankekuatan
 * @property double $qty_obat
 * @property double $hargasatuan_reseptur
 * @property string $signa_reseptur
 * @property string $etiket
 * @property double $harganetto
 * @property string $obatalkes_nama
 * @property double $hargajual
 * @property integer $penjualanresep_id
 */
class InformasicopyresepV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasicopyresepV the static model class
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
		return 'informasicopyresep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('copyresep_id, jmlcopy, pendaftaran_id, penjamin_id, jeniskasuspenyakit_id, kelaspelayanan_id, carabayar_id, kelompokumur_id, golonganumur_id, ruangan_id, pasien_id, pegawai_id, ruanganreseptur_id, resepturdetail_id, obatalkes_id, racikan_id, satuankecil_id, sumberdana_id, reseptur_id, rke, jmlkemasan_reseptur, kekuatan_reseptur, penjualanresep_id', 'numerical', 'integerOnly'=>true),
			array('permintaan_reseptur, qty_obat, hargasatuan_reseptur, harganetto, hargajual', 'numerical'),
			array('no_pendaftaran, satuankekuatan', 'length', 'max'=>20),
			array('umur, signa_reseptur', 'length', 'max'=>30),
			array('kunjungan, statusperiksa, noresep', 'length', 'max'=>50),
			array('fileresep, obatalkes_nama', 'length', 'max'=>200),
			array('r', 'length', 'max'=>2),
			array('etiket', 'length', 'max'=>100),
			array('tglcopy, keterangancopy, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_pendaftaran, tglreseptur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, copyresep_id, tglcopy, keterangancopy, jmlcopy, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pendaftaran_id, penjamin_id, jeniskasuspenyakit_id, kelaspelayanan_id, carabayar_id, kelompokumur_id, golonganumur_id, no_pendaftaran, tgl_pendaftaran, umur, kunjungan, statusperiksa, ruangan_id, pasien_id, pegawai_id, tglreseptur, noresep, ruanganreseptur_id, fileresep, resepturdetail_id, obatalkes_id, racikan_id, satuankecil_id, sumberdana_id, reseptur_id, r, rke, permintaan_reseptur, jmlkemasan_reseptur, kekuatan_reseptur, satuankekuatan, qty_obat, hargasatuan_reseptur, signa_reseptur, etiket, harganetto, obatalkes_nama, hargajual, penjualanresep_id', 'safe', 'on'=>'search'),
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
			'copyresep_id' => 'Copyresep',
			'tglcopy' => 'Tglcopy',
			'keterangancopy' => 'Keterangancopy',
			'jmlcopy' => 'Jmlcopy',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'penjamin_id' => 'Penjamin',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'carabayar_id' => 'Jenis Penjamin',
			'kelompokumur_id' => 'Kelompokumur',
			'golonganumur_id' => 'Golonganumur',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'umur' => 'Umur',
			'kunjungan' => 'Kunjungan',
			'statusperiksa' => 'Statusperiksa',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'pegawai_id' => 'Pegawai',
			'tglreseptur' => 'Tglreseptur',
			'noresep' => 'Noresep',
			'ruanganreseptur_id' => 'Ruanganreseptur',
			'fileresep' => 'Fileresep',
			'resepturdetail_id' => 'Resepturdetail',
			'obatalkes_id' => 'Obatalkes',
			'racikan_id' => 'Racikan',
			'satuankecil_id' => 'Satuankecil',
			'sumberdana_id' => 'Sumberdana',
			'reseptur_id' => 'Reseptur',
			'r' => 'R',
			'rke' => 'Rke',
			'permintaan_reseptur' => 'Permintaan Reseptur',
			'jmlkemasan_reseptur' => 'Jmlkemasan Reseptur',
			'kekuatan_reseptur' => 'Kekuatan Reseptur',
			'satuankekuatan' => 'Satuankekuatan',
			'qty_obat' => 'Jumlah Obat',
			'hargasatuan_reseptur' => 'Hargasatuan Reseptur',
			'signa_reseptur' => 'Signa Reseptur',
			'etiket' => 'Etiket',
			'harganetto' => 'Harganetto',
			'obatalkes_nama' => 'Obatalkes Nama',
			'hargajual' => 'Hargajual',
			'penjualanresep_id' => 'Penjualanresep',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('copyresep_id',$this->copyresep_id);
		$criteria->compare('LOWER(tglcopy)',strtolower($this->tglcopy),true);
		$criteria->compare('LOWER(keterangancopy)',strtolower($this->keterangancopy),true);
		$criteria->compare('jmlcopy',$this->jmlcopy);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglreseptur)',strtolower($this->tglreseptur),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruanganreseptur_id',$this->ruanganreseptur_id);
		$criteria->compare('LOWER(fileresep)',strtolower($this->fileresep),true);
		$criteria->compare('resepturdetail_id',$this->resepturdetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_reseptur',$this->permintaan_reseptur);
		$criteria->compare('jmlkemasan_reseptur',$this->jmlkemasan_reseptur);
		$criteria->compare('kekuatan_reseptur',$this->kekuatan_reseptur);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('qty_obat',$this->qty_obat);
		$criteria->compare('hargasatuan_reseptur',$this->hargasatuan_reseptur);
		$criteria->compare('LOWER(signa_reseptur)',strtolower($this->signa_reseptur),true);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('copyresep_id',$this->copyresep_id);
		$criteria->compare('LOWER(tglcopy)',strtolower($this->tglcopy),true);
		$criteria->compare('LOWER(keterangancopy)',strtolower($this->keterangancopy),true);
		$criteria->compare('jmlcopy',$this->jmlcopy);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglreseptur)',strtolower($this->tglreseptur),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruanganreseptur_id',$this->ruanganreseptur_id);
		$criteria->compare('LOWER(fileresep)',strtolower($this->fileresep),true);
		$criteria->compare('resepturdetail_id',$this->resepturdetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_reseptur',$this->permintaan_reseptur);
		$criteria->compare('jmlkemasan_reseptur',$this->jmlkemasan_reseptur);
		$criteria->compare('kekuatan_reseptur',$this->kekuatan_reseptur);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('qty_obat',$this->qty_obat);
		$criteria->compare('hargasatuan_reseptur',$this->hargasatuan_reseptur);
		$criteria->compare('LOWER(signa_reseptur)',strtolower($this->signa_reseptur),true);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}