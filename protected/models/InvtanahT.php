<?php
/**
 * This is the model class for table "invtanah_t".
 *
 * The followings are the available columns in table 'invtanah_t':
 * @property integer $invtanah_id
 * @property integer $pemilikbarang_id
 * @property integer $barang_id
 * @property integer $asalaset_id
 * @property integer $lokasi_id
 * @property string $invtanah_kode
 * @property string $invtanah_noregister
 * @property string $invtanah_namabrg
 * @property string $invtanah_luas
 * @property string $invtanah_thnpengadaan
 * @property string $invtanah_tglguna
 * @property string $invtanah_alamat
 * @property string $invtanah_status
 * @property string $invtanah_tglsertifikat
 * @property string $invtanah_nosertifikat
 * @property string $invtanah_penggunaan
 * @property double $invtanah_harga
 * @property string $invtanah_ket
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $terimapersdetail_id
 * @property double $invtanah_umurekonomis
 * @property double $umurekonomis
 * @property double $invtanah_nilairesidu
 * @property string $tglpenghapusan
 * @property string $tipepenghapusan
 * @property double $hargajualaktiva
 * @property double $kerugian
 * @property double $keuntungan
 *
 * The followings are the available model relations:
 * @property TerimapersdetailT $terimapersdetail
 */
