<?php

/**
 * This is the model class for table "indexing_m".
 *
 * The followings are the available columns in table 'indexing_m':
 * @property integer $indexing_id
 * @property integer $kelrem_id
 * @property integer $indexing_urutan
 * @property string $indexing_nama
 * @property string $indexing_singk
 * @property double $indexing_nilai
 * @property boolean $indexing_aktif
 */
class IndexingM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IndexingM the static model class
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
		return 'indexing_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelrem_id, indexing_urutan, indexing_nama, indexing_singk, indexing_nilai, indexing_step', 'required'),
			array('kelrem_id, indexing_urutan, indexing_step', 'numerical', 'integerOnly'=>true),
			array('indexing_nilai', 'numerical'),
			array('indexing_nama', 'length', 'max'=>100),
			array('indexing_singk', 'length', 'max'=>30),
			array('indexing_aktif, indexing_offset, indexing_totbobot', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('indexing_id, kelrem_id, indexing_urutan, indexing_nama, indexing_singk, indexing_nilai, indexing_aktif', 'safe', 'on'=>'search'),
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
                                    'kelrem'=>array(self::BELONGS_TO,'KelremM','kelrem_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'indexing_id' => 'ID',
			'kelrem_id' => 'Kelompok Remunerasi',
			'indexing_urutan' => 'Urutan',
			'indexing_nama' => 'Objek',
			'indexing_singk' => 'Singkatan',
			'indexing_nilai' => 'Nilai',
			'indexing_aktif' => 'Aktif',
			'indexing_offset' => 'Nilai Offset',
			'indexing_totbobot' => 'Total Bobot',
                        'indexing_step' => 'Maksimal Penilaian',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
                public function criteria()
                {
		$criteria=new CDbCriteria;

		$criteria->compare('indexing_id',$this->indexing_id);
		$criteria->compare('kelrem_id',$this->kelrem_id);
		$criteria->compare('indexing_urutan',$this->indexing_urutan);
		$criteria->compare('LOWER(indexing_nama)',strtolower($this->indexing_nama),true);
		$criteria->compare('LOWER(indexing_singk)',strtolower($this->indexing_singk),true);
		$criteria->compare('indexing_nilai',$this->indexing_nilai);
		$criteria->compare('indexing_aktif',isset($this->indexing_aktif)?$this->indexing_aktif:true);
                //$criteria->addCondition('indexing_aktif is true');
                $criteria->limit = 10;
                                return $criteria;
                }
                
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.


                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteria(),
                                                //'pagination'=>false,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('indexing_id',$this->indexing_id);
		$criteria->compare('kelrem_id',$this->kelrem_id);
		$criteria->compare('indexing_urutan',$this->indexing_urutan);
		$criteria->compare('LOWER(indexing_nama)',strtolower($this->indexing_nama),true);
		$criteria->compare('LOWER(indexing_singk)',strtolower($this->indexing_singk),true);
		$criteria->compare('indexing_nilai',$this->indexing_nilai);
		$criteria->compare('indexing_aktif',$this->indexing_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getKelremItems()
        {
            return KelremM::model()->findAll('kelrem_aktif=TRUE ORDER BY kelrem_nama ASC');
        }
        
        public function getTotalindex()
        {
            $criteria=$this->criteria();
            $criteria->select = 'SUM(indexing_nilai)';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function getTotalbobot()
        {
            return '<input type="text" class="span1" readonly="readonly" id="totalbobot" />';
        }
        
        public function getTotalscore()
        {
            return '<input type="text" class="span1" readonly="readonly" id="totalscore" name="PersonalscoringT[totalscore]" />';
        }
}