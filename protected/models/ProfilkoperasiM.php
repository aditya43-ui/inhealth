<?php

/**
 * This is the model class for table "profilkoperasi_m".
 *
 * The followings are the available columns in table 'profilkoperasi_m':
 * @property integer $profilkoperasi_id
 * @property integer $profilrs_id
 * @property string $nama_profil
 * @property string $alamat_profil
 * @property string $propinsi_profil
 * @property string $kota_kab_profil
 * @property string $telp_profil
 * @property string $fax_profil
 * @property string $email_profil
 * @property string $visi_profil
 * @property string $misi_profil
 * @property string $waktu_layanan
 * @property string $textinfo1
 * @property string $textinfo2
 * @property string $textinfo3
 * @property string $textinfo4
 * @property string $valuestext1
 * @property string $valuestext2
 * @property string $valuestext3
 * @property string $path_valuesimage1
 * @property string $path_valuesimage2
 * @property string $path_valuesimage3
 * @property string $longitude
 * @property string $latitude
 * @property string $sloganwebsite1
 * @property string $sloganwebsite2
 * @property string $onlinesupport1
 * @property string $onlinesupport2
 * @property string $onlinemarketing1
 * @property string $onlinemarketing2
 * @property string $badanhukum
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property ProfilrumahsakitM $profilrs
 */
class ProfilkoperasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfilkoperasiM the static model class
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
		return 'profilkoperasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, nama_profil, alamat_profil, kota_kab_profil, email_profil, visi_profil, misi_profil, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('profilrs_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_profil, propinsi_profil, kota_kab_profil, waktu_layanan, valuestext1, valuestext2, valuestext3, path_valuesimage1, path_valuesimage2, path_valuesimage3, sloganwebsite1, sloganwebsite2, badanhukum', 'length', 'max'=>200),
			array('alamat_profil, textinfo1, textinfo3', 'length', 'max'=>300),
			array('telp_profil, fax_profil', 'length', 'max'=>50),
			array('email_profil, longitude, latitude, onlinesupport1, onlinesupport2, onlinemarketing2', 'length', 'max'=>100),
			array('visi_profil, textinfo2, textinfo4', 'length', 'max'=>500),
			array('onlinemarketing1, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilkoperasi_id, profilrs_id, nama_profil, alamat_profil, propinsi_profil, kota_kab_profil, telp_profil, fax_profil, email_profil, visi_profil, misi_profil, waktu_layanan, textinfo1, textinfo2, textinfo3, textinfo4, valuestext1, valuestext2, valuestext3, path_valuesimage1, path_valuesimage2, path_valuesimage3, longitude, latitude, sloganwebsite1, sloganwebsite2, onlinesupport1, onlinesupport2, onlinemarketing1, onlinemarketing2, badanhukum, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'profilkoperasi_id' => 'ID',
			'profilrs_id' => 'Profil RS',
			'nama_profil' => 'Nama Profil',
			'alamat_profil' => 'Alamat',
			'propinsi_profil' => 'Provinsi',
			'kota_kab_profil' => 'Kabupaten',
			'telp_profil' => 'Telp',
			'fax_profil' => 'Fax',
			'email_profil' => 'Email',
			'visi_profil' => 'Visi',
			'misi_profil' => 'Misi',
			'waktu_layanan' => 'Waktu Layanan',
			'textinfo1' => 'Text Info 1',
			'textinfo2' => 'Text Info 2',
			'textinfo3' => 'Text Info 3',
			'textinfo4' => 'Text Info 4',
			'valuestext1' => 'Values Text 1',
			'valuestext2' => 'Values Text 2',
			'valuestext3' => 'Values Text 3',
			'path_valuesimage1' => 'Gambar 1',
			'path_valuesimage2' => 'Gambar 2',
			'path_valuesimage3' => 'Gambar 3',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'sloganwebsite1' => 'Slogan Website 1',
			'sloganwebsite2' => 'Slogan Website 2',
			'onlinesupport1' => 'Online Support 1',
			'onlinesupport2' => 'Online Support 2',
			'onlinemarketing1' => 'Online Marketing 1',
			'onlinemarketing2' => 'Online Marketing 2',
			'badanhukum' => 'Badan Hukum',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('profilkoperasi_id',$this->profilkoperasi_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('nama_profil',$this->nama_profil,true);
		$criteria->compare('alamat_profil',$this->alamat_profil,true);
		$criteria->compare('propinsi_profil',$this->propinsi_profil,true);
		$criteria->compare('kota_kab_profil',$this->kota_kab_profil,true);
		$criteria->compare('telp_profil',$this->telp_profil,true);
		$criteria->compare('fax_profil',$this->fax_profil,true);
		$criteria->compare('email_profil',$this->email_profil,true);
		$criteria->compare('visi_profil',$this->visi_profil,true);
		$criteria->compare('misi_profil',$this->misi_profil,true);
		$criteria->compare('waktu_layanan',$this->waktu_layanan,true);
		$criteria->compare('textinfo1',$this->textinfo1,true);
		$criteria->compare('textinfo2',$this->textinfo2,true);
		$criteria->compare('textinfo3',$this->textinfo3,true);
		$criteria->compare('textinfo4',$this->textinfo4,true);
		$criteria->compare('valuestext1',$this->valuestext1,true);
		$criteria->compare('valuestext2',$this->valuestext2,true);
		$criteria->compare('valuestext3',$this->valuestext3,true);
		$criteria->compare('path_valuesimage1',$this->path_valuesimage1,true);
		$criteria->compare('path_valuesimage2',$this->path_valuesimage2,true);
		$criteria->compare('path_valuesimage3',$this->path_valuesimage3,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('sloganwebsite1',$this->sloganwebsite1,true);
		$criteria->compare('sloganwebsite2',$this->sloganwebsite2,true);
		$criteria->compare('onlinesupport1',$this->onlinesupport1,true);
		$criteria->compare('onlinesupport2',$this->onlinesupport2,true);
		$criteria->compare('onlinemarketing1',$this->onlinemarketing1,true);
		$criteria->compare('onlinemarketing2',$this->onlinemarketing2,true);
		$criteria->compare('badanhukum',$this->badanhukum,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getPropinsiNama(){
            $propinsi = PropinsiM::model()->findByPk($this->propinsi_profil);
            
            if (count((array)$propinsi)>0){
                return $propinsi->propinsi_nama;
            }else{
                return '';
            }                        
        }
        
        public function getKabupatenNama(){
            $kabupaten = KabupatenM::model()->findByPk($this->kota_kab_profil);
            
            if (count((array)$kabupaten)>0){
                return $kabupaten->kabupaten_nama;
            }else{
                return '';
            }                        
        }
}