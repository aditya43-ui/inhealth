<?php

/**
 * This is the model class for table "copyresep_r".
 *
 * The followings are the available columns in table 'copyresep_r':
 * @property integer $copyresep_id
 * @property integer $penjualanresep_id
 * @property string $tglcopy
 * @property string $keterangancopy
 * @property integer $jmlcopy
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $reseptur_id
 */
class CopyresepR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CopyresepR the static model class
	 */
        public $tgl_awal, $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'copyresep_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjualanresep_id, tglcopy, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('penjualanresep_id, jmlcopy, reseptur_id', 'numerical', 'integerOnly'=>true),
			array('keterangancopy, update_time, update_loginpemakai_id', 'safe'),
                        
                        array('create_time','default','value'=>date('Y-m-d'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update'),
                        array('create_ruangan', 'default','value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, copyresep_id, penjualanresep_id, tglcopy, keterangancopy, jmlcopy, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan,reseptur_id', 'safe', 'on'=>'search'),
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
                    'reseptur'=>array(self::BELONGS_TO,'ResepturT','reseptur_id'),
                    'penjualanresep'=>array(self::BELONGS_TO,'PenjualanresepT','penjualanresep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'copyresep_id' => 'Copy Resep',
			'penjualanresep_id' => 'Penjualan Resep',
			'tglcopy' => 'Tanggal Copy Resep',
			'keterangancopy' => 'Keterangan',
			'jmlcopy' => 'Jml Copy',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'reseptur_id'=>'reseptur_id',
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

		$criteria->compare('copyresep_id',$this->copyresep_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('LOWER(tglcopy)',strtolower($this->tglcopy),true);
		$criteria->compare('LOWER(keterangancopy)',strtolower($this->keterangancopy),true);
		$criteria->compare('jmlcopy',$this->jmlcopy);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('copyresep_id',$this->copyresep_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('LOWER(tglcopy)',strtolower($this->tglcopy),true);
		$criteria->compare('LOWER(keterangancopy)',strtolower($this->keterangancopy),true);
		$criteria->compare('jmlcopy',$this->jmlcopy);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}