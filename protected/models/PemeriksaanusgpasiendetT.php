<?php

/**
 * This is the model class for table "pemeriksaanusgpasiendet_t".
 *
 * The followings are the available columns in table 'pemeriksaanusgpasiendet_t':
 * @property integer $pemeriksaanusgpasiendet_id
 * @property integer $pemeriksaanusgpasien_id
 * @property integer $janinke
 * @property string $kantongkehamilan
 * @property string $fetalecho
 * @property string $pulsasi
 * @property double $biometri_gs
 * @property double $biometri_crl
 * @property double $biometri_bpd
 * @property double $biometri_fl
 * @property string $patologi
 * @property integer $denyutjantungjanin
 * @property string $gravid
 * @property string $taksiranmelahirkan
 * @property string $kondisijaninkeseluruhan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PemeriksaanusgpasienT $pemeriksaanusgpasien
 */
class PemeriksaanusgpasiendetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanusgpasiendetT the static model class
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
		return 'pemeriksaanusgpasiendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanusgpasien_id, create_time, create_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'required'),
			array('pemeriksaanusgpasien_id, janinke, denyutjantungjanin, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('biometri_gs, biometri_crl, biometri_bpd, biometri_fl, taksiranberatjanin, biometri_ac', 'numerical'),
			array('kantongkehamilan, fetalecho, pulsasi, letakkehamilan, jml_air_ketuban, bunyijantung, jeniskelamin, insertio_plasenta', 'length', 'max'=>50),
			array('gravid, create_loginpemakai, update_loginpemakai, presentasi_janin, jeniskelamin_lainnya', 'length', 'max'=>100),
			array('patologi, taksiranmelahirkan, kondisijaninkeseluruhan, update_time, talipusat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanusgpasiendet_id, pemeriksaanusgpasien_id, janinke, kantongkehamilan, fetalecho, pulsasi, biometri_gs, biometri_crl, biometri_bpd, biometri_fl, patologi, denyutjantungjanin, gravid, taksiranmelahirkan, kondisijaninkeseluruhan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id, letakkehamilan, taksiranberatjanin, jml_air_ketuban, talipusat, presentasi_janin, bunyijantung, jeniskelamin, jeniskelamin_lainnya, biometri_ac, insertio_plasenta', 'safe', 'on'=>'search'),
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
			'pemeriksaanusgpasien' => array(self::BELONGS_TO, 'PemeriksaanusgpasienT', 'pemeriksaanusgpasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanusgpasiendet_id' => 'Pemeriksaanusgpasiendet',
			'pemeriksaanusgpasien_id' => 'Pemeriksaanusgpasien',
			'janinke' => 'Janinke',
			'kantongkehamilan' => 'Kantongkehamilan',
			'fetalecho' => 'Fetalecho',
			'pulsasi' => 'Pulsasi',
			'biometri_gs' => 'Biometri Gs',
			'biometri_crl' => 'Biometri Crl',
			'biometri_bpd' => 'Biometri Bpd',
			'biometri_fl' => 'Biometri Fl',
			'patologi' => 'Patologi',
			'denyutjantungjanin' => 'Denyutjantungjanin',
			'gravid' => 'Gravid',
			'taksiranmelahirkan' => 'Taksiranmelahirkan',
			'kondisijaninkeseluruhan' => 'Kondisijaninkeseluruhan',
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
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pemeriksaanusgpasiendet_id',$this->pemeriksaanusgpasiendet_id);
		$criteria->compare('pemeriksaanusgpasien_id',$this->pemeriksaanusgpasien_id);
		$criteria->compare('janinke',$this->janinke);
		$criteria->compare('kantongkehamilan',$this->kantongkehamilan,true);
		$criteria->compare('fetalecho',$this->fetalecho,true);
		$criteria->compare('pulsasi',$this->pulsasi,true);
		$criteria->compare('biometri_gs',$this->biometri_gs);
		$criteria->compare('biometri_crl',$this->biometri_crl);
		$criteria->compare('biometri_bpd',$this->biometri_bpd);
		$criteria->compare('biometri_fl',$this->biometri_fl);
		$criteria->compare('patologi',$this->patologi,true);
		$criteria->compare('denyutjantungjanin',$this->denyutjantungjanin);
		$criteria->compare('gravid',$this->gravid,true);
		$criteria->compare('taksiranmelahirkan',$this->taksiranmelahirkan,true);
		$criteria->compare('kondisijaninkeseluruhan',$this->kondisijaninkeseluruhan,true);
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
}