class InvtanahT extends CActiveRecord
{
        public $barang_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvtanahT the static model class
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
		return 'invtanah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('pemilikbarang_id, barang_id, invtanah_tglguna, invtanah_umurekonomis', 'required'),
            array('pemilikbarang_id, barang_id, asalaset_id, lokasi_id, terimapersdetail_id', 'numerical', 'integerOnly'=>true),
            array('invtanah_harga, invtanah_umurekonomis, umurekonomis, invtanah_nilairesidu, hargajualaktiva, kerugian, keuntungan', 'numerical'),
            array('invtanah_kode, invtanah_noregister, invtanah_status', 'length', 'max'=>50),
            array('invtanah_namabrg, invtanah_nosertifikat, invtanah_penggunaan, invtanah_ket', 'length', 'max'=>100),
            array('invtanah_luas', 'length', 'max'=>30),
            array('invtanah_thnpengadaan', 'length', 'max'=>5),
            array('tipepenghapusan', 'length', 'max'=>25),
            array('invtanah_tglguna, invtanah_alamat, invtanah_tglsertifikat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglpenghapusan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
			array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			
            array('invtanah_id, pemilikbarang_id, barang_id, asalaset_id, lokasi_id, invtanah_kode, invtanah_noregister, invtanah_namabrg, invtanah_luas, invtanah_thnpengadaan, invtanah_tglguna, invtanah_alamat, invtanah_status, invtanah_tglsertifikat, invtanah_nosertifikat, invtanah_penggunaan, invtanah_harga, invtanah_ket, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, terimapersdetail_id, invtanah_umurekonomis, umurekonomis, invtanah_nilairesidu, tglpenghapusan, tipepenghapusan, hargajualaktiva, kerugian, keuntungan', 'safe', 'on'=>'search'),
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
                    'pemilik' => array(self::BELONGS_TO, 'PemilikbarangM', 'pemilikbarang_id'),
                    'barang'=>array(self::BELONGS_TO,'BarangM','barang_id'),
                    'lokasi' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasi_id'),
                    'asal'=>array(self::BELONGS_TO,'AsalasetM','asalaset_id'),
					'terimapersdetail' => array(self::BELONGS_TO, 'TerimapersdetailT', 'terimapersdetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invtanah_id' => 'Invtanah',
			'pemilikbarang_id' => 'Pemilik Barang',
			'barang_id' => 'Barang',
			'asalaset_id' => 'Asal Aset',
			'lokasi_id' => 'Lokasi',
			'invtanah_kode' => 'Kode Tanah',
			'invtanah_noregister' => ' No. Register',
			'invtanah_namabrg' => 'Nama Tanah',
			'invtanah_luas' => 'Luas Tanah',
			'invtanah_thnpengadaan' => 'Tahun Pengadaan',
			'invtanah_tglguna' => 'Tanggal Penggunaan',
			'invtanah_alamat' => 'Alamat Tanah',
			'invtanah_status' => 'Status Tanah',
			'invtanah_tglsertifikat' => 'Tanggal Sertifikat',
			'invtanah_nosertifikat' => 'No. Sertifikat',
			'invtanah_penggunaan' => 'Penggunaan Tanah',
			'invtanah_harga' => 'Harga Tanah',
			'invtanah_ket' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'terimapersdetail_id' => 'Terima Persediaan',
            'invtanah_umurekonomis' => 'Umur Ekonomis Tanah',
            'umurekonomis' => 'Umur Ekonomis',
            'invtanah_nilairesidu' => 'Nilai Residu',
            'tglpenghapusan' => 'Tanggal Penghapusan',
            'tipepenghapusan' => 'Tipe Penghapusan',
            'hargajualaktiva' => 'Harga Jual Aktiva',
            'kerugian' => 'Kerugian',
            'keuntungan' => 'Keuntungan',
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

		$criteria->compare('invtanah_id',$this->invtanah_id);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		$criteria->compare('LOWER(invtanah_namabrg)',strtolower($this->invtanah_namabrg),true);
		$criteria->compare('LOWER(invtanah_luas)',strtolower($this->invtanah_luas),true);
		$criteria->compare('LOWER(invtanah_thnpengadaan)',strtolower($this->invtanah_thnpengadaan),true);
		$criteria->compare('LOWER(invtanah_tglguna)',strtolower($this->invtanah_tglguna),true);
		$criteria->compare('LOWER(invtanah_alamat)',strtolower($this->invtanah_alamat),true);
		$criteria->compare('LOWER(invtanah_status)',strtolower($this->invtanah_status),true);
		$criteria->compare('LOWER(invtanah_tglsertifikat)',strtolower($this->invtanah_tglsertifikat),true);
		$criteria->compare('LOWER(invtanah_nosertifikat)',strtolower($this->invtanah_nosertifikat),true);
		$criteria->compare('LOWER(invtanah_penggunaan)',strtolower($this->invtanah_penggunaan),true);
		$criteria->compare('invtanah_harga',$this->invtanah_harga);
		$criteria->compare('LOWER(invtanah_ket)',strtolower($this->invtanah_ket),true);
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
		$criteria->compare('invtanah_id',$this->invtanah_id);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		$criteria->compare('LOWER(invtanah_namabrg)',strtolower($this->invtanah_namabrg),true);
		$criteria->compare('LOWER(invtanah_luas)',strtolower($this->invtanah_luas),true);
		$criteria->compare('LOWER(invtanah_thnpengadaan)',strtolower($this->invtanah_thnpengadaan),true);
		$criteria->compare('LOWER(invtanah_tglguna)',strtolower($this->invtanah_tglguna),true);
		$criteria->compare('LOWER(invtanah_alamat)',strtolower($this->invtanah_alamat),true);
		$criteria->compare('LOWER(invtanah_status)',strtolower($this->invtanah_status),true);
		$criteria->compare('LOWER(invtanah_tglsertifikat)',strtolower($this->invtanah_tglsertifikat),true);
		$criteria->compare('LOWER(invtanah_nosertifikat)',strtolower($this->invtanah_nosertifikat),true);
		$criteria->compare('LOWER(invtanah_penggunaan)',strtolower($this->invtanah_penggunaan),true);
		$criteria->compare('invtanah_harga',$this->invtanah_harga);
		$criteria->compare('LOWER(invtanah_ket)',strtolower($this->invtanah_ket),true);
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
        
        public function getBarangItems()
        {
            return BarangM::model()->findAll(array('order'=>'barang_nama'));
        }
                public function getPemilikItems()
        {
            return PemilikbarangM::model()->findAll(array('order'=>'pemilikbarang_nama'));
        }
        public function getAsalAsetItems()
        {
            return AsalasetM::model()->findAll(array('order'=>'asalaset_nama'));
        }
                public function getLokasiAsetItems()
        {
            return LokasiasetM::model()->findAll(array('order'=>'lokasiaset_namalokasi'));
        }
        
//         HINDARI PENGGUNAAN FUNCTION INI
//         protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date'){
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                    }elseif ($column->dbType == 'timestamp without time zone'){
//                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                    }
//            }
//
//            return parent::beforeValidate ();
//        }

//        HINDARI PENGGUNAAN FUNCTION INI
//        protected function beforeSave() {  
//            if($this->invtanah_tglguna===null || trim($this->invtanah_tglguna)==''){
//	        $this->setAttribute('invtanah_tglguna', null);
//            }
//            if($this->invtanah_tglsertifikat===null || trim($this->invtanah_tglsertifikat)==''){
//	        $this->setAttribute('invtanah_tglsertifikat', null);
//            }
//            return parent::beforeSave();
//        }
                
//        HINDARI PENGGUNAAN FUNCTION INI
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
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                        }
//            }
//            return true;
//        }
}