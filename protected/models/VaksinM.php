<?php

/**
 * This is the model class for table "vaksin_m".
 *
 * The followings are the available columns in table 'vaksin_m':
 * @property integer $vaksin_id
 * @property integer $jenisvaksin_id
 * @property string $imunisasi_kategori
 * @property string $imunisasi_frekuensi
 * @property string $imunisasi_level
 * @property string $imunisasi_program
 * @property string $kategori_pasien
 * @property string $imunisasi_sumberdana
 * @property boolean $vaksin_aktif
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property JenisvaksinM $jenisvaksin
 * @property DaftarvaksinM[] $daftarvaksinMs
 */
class VaksinM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vaksin_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisvaksin_id, imunisasi_kategori, kategori_pasien, imunisasi_sumberdana, create_time, create_loginpemakai', 'required'),
			array('jenisvaksin_id, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('imunisasi_kategori, imunisasi_sumberdana', 'length', 'max'=>50),
			array('imunisasi_frekuensi, imunisasi_level, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('imunisasi_program, kategori_pasien', 'length', 'max'=>200),
			array('vaksin_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('vaksin_id, jenisvaksin_id, imunisasi_kategori, imunisasi_frekuensi, imunisasi_level, imunisasi_program, kategori_pasien, imunisasi_sumberdana, vaksin_aktif, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'jenisvaksin' => array(self::BELONGS_TO, 'JenisvaksinM', 'jenisvaksin_id'),
			'daftarvaksinMs' => array(self::HAS_MANY, 'DaftarvaksinM', 'vaksin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'vaksin_id' => 'Vaksin',
			'jenisvaksin_id' => 'Jenis Vaksin',
			'imunisasi_kategori' => 'Kategori Vaksinasi/Imunisasi',
			'imunisasi_frekuensi' => 'Frekuensi Vaksinasi/Imunisasi',
			'imunisasi_level' => 'Level Vaksinasi/Imunisasi',
			'imunisasi_program' => 'Nama Program Vaksinasi/Imunisasi',
			'kategori_pasien' => 'Kategori Pasien',
			'imunisasi_sumberdana' => 'Sumber Dana',
			'vaksin_aktif' => 'Vaksin Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('vaksin_id',$this->vaksin_id);
		$criteria->compare('jenisvaksin_id',$this->jenisvaksin_id);
		$criteria->compare('imunisasi_kategori',$this->imunisasi_kategori,true);
		$criteria->compare('imunisasi_frekuensi',$this->imunisasi_frekuensi,true);
		$criteria->compare('imunisasi_level',$this->imunisasi_level,true);
		$criteria->compare('imunisasi_program',$this->imunisasi_program,true);
		$criteria->compare('kategori_pasien',$this->kategori_pasien,true);
		$criteria->compare('imunisasi_sumberdana',$this->imunisasi_sumberdana,true);
		$criteria->compare('vaksin_aktif',$this->vaksin_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VaksinM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
