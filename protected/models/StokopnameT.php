<?php

/**
 * This is the model class for table "stokopname_t".
 *
 * The followings are the available columns in table 'stokopname_t':
 * @property integer $stokopname_id
 * @property integer $ruangan_id
 * @property integer $formuliropname_id
 * @property string $tglstokopname
 * @property string $nostokopname
 * @property boolean $isstokawal
 * @property string $jenisstokopname
 * @property string $keterangan_opname
 * @property double $totalharga
 * @property double $totalnetto
 * @property integer $mengetahui_id
 * @property integer $petugas1_id
 * @property integer $petugas2_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class StokopnameT extends CActiveRecord
{
        public $mengetahui_nama, $petugas1_nama, $petugas2_nama, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StokopnameT the static model class
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
		return 'stokopname_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, tglstokopname, nostokopname, jenisstokopname, totalharga, totalnetto', 'required'),
			array('ruangan_id, formuliropname_id, mengetahui_id, petugas1_id, petugas2_id', 'numerical', 'integerOnly'=>true),
			array('totalharga, totalnetto', 'numerical'),
			array('nostokopname, jenisstokopname', 'length', 'max'=>50),
			array('mengetahui_nama, petugas1_nama, petugas2_nama, isstokawal, keterangan_opname, update_time, update_loginpemakai_id', 'safe'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan', 'default', 'value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_akhir, stokopname_id, ruangan_id, formuliropname_id, tglstokopname, nostokopname, isstokawal, jenisstokopname, keterangan_opname, totalharga, totalnetto, mengetahui_id, petugas1_id, petugas2_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'mengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
                    'petugas1'=>array(self::BELONGS_TO, 'PegawaiM', 'petugas1_id'),
                    'petugas2'=>array(self::BELONGS_TO, 'PegawaiM', 'petugas2_id'),
                    'formuliropname'=>array(self::BELONGS_TO, 'FormuliropnameR', 'formuliropname_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stokopname_id' => 'Stock Opname',
			'ruangan_id' => 'Ruangan',
			'formuliropname_id' => 'Formulir Opname',
			'tglstokopname' => 'Tanggal Stock Opname',
			'nostokopname' => 'No. Stock Opname',
			'isstokawal' => 'Is Stok Awal',
			'jenisstokopname' => 'Jenis Stock Opname',
			'keterangan_opname' => 'Keterangan Opname',
			'totalharga' => 'Total Nilai Persediaan',
			'totalnetto' => 'Total Netto',
			'mengetahui_id' => 'Mengetahui',
			'petugas1_id' => 'Petugas 1',
			'petugas2_id' => 'Petugas 2',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'tgl_akhir'=>'Sampai Dengan',
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

                $criteria->with=array('mengetahui');
		$criteria->compare('stokopname_id',$this->stokopname_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('formuliropname_id',$this->formuliropname_id);
		$criteria->compare('tglstokopname',$this->tglstokopname,true);
		$criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
		$criteria->compare('isstokawal',$this->isstokawal);
		$criteria->compare('LOWER(jenisstokopname)',strtolower($this->jenisstokopname),true);
		$criteria->compare('LOWER(keterangan_opname)',strtolower($this->keterangan_opname),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('totalnetto',$this->totalnetto);
		$criteria->compare('LOWER(mengetahui.nama_pegawai)',strtolower($this->mengetahui_id),true);
		$criteria->compare('petugas1_id',$this->petugas1_id);
		$criteria->compare('petugas2_id',$this->petugas2_id);
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
		$criteria->compare('stokopname_id',$this->stokopname_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('formuliropname_id',$this->formuliropname_id);
		$criteria->compare('LOWER(tglstokopname)',strtolower($this->tglstokopname),true);
		$criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
		$criteria->compare('isstokawal',$this->isstokawal);
		$criteria->compare('LOWER(jenisstokopname)',strtolower($this->jenisstokopname),true);
		$criteria->compare('LOWER(keterangan_opname)',strtolower($this->keterangan_opname),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('totalnetto',$this->totalnetto);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('petugas1_id',$this->petugas1_id);
		$criteria->compare('petugas2_id',$this->petugas2_id);
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

//        protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//                    else if ( $column->dbType == 'timestamp without time zone')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//            }
//
//            return parent::beforeValidate ();
//        }

//        public function beforeSave() {
//            if($this->tglstokopname===null || trim($this->tglstokopname)==''){
//	        $this->setAttribute('tglstokopname', null);
//            }
//
//            return parent::beforeSave();
//        }
//
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
