<?php

/**
 * This is the model class for table "kelbahanmakananrek_m".
 *
 * The followings are the available columns in table 'kelbahanmakananrek_m':
 * @property integer $kelbahanmakananrek_id
 * @property string $kelbahanmakanan
 * @property integer $rekening5_id
 * @property string $debitkredit
 * @property boolean $ispenerimaan
 * @property boolean $ispemakaian
 * @property boolean $isreturpenerimaan
 *
 * The followings are the available model relations:
 * @property Rekening5M $rekening5
 */
class KelbahanmakananrekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelbahanmakananrekM the static model class
	 */

	 public $jenisbarang_id;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kelbahanmakananrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelbahanmakanan, rekening5_id, debitkredit', 'required'),
			array('rekening5_id', 'numerical', 'integerOnly'=>true),
			array('kelbahanmakanan', 'length', 'max'=>50),
			array('debitkredit', 'length', 'max'=>1),
			array('ispenerimaan, ispemakaian, isreturpenerimaan, istokopname, istokopnamebertambah, istokopnameberkurang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelbahanmakananrek_id, kelbahanmakanan, rekening5_id, debitkredit, ispenerimaan, ispemakaian, isreturpenerimaan, istokopname, istokopnamebertambah, istokopnameberkurang', 'safe', 'on'=>'search'),
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
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelbahanmakananrek_id' => 'Kelbahanmakananrek',
			'kelbahanmakanan' => 'Kelompok Bahan Makanan',
			'rekening5_id' => 'Rekening 5',
			'debitkredit' => 'Debit / Kredit',
			'ispenerimaan' => 'Penerimaan',
			'ispemakaian' => 'Pemakaian',
			'isreturpenerimaan' => 'Retur Penerimaan',
			'istokopname' => 'Stok Opname Awal',
			'istokopnamebertambah' => 'Stok Opname Penyesuaian Bertambah',
			'istokopnameberkurang' => 'Stok Opname Penyesuaian Berkurang',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		
		$criteria=new CDbCriteria;

		$criteria->compare('kelbahanmakananrek_id',$this->kelbahanmakananrek_id);
		$criteria->compare('LOWER(kelbahanmakanan)',strtolower($this->kelbahanmakanan),true);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit);

		if ($this->ispenerimaan == 1) {
            $criteria->addCondition('ispenerimaan = true');
        } else if ($this->ispenerimaan == 2) {
            $criteria->addCondition('ispenerimaan = false');            
        }
        if ($this->ispemakaian == 1) {
            $criteria->addCondition('ispemakaian = true');
        } else if ($this->ispemakaian == 2) {
            $criteria->addCondition('ispemakaian = false');            
        }
        if ($this->isreturpenerimaan == 1) {
            $criteria->addCondition('isreturpenerimaan = true');
        } else if ($this->isreturpenerimaan == 2) {
            $criteria->addCondition('isreturpenerimaan = false');            
        }

				if ($this->istokopname == 1) {
					$criteria->addCondition('istokopname = true');
				} else if ($this->istokopname == 2) {
						$criteria->addCondition('istokopname = false');            
				}

				if ($this->istokopnamebertambah == 1) {
					$criteria->addCondition('istokopnamebertambah = true');
			} else if ($this->istokopnamebertambah == 2) {
					$criteria->addCondition('istokopnamebertambah = false');            
			}

			if ($this->istokopnameberkurang == 1) {
				$criteria->addCondition('istokopnameberkurang = true');
		} else if ($this->istokopnameberkurang == 2) {
				$criteria->addCondition('istokopnameberkurang = false');            
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchPrint()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('kelbahanmakananrek_id',$this->kelbahanmakananrek_id);
		$criteria->compare('LOWER(kelbahanmakanan)',strtolower($this->kelbahanmakanan),true);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit);

		if ($this->ispenerimaan == 1) {
            $criteria->addCondition('ispenerimaan = true');
        } else if ($this->ispenerimaan == 2) {
            $criteria->addCondition('ispenerimaan = false');            
        }
        if ($this->ispemakaian == 1) {
            $criteria->addCondition('ispemakaian = true');
        } else if ($this->ispemakaian == 2) {
            $criteria->addCondition('ispemakaian = false');            
        }
        if ($this->isreturpenerimaan == 1) {
            $criteria->addCondition('isreturpenerimaan = true');
        } else if ($this->isreturpenerimaan == 2) {
            $criteria->addCondition('isreturpenerimaan = false');            
        }

				if ($this->istokopname == 1) {
					$criteria->addCondition('istokopname = true');
				} else if ($this->istokopname == 2) {
						$criteria->addCondition('istokopname = false');            
				}

				if ($this->istokopnamebertambah == 1) {
					$criteria->addCondition('istokopnamebertambah = true');
			} else if ($this->istokopnamebertambah == 2) {
					$criteria->addCondition('istokopnamebertambah = false');            
			}

			if ($this->istokopnameberkurang == 1) {
				$criteria->addCondition('istokopnameberkurang = true');
		} else if ($this->istokopnameberkurang == 2) {
				$criteria->addCondition('istokopnameberkurang = false');            
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
}