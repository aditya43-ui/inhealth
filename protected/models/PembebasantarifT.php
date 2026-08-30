<?php

/**
 * This is the model class for table "pembebasantarif_t".
 *
 * The followings are the available columns in table 'pembebasantarif_t':
 * @property integer $pembebasantarif_id
 * @property integer $loginpemakai_id
 * @property integer $pegawai_id
 * @property integer $tindakanpelayanan_id
 * @property integer $komponentarif_id
 * @property string $tglpembebasan
 * @property double $jmlpembebasan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PembebasantarifT extends CActiveRecord
{
    
        public $pegawai_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembebasantarifT the static model class
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
		return 'pembebasantarif_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('loginpemakai_id, pegawai_id, tglpembebasan, jmlpembebasan', 'required'),
			array('loginpemakai_id, pegawai_id, tindakanpelayanan_id, komponentarif_id, tindakansudahbayar_id, pasien_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('jmlpembebasan', 'numerical'),
			array('update_time, update_loginpemakai_id', 'safe'),
                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembebasantarif_id, loginpemakai_id, pegawai_id, tindakanpelayanan_id, komponentarif_id, tglpembebasan, jmlpembebasan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tindakansudahbayar_id, pasien_id, pendaftaran_id', 'safe', 'on'=>'search'),
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
			'pembebasantarif_id' => 'Pembebasantarif',
			'loginpemakai_id' => 'Loginpemakai',
			'pegawai_id' => 'Dokter',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'komponentarif_id' => 'Komponentarif',
			'tglpembebasan' => 'Tanggal Pembebasan',
			'jmlpembebasan' => 'Jml Pembebasan',
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

		$criteria->compare('pembebasantarif_id',$this->pembebasantarif_id);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpembebasan)',strtolower($this->tglpembebasan),true);
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
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
		$criteria->compare('pembebasantarif_id',$this->pembebasantarif_id);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpembebasan)',strtolower($this->tglpembebasan),true);
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
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