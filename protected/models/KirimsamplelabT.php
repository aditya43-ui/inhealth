<?php

/**
 * This is the model class for table "kirimsamplelab_t".
 *
 * The followings are the available columns in table 'kirimsamplelab_t':
 * @property integer $kirimsamplelab_id
 * @property integer $pengambilansample_id
 * @property integer $labklinikrujukan_id
 * @property string $nokirimsample
 * @property string $tglkirimsample
 * @property string $tglterimahasilsample
 * @property string $keterangan_kirim
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KirimsamplelabT extends CActiveRecord
{
        public $isKirimSample;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimsamplelabT the static model class
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
		return 'kirimsamplelab_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('labklinikrujukan_id, nokirimsample, tglkirimsample', 'required'),
			array('pengambilansample_id, labklinikrujukan_id', 'numerical', 'integerOnly'=>true),
			array('nokirimsample', 'length', 'max'=>20),
			array('alasan_kirim, tglterimahasilsample, keterangan_kirim, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update'),
                    
			array('kirimsamplelab_id, pengambilansample_id, labklinikrujukan_id, nokirimsample, tglkirimsample, tglterimahasilsample, keterangan_kirim, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'kirimsamplelab_id' => 'Kirim Sampel Lab',
			'pengambilansample_id' => 'Pengambilan Sample',
			'labklinikrujukan_id' => 'Laboratorium Klinik Rujukan',
			'nokirimsample' => 'No. Kirim Sample',
			'tglkirimsample' => 'Tanggal Kirim Sample',
			'tglterimahasilsample' => 'Tanggal Terima Hasil Sample',
			'keterangan_kirim' => 'Keterangan Kirim',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'alasan_kirim' => 'Alasan Dikirim'
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

		$criteria->compare('kirimsamplelab_id',$this->kirimsamplelab_id);
		$criteria->compare('pengambilansample_id',$this->pengambilansample_id);
		$criteria->compare('labklinikrujukan_id',$this->labklinikrujukan_id);
		$criteria->compare('LOWER(nokirimsample)',strtolower($this->nokirimsample),true);
		$criteria->compare('LOWER(tglkirimsample)',strtolower($this->tglkirimsample),true);
		$criteria->compare('LOWER(tglterimahasilsample)',strtolower($this->tglterimahasilsample),true);
		$criteria->compare('LOWER(keterangan_kirim)',strtolower($this->keterangan_kirim),true);
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
		$criteria->compare('kirimsamplelab_id',$this->kirimsamplelab_id);
		$criteria->compare('pengambilansample_id',$this->pengambilansample_id);
		$criteria->compare('labklinikrujukan_id',$this->labklinikrujukan_id);
		$criteria->compare('LOWER(nokirimsample)',strtolower($this->nokirimsample),true);
		$criteria->compare('LOWER(tglkirimsample)',strtolower($this->tglkirimsample),true);
		$criteria->compare('LOWER(tglterimahasilsample)',strtolower($this->tglterimahasilsample),true);
		$criteria->compare('LOWER(keterangan_kirim)',strtolower($this->keterangan_kirim),true);
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
        
          public function getLabKlinikRujukanItems()
        {
            return LabklinikrujukanM::model()->findAll('labklinikrujukan_aktif=TRUE ORDER BY labklinikrujukan_nama');
        }
}