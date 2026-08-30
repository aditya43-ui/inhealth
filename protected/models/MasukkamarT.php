<?php

/**
 * This is the model class for table "masukkamar_t".
 *
 * The followings are the available columns in table 'masukkamar_t':
 * @property integer $masukkamar_id
 * @property integer $carabayar_id
 * @property integer $kamarruangan_id
 * @property integer $kelaspelayanan_id
 * @property integer $bookingkamar_id
 * @property integer $ruangan_id
 * @property integer $pasienadmisi_id
 * @property integer $pegawai_id
 * @property integer $penjamin_id
 * @property integer $shift_id
 * @property string $tglmasukkamar
 * @property string $nomasukkamar
 * @property string $jammasukkamar
 * @property string $tglkeluarkamar
 * @property string $jamkeluarkamar
 * @property integer $lamadirawat_kamar
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class MasukkamarT extends CActiveRecord
{
	public $tglpembayaran;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MasukkamarT the static model class
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
		return 'masukkamar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, carabayar_id, pasienadmisi_id, penjamin_id, kelaspelayanan_id, shift_id, tglmasukkamar, nomasukkamar, jammasukkamar, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('ruangan_id, carabayar_id, bookingkamar_id, pasienadmisi_id, penjamin_id, pindahkamar_id, pegawai_id, kelaspelayanan_id, shift_id, kamarruangan_id, lamadirawat_kamar', 'numerical', 'integerOnly'=>true),
            array('nomasukkamar', 'length', 'max'=>50),
            array('tglkeluarkamar, jamkeluarkamar, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('masukkamar_id, ruangan_id, carabayar_id, bookingkamar_id, pasienadmisi_id, penjamin_id, pindahkamar_id, pegawai_id, kelaspelayanan_id, shift_id, kamarruangan_id, tglmasukkamar, nomasukkamar, jammasukkamar, tglkeluarkamar, jamkeluarkamar, lamadirawat_kamar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'carabayar'=>array(self::BELONGS_TO, 'CarabayarM','carabayar_id'),
                    'bookingkamar' => array(self::BELONGS_TO, 'BookingkamarT', 'bookingkamar_id'),
                    'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM','penjamin_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
                    'kelaspelayanan'=>array(self::BELONGS_TO, 'KelaspelayananM','kelaspelayanan_id'),
                    'admisi'=>array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'kamarruangan'=>array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
                    'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
                    'pindahkamar' => array(self::BELONGS_TO, 'PindahkamarT', 'pindahkamar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'masukkamar_id' => 'Masukkamar',
			'carabayar_id' => 'Jenis Penjamin',
			'kamarruangan_id' => 'Kamar Ruangan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'bookingkamar_id' => 'Bookingkamar',
			'ruangan_id' => 'Ruangan',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pegawai_id' => 'Pegawai',
			'penjamin_id' => 'Penjamin',
			'shift_id' => 'Shift',
			'tglmasukkamar' => 'Tanggal Masuk Kamar',
			'nomasukkamar' => 'Nomasukkamar',
			'jammasukkamar' => 'Jam Masuk Kamar',
			'tglkeluarkamar' => 'Tanggal Keluar Kamar',
			'jamkeluarkamar' => 'Jam Keluar Kamar',
			'lamadirawat_kamar' => 'Lama Dirawat',
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

		$criteria->compare('masukkamar_id',$this->masukkamar_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('bookingkamar_id',$this->bookingkamar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
		$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
		$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
		$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
		$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
		$criteria->compare('lamadirawat_kamar',$this->lamadirawat_kamar);
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
		$criteria->compare('masukkamar_id',$this->masukkamar_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('bookingkamar_id',$this->bookingkamar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
		$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
		$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
		$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
		$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
		$criteria->compare('lamadirawat_kamar',$this->lamadirawat_kamar);
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
                    if ($column->dbType == 'date'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                    }
            }

            return parent::beforeValidate ();
        }
        
        protected function beforeSave() {  
            if($this->tglkeluarkamar===null || trim($this->tglkeluarkamar)==''){
	        $this->setAttribute('tglkeluarkamar', null);
            }
            if($this->jamkeluarkamar===null || trim($this->jamkeluarkamar)==''){
	        $this->setAttribute('jamkeluarkamar', null);
            }
            return parent::beforeSave();
        }
        
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                        }
//            }
//            return true;
//        }
        
        public function getNoKamarRuangan($kamarruangan_id)
        {
            $kamarKosong = KamarruanganM::model()->findByAttributes(
                array('kamarruangan_id'=>$kamarruangan_id, 'kamarruangan_aktif'=>true)
            );
            return (isset($kamarKosong->kamarruangan_nokamar ) ? $kamarKosong->kamarruangan_nokamar : ""). ' - ' . (isset($kamarKosong->kamarruangan_nobed) ? $kamarKosong->kamarruangan_nobed : "");
        } 

        public function getTgl($pasienadmisi_id)
        {
            $tgl = PasienadmisiT::model()->findByAttributes(
                array('pasienadmisi_id'=>$pasienadmisi_id)
            );
            return $tgl->admisi->tgladmisi;
        }               
        
        public function getKamarKosongItems($ruangan_id = '')
        {
            if(!empty($ruangan_id))
                return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true, 'kamarruangan_aktif'=>true));
            else
                return array();
        }
		
		 public function getAllKamarItems($ruangan_id = '',$kelaspelayanan_id='')
        {
            if(!empty($ruangan_id))
                return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kelaspelayanan_id'=>$kelaspelayanan_id, 'kamarruangan_aktif'=>true));
            else
                return array();
        }
}