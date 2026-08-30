<?php

/**
 * This is the model class for table "returpenerimaan_t".
 *
 * The followings are the available columns in table 'returpenerimaan_t':
 * @property integer $returpenerimaan_id
 * @property integer $terimapersediaan_id
 * @property string $noreturterima
 * @property string $tglreturterima
 * @property string $alasanreturterima
 * @property string $keterangan_retur
 * @property double $totalretur
 * @property integer $peg_retur_id
 * @property integer $peg_mengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ReturpenerimaanT extends CActiveRecord
{
        public $peg_retur_nama, $peg_mengetahui_nama, $tgl_awal, $tgl_akhir;
        public $jumlah;
        public $data;
        public $tick;
        public $pilihanx;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturpenerimaanT the static model class
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
		return 'returpenerimaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('noreturterima, tglreturterima, alasanreturterima, peg_retur_id', 'required'),
			array('terimapersediaan_id, peg_retur_id, peg_mengetahui_id', 'numerical', 'integerOnly'=>true),
			array('totalretur', 'numerical'),
			array('noreturterima', 'length', 'max'=>50),
			array('alasanreturterima', 'length', 'max'=>100),
			array('peg_retur_nama, peg_mengetahui_nama, keterangan_retur, update_time, update_loginpemakai_id', 'safe'),
                        array('create_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_ruangan', 'default','value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returpenerimaan_id, terimapersediaan_id, noreturterima, tgl_awal, tgl_akhir, jumlah, data, tick, pilihanx, tglreturterima, alasanreturterima, keterangan_retur, totalretur, peg_retur_id, peg_mengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pegawairetur'=>array(self::BELONGS_TO, 'PegawaiM', 'peg_retur_id'),
                    'pegawaimengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'peg_mengetahui_id'),
					'terimapersediaan'=>array(self::BELONGS_TO, 'TerimapersediaanT', 'terimapersediaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'returpenerimaan_id' => 'Retur Penerimaan',
			'terimapersediaan_id' => 'Terima Persediaan',
			'noreturterima' => 'No. Retur Terima',
			'tglreturterima' => 'Tanggal Retur Terima',
			'alasanreturterima' => 'Alasan Retur Terima',
			'keterangan_retur' => 'Keterangan Retur',
			'totalretur' => 'Total Retur',
			'peg_retur_id' => 'Pegawai Retur',
			'peg_mengetahui_id' => 'Pegawai Mengetahui',
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

		$criteria->compare('returpenerimaan_id',$this->returpenerimaan_id);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('LOWER(noreturterima)',strtolower($this->noreturterima),true);
		$criteria->compare('LOWER(tglreturterima)',strtolower($this->tglreturterima),true);
		$criteria->compare('LOWER(alasanreturterima)',strtolower($this->alasanreturterima),true);
		$criteria->compare('LOWER(keterangan_retur)',strtolower($this->keterangan_retur),true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('peg_retur_id',$this->peg_retur_id);
		$criteria->compare('peg_mengetahui_id',$this->peg_mengetahui_id);
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
		$criteria->compare('returpenerimaan_id',$this->returpenerimaan_id);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('LOWER(noreturterima)',strtolower($this->noreturterima),true);
		$criteria->compare('LOWER(tglreturterima)',strtolower($this->tglreturterima),true);
		$criteria->compare('LOWER(alasanreturterima)',strtolower($this->alasanreturterima),true);
		$criteria->compare('LOWER(keterangan_retur)',strtolower($this->keterangan_retur),true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('peg_retur_id',$this->peg_retur_id);
		$criteria->compare('peg_mengetahui_id',$this->peg_mengetahui_id);
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
            if($this->tglreturterima===null || trim($this->tglreturterima)==''){
	        $this->setAttribute('tglreturterima', null);
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