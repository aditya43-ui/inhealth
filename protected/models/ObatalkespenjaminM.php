<?php

/**
 * This is the model class for table "obatalkespenjamin_m".
 *
 * The followings are the available columns in table 'obatalkespenjamin_m':
 * @property integer $obatalkespenjamin_id
 * @property integer $penjamin_id
 * @property integer $jenisobatalkes_id
 * @property double $hpp_min
 * @property double $hpp_maks
 * @property double $persmargin
 * @property double $persdiskon
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PenjaminpasienM $penjamin
 * @property JenisobatalkesM $jenisobatalkes
 */
class ObatalkespenjaminM extends CActiveRecord
{
	public $penjamin_nama,$jenisobatalkes_nama, $carabayar_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkespenjaminM the static model class
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
		return 'obatalkespenjamin_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjamin_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('penjamin_id, jenisobatalkes_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, carabayar_id', 'numerical', 'integerOnly'=>true),
			array('hpp_min, hpp_maks, persmargin, persdiskon, biayaadministrasi', 'numerical'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkespenjamin_id, penjamin_id, jenisobatalkes_id, hpp_min, hpp_maks, persmargin, persdiskon, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, carabayar_id, biayaadministrasi', 'safe', 'on'=>'search'),
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
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'jenisobatalkes' => array(self::BELONGS_TO, 'JenisobatalkesM', 'jenisobatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkespenjamin_id' => 'Obat Alkes Penjamin',
			'penjamin_id' => 'Penjamin',
			'jenisobatalkes_id' => 'Jenis Obat Alkes',
			'hpp_min' => 'HPP Min',
			'hpp_maks' => 'HPP Maks',
			'persmargin' => 'Margin (%)',
			'persdiskon' => 'Keringanan (%)',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'carabayar_id'=>'Jenis Penjamin',
			'biayaadministrasi'=>'Biaya Administrasi (Rp)'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		
		if (!empty($this->penjamin_id)) {
			$criteria->addCondition('penjamin_id = ' . $this->penjamin_id);
		}
		
		if (!empty($this->jenisobatalkes_id)) {
			$criteria->addCondition('t.jenisobatalkes_id = ' . $this->jenisobatalkes_id);
		}

		if (!empty($this->carabayar_id)) {
			$criteria->addCondition('carabayar_id = ' . $this->carabayar_id);
		}
		$criteria->order = "carabayar_id, penjamin_id";
		
		return $criteria;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = $this->criteriaSearch();
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
}