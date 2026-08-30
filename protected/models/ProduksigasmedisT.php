<?php

/**
 * This is the model class for table "produksigasmedis_t".
 *
 * The followings are the available columns in table 'produksigasmedis_t':
 * @property integer $produksigasmedis_id
 * @property string $tgl_produksi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 * @property integer $petugasgasmedis_id
 * @property integer $mengetahui_id
 * @property string $no_produksi
 */
class ProduksigasmedisT extends CActiveRecord
{
        public $petugasgasmedis_nama, $mengetahui_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProduksigasmedisT the static model class
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
		return 'produksigasmedis_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_produksi', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan, petugasgasmedis_id, mengetahui_id', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time, no_produksi, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('produksigasmedis_id, tgl_produksi, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, petugasgasmedis_id, mengetahui_id, no_produksi', 'safe', 'on'=>'search'),
                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
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
                    'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugasgasmedis_id'),
                    'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'produksigasmedis_id' => 'Produksigasmedis',
			'tgl_produksi' => 'Tgl. Produksi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'petugasgasmedis_id' => 'Petugas Gas Medis',
			'mengetahui_id' => 'Mengetahui',
			'no_produksi' => 'No. Produksi',
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

		$criteria->compare('produksigasmedis_id',$this->produksigasmedis_id);
		$criteria->compare('tgl_produksi',$this->tgl_produksi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('petugasgasmedis_id',$this->petugasgasmedis_id);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('lower(no_produksi)',strtolower($this->no_produksi),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}