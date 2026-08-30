<?php

/**
 * This is the model class for table "grouplayanan_m".
 *
 * The followings are the available columns in table 'grouplayanan_m':
 * @property integer $grouplayanan_id
 * @property string $grouplayanan_kode
 * @property string $grouplayanan_nama
 * @property string $grouplayanan_namalain
 * @property string $grouplayanan_definisi
 * @property integer $grouplayanan_order
 * @property boolean $is_oa
 * @property boolean $grouplayanan_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property GrouplayanankasirM[] $grouplayanankasirMs
 * @property GrouplayanankasiroaM[] $grouplayanankasiroaMs
 */
class GrouplayananM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GrouplayananM the static model class
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
		return 'grouplayanan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('grouplayanan_nama, grouplayanan_order, create_time, create_loginpemakai_id', 'required'),
			array('grouplayanan_order, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('grouplayanan_kode', 'length', 'max'=>10),
			array('grouplayanan_namalain, grouplayanan_definisi, is_oa, grouplayanan_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('grouplayanan_id, grouplayanan_kode, grouplayanan_nama, grouplayanan_namalain, grouplayanan_definisi, grouplayanan_order, is_oa, grouplayanan_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'grouplayanankasirMs' => array(self::HAS_MANY, 'GrouplayanankasirM', 'grouplayanan_id'),
			'grouplayanankasiroaMs' => array(self::HAS_MANY, 'GrouplayanankasiroaM', 'grouplayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'grouplayanan_id' => 'ID',
			'grouplayanan_kode' => 'Kode',
			'grouplayanan_nama' => 'Nama',
			'grouplayanan_namalain' => 'Nama Lain',
			'grouplayanan_definisi' => 'Definisi',
			'grouplayanan_order' => 'Urutan',
			'is_oa' => 'Jenis Obat dan Alkes',
			'grouplayanan_aktif' => 'Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('grouplayanan_id',$this->grouplayanan_id);
		$criteria->compare('grouplayanan_kode',$this->grouplayanan_kode,true);
		$criteria->compare('grouplayanan_nama',$this->grouplayanan_nama,true);
		$criteria->compare('grouplayanan_namalain',$this->grouplayanan_namalain,true);
		$criteria->compare('grouplayanan_definisi',$this->grouplayanan_definisi,true);
		$criteria->compare('grouplayanan_order',$this->grouplayanan_order);
		
		if (!empty($this->is_oa)){
			if ($this->is_oa == 'is_oa'){
				$criteria->compare('is_oa',true);
			}else{
				$criteria->compare('is_oa',false);
			}		
		}
		
		$criteria->compare('grouplayanan_aktif',isset($this->grouplayanan_aktif)?$this->grouplayanan_aktif:true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('grouplayanan_id',$this->grouplayanan_id);
		$criteria->compare('grouplayanan_kode',$this->grouplayanan_kode,true);
		$criteria->compare('grouplayanan_nama',$this->grouplayanan_nama,true);
		$criteria->compare('grouplayanan_namalain',$this->grouplayanan_namalain,true);
		$criteria->compare('grouplayanan_definisi',$this->grouplayanan_definisi,true);
		$criteria->compare('grouplayanan_order',$this->grouplayanan_order);
		
		if (!empty($this->is_oa)){
			if ($this->is_oa == 'is_oa'){
				$criteria->compare('is_oa',true);
			}else{
				$criteria->compare('is_oa',false);
			}		
		}
		
		$criteria->compare('grouplayanan_aktif',isset($this->grouplayanan_aktif)?$this->grouplayanan_aktif:true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function searchGrupLayanan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('grouplayanan_id',$this->grouplayanan_id);
		$criteria->compare('grouplayanan_kode',$this->grouplayanan_kode,true);
		$criteria->compare('grouplayanan_nama',$this->grouplayanan_nama,true);
		$criteria->compare('grouplayanan_namalain',$this->grouplayanan_namalain,true);
		$criteria->compare('grouplayanan_definisi',$this->grouplayanan_definisi,true);
		$criteria->compare('grouplayanan_order',$this->grouplayanan_order);
		
		if (!empty($this->is_oa)){
			//var_dump($this->is_oa);
			if ($this->is_oa == 'is_oa'){
				$criteria->addCondition('is_oa = true');
			}else{
				$criteria->addCondition('is_oa = false');
			}		
		}
		
		$criteria->compare('grouplayanan_aktif',isset($this->grouplayanan_aktif)?$this->grouplayanan_aktif:true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}