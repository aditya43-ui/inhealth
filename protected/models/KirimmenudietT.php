<?php

/**
 * This is the model class for table "kirimmenudiet_t".
 *
 * The followings are the available columns in table 'kirimmenudiet_t':
 * @property integer $kirimmenudiet_id
 * @property integer $bahandiet_id
 * @property integer $jenisdiet_id
 * @property integer $pesanmenudiet_id
 * @property string $nokirimmenu
 * @property string $tglkirimmenu
 * @property string $keterangan_kirim
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KirimmenudietT extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimmenudietT the static model class
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
		return 'kirimmenudiet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiet_id, nokirimmenu, tglkirimmenu, jenispesanmenu', 'required'),
                        array('bahandiet_id, jenisdiet_id, pesanmenudiet_id', 'numerical', 'integerOnly'=>true),
                        array('nokirimmenu, jenispesanmenu', 'length', 'max'=>50),
                        array('keterangan_kirim, update_time, update_loginpemakai_id', 'safe'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('create_loginpemakai_id', 'default', 'value'=>Yii::app()->user->id,'setOnEmpty'=>false, 'on'=>'insert'),
                        array('create_ruangan', 'default', 'value'=>Yii::app()->user->getState('ruangan_id'), 'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, kirimmenudiet_id, bahandiet_id, jenisdiet_id, pesanmenudiet_id, nokirimmenu, tglkirimmenu, jenispesanmenu, keterangan_kirim, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'kirimmenupasien'=>array(self::HAS_ONE,'KirimmenupasienT','kirimmenudiet_id'),
                    'kirimmenupegawai'=>array(self::HAS_ONE,'KirimmenupegawaiT','kirimmenudiet_id'),
                    'bahandiet'=>array(self::BELONGS_TO, 'BahandietM', 'bahandiet_id'),
                    'jenisdiet'=>array(self::BELONGS_TO, 'JenisdietM', 'jenisdiet_id'),
                    'pesanmenudiet'=>array(self::BELONGS_TO, 'PesanmenudietT', 'pesanmenudiet_id'),
                    'pengirim' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kirimmenudiet_id' => 'Kirim Menu Diet',
			'bahandiet_id' => 'Bahan Diet',
			'jenisdiet_id' => 'Jenis Diet',
			'pesanmenudiet_id' => 'Pesan Menu Diet',
			'nokirimmenu' => 'No. Kirim Menu',
			'tglkirimmenu' => 'Tanggal Kirim Menu',
			'keterangan_kirim' => 'Keterangan Kirim',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'jenispesanmenu'=>'Menu Untuk',
                        'ruangan_id'=>'Ruangan',
                        'instalasi_id'=>'Instalasi'
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

		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('bahandiet_id',$this->bahandiet_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
                $criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('pesanmenudiet_id',$this->pesanmenudiet_id);
		$criteria->compare('LOWER(nokirimmenu)',strtolower($this->nokirimmenu),true);
		$criteria->addBetweenCondition('DATE(tglkirimmenu)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(keterangan_kirim)',strtolower($this->keterangan_kirim),true);
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
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('bahandiet_id',$this->bahandiet_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
                $criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('pesanmenudiet_id',$this->pesanmenudiet_id);
		$criteria->compare('LOWER(nokirimmenu)',strtolower($this->nokirimmenu),true);
		$criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
		$criteria->compare('LOWER(keterangan_kirim)',strtolower($this->keterangan_kirim),true);
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
                     else if ($column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }    
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tglkirimmenu===null || trim($this->tglkirimmenu)==''){
	        $this->setAttribute('tglkirimmenu', null);
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