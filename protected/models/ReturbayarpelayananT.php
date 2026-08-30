<?php

/**
 * This is the model class for table "returbayarpelayanan_t".
 *
 * The followings are the available columns in table 'returbayarpelayanan_t':
 * @property integer $returbayarpelayanan_id
 * @property integer $tandabuktikeluar_id
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property string $tglreturpelayanan
 * @property string $noreturbayar
 * @property double $totaloaretur
 * @property double $totaltindakanretur
 * @property double $totalbiayaretur
 * @property double $biayaadministrasi
 * @property string $keteranganretur
 * @property integer $user_nm_otorisasi
 * @property integer $user_id_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $returresep_id
 */
class ReturbayarpelayananT extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir, $noreturresep, $pegawai, $pegawairetur;
        public $no_pendaftaran, $no_rekam_medik, $nama_pasien;
        public $carabayar_id, $penjamin_id; 
        public $nobuktibayar;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturbayarpelayananT the static model class
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
		return 'returbayarpelayanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, tglreturpelayanan, noreturbayar, totaloaretur, totaltindakanretur, totalbiayaretur, biayaadministrasi, keteranganretur', 'required'),
			array('tandabuktikeluar_id, returresep_id, tandabuktibayar_id, ruangan_id, user_id_otorisasi', 'numerical', 'integerOnly'=>true),
			array('totaloaretur, totaltindakanretur, totalbiayaretur, biayaadministrasi, jumlahpembulatan', 'numerical'),
			array('noreturbayar, user_nm_otorisasi', 'length', 'max'=>50),
			array('update_time, update_loginpemakai_id', 'safe'),
                    
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returbayarpelayanan_id, tgl_awal, tgl_akhir, tandabuktikeluar_id, tandabuktibayar_id, ruangan_id, tglreturpelayanan, noreturbayar, totaloaretur, totaltindakanretur, totalbiayaretur, biayaadministrasi, keteranganretur, user_nm_otorisasi, user_id_otorisasi, create_time, update_time, returresep_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jumlahpembulatan', 'safe', 'on'=>'search'),
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
                    'tandabuktikeluar'=>array(self::BELONGS_TO, 'TandabuktikeluarT','tandabuktikeluar_id'),
                    'returresep'=>array(self::BELONGS_TO,'ReturresepT','returresep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'returbayarpelayanan_id' => 'Returbayarpelayanan',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'ruangan_id' => 'Ruangan',
			'tglreturpelayanan' => 'Tanggal Retur',
			'noreturbayar' => 'No. Retur',
			'totaloaretur' => 'Total Retur OA',
			'totaltindakanretur' => 'Total Retur Tindakan',
			'totalbiayaretur' => 'Total Biaya Retur',
			'biayaadministrasi' => 'Biaya Administrasi',
			'keteranganretur' => 'Keterangan',
			'user_nm_otorisasi' => 'User Nm Otorisasi',
			'user_id_otorisasi' => 'User Id Otorisasi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'returresep_id'=>'Retur Resep',
                        'carabayar_id' =>'Jenis Penjamin',
                        'penjamin_id' => 'Penjamin',
                        'nobuktibayar' => 'No. Pembayaran',
                        'tgl_pendaftaran' => 'Tgl. Pendaftaran',
                        'no_pendaftaran' => 'No. Pendaftaran',
                        'no_rekam_medik' => 'No. Rekam Medik',
                    'jumlahpembulatan'=> 'Jumlah Pembulatan'
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

		$criteria->compare('returbayarpelayanan_id',$this->returbayarpelayanan_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(tglreturpelayanan)',strtolower($this->tglreturpelayanan),true);
		$criteria->compare('LOWER(noreturbayar)',strtolower($this->noreturbayar),true);
		$criteria->compare('totaloaretur',$this->totaloaretur);
		$criteria->compare('totaltindakanretur',$this->totaltindakanretur);
		$criteria->compare('totalbiayaretur',$this->totalbiayaretur);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('user_nm_otorisasi',$this->user_nm_otorisasi);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('returresep_id',$this->returresep_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('returbayarpelayanan_id',$this->returbayarpelayanan_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(tglreturpelayanan)',strtolower($this->tglreturpelayanan),true);
		$criteria->compare('LOWER(noreturbayar)',strtolower($this->noreturbayar),true);
		$criteria->compare('totaloaretur',$this->totaloaretur);
		$criteria->compare('totaltindakanretur',$this->totaltindakanretur);
		$criteria->compare('totalbiayaretur',$this->totalbiayaretur);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('user_nm_otorisasi',$this->user_nm_otorisasi);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('returresep_id',$this->returresep_id);
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
                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }
            }

            return parent::beforeValidate ();
        }
                
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
        public function searchReturPenjualan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('returbayarpelayanan_id',$this->returbayarpelayanan_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(tglreturpelayanan)',strtolower($this->tglreturpelayanan),true);
		$criteria->compare('LOWER(noreturbayar)',strtolower($this->noreturbayar),true);
		$criteria->compare('totaloaretur',$this->totaloaretur);
		$criteria->compare('totaltindakanretur',$this->totaltindakanretur);
		$criteria->compare('totalbiayaretur',$this->totalbiayaretur);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('user_nm_otorisasi',$this->user_nm_otorisasi);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('returresep_id',$this->returresep_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}