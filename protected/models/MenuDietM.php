<?php

/**
 * This is the model class for table "menudiet_m".
 *
 * The followings are the available columns in table 'menudiet_m':
 * @property integer $menudiet_id
 * @property integer $jenisdiet_id
 * @property string $menudiet_nama
 * @property string $menudiet_namalain
 * @property double $jml_porsi
 * @property string $ukuranrumahtangga
 * @property integer $daftartindakan_id
 */
class MenuDietM extends CActiveRecord
{
                public $jenisdiet_nama;
                public $menudiet_nama;
                public $daftartindakan_nama;
                public $harga_tariftindakan;
                public $kelaspelayanan_nama,$kelaspelayanan_id;
                public $idKelasPelayanan,$idJenisDiet, $tipediet_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MenuDietM the static model class
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
		return 'menudiet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiet_id, menudiet_nama, jml_porsi', 'required'),
			array('jenisdiet_id, daftartindakan_id, tipediet_id', 'numerical', 'integerOnly'=>true),
			array('jml_porsi', 'numerical'),
			array('menudiet_nama, menudiet_namalain', 'length', 'max'=>200),
			array('ukuranrumahtangga', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idJenisDiet, idKelasPelayanan,menudiet_id, jenistarif_id,jenisdiet_id, menudiet_nama, menudiet_namalain, jenisdiet_nama, jml_porsi, ukuranrumahtangga,daftartindakan_id, tipediet_id', 'safe', 'on'=>'search'),
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
                    'jenisdiet' => array(self::BELONGS_TO, 'JenisdietM', 'jenisdiet_id'),
                    'menudiet' => array(self::BELONGS_TO, 'MenuDietM', 'menudiet_id'),
                    'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
                    'tipediet' => array(self::BELONGS_TO, 'TipeDietM', 'tipediet_id'),
                    'jeniswaktu' => array(self::BELONGS_TO, 'JeniswaktuM', 'jeniswaktu_id'),
                    'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'menudiet_id' => 'ID',
			'jenisdiet_id' => 'Jenis Diet',
			'menudiet_nama' => 'Menu Diet',
			'menudiet_namalain' => 'Nama Lain Menu',
			'jml_porsi' => 'Jumlah Porsi',
			'ukuranrumahtangga' => 'URT',
                        'daftartindakan_id'=>'Tindakan Menu Diet',
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

        $criteria->select = 't.*, jenisdiet_m.*';
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jenisdiet_m.jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(jenisdiet_m.jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('LOWER(menudiet_nama)',strtolower($this->menudiet_nama),true);
		$criteria->compare('LOWER(menudiet_namalain)',strtolower($this->menudiet_namalain),true);
		$criteria->compare('jml_porsi',$this->jml_porsi);

		$criteria->compare('LOWER(ukuranrumahtangga)',strtolower($this->ukuranrumahtangga),true);
		$criteria->join = 'LEFT JOIN jenisdiet_m on jenisdiet_m.jenisdiet_id = t.jenisdiet_id';
                                                   

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,                       
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                
		$criteria->select = 't.*, tariftindakan_m.*, kelaspelayanan_m.*';
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(menudiet_nama)',strtolower($this->menudiet_nama),true);
		$criteria->compare('LOWER(menudiet_namalain)',strtolower($this->menudiet_namalain),true);
		$criteria->compare('jml_porsi',$this->jml_porsi);
		$criteria->compare('LOWER(ukuranrumahtangga)',strtolower($this->ukuranrumahtangga),true);
		$criteria->join = 'LEFT JOIN tariftindakan_m on tariftindakan_m.daftartindakan_id = t.daftartindakan_id 
						   LEFT JOIN kelaspelayanan_m on kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id';
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
        }
        
        public function getJenisDietItems()
        {
            return JenisdietM::Model()->findAll('jenisdiet_aktif=TRUE ORDER BY jenisdiet_nama');
        }        
        
        public function getURTItems()
        {
            return LookupM::Model()->findAll("lookup_type='ukuranrumahtangga' ORDER BY lookup_name");
        }     
        
        public static function getMenuDietItems()
        {
            return self::Model()->findAllByAttributes([],['order'=>'menudiet_nama ASC']);
        }  
}