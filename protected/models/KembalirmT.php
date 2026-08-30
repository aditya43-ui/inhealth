<?php

/**
 * This is the model class for table "kembalirm_t".
 *
 * The followings are the available columns in table 'kembalirm_t':
 * @property integer $kembalirm_id
 * @property integer $pengirimanrm_id
 * @property integer $pendaftaran_id
 * @property integer $peminjamanrm_id
 * @property integer $pasien_id
 * @property integer $dokrekammedis_id
 * @property string $tglkembali
 * @property boolean $lengkapdokumenkembali
 * @property string $petugaspenerima
 * @property string $keterangan_pengembalian
 * @property integer $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KembalirmT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KembalirmT the static model class
	 */
        public $tgl_awal, $tgl_akhir,$pasienNama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kembalirm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, dokrekammedis_id, tglkembali, lengkapdokumenkembali', 'required'),
			array('pengirimanrm_id, pendaftaran_id, peminjamanrm_id, pasien_id, dokrekammedis_id, ruanganasal_id', 'numerical', 'integerOnly'=>true),
			array('petugaspenerima', 'length', 'max'=>100),
			array('keterangan_pengembalian, update_time, update_loginpemakai_id', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kembalirm_id, tgl_awal, pasienNama, tgl_akhir, pengirimanrm_id, pendaftaran_id, peminjamanrm_id, pasien_id, dokrekammedis_id, tglkembali, lengkapdokumenkembali, petugaspenerima, keterangan_pengembalian, ruanganasal_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'dokrekammedis'=>array(self::BELONGS_TO, 'DokrekammedisM', 'dokrekammedis_id'),
                    'pasien'=>array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                    'ruanganasal'=>array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
                    'peminjaman'=>array(self::BELONGS_TO,'PeminjamanrmT','peminjamanrm_id'),
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kembalirm_id' => 'Pengembalian Dok. RM',
			'pengirimanrm_id' => 'Pengiriman Dok. RM',
			'pendaftaran_id' => 'Pendaftaran',
			'peminjamanrm_id' => 'Peminjaman Dok. RM',
			'pasien_id' => 'Pasien',
			'dokrekammedis_id' => 'Dok. RM',
			'tglkembali' => 'Tanggal Pengembalian',
			'lengkapdokumenkembali' => 'Kelengkapan Dok. ',
			'petugaspenerima' => 'Petugas Penerima',
			'keterangan_pengembalian' => 'Keterangan Pengembalian',
			'ruanganasal_id' => 'Ruangan Asal',
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

		$criteria->compare('kembalirm_id',$this->kembalirm_id);
		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('LOWER(tglkembali)',strtolower($this->tglkembali),true);
		$criteria->compare('lengkapdokumenkembali',$this->lengkapdokumenkembali);
		$criteria->compare('LOWER(petugaspenerima)',strtolower($this->petugaspenerima),true);
		$criteria->compare('LOWER(keterangan_pengembalian)',strtolower($this->keterangan_pengembalian),true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchInformasiPenerimaan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->with = array('pasien');
                $criteria->addBetweenCondition('tglkembali',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('kembalirm_id',$this->kembalirm_id);
		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('pasien_id',$this->pasien_id);
                $criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->pasienNama),true);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('lengkapdokumenkembali',$this->lengkapdokumenkembali);
		$criteria->compare('LOWER(petugaspenerima)',strtolower($this->petugaspenerima),true);
		$criteria->compare('LOWER(keterangan_pengembalian)',strtolower($this->keterangan_pengembalian),true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
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
		$criteria->compare('kembalirm_id',$this->kembalirm_id);
		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('LOWER(tglkembali)',strtolower($this->tglkembali),true);
		$criteria->compare('lengkapdokumenkembali',$this->lengkapdokumenkembali);
		$criteria->compare('LOWER(petugaspenerima)',strtolower($this->petugaspenerima),true);
		$criteria->compare('LOWER(keterangan_pengembalian)',strtolower($this->keterangan_pengembalian),true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
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
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                     else if ($column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }    
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tglkembali===null || trim($this->tglkembali)==''){
	        $this->setAttribute('tglkembali', null);
            }
            
            return parent::beforeSave();
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
}