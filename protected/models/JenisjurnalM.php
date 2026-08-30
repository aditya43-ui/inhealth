<?php

/**
 * This is the model class for table "jenisjurnal_m".
 *
 * The followings are the available columns in table 'jenisjurnal_m':
 * @property integer $jenisjurnal_id
 * @property string $jenisjurnal_nama
 * @property string $jenisjurnal_namalain
 * @property boolean $jenisjurnal_aktif
 */
class JenisjurnalM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisjurnalM the static model class
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
		return 'jenisjurnal_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisjurnal_nama', 'required'),
			array('jenisjurnal_nama, jenisjurnal_namalain', 'length', 'max'=>100),
			array('jenisjurnal_aktif, istabpiutangpasien, jeniskode', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisjurnal_id, jenisjurnal_nama, jenisjurnal_namalain, jenisjurnal_aktif, istabpiutangpasien, jeniskode', 'safe', 'on'=>'search'),
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
			'jenisjurnal_id' => 'ID Jenis Jurnal',
			'jenisjurnal_nama' => 'Nama Jenis Jurnal',
			'jenisjurnal_namalain' => 'Nama Lain Jenis Jurnal',
			'jenisjurnal_aktif' => 'Jenis Jurnal Aktif',
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

		$criteria->compare('jenisjurnal_id',$this->jenisjurnal_id);
		$criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		$criteria->compare('LOWER(jenisjurnal_namalain)',strtolower($this->jenisjurnal_namalain),true);
		$criteria->compare('jenisjurnal_aktif',isset($this->jenisjurnal_aktif)?$this->jenisjurnal_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenisjurnal_id',$this->jenisjurnal_id);
		$criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		$criteria->compare('LOWER(jenisjurnal_namalain)',strtolower($this->jenisjurnal_namalain),true);
		$criteria->compare('jenisjurnal_aktif',$this->jenisjurnal_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

        public static function items()
        {
            $models = self::model()->findAll(
                array(
                    'condition'=>'jenisjurnal_aktif = true',
                    'order'=>'jenisjurnal_id',
                )
            );
            $result = array();
            foreach($models as $model){
                $result[$model->jenisjurnal_id] = $model->jenisjurnal_nama;
            }
            return $result;
        }

		public static function itemsWithInit($params=array())
        {
			$cri = new CDbCriteria();
			$cri->addCondition(" jenisjurnal_aktif = TRUE ");
			if (count((array)$params)>0){
				$cri->addNotInCondition("jenisjurnal_id",$params);
			}
			$cri->order = " jenisjurnal_nama ASC ";
            $models = self::model()->findAll($cri);
            $result = array();
            foreach($models as $model){
                $result[$model->jenisjurnal_id] = $model->jenisjurnal_nama.' ('.$model->jeniskode.')';
            }
            return $result;
        }
}
