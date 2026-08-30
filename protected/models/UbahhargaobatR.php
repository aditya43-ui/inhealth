<?php

/**
 * This is the model class for table "ubahhargaobat_r".
 *
 * The followings are the available columns in table 'ubahhargaobat_r':
 * @property integer $ubahhargaobat_id
 * @property integer $obatalkes_id
 * @property integer $sumberdana_id
 * @property integer $loginpemakai_id
 * @property string $tglperubahan
 * @property double $harganettoasal
 * @property double $hargajualasal
 * @property double $harganettoperubahan
 * @property double $hargajualperubahan
 * @property string $alasanperubahan
 * @property string $disetujuioleh
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class UbahhargaobatR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbahhargaobatR the static model class
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
		return 'ubahhargaobat_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, sumberdana_id, loginpemakai_id, tglperubahan, harganettoasal, hargajualasal, harganettoperubahan, hargajualperubahan, alasanperubahan, disetujuioleh', 'required'),
			array('obatalkes_id, sumberdana_id, loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('harganettoasal, hargajualasal, harganettoperubahan, hargajualperubahan', 'numerical'),
			array('alasanperubahan, disetujuioleh', 'length', 'max'=>100),
			array('update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('ubahhargaobat_id, obatalkes_id, sumberdana_id, loginpemakai_id, tglperubahan, harganettoasal, hargajualasal, harganettoperubahan, hargajualperubahan, alasanperubahan, disetujuioleh, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ubahhargaobat_id' => 'ID',
			'obatalkes_id' => 'Obat Slkes',
			'sumberdana_id' => 'Sumber Dana',
			'loginpemakai_id' => 'Login Pemakai',
			'tglperubahan' => 'Tanggal Perubahan',
			'harganettoasal' => 'Harga Netto Sebelumnya',
			'hargajualasal' => 'Harga Jual Sebelumnya',
			'harganettoperubahan' => 'Harga Netto Baru',
			'hargajualperubahan' => 'Harga Jual Baru',
			'alasanperubahan' => 'Alasan Perubahan',
			'disetujuioleh' => 'Disetujui Oleh',
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

		$criteria->compare('ubahhargaobat_id',$this->ubahhargaobat_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('LOWER(tglperubahan)',strtolower($this->tglperubahan),true);
		$criteria->compare('harganettoasal',$this->harganettoasal);
		$criteria->compare('hargajualasal',$this->hargajualasal);
		$criteria->compare('harganettoperubahan',$this->harganettoperubahan);
		$criteria->compare('hargajualperubahan',$this->hargajualperubahan);
		$criteria->compare('LOWER(alasanperubahan)',strtolower($this->alasanperubahan),true);
		$criteria->compare('LOWER(disetujuioleh)',strtolower($this->disetujuioleh),true);
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
		$criteria->compare('ubahhargaobat_id',$this->ubahhargaobat_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('LOWER(tglperubahan)',strtolower($this->tglperubahan),true);
		$criteria->compare('harganettoasal',$this->harganettoasal);
		$criteria->compare('hargajualasal',$this->hargajualasal);
		$criteria->compare('harganettoperubahan',$this->harganettoperubahan);
		$criteria->compare('hargajualperubahan',$this->hargajualperubahan);
		$criteria->compare('LOWER(alasanperubahan)',strtolower($this->alasanperubahan),true);
		$criteria->compare('LOWER(disetujuioleh)',strtolower($this->disetujuioleh),true);
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
        
        public function getSumberDanaItems()
        {
            return SumberdanaM::model()->findAll('sumberdana_aktif=TRUE ORDER BY sumberdana_nama');
        }
}