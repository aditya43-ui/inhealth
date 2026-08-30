<?php

/**
 * This is the model class for table "jenisobatalkes_m".
 *
 * The followings are the available columns in table 'jenisobatalkes_m':
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property string $jenisobatalkes_namalain
 * @property boolean $jenisobatalkes_aktif
 * @property boolean $jenisobatalkes_farmasi
 */
class JenisobatalkesM extends CActiveRecord
{
	public $grouplayanan_id;
	public $grouplayanan_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisobatalkesM the static model class
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
		return 'jenisobatalkes_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisobatalkes_nama', 'required'),
			array('jenisobatalkes_nama, jenisobatalkes_namalain', 'length', 'max'=>50),
			array('jenisobatalkes_aktif, jenisobatalkes_farmasi, isbmhp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisobatalkes_id, jenisobatalkes_farmasi, jenisobatalkes_nama, jenisobatalkes_namalain, jenisobatalkes_aktif, isbmhp', 'safe', 'on'=>'search'),
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
			'jenisobatalkes_id' => 'ID',
			'jenisobatalkes_nama' => 'Nama Jenis Obat Alkes',
			'jenisobatalkes_namalain' => 'Nama Lainnya',
			'jenisobatalkes_aktif' => 'Aktif',
                        'jenisobatalkes_farmasi'=>'Jenis Farmasi'
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

		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(jenisobatalkes_namalain)',strtolower($this->jenisobatalkes_namalain),true);
		$criteria->compare('jenisobatalkes_aktif',isset($this->jenisobatalkes_aktif)?$this->jenisobatalkes_aktif:true);
		$criteria->compare('jenisobatalkes_farmasi', $this->jenisobatalkes_farmasi);
		$criteria->addCondition('jenisobatalkes_farmasi is true');
                // $criteria->order='jenisobatalkes_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchObatMaster()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(jenisobatalkes_namalain)',strtolower($this->jenisobatalkes_namalain),true);
		$criteria->addCondition('jenisobatalkes_aktif = true ');
		$criteria->compare('jenisobatalkes_farmasi', $this->jenisobatalkes_farmasi);
		$criteria->addCondition('jenisobatalkes_farmasi is true');
                // $criteria->order='jenisobatalkes_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(jenisobatalkes_namalain)',strtolower($this->jenisobatalkes_namalain),true);
		$criteria->compare('jenisobatalkes_aktif',isset($this->jenisobatalkes_aktif)?$this->jenisobatalkes_aktif:true);
                $criteria->compare('jenisobatalkes_farmasi', $this->jenisobatalkes_farmasi);
                $criteria->addCondition('jenisobatalkes_farmasi is true');
                // $criteria->order='jenisobatalkes_id';
				$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(jenisobatalkes_namalain)',strtolower($this->jenisobatalkes_namalain),true);
                $criteria->order='jenisobatalkes_id';
//		$criteria->compare('jenisobatalkes_aktif',$this->jenisobatalkes_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            $this->jenisobatalkes_namalain = strtoupper($this->jenisobatalkes_namalain);
            $this->jenisobatalkes_nama = ucwords(strtolower($this->jenisobatalkes_nama));
            return parent::beforeSave();
        }
        
        public function getItemsFarmasi(){
            $model = $this->model()->findAllByAttributes(array('jenisobatalkes_aktif'=>true, 'jenisobatalkes_farmasi'=>true), array('order'=>'jenisobatalkes_nama ASC'));
            if(count((array)$model) > 0){
                return $model;
            }else{
                return array();
            }
        }
        
        public function listItem() {
            return CHtml::listData($this->itemsFarmasi, 'jenisobatalkes_id', 'jenisobatalkes_nama');
        }
		
		public function searchGrupLayananJenisOa()
		{
			
			$getGrup = GrouplayanankasiroaM::model()->findAll();
			
			$dt = array();
			
			if (count((array)$getGrup)){
				foreach ($getGrup as $gr){
					$dt[] = $gr->jenisobatalkes_id;
				}
			}
			
			$cri = new CDbCriteria();
			$cri->addCondition(" jenisobatalkes_aktif = TRUE ");
			$cri->compare(" LOWER(jenisobatalkes_nama) ",strtolower($this->jenisobatalkes_nama),true);
			$cri->compare(" LOWER(jenisobatalkes_kode) ",strtolower($this->jenisobatalkes_kode),true);
			$cri->addNotInCondition("jenisobatalkes_id", $dt);
			$cri->order = " jenisobatalkes_nama ASC ";
					  
			return new CActiveDataProvider($this, array(
				'criteria'=>$cri,
			));
		}
}