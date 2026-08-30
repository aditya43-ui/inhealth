<?php

/**
 * This is the model class for table "permintaanpenawaran_t".
 *
 * The followings are the available columns in table 'permintaanpenawaran_t':
 * @property integer $permintaanpenawaran_id
 * @property integer $supplier_id
 * @property integer $rencanakebfarmasi_id
 * @property string $tglpenawaran
 * @property string $nosuratpenawaran
 * @property double $harganettopenawaran
 * @property string $keteranganpenawaran
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawaimengetahui_id
 * @property integer $pegawaimenyetujui_id
 * @property string $statusrencana
 */
class PermintaanpenawaranT extends CActiveRecord
{
        public $obatAlkes;
        public $tgl_awal;
        public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaanpenawaranT the static model class
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
		return 'permintaanpenawaran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpenawaran, nosuratpenawaran, supplier_id', 'required'),
			array('supplier_id, rencanakebfarmasi_id', 'numerical', 'integerOnly'=>true),
			array('harganettopenawaran', 'numerical'),
			array('nosuratpenawaran', 'length', 'max'=>50),
			array('keteranganpenawaran, update_time, update_loginpemakai_id', 'safe'),
                        array('tglpenawaran','setValidation'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('permintaanpenawaran_id, supplier_id, rencanakebfarmasi_id, tglpenawaran, nosuratpenawaran, harganettopenawaran, keteranganpenawaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaimengetahui_id, pegawaimenyetujui_id, statusrencana', 'safe', 'on'=>'search'),
		);
	}
        
        /**
         * custom validation for tglperencanaan 
         */
        public function setValidation(){
            if (!$this->hasErrors()){
                if (strtotime(date('Y-m-d', strtotime($this->tglpenawaran))) >= strtotime(date('Y-m-d H:i:s'))){
                    $this->addError('tglpenawaran','Tanggal penawaran tidak boleh lebih dari '.date('d M Y'));
                }
            }
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'supplier'=>array(self::BELONGS_TO, 'SupplierM','supplier_id'),
                    'permintaanpembelian'=>array(self::HAS_ONE, 'PermintaanpembelianT','permintaanpenawaran_id'),
                    'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
                    'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permintaanpenawaran_id' => 'Permintaanpenawaran',
			'supplier_id' => 'Supplier',
			'rencanakebfarmasi_id' => 'Rencanakebfarmasi',
			'tglpenawaran' => 'Tanggal Penawaran',
			'nosuratpenawaran' => 'No. Surat',
			'harganettopenawaran' => 'Total Harga Netto',
			'keteranganpenawaran' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'obatAlkes'=>'Obat Alkes',
			'pegawaimengetahui_id' =>'Pegawai Mengetahui',
			'pegawaimenyetujui_id' =>'Pegawai Menyetujui',
			'statusrencana' =>'Status Rencana',
			'ispenawaranmasuk'=>'Penawaran Masuk'

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

		$criteria->compare('permintaanpenawaran_id',$this->permintaanpenawaran_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('rencanakebfarmasi_id',$this->rencanakebfarmasi_id);
		$criteria->compare('LOWER(tglpenawaran)',strtolower($this->tglpenawaran),true);
		$criteria->compare('LOWER(nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);
		$criteria->compare('harganettopenawaran',$this->harganettopenawaran);
		$criteria->compare('LOWER(keteranganpenawaran)',strtolower($this->keteranganpenawaran),true);
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
		$criteria->compare('permintaanpenawaran_id',$this->permintaanpenawaran_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('rencanakebfarmasi_id',$this->rencanakebfarmasi_id);
		$criteria->compare('LOWER(tglpenawaran)',strtolower($this->tglpenawaran),true);
		$criteria->compare('LOWER(nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);
		$criteria->compare('harganettopenawaran',$this->harganettopenawaran);
		$criteria->compare('LOWER(keteranganpenawaran)',strtolower($this->keteranganpenawaran),true);
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
        
        public function getSupplierItems()
        {
            return GFSupplierM::model()->findAll("supplier_aktif=TRUE AND supplier_jenis='Farmasi' ORDER BY supplier_nama");
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
}