<?php

/**
 * This is the model class for table "carabayar_m".
 *
 * The followings are the available columns in table 'carabayar_m':
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property string $carabayar_namalainnya
 * @property string $metode_pembayaran
 * @property boolean $carabayar_aktif
 * @property string $carabayar_loket
 * @property string $carabayar_singkatan
 * @property integer $carabayar_nourut
 */
class CarabayarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarabayarM the static model class
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
		return 'carabayar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_nama', 'required'),
			array('carabayar_nourut', 'numerical', 'integerOnly'=>true),
			array('carabayar_nama, carabayar_namalainnya, metode_pembayaran, carabayar_loket, nama_carabayar_inacbg', 'length', 'max'=>50),
			array('kode_carabayar_inacbg', 'length', 'max'=>10),
			array('carabayar_singkatan', 'length', 'max'=>1),
			array('carabayar_aktif, issubsidiasuransi, issubsidipemerintah, issubsidirs', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('carabayar_id, issubsidiasuransi, issubsidipemerintah, issubsidirs, carabayar_nama, carabayar_namalainnya, metode_pembayaran, carabayar_aktif, carabayar_loket, carabayar_singkatan, carabayar_nourut, kode_carabayar_inacbg, nama_carabayar_inacbg', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'carabayar_id' => 'ID',


			'carabayar_nama' => 'Nama',
			'carabayar_namalainnya' => 'Nama Lainnya',
			'metode_pembayaran' => 'Metode Pembayaran',
			'carabayar_aktif' => 'Aktif',
			'carabayar_loket' => 'Loket',
			'carabayar_singkatan' => 'Singkatan',
			'carabayar_nourut' => 'No. Urut',

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

		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(carabayar_namalainnya)',strtolower($this->carabayar_namalainnya),true);
		$criteria->compare('LOWER(metode_pembayaran)',strtolower($this->metode_pembayaran),true);
		$criteria->compare('carabayar_aktif',isset($this->carabayar_aktif)?$this->carabayar_aktif:true);
		$criteria->compare('LOWER(carabayar_loket)',strtolower($this->carabayar_loket),true);
		$criteria->compare('LOWER(carabayar_singkatan)',strtolower($this->carabayar_singkatan),true);
		$criteria->compare('carabayar_nourut',$this->carabayar_nourut);
//                $criteria->addCondition('carabayar_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function arrBayarId(){
		$res = [];
		
		$cri = new CDbCriteria;                        
		$cri->addCondition(" carabayar_aktif = true ");
	
		$cri->order = " carabayar_nama ASC ";
		$load = self::model()->findAll($cri);
		
		if (!empty($load)){
			foreach($load as $key => $val){
				$res[$val->carabayar_id] = $val->carabayar_nama;
			}
		}
		
		return $res;
	}
        
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(carabayar_namalainnya)',strtolower($this->carabayar_namalainnya),true);
		$criteria->compare('LOWER(metode_pembayaran)',strtolower($this->metode_pembayaran),true);
		//$criteria->compare('carabayar_aktif',$this->carabayar_aktif);
		$criteria->compare('LOWER(carabayar_loket)',strtolower($this->carabayar_loket),true);
		$criteria->compare('LOWER(carabayar_singkatan)',strtolower($this->carabayar_singkatan),true);
		$criteria->compare('carabayar_nourut',$this->carabayar_nourut);
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        
         public function beforeSave() {
            //$this->ruangan_nama = ucwords(strtolower($this->ruangan_nama));
            $this->carabayar_namalainnya = strtoupper($this->carabayar_namalainnya);
            $this->carabayar_loket = strtoupper($this->carabayar_loket);
            $this->carabayar_singkatan = ucwords(strtolower($this->carabayar_singkatan));
            return parent::beforeSave();
        }
        
    public function getCarabayarItems()
    {
        return CarabayarM::model()->findAll("carabayar_aktif=TRUE ORDER BY carabayar_nama");
    }

    public function getCarabayarRek()
    {
    	$attributes = array("carabayar_id"=>$this->carabayar_id);

    	$result = CarapembrekM::model()->findAllByAttributes($attributes);
    	$data = "";
    	foreach ($result as $value)
    	{
    		$rec = Rekening5M::model()->findBypk($value['rekening5_id']);
    		$data .= "<li>" . $rec->nmrekening5 ." (". $rec->rekening5_nb .")</li>";
    	}
    	// var_dump($data);
    	// exit;
    	return $data;

    }  
        
}