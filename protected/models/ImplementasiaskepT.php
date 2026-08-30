<?php

/**
 * This is the model class for table "implementasiaskep_t".
 *
 * The followings are the available columns in table 'implementasiaskep_t':
 * @property integer $implementasiaskep_id
 * @property integer $implementasikeperawatan_id
 * @property integer $asuhankeperawatan_id
 * @property string $tglmulaiimplementasi
 * @property string $implementasi_nama
 * @property boolean $iskolaborasi
 */
class ImplementasiaskepT extends CActiveRecord
{
        public $nama_pegawai, $no_rencana, $ruangan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImplementasiaskepT the static model class
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
		return 'implementasiaskep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('tglmulaiimplementasi, implementasi_nama', 'required'),
			array('implementasikeperawatan_id, asuhankeperawatan_id', 'numerical', 'integerOnly'=>true),
			array('iskolaborasi, rencanaaskep_id, ruangan_id, pegawai_id, no_implementasi, implementasiaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('implementasiaskep_id, implementasikeperawatan_id, asuhankeperawatan_id, tglmulaiimplementasi, implementasi_nama, iskolaborasi', 'safe', 'on'=>'search'),
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
                    'implementasikeperawatan'=>array(self::BELONGS_TO, 'ImplementasikeperawatanM', 'implementasikeperawatan_id'),
                    'rencanaaskep' => array(self::BELONGS_TO, 'RencanaaskepT', 'rencanaaskep_id'),
                    'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'implementasiaskep_id' => 'Implementasiaskep',
			'implementasikeperawatan_id' => 'Implementasikeperawatan',
			'asuhankeperawatan_id' => 'Asuhankeperawatan',
			'tglmulaiimplementasi' => 'Tglmulaiimplementasi',
			'implementasi_nama' => 'Implementasi Nama',
			'iskolaborasi' => 'Iskolaborasi',
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

		$criteria->compare('implementasiaskep_id',$this->implementasiaskep_id);
		$criteria->compare('implementasikeperawatan_id',$this->implementasikeperawatan_id);
		$criteria->compare('asuhankeperawatan_id',$this->asuhankeperawatan_id);
		$criteria->compare('LOWER(tglmulaiimplementasi)',strtolower($this->tglmulaiimplementasi),true);
		$criteria->compare('LOWER(implementasi_nama)',strtolower($this->implementasi_nama),true);
		$criteria->compare('iskolaborasi',$this->iskolaborasi);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('implementasiaskep_id',$this->implementasiaskep_id);
		$criteria->compare('implementasikeperawatan_id',$this->implementasikeperawatan_id);
		$criteria->compare('asuhankeperawatan_id',$this->asuhankeperawatan_id);
		$criteria->compare('LOWER(tglmulaiimplementasi)',strtolower($this->tglmulaiimplementasi),true);
		$criteria->compare('LOWER(implementasi_nama)',strtolower($this->implementasi_nama),true);
		$criteria->compare('iskolaborasi',$this->iskolaborasi);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}