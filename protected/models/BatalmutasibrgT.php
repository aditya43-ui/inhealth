<?php

/**
 * This is the model class for table "batalmutasibrg_t".
 *
 * The followings are the available columns in table 'batalmutasibrg_t':
 * @property integer $batalmutasibrg_id
 * @property integer $mutasibrg_id
 * @property string $tglbatalmutasibrg
 * @property string $alasan_pembatalan
 * @property double $qty_batal
 * @property double $hargasatuan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BatalmutasibrgT extends CActiveRecord
{
        public $qty_mutasi;
        public $mutasibrgdetail_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalmutasibrgT the static model class
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
		return 'batalmutasibrg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, mutasibrg_id, tglbatalmutasibrg, alasan_pembatalan, qty_batal, hargasatuan', 'required'),
			array('barang_id, mutasibrg_id', 'numerical', 'integerOnly'=>true),
			array('qty_batal, hargasatuan', 'numerical'),
			array('mutasibrgdetail_id, qty_mutasi, update_time, update_loginpemakai_id', 'safe'),
                        array('create_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_ruangan', 'default','value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mutasibrgdetail_id, batalmutasibrg_id, mutasibrg_id, tglbatalmutasibrg, alasan_pembatalan, qty_batal, hargasatuan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'batalmutasibrg_id' => 'Batal Mutasi Barang',
			'mutasibrg_id' => 'Mutasi Barang',
			'tglbatalmutasibrg' => 'Tanggal Batal Mutasi',
			'alasan_pembatalan' => 'Alasan Pembatalan',
			'qty_batal' => 'Jumlah Batal',
			'hargasatuan' => 'Harga Satuan',
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

		$criteria->compare('batalmutasibrg_id',$this->batalmutasibrg_id);
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('LOWER(tglbatalmutasibrg)',strtolower($this->tglbatalmutasibrg),true);
		$criteria->compare('LOWER(alasan_pembatalan)',strtolower($this->alasan_pembatalan),true);
		$criteria->compare('qty_batal',$this->qty_batal);
		$criteria->compare('hargasatuan',$this->hargasatuan);
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
		$criteria->compare('batalmutasibrg_id',$this->batalmutasibrg_id);
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('LOWER(tglbatalmutasibrg)',strtolower($this->tglbatalmutasibrg),true);
		$criteria->compare('LOWER(alasan_pembatalan)',strtolower($this->alasan_pembatalan),true);
		$criteria->compare('qty_batal',$this->qty_batal);
		$criteria->compare('hargasatuan',$this->hargasatuan);
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
            if($this->tglbatalmutasibrg===null || trim($this->tglbatalmutasibrg)==''){
	        $this->setAttribute('tglbatalmutasibrg', null);
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