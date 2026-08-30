<?php

/**
 * This is the model class for table "layarantrian_m".
 *
 * The followings are the available columns in table 'layarantrian_m':
 * @property integer $layarantrian_id
 * @property string $layarantrian_jenis
 * @property string $layarantrian_nama
 * @property string $layarantrian_judul
 * @property string $layarantrian_runningtext
 * @property string $layarantrian_latarbelakang
 * @property integer $layarantrian_maksitem
 * @property integer $layarantrian_itemhigh
 * @property integer $layarantrian_itemwidth
 * @property integer $layarantrian_intrefresh
 * @property boolean $layarantrian_aktif
 *
 * The followings are the available model relations:
 * @property RuanganM[] $ruanganMs
 */
class LayarantrianM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LayarantrianM the static model class
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
		return 'layarantrian_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('layarantrian_jenis, layarantrian_nama, layarantrian_judul, layarantrian_maksitem, layarantrian_itemhigh, layarantrian_itemwidth, layarantrian_intrefresh', 'required'),
			array('layarantrian_maksitem, layarantrian_itemhigh, layarantrian_itemwidth, layarantrian_intrefresh', 'numerical', 'integerOnly'=>true),
			array('layarantrian_jenis, layarantrian_nama', 'length', 'max'=>100),
			array('layarantrian_judul', 'length', 'max'=>200),
			array('layarantrian_latarbelakang', 'length', 'max'=>300),
			array('layarantrian_runningtext, layarantrian_aktif, modelantrianfarmasi_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('modelantrianfarmasi_id, layarantrian_id, layarantrian_jenis, layarantrian_nama, layarantrian_judul, layarantrian_runningtext, layarantrian_latarbelakang, layarantrian_maksitem, layarantrian_itemhigh, layarantrian_itemwidth, layarantrian_intrefresh, layarantrian_aktif', 'safe', 'on'=>'search'),
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
			'ruanganMs' => array(self::MANY_MANY, 'RuanganM', 'layarruangan_m(layarantrian_id, ruangan_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'layarantrian_id' => 'ID Layar Antrian',
			'layarantrian_jenis' => 'Jenis Layar Antrian',
			'layarantrian_nama' => 'Nama Layar Antrian',
			'layarantrian_judul' => 'Judul Layar Antrian',
			'layarantrian_runningtext' => 'Running Text',
			'layarantrian_latarbelakang' => 'Latar Belakang',
			'layarantrian_maksitem' => 'Item Maksimal',
			'layarantrian_itemhigh' => 'Tinggi Item (px)',
			'layarantrian_itemwidth' => 'Lebar Item (px)',
			'layarantrian_intrefresh' => 'Interval Refresh (detik)',
			'layarantrian_aktif' => 'Layar Antrian Aktif',
            'modelantrianfarmasi_id' => 'Model Antrian Farmasi',
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

		$criteria->compare('layarantrian_id',$this->layarantrian_id);
		$criteria->compare('LOWER(layarantrian_jenis)',strtolower($this->layarantrian_jenis),true);
		$criteria->compare('LOWER(layarantrian_nama)',strtolower($this->layarantrian_nama),true);
		$criteria->compare('LOWER(layarantrian_judul)',strtolower($this->layarantrian_judul),true);
		$criteria->compare('LOWER(layarantrian_runningtext)',strtolower($this->layarantrian_runningtext),true);
		$criteria->compare('LOWER(layarantrian_latarbelakang)',strtolower($this->layarantrian_latarbelakang),true);
		$criteria->compare('layarantrian_maksitem',$this->layarantrian_maksitem);
		$criteria->compare('modelantrianfarmasi_id',$this->modelantrianfarmasi_id);
		$criteria->compare('layarantrian_itemhigh',$this->layarantrian_itemhigh);
		$criteria->compare('layarantrian_itemwidth',$this->layarantrian_itemwidth);
		$criteria->compare('layarantrian_intrefresh',$this->layarantrian_intrefresh);
		$criteria->compare('layarantrian_aktif',isset($this->layarantrian_aktif)?$this->layarantrian_aktif:true);

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