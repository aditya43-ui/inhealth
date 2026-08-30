<?php

/**
 * This is the model class for table "penghargaoadetail_t".
 *
 * The followings are the available columns in table 'penghargaoadetail_t':
 * @property integer $penghargaoadetail_id
 * @property integer $pengajuanhargaoa_id
 * @property integer $obatalkes_id
 * @property integer $satuanbesar_id
 * @property integer $satuankecil_id
 * @property double $kemasanbesar
 * @property double $harganettolama
 * @property double $diskonlama
 * @property double $ppnlama
 * @property double $hpplama
 * @property double $marginlama
 * @property double $hargajuallama
 * @property double $harganettobaru
 * @property double $diskonbaru
 * @property double $ppnbaru
 * @property double $hppbaru
 * @property double $marginbaru
 * @property double $hargajualbaru
 * @property string $alasanperubahan
 * @property boolean $isperubahanharga
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengajuanhargaoaT $pengajuanhargaoa
 * @property ObatalkesM $obatalkes
 * @property SatuanbesarM $satuanbesar
 * @property SatuankecilM $satuankecil
 */
class PenghargaoadetailT extends CActiveRecord
{
    public $checklist;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenghargaoadetailT the static model class
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
		return 'penghargaoadetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengajuanhargaoa_id, obatalkes_id, harganettolama, diskonlama, ppnlama, hpplama, marginlama, hargajuallama, harganettobaru, diskonbaru, ppnbaru, hppbaru, marginbaru, hargajualbaru, alasanperubahan, create_time, create_loginpemakai', 'required'),
			array('pengajuanhargaoa_id, obatalkes_id, satuanbesar_id, satuankecil_id', 'numerical', 'integerOnly'=>true),
			array('kemasanbesar, harganettolama, diskonlama, ppnlama, hpplama, marginlama, hargajuallama, harganettobaru, diskonbaru, ppnbaru, hppbaru, marginbaru, hargajualbaru', 'numerical'),
			array('isperubahanharga, update_time, update_loginpemakai, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penghargaoadetail_id, pengajuanhargaoa_id, obatalkes_id, satuanbesar_id, satuankecil_id, kemasanbesar, harganettolama, diskonlama, ppnlama, hpplama, marginlama, hargajuallama, harganettobaru, diskonbaru, ppnbaru, hppbaru, marginbaru, hargajualbaru, alasanperubahan, isperubahanharga, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'pengajuanhargaoa' => array(self::BELONGS_TO, 'PengajuanhargaoaT', 'pengajuanhargaoa_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'satuanbesar' => array(self::BELONGS_TO, 'SatuanbesarM', 'satuanbesar_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penghargaoadetail_id' => 'Penghargaoadetail',
			'pengajuanhargaoa_id' => 'Pengajuanhargaoa',
			'obatalkes_id' => 'Obatalkes',
			'satuanbesar_id' => 'Satuanbesar',
			'satuankecil_id' => 'Satuankecil',
			'kemasanbesar' => 'Kemasanbesar',
			'harganettolama' => 'Harganettolama',
			'diskonlama' => 'Keringanan Lama',
			'ppnlama' => 'Ppnlama',
			'hpplama' => 'Hpplama',
			'marginlama' => 'Marginlama',
			'hargajuallama' => 'Hargajuallama',
			'harganettobaru' => 'Harganettobaru',
			'diskonbaru' => 'Keringanan Baru',
			'ppnbaru' => 'Ppnbaru',
			'hppbaru' => 'Hppbaru',
			'marginbaru' => 'Marginbaru',
			'hargajualbaru' => 'Hargajualbaru',
			'alasanperubahan' => 'Alasanperubahan',
			'isperubahanharga' => 'Isperubahanharga',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('penghargaoadetail_id',$this->penghargaoadetail_id);
		$criteria->compare('pengajuanhargaoa_id',$this->pengajuanhargaoa_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('harganettolama',$this->harganettolama);
		$criteria->compare('diskonlama',$this->diskonlama);
		$criteria->compare('ppnlama',$this->ppnlama);
		$criteria->compare('hpplama',$this->hpplama);
		$criteria->compare('marginlama',$this->marginlama);
		$criteria->compare('hargajuallama',$this->hargajuallama);
		$criteria->compare('harganettobaru',$this->harganettobaru);
		$criteria->compare('diskonbaru',$this->diskonbaru);
		$criteria->compare('ppnbaru',$this->ppnbaru);
		$criteria->compare('hppbaru',$this->hppbaru);
		$criteria->compare('marginbaru',$this->marginbaru);
		$criteria->compare('hargajualbaru',$this->hargajualbaru);
		$criteria->compare('alasanperubahan',$this->alasanperubahan,true);
		$criteria->compare('isperubahanharga',$this->isperubahanharga);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}