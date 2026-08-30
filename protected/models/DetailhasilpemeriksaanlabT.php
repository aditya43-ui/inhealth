<?php

/**
 * This is the model class for table "detailhasilpemeriksaanlab_t".
 *
 * The followings are the available columns in table 'detailhasilpemeriksaanlab_t':
 * @property integer $detailhasilpemeriksaanlab_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pemeriksaanlabdet_id
 * @property integer $pemeriksaanlab_id
 * @property integer $hasilpemeriksaanlab_id
 * @property string $hasilpemeriksaan
 * @property string $nilairujukan
 * @property string $hasilpemeriksaan_satuan
 * @property string $hasilpemeriksaan_metode
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class DetailhasilpemeriksaanlabT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DetailhasilpemeriksaanlabT the static model class
	 */
	public $jenispemeriksaanlab_nama, $pemeriksaanlab_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detailhasilpemeriksaanlab_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanlabdet_id, pemeriksaanlab_id, hasilpemeriksaanlab_id', 'required'),
			array('tindakanpelayanan_id, pemeriksaanlabdet_id, pemeriksaanlab_id, hasilpemeriksaanlab_id', 'numerical', 'integerOnly'=>true),
			array('hasilpemeriksaan_satuan', 'length', 'max'=>50),
			array('nilairujukan, hasilpemeriksaan_metode', 'length', 'max'=>100),
			array('update_time, update_loginpemakai_id', 'safe'),
                        
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('detailhasilpemeriksaanlab_id, tindakanpelayanan_id, pemeriksaanlabdet_id, pemeriksaanlab_id, hasilpemeriksaanlab_id, hasilpemeriksaan, nilairujukan, hasilpemeriksaan_satuan, hasilpemeriksaan_metode, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pemeriksaanlab'=>array(self::BELONGS_TO, 'PemeriksaanlabM' ,'pemeriksaanlab_id'),
                    'pemeriksaandetail'=>array(self::BELONGS_TO,  'PemeriksaanlabdetM', 'pemeriksaanlabdet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'detailhasilpemeriksaanlab_id' => 'Detail hasil pemeriksaan lab',
			'tindakanpelayanan_id' => 'Tindakan pelayanan',
			'pemeriksaanlabdet_id' => 'Pemeriksaan lab det',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'hasilpemeriksaanlab_id' => 'Hasilpemeriksaan lab',
			'hasilpemeriksaan' => 'Hasil pemeriksaan',
			'nilairujukan' => 'Nilai rujukan',
			'hasilpemeriksaan_satuan' => 'Hasil pemeriksaan Satuan',
			'hasilpemeriksaan_metode' => 'Hasil pemeriksaan Metode',
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

		$criteria->compare('detailhasilpemeriksaanlab_id',$this->detailhasilpemeriksaanlab_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pemeriksaanlabdet_id',$this->pemeriksaanlabdet_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('hasilpemeriksaanlab_id',$this->hasilpemeriksaanlab_id);
		$criteria->compare('LOWER(hasilpemeriksaan)',strtolower($this->hasilpemeriksaan),true);
		$criteria->compare('LOWER(nilairujukan)',strtolower($this->nilairujukan),true);
		$criteria->compare('LOWER(hasilpemeriksaan_satuan)',strtolower($this->hasilpemeriksaan_satuan),true);
		$criteria->compare('LOWER(hasilpemeriksaan_metode)',strtolower($this->hasilpemeriksaan_metode),true);
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
		$criteria->compare('detailhasilpemeriksaanlab_id',$this->detailhasilpemeriksaanlab_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pemeriksaanlabdet_id',$this->pemeriksaanlabdet_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('hasilpemeriksaanlab_id',$this->hasilpemeriksaanlab_id);
		$criteria->compare('LOWER(hasilpemeriksaan)',strtolower($this->hasilpemeriksaan),true);
		$criteria->compare('LOWER(nilairujukan)',strtolower($this->nilairujukan),true);
		$criteria->compare('LOWER(hasilpemeriksaan_satuan)',strtolower($this->hasilpemeriksaan_satuan),true);
		$criteria->compare('LOWER(hasilpemeriksaan_metode)',strtolower($this->hasilpemeriksaan_metode),true);
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
		
		public function getNilaiRujuk(){
			$get = NilairujukanM::model()->findByPk($this->pemeriksaandetail->nilairujukan_id);
			return $get->nilairujukan.' ';
		}
}