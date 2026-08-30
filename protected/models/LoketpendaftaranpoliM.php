<?php

/**
 * This is the model class for table "loketpendaftaranpoli_m".
 *
 * The followings are the available columns in table 'loketpendaftaranpoli_m':
 * @property integer $loketpendaftaranpoli_id
 * @property integer $loket_id
 * @property integer $ruangan_id
 * @property string $loket_nama
 * @property string $ruangan_nama
 */
class LoketpendaftaranpoliM extends CActiveRecord
{
        public $loket_singkatan;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'loketpendaftaranpoli_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('loket_id, ruangan_id', 'required'),
			array('loket_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('loket_nama, ruangan_nama', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('loketpendaftaranpoli_id, loket_id, ruangan_id, loket_nama, ruangan_nama', 'safe', 'on'=>'search'),
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
                    'ruangan' => [self::BELONGS_TO,'RuanganM','ruangan_id'],
                    'loket' => [self::BELONGS_TO,'LoketM','loket_id'],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'loketpendaftaranpoli_id' => 'Loketpendaftaranpoli',
			'loket_id' => 'Loket',
			'ruangan_id' => 'Ruangan',
			'loket_nama' => 'Loket Nama',
			'ruangan_nama' => 'Ruangan Nama',
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
	public function searchLoket()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;  
                $criteria->group = "loket_id,loket_nama";
                $criteria->select = $criteria->group.', loket_id as loketpendaftaranpoli_id';
		$criteria->compare('LOWER(loket_nama)', strtolower($this->loket_nama), true);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoketpendaftaranpoliM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function listLoket($start = 0, $end = 6){
            $cri = new CDbCriteria;
            $cri->join = " JOIN loket_m l ON l.loket_id = t.loket_id ";
            $cri->group = $cri->select = "l.loket_singkatan, t.loket_id, l.loket_nourut";
            $cri->order = " l.loket_nourut ASC";
            $cri->offset = $start;
            $cri->limit = $end;
            return CHtml::listData(self::model()->findAll($cri),'loket_id','loket_singkatan');
        }
        
        public static function listRuanganId(){
            $cri = new CDbCriteria;
            $cri->group = $cri->select = " ruangan_id, ruangan_nama ";
            return CHtml::listData(self::model()->findAll($cri),'ruangan_id','ruangan_id');
        }


		public static function listRuanganLoket() {

			$cr = new CDbCriteria;
			$cr->select = 'ruangan_id, ruangan_nama';
			$cr->group = $cr->select;
	
            return CHtml::listData(self::model()->findAll($cr),'ruangan_id','ruangan_nama');
		}
}
