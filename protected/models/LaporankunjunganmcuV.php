<?php

/**
 * This is the model class for table "laporankunjunganmcu_v".
 *
 * The followings are the available columns in table 'laporankunjunganmcu_v':
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $tanggal_lahir
 * @property string $umur
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $pegawai_id
 * @property string $dokter
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property double $pakettindakan
 * @property double $non_pakettindakan
 */
class LaporankunjunganmcuV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankunjunganmcuV the static model class
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
		return 'laporankunjunganmcu_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, penjamin_id, pegawai_id, jeniskasuspenyakit_id', 'numerical', 'integerOnly'=>true),
			array('pakettindakan, non_pakettindakan', 'numerical'),
			array('no_pendaftaran, jeniskelamin', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, penjamin_nama, dokter', 'length', 'max'=>50),
			array('umur', 'length', 'max'=>30),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('tgl_pendaftaran, tanggal_lahir, alamat_pasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_pendaftaran, no_pendaftaran, pasien_id, no_rekam_medik, nama_pasien, tanggal_lahir, umur, jeniskelamin, alamat_pasien, penjamin_id, penjamin_nama, pegawai_id, dokter, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, pakettindakan, non_pakettindakan', 'safe', 'on'=>'search'),
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
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'tanggal_lahir' => 'Tanggal Lahir',
			'umur' => 'Umur',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'pegawai_id' => 'Pegawai',
			'dokter' => 'Dokter',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
			'pakettindakan' => 'Paket Tindakan',
			'non_pakettindakan' => 'Non Paket Tindakan',
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

		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(dokter)',strtolower($this->dokter),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('pakettindakan',$this->pakettindakan);
		$criteria->compare('non_pakettindakan',$this->non_pakettindakan);

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
}