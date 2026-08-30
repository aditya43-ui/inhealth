<?php

/**
 * This is the model class for table "penanggungjawab_m".
 *
 * The followings are the available columns in table 'penanggungjawab_m':
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $jenisidentitas
 * @property string $no_identitas
 * @property string $hubungankeluarga
 * @property string $nama_pj
 * @property string $tgllahir_pj
 * @property string $jeniskelamin
 * @property string $tempatlahir_pj
 * @property string $alamat_pj
 * @property string $no_teleponpj
 * @property string $no_mobilepj
 * @property boolean $penanggungjawab_aktif
 * @property string $no_identitas_pj
 *
 * The followings are the available model relations:
 * @property PendaftaranT[] $pendaftaranTs
 */
class PenanggungjawabM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenanggungjawabM the static model class
	 */

	public $umur_pj, $nama_pegawai, $jabatan_nama, $unit_perusahaan, $umur;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'penanggungjawab_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengantar, nama_pj, jeniskelamin', 'required'),
			array('pengantar, no_identitas, hubungankeluarga, nama_pj, no_identitas_pj', 'length', 'max'=>50),
			array('jenisidentitas, jeniskelamin, tempatlahir_pj', 'length', 'max'=>20),
			array('no_teleponpj, no_mobilepj', 'length', 'max'=>15),
			array('pekerjaan_id, tgllahir_pj, alamat_pj, penanggungjawab_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penanggungjawab_id, pengantar, jenisidentitas, no_identitas, hubungankeluarga, nama_pj, tgllahir_pj, jeniskelamin, tempatlahir_pj, alamat_pj, no_teleponpj, no_mobilepj, penanggungjawab_aktif, no_identitas_pj', 'safe', 'on'=>'search'),
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
                    'pendaftaranTs' => array(self::HAS_MANY, 'PendaftaranT', 'penanggungjawab_id'),
                    'pekerjaan' => array(self::HAS_MANY, 'PekerjaanM', 'pekerjaan_id'),
                    'createlogin' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penanggungjawab_id' => 'Penanggung Jawab',
			'pengantar' => 'Pengantar',
			'jenisidentitas' => 'Jenis Identitas',
			'no_identitas' => 'No. Identitas',
			'hubungankeluarga' => 'Hubungan Keluarga',
			'nama_pj' => 'Nama',
			'tgllahir_pj' => 'Tanggal Lahir',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempatlahir_pj' => 'Tempat Lahir',
			'alamat_pj' => 'Alamat',
			'no_teleponpj' => 'No. Telepon',
			'no_mobilepj' => 'No. Handphone',
			'penanggungjawab_aktif' => 'Penanggung Jawab Aktif',
			'no_identitas_pj' => 'No. Identitas',
			'pekerjaan_id' => 'Pekerjaan',
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

		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas)',strtolower($this->no_identitas),true);
		$criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		$criteria->compare('LOWER(tgllahir_pj)',strtolower($this->tgllahir_pj),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempatlahir_pj)',strtolower($this->tempatlahir_pj),true);
		$criteria->compare('LOWER(alamat_pj)',strtolower($this->alamat_pj),true);
		$criteria->compare('LOWER(no_teleponpj)',strtolower($this->no_teleponpj),true);
		$criteria->compare('LOWER(no_mobilepj)',strtolower($this->no_mobilepj),true);
		$criteria->compare('penanggungjawab_aktif',$this->penanggungjawab_aktif);
		$criteria->compare('LOWER(no_identitas_pj)',strtolower($this->no_identitas_pj),true);

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