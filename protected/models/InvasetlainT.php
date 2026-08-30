<?php

/**
 * This is the model class for table "invasetlain_t".
 *
 * The followings are the available columns in table 'invasetlain_t':
 * @property integer $invasetlain_id
 * @property integer $asalaset_id
 * @property integer $barang_id
 * @property integer $lokasi_id
 * @property integer $pemilikbarang_id
 * @property string $invasetlain_kode
 * @property string $invasetlain_noregister
 * @property string $invasetlain_namabrg
 * @property string $invasetlain_judulbuku
 * @property string $invasetlain_spesifikasibuku
 * @property string $invasetlain_asalkesenian
 * @property double $invasetlain_jumlah
 * @property string $invasetlain_thncetak
 * @property double $invasetlain_harga
 * @property string $invasetlain_tglguna
 * @property double $invasetlain_akumsusut
 * @property string $invasetlain_ket
 * @property string $invasetlain_penciptakesenian
 * @property string $invasetlain_bahankesenian
 * @property string $invasetlain_jenishewan_tum
 * @property string $invasetlain_ukuranhewan_tum
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InvasetlainT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvasetlainT the static model class
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
		return 'invasetlain_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, pemilikbarang_id, invasetlain_kode, invasetlain_noregister, invasetlain_namabrg, invasetlain_umurekonomis, invasetlain_tglguna', 'required'),
			array('asalaset_id, barang_id, lokasi_id, pemilikbarang_id', 'numerical', 'integerOnly'=>true),
			array('invasetlain_jumlah, invasetlain_harga, invasetlain_akumsusut', 'numerical'),
			array('invasetlain_kode, invasetlain_noregister, invasetlain_judulbuku, invasetlain_spesifikasibuku, invasetlain_asalkesenian, invasetlain_penciptakesenian, invasetlain_bahankesenian, invasetlain_jenishewan_tum, invasetlain_ukuranhewan_tum', 'length', 'max'=>50),
			array('invasetlain_namabrg, invasetlain_ket', 'length', 'max'=>100),
			array('invasetlain_thncetak', 'length', 'max'=>5),
			array('terimapersdetail_id, invasetlain_tglguna, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('invasetlain_id, asalaset_id, barang_id, lokasi_id, pemilikbarang_id, invasetlain_kode, invasetlain_noregister, invasetlain_namabrg, invasetlain_judulbuku, invasetlain_spesifikasibuku, invasetlain_asalkesenian, invasetlain_jumlah, invasetlain_thncetak, invasetlain_harga, invasetlain_tglguna, invasetlain_akumsusut, invasetlain_ket, invasetlain_penciptakesenian, invasetlain_bahankesenian, invasetlain_jenishewan_tum, invasetlain_ukuranhewan_tum, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'asal'=>array(self::BELONGS_TO,'AsalasetM','asalaset_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invasetlain_id' => 'ID',
			'asalaset_id' => 'Asal aset',
			'barang_id' => 'Barang',
			'lokasi_id' => 'Lokasi',
			'pemilikbarang_id' => 'Pemilik Barang',
			'invasetlain_kode' => 'Kode',
			'invasetlain_noregister' => ' No. register',
			'invasetlain_namabrg' => 'Nama Barang',
			'invasetlain_judulbuku' => 'Judul Buku',
			'invasetlain_spesifikasibuku' => 'Spesifikasi Buku',
			'invasetlain_asalkesenian' => 'Asal Kesenian',
			'invasetlain_jumlah' => 'Jumlah',
			'invasetlain_thncetak' => 'Tahun Cetak',
			'invasetlain_harga' => 'Harga',
			'invasetlain_tglguna' => 'Tanggal Penggunaan',
			'invasetlain_akumsusut' => 'Akum Susut',
			'invasetlain_ket' => 'Keterangan',
			'invasetlain_penciptakesenian' => 'Pencipta Kesenian',
			'invasetlain_bahankesenian' => 'Bahan Kesenian',
			'invasetlain_jenishewan_tum' => 'Jenis Hewan',
			'invasetlain_ukuranhewan_tum' => 'Ukuran Hewan',
			'invasetlain_umurekonomis' => 'Tahun Ekonomis',
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

		$criteria->compare('invasetlain_id',$this->invasetlain_id);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		$criteria->compare('LOWER(invasetlain_namabrg)',strtolower($this->invasetlain_namabrg),true);
		$criteria->compare('LOWER(invasetlain_judulbuku)',strtolower($this->invasetlain_judulbuku),true);
		$criteria->compare('LOWER(invasetlain_spesifikasibuku)',strtolower($this->invasetlain_spesifikasibuku),true);
		$criteria->compare('LOWER(invasetlain_asalkesenian)',strtolower($this->invasetlain_asalkesenian),true);
		$criteria->compare('invasetlain_jumlah',$this->invasetlain_jumlah);
		$criteria->compare('LOWER(invasetlain_thncetak)',strtolower($this->invasetlain_thncetak),true);
		$criteria->compare('invasetlain_harga',$this->invasetlain_harga);
		$criteria->compare('LOWER(invasetlain_tglguna)',strtolower($this->invasetlain_tglguna),true);
		$criteria->compare('invasetlain_akumsusut',$this->invasetlain_akumsusut);
		$criteria->compare('LOWER(invasetlain_ket)',strtolower($this->invasetlain_ket),true);
		$criteria->compare('LOWER(invasetlain_penciptakesenian)',strtolower($this->invasetlain_penciptakesenian),true);
		$criteria->compare('LOWER(invasetlain_bahankesenian)',strtolower($this->invasetlain_bahankesenian),true);
		$criteria->compare('LOWER(invasetlain_jenishewan_tum)',strtolower($this->invasetlain_jenishewan_tum),true);
		$criteria->compare('LOWER(invasetlain_ukuranhewan_tum)',strtolower($this->invasetlain_ukuranhewan_tum),true);
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
		$criteria->compare('invasetlain_id',$this->invasetlain_id);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		$criteria->compare('LOWER(invasetlain_namabrg)',strtolower($this->invasetlain_namabrg),true);
		$criteria->compare('LOWER(invasetlain_judulbuku)',strtolower($this->invasetlain_judulbuku),true);
		$criteria->compare('LOWER(invasetlain_spesifikasibuku)',strtolower($this->invasetlain_spesifikasibuku),true);
		$criteria->compare('LOWER(invasetlain_asalkesenian)',strtolower($this->invasetlain_asalkesenian),true);
		$criteria->compare('invasetlain_jumlah',$this->invasetlain_jumlah);
		$criteria->compare('LOWER(invasetlain_thncetak)',strtolower($this->invasetlain_thncetak),true);
		$criteria->compare('invasetlain_harga',$this->invasetlain_harga);
		$criteria->compare('LOWER(invasetlain_tglguna)',strtolower($this->invasetlain_tglguna),true);
		$criteria->compare('invasetlain_akumsusut',$this->invasetlain_akumsusut);
		$criteria->compare('LOWER(invasetlain_ket)',strtolower($this->invasetlain_ket),true);
		$criteria->compare('LOWER(invasetlain_penciptakesenian)',strtolower($this->invasetlain_penciptakesenian),true);
		$criteria->compare('LOWER(invasetlain_bahankesenian)',strtolower($this->invasetlain_bahankesenian),true);
		$criteria->compare('LOWER(invasetlain_jenishewan_tum)',strtolower($this->invasetlain_jenishewan_tum),true);
		$criteria->compare('LOWER(invasetlain_ukuranhewan_tum)',strtolower($this->invasetlain_ukuranhewan_tum),true);
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
        
         protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
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

        protected function beforeSave() {  
            if($this->invasetlain_tglguna===null || trim($this->invasetlain_tglguna)==''){
	        $this->setAttribute('invasetlain_tglguna', null);
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
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
}