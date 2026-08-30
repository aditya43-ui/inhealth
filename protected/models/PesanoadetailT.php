<?php

/**
 * This is the model class for table "pesanoadetail_t".
 *
 * The followings are the available columns in table 'pesanoadetail_t':
 * @property integer $pesanoadetail_id
 * @property integer $satuankecil_id
 * @property integer $obatalkes_id
 * @property integer $pesanobatalkes_id
 * @property integer $sumberdana_id
 * @property double $jmlpesan
 */
class PesanoadetailT extends CActiveRecord
{   
        public $harganetto,$hargajual, $stok, $subtotal, $discount, $tglkadaluarsa;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanoadetailT the static model class
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
		return 'pesanoadetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, pesanobatalkes_id, sumberdana_id, jmlpesan', 'required'),
			array('satuankecil_id, obatalkes_id, pesanobatalkes_id, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('jmlpesan', 'numerical'),
                        array('tglkadaluarsa, harganetto,hargajual, stok, subtotal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanoadetail_id, satuankecil_id, obatalkes_id, pesanobatalkes_id, sumberdana_id, jmlpesan', 'safe', 'on'=>'search'),
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
                    'pesanobatalkes'=>array(self::BELONGS_TO,'PesanobatalkesT','pesanobatalkes_id'),
                    'obatalkes'=>array(self::BELONGS_TO,'ObatalkesM','obatalkes_id'),
                    'satuankecil'=>array(self::BELONGS_TO,'SatuankecilM','satuankecil_id'),
                    'sumberdana'=>array(self::BELONGS_TO,'SumberdanaM','sumberdana_id'),
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanoadetail_id' => 'ID',
			'satuankecil_id' => 'Satuan Kecil',
			'obatalkes_id' => 'Obat Alkes',
			'pesanobatalkes_id' => 'Pesan Obat Alkes',
			'sumberdana_id' => 'Sumber Dana',
			'jmlpesan' => 'Jumlah Pesan',
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

		$criteria->compare('pesanoadetail_id',$this->pesanoadetail_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('pesanobatalkes_id',$this->pesanobatalkes_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('jmlpesan',$this->jmlpesan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pesanoadetail_id',$this->pesanoadetail_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('pesanobatalkes_id',$this->pesanobatalkes_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('jmlpesan',$this->jmlpesan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                    else if ( $column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
            }

            return parent::beforeValidate ();
        }
}