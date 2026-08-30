<?php

/**
 * This is the model class for table "renkebbarang_t".
 *
 * The followings are the available columns in table 'renkebbarang_t':
 * @property integer $renkebbarang_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property string $renkebbarang_tgl
 * @property string $renkebbarang_no
 * @property integer $pegmengetahui_id
 * @property integer $pegmenyetujui_id
 * @property integer $ro_barang_bulan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemekai_id
 * @property integer $update_loginpemekai_id
 * @property integer $create_ruangan
 */
class RenkebbarangT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RenkebbarangT the static model class
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
		return 'renkebbarang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pegawai_id, renkebbarang_tgl, renkebbarang_no, ro_barang_bulan, create_time, create_loginpemekai_id, create_ruangan, sumberdana_id', 'required'),
			array('ruangan_id, pegawai_id, pegmengetahui_id, pegmenyetujui_id, ro_barang_bulan, create_loginpemekai_id, update_loginpemekai_id, create_ruangan, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('renkebbarang_no', 'length', 'max'=>50),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('renkebbarang_id, ruangan_id, pegawai_id, renkebbarang_tgl, renkebbarang_no, pegmengetahui_id, pegmenyetujui_id, ro_barang_bulan, create_time, update_time, create_loginpemekai_id, update_loginpemekai_id, create_ruangan, tglmengetahui, tglmenyetujui, sumberdana_id', 'safe', 'on'=>'search'),
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
			'pegawaimenyetujui'=>array(self::BELONGS_TO, 'PegawaiM', 'pegmenyetujui_id'),
			'pegawaimengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),
			'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'sumberdana'=>array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'renkebbarang_id' => 'Renkebbarang',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'renkebbarang_tgl' => 'Tanggal Rencana',
			'renkebbarang_no' => 'No. Rencana',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'pegmenyetujui_id' => 'Pegawai Menyetujui',
			'ro_barang_bulan' => 'Ro Barang Bulan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemekai_id' => 'Create Loginpemekai',
			'update_loginpemekai_id' => 'Update Loginpemekai',
			'create_ruangan' => 'Create Ruangan',
                        'sumberdana_id' => 'Sumber Dana'
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

		if(!empty($this->renkebbarang_id)){
			$criteria->addCondition('renkebbarang_id = '.$this->renkebbarang_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(renkebbarang_tgl)',strtolower($this->renkebbarang_tgl),true);
		$criteria->compare('LOWER(renkebbarang_no)',strtolower($this->renkebbarang_no),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegmenyetujui_id)){
			$criteria->addCondition('pegmenyetujui_id = '.$this->pegmenyetujui_id);
		}
		if(!empty($this->ro_barang_bulan)){
			$criteria->addCondition('ro_barang_bulan = '.$this->ro_barang_bulan);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemekai_id)){
			$criteria->addCondition('create_loginpemekai_id = '.$this->create_loginpemekai_id);
		}
		if(!empty($this->update_loginpemekai_id)){
			$criteria->addCondition('update_loginpemekai_id = '.$this->update_loginpemekai_id);
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