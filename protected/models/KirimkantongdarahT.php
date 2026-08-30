<?php

/**
 * This is the model class for table "kirimkantongdarah_t".
 *
 * The followings are the available columns in table 'kirimkantongdarah_t':
 * @property integer $kirimkantongdarah_id
 * @property string $tglkirimkantongdarah
 * @property string $no_kirimkantong
 * @property integer $ruangankirim_id
 * @property integer $ruangantujuan_id
 * @property integer $petugaskirim_id
 * @property string $ket_kirim
 * @property boolean $isterima
 * @property integer $waktukirim_mnt
 * @property integer $petugastransporter_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property double $suhu
 *
 * The followings are the available model relations:
 * @property TerimakantongdarahT[] $terimakantongdarahTs
 * @property MonitoringkantongT[] $monitoringkantongTs
 * @property KirimkantongdetT[] $kirimkantongdetTs
 */
class KirimkantongdarahT extends CActiveRecord
{
    public $tgl_awal,$tgl_akhir,$petugaskirim_nama;
    public $coolboxdarah_id;
    public $ruangantujuan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimkantongdarahT the static model class
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
		return 'kirimkantongdarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglkirimkantongdarah, no_kirimkantong, ruangankirim_id, ruangantujuan_id, petugaskirim_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangankirim_id, ruangantujuan_id, petugaskirim_id, waktukirim_mnt, petugastransporter_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('suhu', 'numerical'),
			array('no_kirimkantong', 'length', 'max'=>50),
			array('coolboxdarah_id, ket_kirim, isterima, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kirimkantongdarah_id, tglkirimkantongdarah, no_kirimkantong, ruangankirim_id, ruangantujuan_id, petugaskirim_id, ket_kirim, isterima, waktukirim_mnt, petugastransporter_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, suhu', 'safe', 'on'=>'search'),
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
			'terimakantongdarahTs' => array(self::HAS_MANY, 'TerimakantongdarahT', 'kirimkantongdarah_id'),
			'monitoringkantongTs' => array(self::HAS_MANY, 'MonitoringkantongT', 'kirimkantongdarah_id'),
			'kirimkantongdetTs' => array(self::HAS_MANY, 'KirimkantongdetT', 'kirimkantongdarah_id'),
                        'ruangankirim' => array(self::BELONGS_TO,'RuanganM','ruangankirim_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kirimkantongdarah_id' => 'Kirimkantongdarah',
			'tglkirimkantongdarah' => 'Tglkirimkantongdarah',
			'no_kirimkantong' => 'No Kirimkantong',
			'ruangankirim_id' => 'Ruangankirim',
			'ruangantujuan_id' => 'Ruangantujuan',
			'petugaskirim_id' => 'Petugaskirim',
			'ket_kirim' => 'Ket Kirim',
			'isterima' => 'Isterima',
			'waktukirim_mnt' => 'Waktukirim Mnt',
			'petugastransporter_id' => 'Petugastransporter',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'suhu' => 'Suhu',
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

		$criteria->compare('kirimkantongdarah_id',$this->kirimkantongdarah_id);
		$criteria->compare('tglkirimkantongdarah',$this->tglkirimkantongdarah,true);
		$criteria->compare('no_kirimkantong',$this->no_kirimkantong,true);
		$criteria->compare('ruangankirim_id',$this->ruangankirim_id);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('petugaskirim_id',$this->petugaskirim_id);
		$criteria->compare('ket_kirim',$this->ket_kirim,true);
		$criteria->compare('isterima',$this->isterima);
		$criteria->compare('waktukirim_mnt',$this->waktukirim_mnt);
		$criteria->compare('petugastransporter_id',$this->petugastransporter_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('suhu',$this->suhu);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        //$criteria->addBetweenCondition(" DATE(tglkirimkantongdarah) ", $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('kirimkantongdarah_id',$this->kirimkantongdarah_id);
		//$criteria->compare('tglkirimkantongdarah',$this->tglkirimkantongdarah,true);
		$criteria->compare('LOWER(no_kirimkantong)',strtolower($this->no_kirimkantong),true);
		$criteria->compare('ruangankirim_id',$this->ruangankirim_id);
		//$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('petugaskirim_id',$this->petugaskirim_id);
		/*$criteria->compare('ket_kirim',$this->ket_kirim,true);
		$criteria->compare('isterima',$this->isterima);
		$criteria->compare('waktukirim_mnt',$this->waktukirim_mnt);
		$criteria->compare('petugastransporter_id',$this->petugastransporter_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('suhu',$this->suhu);
        */
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = " t.*, rtujuan.ruangan_nama as ruangantujuan_nama ";
                $criteria->join = " JOIN ruangan_m  rtujuan ON rtujuan.ruangan_id = t.ruangantujuan_id ";
		$criteria->compare('kirimkantongdarah_id',$this->kirimkantongdarah_id);
		$criteria->compare('tglkirimkantongdarah',$this->tglkirimkantongdarah,true);
		$criteria->compare('no_kirimkantong',$this->no_kirimkantong,true);
		$criteria->compare('ruangankirim_id',$this->ruangankirim_id);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('petugaskirim_id',$this->petugaskirim_id);
		$criteria->compare('ket_kirim',$this->ket_kirim,true);
                $criteria->addCondition('isterima = false');
		$criteria->compare('waktukirim_mnt',$this->waktukirim_mnt);
		$criteria->compare('petugastransporter_id',$this->petugastransporter_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('suhu',$this->suhu);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'defaultOrder' => 'tglkirimkantongdarah DESC'
                            )
		));
	}
        
        /**
         * load data coolboxdarah_m, yang di transaksikan pada hari ini
         * @return type
         */
        public function getDropDownCoolBoxHariIni(){
            $hariini = date('Y-m-d');
            $cri = new CDbCriteria();
            $cri->join = " JOIN coolboxdarah_m cbd ON cbd.coolboxdarah_id = t.coolboxdarah_id ";
            $cri->select = " cbd.coolboxdarah_id, cbd.coolboxdarah_nama ";
            $cri->group = $cri->select;
            $cri->addCondition(" DATE(tgl_penggunaan_coolbox) = '".$hariini."' ");
            $getCoolBox = PenggunaanCoolboxT::model()->findAll($cri);
            
            return CHtml::listData($getCoolBox,'coolboxdarah_id', 'coolboxdarah_nama');
        }
}