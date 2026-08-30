<?php

/**
 * This is the model class for table "invgedung_t".
 *
 * The followings are the available columns in table 'invgedung_t':
 * @property integer $invgedung_id
 * @property integer $pemilikbarang_id
 * @property integer $barang_id
 * @property integer $lokasi_id
 * @property integer $asalaset_id
 * @property string $invgedung_kode
 * @property string $invgedung_noregister
 * @property string $invgedung_namabrg
 * @property string $invgedung_kontruksi
 * @property double $invgedung_luaslantai
 * @property string $invgedung_alamat
 * @property string $invgedung_tgldokumen
 * @property string $invgedung_tglguna
 * @property string $invgedung_nodokumen
 * @property double $invgedung_harga
 * @property double $invgedung_akumsusut
 * @property string $invgedung_ket
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property AsalasetM $asalaset
 * @property BarangM $barang
 * @property LokasiasetM $lokasi
 * @property PemilikbarangM $pemilikbarang
 */
class InvgedungT extends CActiveRecord
{
	public $barang_nama,$jmlterima,$nopenerimaan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvgedungT the static model class
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
		return 'invgedung_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemilikbarang_id, barang_id, invgedung_kode, invgedung_noregister, invgedung_namabrg, invgedung_alamat, create_time, invgedung_tglguna, umurekonomis', 'required'),
			array('pemilikbarang_id, barang_id, lokasi_id, asalaset_id', 'numerical', 'integerOnly'=>true),
			array('invgedung_luaslantai, invgedung_harga, invgedung_akumsusut', 'numerical'),
			array('invgedung_kode, invgedung_noregister', 'length', 'max'=>50),
			array('invgedung_kontruksi, invgedung_namabrg, invgedung_ket', 'length', 'max'=>100),
			array('invgedung_nodokumen', 'length', 'max'=>20),
			array('invgedung_tgldokumen, invgedung_tglguna, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
                        ['dalam_kontruksi, status_tanah, kondisifisikbanguna, kontruksi_bangunan, luas, kd_tanah','safe'],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invgedung_id, pemilikbarang_id, barang_id, lokasi_id, asalaset_id, invgedung_kode, invgedung_noregister, invgedung_namabrg, invgedung_kontruksi, invgedung_luaslantai, invgedung_alamat, invgedung_tgldokumen, invgedung_tglguna, invgedung_nodokumen, invgedung_harga, invgedung_akumsusut, invgedung_ket, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, umurekonomis', 'safe', 'on'=>'search'),
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
			'asalaset' => array(self::BELONGS_TO, 'AsalasetM', 'asalaset_id'),
			'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
			'lokasi' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasi_id'),
			'pemilikbarang' => array(self::BELONGS_TO, 'PemilikbarangM', 'pemilikbarang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invgedung_id' => 'Inv. Gedung ID',
			'pemilikbarang_id' => 'Pemilik Barang',
			'barang_id' => 'Barang',
			'lokasi_id' => 'Lokasi',
			'asalaset_id' => 'Asal Aset',
			'invgedung_kode' => 'Kode Gedung',
			'invgedung_noregister' => 'No. register',
			'invgedung_namabrg' => 'Nama Gedung',
			'invgedung_kontruksi' => 'Kontruksi Gedung',
			'invgedung_luaslantai' => 'Luas Lantai',
			'invgedung_alamat' => 'Alamat Gedung',
			'invgedung_tgldokumen' => 'Tanggal Dokumen Gedung',
			'invgedung_tglguna' => 'Tanggal Guna Gedung',
			'invgedung_nodokumen' => 'No. dokumen Gedung',
			'invgedung_harga' => 'Harga Gedung',
			'invgedung_akumsusut' => 'Akumulasi Susut Gedung',
			'invgedung_ket' => 'Keterangan Gedung',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'umurekonomis'=>'Tahun Ekonomis',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->pemilikbarang_id)){
			$criteria->addCondition('pemilikbarang_id = '.$this->pemilikbarang_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->lokasi_id)){
			$criteria->addCondition('lokasi_id = '.$this->lokasi_id);
		}
		if(!empty($this->asalaset_id)){
			$criteria->addCondition('asalaset_id = '.$this->asalaset_id);
		}
		$criteria->compare('LOWER(invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		$criteria->compare('LOWER(invgedung_namabrg)',strtolower($this->invgedung_namabrg),true);
		$criteria->compare('LOWER(invgedung_kontruksi)',strtolower($this->invgedung_kontruksi),true);
		$criteria->compare('invgedung_luaslantai',$this->invgedung_luaslantai);
		$criteria->compare('LOWER(invgedung_alamat)',strtolower($this->invgedung_alamat),true);
		$criteria->compare('LOWER(invgedung_tgldokumen)',strtolower($this->invgedung_tgldokumen),true);
		$criteria->compare('LOWER(invgedung_tglguna)',strtolower($this->invgedung_tglguna),true);
		$criteria->compare('LOWER(invgedung_nodokumen)',strtolower($this->invgedung_nodokumen),true);
		$criteria->compare('invgedung_harga',$this->invgedung_harga);
		$criteria->compare('invgedung_akumsusut',$this->invgedung_akumsusut);
		$criteria->compare('LOWER(invgedung_ket)',strtolower($this->invgedung_ket),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
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
            if($this->invgedung_tgldokumen===null || trim($this->invgedung_tgldokumen)==''){
	        $this->setAttribute('invgedung_tgldokumen', null);
            }
            if($this->invgedung_tglguna===null || trim($this->invgedung_tglguna)==''){
	        $this->setAttribute('invgedung_tglguna', null);
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
