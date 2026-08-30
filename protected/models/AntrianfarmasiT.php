<?php

/**
 * This is the model class for table "antrianfarmasi_t".
 *
 * The followings are the available columns in table 'antrianfarmasi_t':
 * @property integer $antrianfarmasi_id
 * @property integer $racikan_id
 * @property integer $ruangan_id
 * @property string $tglambilantrian
 * @property string $noantrian
 * @property boolean $panggilantrian
 * @property boolean $antrianlewat
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PenjualanresepT[] $penjualanresepTs
 * @property RacikanM $racikan
 * @property RuanganM $ruangan
 */
class AntrianfarmasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianfarmasiT the static model class
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
		return 'antrianfarmasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('racikan_id, ruangan_id, tglambilantrian, noantrian, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('racikan_id, ruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('noantrian', 'length', 'max'=>6),
			array('panggilantrian, antrianlewat, update_time, reseptur_id, modelantrian_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('modelantrian_id, antrianfarmasi_id, racikan_id, ruangan_id, tglambilantrian, noantrian, panggilantrian, antrianlewat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'penjualanresepTs' => array(self::HAS_MANY, 'PenjualanresepT', 'antiranfarmasi_id'),
			'racikan' => array(self::BELONGS_TO, 'RacikanM', 'racikan_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'antrianfarmasi_id' => 'Antrian farmasi',
			'racikan_id' => 'Racikan',
			'ruangan_id' => 'Ruangan',
			'tglambilantrian' => 'Tanggal Ambil Antrian',
			'noantrian' => 'No. Antrian',
			'panggilantrian' => 'Antrian Dipanggil',
			'antrianlewat' => 'Antrian Dilewat',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('antrianfarmasi_id',$this->antrianfarmasi_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(tglambilantrian)',strtolower($this->tglambilantrian),true);
		$criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
		$criteria->compare('panggilantrian',$this->panggilantrian);
		$criteria->compare('antrianlewat',$this->antrianlewat);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

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