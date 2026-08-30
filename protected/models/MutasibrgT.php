<?php

/**
 * This is the model class for table "mutasibrg_t".
 *
 * The followings are the available columns in table 'mutasibrg_t':
 * @property integer $mutasibrg_id
 * @property integer $pesanbarang_id
 * @property string $tglmutasibrg
 * @property string $nomutasibrg
 * @property string $keterangan_mutasi
 * @property integer $pegpengirim_id
 * @property double $totalhargamutasi
 * @property integer $pegmengetahui_id
 * @property integer $ruangantujuan_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class MutasibrgT extends CActiveRecord
{
        public $tgl_awal,$tgl_akhir, $pegpengirim_nama, $pegmengetahui_nama, $instalasi_id, $ruangan_nama;
    public $masukkeluar; 
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutasibrgT the static model class
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
		return 'mutasibrg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglmutasibrg, nomutasibrg, pegpengirim_id, totalhargamutasi, ruangantujuan_id', 'required'),
			array('pesanbarang_id, pegpengirim_id, pegmengetahui_id, ruangantujuan_id', 'numerical', 'integerOnly'=>true),
			array('totalhargamutasi', 'numerical'),
			array('nomutasibrg', 'length', 'max'=>50),
			array('masukkeluar, ruangan_nama, pegpengirim_nama,pegmengetahui_nama, instalasi_id, keterangan_mutasi, update_time, update_loginpemakai_id', 'safe'),
                        array('create_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_ruangan', 'default','value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('masukkeluar, tgl_awal, tgl_akhir,mutasibrg_id, pesanbarang_id, tglmutasibrg, nomutasibrg, keterangan_mutasi, pegpengirim_id, totalhargamutasi, pegmengetahui_id, ruangantujuan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pegawaipengirim'=>array(self::BELONGS_TO, 'PegawaiM', 'pegpengirim_id'),
                    'pegawaimengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),
                    'pegawaimenyetujui'=>array(self::BELONGS_TO, 'PegawaiM', 'pegmenyetujui_id'),
                    'ruangantujuan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangantujuan_id'),
                    'pesanbarang'=>array(self::BELONGS_TO, 'PesanbarangT', 'pesanbarang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mutasibrg_id' => 'Mutasi Barang',
			'pesanbarang_id' => 'Pesan Barang',
			'tglmutasibrg' => 'Tanggal Mutasi Barang',
			'nomutasibrg' => 'No. Mutasi Barang',
			'keterangan_mutasi' => 'Keterangan Mutasi',
			'pegpengirim_id' => 'Pegawai Pengirim',
			'totalhargamutasi' => 'Total Harga Mutasi',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'ruangantujuan_id' => 'Ruangan Tujuan',
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

		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('pesanbarang_id',$this->pesanbarang_id);
		$criteria->compare('LOWER(tglmutasibrg)',strtolower($this->tglmutasibrg),true);
		$criteria->compare('LOWER(nomutasibrg)',strtolower($this->nomutasibrg),true);
		$criteria->compare('LOWER(keterangan_mutasi)',strtolower($this->keterangan_mutasi),true);
		$criteria->compare('pegpengirim_id',$this->pegpengirim_id);
		$criteria->compare('totalhargamutasi',$this->totalhargamutasi);
		$criteria->compare('pegmengetahui_id',$this->pegmengetahui_id);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
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
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('pesanbarang_id',$this->pesanbarang_id);
		$criteria->compare('LOWER(tglmutasibrg)',strtolower($this->tglmutasibrg),true);
		$criteria->compare('LOWER(nomutasibrg)',strtolower($this->nomutasibrg),true);
		$criteria->compare('LOWER(keterangan_mutasi)',strtolower($this->keterangan_mutasi),true);
		$criteria->compare('pegpengirim_id',$this->pegpengirim_id);
		$criteria->compare('totalhargamutasi',$this->totalhargamutasi);
		$criteria->compare('pegmengetahui_id',$this->pegmengetahui_id);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
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
                    else if ( $column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tglmutasibrg===null || trim($this->tglmutasibrg)==''){
	        $this->setAttribute('tglmutasibrg', null);
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
        
        public function getTestingData(){
            $modBatal = BatalmutasibrgT::model()->findAll('mutasibrg_id = '.$this->mutasibrg_id);
            if (count((array)$modBatal) > 0){
                $hasil = true;
            }else{
                $hasil = false;
            }
            
            return $hasil;
        }
}