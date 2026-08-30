<?php

/**
 * This is the model class for table "tindakananestesi_t".
 *
 * The followings are the available columns in table 'tindakananestesi_t':
 * @property integer $tindakananestesi_id
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property integer $anastesi_id
 * @property integer $praanestesi_id
 * @property integer $intraanestesi_id
 * @property integer $ruangan_id
 * @property integer $alatmedis_id
 * @property string $tgl_tindakananestesi
 * @property integer $qty_tindakan
 * @property double $tarif_tindakan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property AlatmedisM $alatmedis
 * @property AnastesiM $anastesi
 * @property DaftartindakanM $daftartindakan
 * @property IntraanestesiT $intraanestesi
 * @property PraanestesiT $praanestesi
 * @property RuanganM $ruangan
 * @property TindakanpelayananT $tindakanpelayanan
 */
class TindakananestesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakananestesiT the static model class
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
		return 'tindakananestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anastesi_id, tgl_tindakananestesi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('tindakanpelayanan_id, daftartindakan_id, anastesi_id, praanestesi_id, intraanestesi_id, ruangan_id, alatmedis_id, qty_tindakan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tarif_tindakan', 'numerical'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakananestesi_id, tindakanpelayanan_id, daftartindakan_id, anastesi_id, praanestesi_id, intraanestesi_id, ruangan_id, alatmedis_id, tgl_tindakananestesi, qty_tindakan, tarif_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'alatmedis' => array(self::BELONGS_TO, 'AlatmedisM', 'alatmedis_id'),
			'anastesi' => array(self::BELONGS_TO, 'AnastesiM', 'anastesi_id'),
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'intraanestesi' => array(self::BELONGS_TO, 'IntraanestesiT', 'intraanestesi_id'),
			'praanestesi' => array(self::BELONGS_TO, 'PraanestesiT', 'praanestesi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakananestesi_id' => 'Tindakan Anestesi',
			'tindakanpelayanan_id' => 'Tindakan Pelayanan',
			'daftartindakan_id' => 'Daftar Tindakan',
			'anastesi_id' => 'Anastesi',
			'praanestesi_id' => 'Pra Anestesi',
			'intraanestesi_id' => 'Intra Anestesi',
			'ruangan_id' => 'Ruangan',
			'alatmedis_id' => 'Alat Medis',
			'tgl_tindakananestesi' => 'Tgl. Tindakan Anestesi',
			'qty_tindakan' => 'Jumlah Tindakan',
			'tarif_tindakan' => 'Nominal Tarif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		if(!empty($this->tindakananestesi_id)){
			$criteria->addCondition('tindakananestesi_id = '.$this->tindakananestesi_id);
		}
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		if(!empty($this->anastesi_id)){
			$criteria->addCondition('anastesi_id = '.$this->anastesi_id);
		}
		if(!empty($this->praanestesi_id)){
			$criteria->addCondition('praanestesi_id = '.$this->praanestesi_id);
		}
		if(!empty($this->intraanestesi_id)){
			$criteria->addCondition('intraanestesi_id = '.$this->intraanestesi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->alatmedis_id)){
			$criteria->addCondition('alatmedis_id = '.$this->alatmedis_id);
		}
		$criteria->compare('LOWER(tgl_tindakananestesi)',strtolower($this->tgl_tindakananestesi),true);
		if(!empty($this->qty_tindakan)){
			$criteria->addCondition('qty_tindakan = '.$this->qty_tindakan);
		}
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

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