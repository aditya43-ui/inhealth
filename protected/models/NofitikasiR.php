<?php

/**
 * This is the model class for table "notifikasi_r".
 *
 * The followings are the available columns in table 'notifikasi_r':
 * @property integer $nofitikasi_id
 * @property integer $instalasi_id
 * @property integer $modul_id
 * @property string $tglnotifikasi
 * @property string $judulnotifikasi
 * @property string $isinotifikasi
 * @property boolean $isread
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $lamahrnotif
 */
class NofitikasiR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NofitikasiR the static model class
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
		return 'notifikasi_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, tglnotifikasi, judulnotifikasi, isinotifikasi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('instalasi_id, modul_id, lamahrnotif', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time','default','value'=>date( 'Y-m-d H:i:s'),'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'on'=>'update'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('judulnotifikasi', 'length', 'max'=>200),
			array('keterangan, link_proses, pegawai_id, isread, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nofitikasi_id, instalasi_id, modul_id, tglnotifikasi, judulnotifikasi, isinotifikasi, isread, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, lamahrnotif', 'safe', 'on'=>'search'),
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
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'pemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nofitikasi_id' => 'Nofitikasi ID',
			'instalasi_id' => 'Instalasi',
			'modul_id' => 'Modul',
			'tglnotifikasi' => 'Tanggal Notifikasi',
			'judulnotifikasi' => 'Judul Notifikasi',
			'isinotifikasi' => 'Isi Notifikasi',
			'isread' => 'Sudah Dibaca',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'lamahrnotif' => 'Lama Notifikasi',
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

		$criteria->compare('nofitikasi_id',$this->nofitikasi_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('LOWER(tglnotifikasi)',strtolower($this->tglnotifikasi),true);
		$criteria->compare('LOWER(judulnotifikasi)',strtolower($this->judulnotifikasi),true);
		$criteria->compare('LOWER(isinotifikasi)',strtolower($this->isinotifikasi),true);
		$criteria->compare('isread',$this->isread);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('lamahrnotif',$this->lamahrnotif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchByRuangan()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('nofitikasi_id',$this->nofitikasi_id);
		$criteria->compare('instalasi_id', Yii::app()->user->getState('instalasi_id'));
		$criteria->compare('modul_id',Yii::app()->session['modul_id']);
		$criteria->compare('LOWER(tglnotifikasi)',strtolower($this->tglnotifikasi),true);
		$criteria->compare('LOWER(judulnotifikasi)',strtolower($this->judulnotifikasi),true);
		$criteria->compare('LOWER(isinotifikasi)',strtolower($this->isinotifikasi),true);
		$criteria->compare('isread',$this->isread);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('lamahrnotif',$this->lamahrnotif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}        
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('nofitikasi_id',$this->nofitikasi_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('LOWER(tglnotifikasi)',strtolower($this->tglnotifikasi),true);
		$criteria->compare('LOWER(judulnotifikasi)',strtolower($this->judulnotifikasi),true);
		$criteria->compare('LOWER(isinotifikasi)',strtolower($this->isinotifikasi),true);
		$criteria->compare('isread',$this->isread);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('lamahrnotif',$this->lamahrnotif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}