<?php

/**
 * This is the model class for table "invjalan_t".
 *
 * The followings are the available columns in table 'invjalan_t':
 * @property integer $invjalan_id
 * @property integer $pemilikbarang_id
 * @property integer $asalaset_id
 * @property integer $barang_id
 * @property integer $lokasi_id
 * @property string $invjalan_kode
 * @property string $invjalan_noregister
 * @property string $invjalan_namabrg
 * @property string $invjalan_kontruksi
 * @property string $invjalan_panjang
 * @property string $invjalan_lebar
 * @property string $invjalan_luas
 * @property string $invjalan_letak
 * @property string $invjalan_tgldokumen
 * @property string $invjalan_tglguna
 * @property string $invjalan_nodokumen
 * @property string $invjalan_statustanah
 * @property string $invjalan_keadaaan
 * @property double $invjalan_harga
 * @property double $invjalan_akumsusut
 * @property string $invjalan_ket
 * @property string $craete_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InvjalanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvjalanT the static model class
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
		return 'invjalan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemilikbarang_id, barang_id, invjalan_kode, invjalan_noregister, invjalan_namabrg, invjalan_tglguna, invjalan_umurekonomis', 'required'),
			array('pemilikbarang_id, asalaset_id, barang_id, lokasi_id', 'numerical', 'integerOnly'=>true),
			array('invjalan_harga, invjalan_akumsusut', 'numerical'),
			array('invjalan_kode, invjalan_noregister, invjalan_statustanah, invjalan_keadaaan', 'length', 'max'=>50),
			array('invjalan_namabrg, invjalan_ket', 'length', 'max'=>100),
			array('invjalan_kontruksi', 'length', 'max'=>20),
			array('invjalan_panjang, invjalan_lebar, invjalan_luas, invjalan_letak, invjalan_nodokumen', 'length', 'max'=>30),
			array('terimapersdetail_id, invjalan_tgldokumen, invjalan_tglguna, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('craete_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('invjalan_id, pemilikbarang_id, asalaset_id, barang_id, lokasi_id, invjalan_kode, invjalan_noregister, invjalan_namabrg, invjalan_kontruksi, invjalan_panjang, invjalan_lebar, invjalan_luas, invjalan_letak, invjalan_tgldokumen, invjalan_tglguna, invjalan_nodokumen, invjalan_statustanah, invjalan_keadaaan, invjalan_harga, invjalan_akumsusut, invjalan_ket, craete_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'invjalan_id' => 'ID',
			'pemilikbarang_id' => 'Pemilik Barang',
			'asalaset_id' => 'Asal Aset',
			'barang_id' => 'Barang',
			'lokasi_id' => 'Lokasi',
			'invjalan_kode' => 'Kode',
			'invjalan_noregister' => 'No. Register',
			'invjalan_namabrg' => 'Nama Barang',
			'invjalan_kontruksi' => 'Kontruksi',
			'invjalan_panjang' => ' Panjang',
			'invjalan_lebar' => ' Lebar',
			'invjalan_luas' => ' Luas',
			'invjalan_letak' => ' Letak',
			'invjalan_tgldokumen' => 'Tanggal Dokumen',
			'invjalan_tglguna' => 'Tanggal Penggunaan',
			'invjalan_nodokumen' => 'No. Dokumen',
			'invjalan_statustanah' => 'Status Tanah',
			'invjalan_keadaaan' => 'Keadaan',
			'invjalan_harga' => 'Harga',
			'invjalan_akumsusut' => 'Akum Susut',
			'invjalan_ket' => 'Keterangan',
			'invjalan_umurekonomis' => 'Tahun Ekonomis',
			'craete_time' => 'Craete Time',
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

		$criteria->compare('invjalan_id',$this->invjalan_id);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		$criteria->compare('LOWER(invjalan_namabrg)',strtolower($this->invjalan_namabrg),true);
		$criteria->compare('LOWER(invjalan_kontruksi)',strtolower($this->invjalan_kontruksi),true);
		$criteria->compare('LOWER(invjalan_panjang)',strtolower($this->invjalan_panjang),true);
		$criteria->compare('LOWER(invjalan_lebar)',strtolower($this->invjalan_lebar),true);
		$criteria->compare('LOWER(invjalan_luas)',strtolower($this->invjalan_luas),true);
		$criteria->compare('LOWER(invjalan_letak)',strtolower($this->invjalan_letak),true);
		$criteria->compare('LOWER(invjalan_tgldokumen)',strtolower($this->invjalan_tgldokumen),true);
		$criteria->compare('LOWER(invjalan_tglguna)',strtolower($this->invjalan_tglguna),true);
		$criteria->compare('LOWER(invjalan_nodokumen)',strtolower($this->invjalan_nodokumen),true);
		$criteria->compare('LOWER(invjalan_statustanah)',strtolower($this->invjalan_statustanah),true);
		$criteria->compare('LOWER(invjalan_keadaaan)',strtolower($this->invjalan_keadaaan),true);
		$criteria->compare('invjalan_harga',$this->invjalan_harga);
		$criteria->compare('invjalan_akumsusut',$this->invjalan_akumsusut);
		$criteria->compare('LOWER(invjalan_ket)',strtolower($this->invjalan_ket),true);
		$criteria->compare('LOWER(craete_time)',strtolower($this->craete_time),true);
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
		$criteria->compare('invjalan_id',$this->invjalan_id);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		$criteria->compare('LOWER(invjalan_namabrg)',strtolower($this->invjalan_namabrg),true);
		$criteria->compare('LOWER(invjalan_kontruksi)',strtolower($this->invjalan_kontruksi),true);
		$criteria->compare('LOWER(invjalan_panjang)',strtolower($this->invjalan_panjang),true);
		$criteria->compare('LOWER(invjalan_lebar)',strtolower($this->invjalan_lebar),true);
		$criteria->compare('LOWER(invjalan_luas)',strtolower($this->invjalan_luas),true);
		$criteria->compare('LOWER(invjalan_letak)',strtolower($this->invjalan_letak),true);
		$criteria->compare('LOWER(invjalan_tgldokumen)',strtolower($this->invjalan_tgldokumen),true);
		$criteria->compare('LOWER(invjalan_tglguna)',strtolower($this->invjalan_tglguna),true);
		$criteria->compare('LOWER(invjalan_nodokumen)',strtolower($this->invjalan_nodokumen),true);
		$criteria->compare('LOWER(invjalan_statustanah)',strtolower($this->invjalan_statustanah),true);
		$criteria->compare('LOWER(invjalan_keadaaan)',strtolower($this->invjalan_keadaaan),true);
		$criteria->compare('invjalan_harga',$this->invjalan_harga);
		$criteria->compare('invjalan_akumsusut',$this->invjalan_akumsusut);
		$criteria->compare('LOWER(invjalan_ket)',strtolower($this->invjalan_ket),true);
		$criteria->compare('LOWER(craete_time)',strtolower($this->craete_time),true);
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
            if($this->invjalan_tgldokumen===null || trim($this->invjalan_tgldokumen)==''){
	        $this->setAttribute('invjalan_tgldokumen', null);
            }
            if($this->invjalan_tglguna===null || trim($this->invjalan_tglguna)==''){
	        $this->setAttribute('invjalan_tglguna', null);
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