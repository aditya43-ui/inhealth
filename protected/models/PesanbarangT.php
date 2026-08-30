<?php

/**
 * This is the model class for table "pesanbarang_t".
 *
 * The followings are the available columns in table 'pesanbarang_t':
 * @property integer $pesanbarang_id
 * @property integer $mutasibrg_id
 * @property string $nopemesanan
 * @property string $tglpesanbarang
 * @property string $tglmintadikirim
 * @property integer $ruanganpemesan_id
 * @property string $keterangan_pesan
 * @property integer $pegpemesan_id
 * @property integer $pegmengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PesanbarangT extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir, $ruanganpemesan_nama, $pegpemesan_nama, $pegmengetahui_nama, $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanbarangT the static model class
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
		return 'pesanbarang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nopemesanan, tglpesanbarang, ruanganpemesan_id, pegpemesan_id', 'required'),
			array('mutasibrg_id, ruanganpemesan_id, pegpemesan_id, pegmengetahui_id', 'numerical', 'integerOnly'=>true),
			array('nopemesanan', 'length', 'max'=>50),
			array('pesanbarang_status, ruangantujuan_id, tglmintadikirim, keterangan_pesan, update_time, update_loginpemakai_id, instalasi_id, pegpemesan_nama, pegmengetahui_nama, ruanganpemesan_nama ', 'safe'),
                        array('create_time', 'default', 'value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_time', 'default', 'value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_loginpemakai_id', 'default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_loginpemakai_id','default', 'value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
                        
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, pesanbarang_id, mutasibrg_id, nopemesanan, tglpesanbarang, tglmintadikirim, ruanganpemesan_id, keterangan_pesan, pegpemesan_id, pegmengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'ruanganpemesan'=>array(self::BELONGS_TO, 'RuanganM', 'ruanganpemesan_id'),
                    'ruangantujuan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangantujuan_id'),
                    'pegawaipemesan'=>array(self::BELONGS_TO, 'PegawaiM', 'pegpemesan_id'),
                    'pegawaimengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanbarang_id' => 'Pesan Barang',
			'mutasibrg_id' => 'Mutasi Barang',
			'nopemesanan' => 'No. Pemesanan',
			'tglpesanbarang' => 'Tanggal Pesan Barang',
			'tglmintadikirim' => 'Tanggal Kirim',
			'ruanganpemesan_id' => 'Ruangan Pemesan',
			'keterangan_pesan' => 'Keterangan Pesan',
			'pegpemesan_id' => 'Pegawai Pemesan',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'pegpemesan_nama'=>'Pegawai Pemesan', 
                        'pegmengetahui_nama'=>'Pegawai Mengetahui',
                        'ruangantujuan_id' => 'Ruangan Tujuan',
                        'ruanganpemesan_nama' => 'Ruangan Pemesan',
                        'pesanbarang_status' => 'Status'
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

		$criteria->compare('pesanbarang_id',$this->pesanbarang_id);
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('LOWER(nopemesanan)',strtolower($this->nopemesanan),true);
		$criteria->compare('LOWER(tglpesanbarang)',strtolower($this->tglpesanbarang),true);
		$criteria->compare('LOWER(tglmintadikirim)',strtolower($this->tglmintadikirim),true);
		$criteria->compare('ruanganpemesan_id',$this->ruanganpemesan_id);
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		$criteria->compare('pegpemesan_id',$this->pegpemesan_id);
		$criteria->compare('pegmengetahui_id',$this->pegmengetahui_id);
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
		$criteria->compare('pesanbarang_id',$this->pesanbarang_id);
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('LOWER(nopemesanan)',strtolower($this->nopemesanan),true);
		$criteria->compare('LOWER(tglpesanbarang)',strtolower($this->tglpesanbarang),true);
		$criteria->compare('LOWER(tglmintadikirim)',strtolower($this->tglmintadikirim),true);
		$criteria->compare('ruanganpemesan_id',$this->ruanganpemesan_id);
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		$criteria->compare('pegpemesan_id',$this->pegpemesan_id);
		$criteria->compare('pegmengetahui_id',$this->pegmengetahui_id);
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
            if($this->tglmintadikirim===null || trim($this->tglmintadikirim)==''){
	        $this->setAttribute('tglmintadikirim', null);
            }
            if($this->tglpesanbarang===null || trim($this->tglpesanbarang)==''){
	        $this->setAttribute('tglpesanbarang', null);
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