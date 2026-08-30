<?php

/**
 * This is the model class for table "unitdosisdetail_t".
 *
 * The followings are the available columns in table 'unitdosisdetail_t':
 * @property integer $unitdosisdetail_id
 * @property integer $unitdosis_id
 * @property integer $satuankecil_id
 * @property integer $racikan_id
 * @property integer $sumberdana_id
 * @property integer $obatalkes_id
 * @property string $r
 * @property integer $rke
 * @property string $signa
 * @property integer $jmlhari
 * @property double $jmlobat
 * @property string $tglinsmulai
 * @property string $jaminsmulai
 * @property string $tglinsstop
 * @property string $jaminsstop
 * @property string $etiket
 * @property double $harganetto
 * @property double $hargasatuan
 * @property double $hargajual
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class UnitdosisdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UnitdosisdetailT the static model class
	 */
        public $dosis1,$dosis2,$obatalkesNama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'unitdosisdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unitdosis_id, jmlhari, jmlobat, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('unitdosis_id, satuankecil_id, racikan_id, sumberdana_id, obatalkes_id, rke, jmlhari, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmlobat, harganetto, hargasatuan, hargajual', 'numerical'),
			array('r', 'length', 'max'=>2),
			array('signa', 'length', 'max'=>30),
			array('etiket', 'length', 'max'=>100),
                    
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                    
			array('tglinsmulai, jaminsmulai, tglinsstop, jaminsstop, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('unitdosisdetail_id, unitdosis_id, satuankecil_id, racikan_id, sumberdana_id, obatalkes_id, r, rke, signa, jmlhari, jmlobat, tglinsmulai, jaminsmulai, tglinsstop, jaminsstop, etiket, harganetto, hargasatuan, hargajual, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'unitdosisdetail_id' => 'Unit Dosis Detail',
			'unitdosis_id' => 'Unit Dosis',
			'satuankecil_id' => 'Satuan Kecil',
			'racikan_id' => 'Racikan',
			'sumberdana_id' => 'Sumber Dana',
			'obatalkes_id' => 'Obat Alkes',
			'r' => 'R',
			'rke' => 'Rke',
			'signa' => 'Signa',
			'jmlhari' => 'Jml Hari',
			'jmlobat' => 'Jml Obat',
			'tglinsmulai' => 'Tanggal Ins Mulai',
			'jaminsmulai' => 'Jam Ins Mulai',
			'tglinsstop' => 'Tanggal Ins Stop',
			'jaminsstop' => 'Jam Ins Stop',
			'etiket' => 'Etiket',
			'harganetto' => 'Harga Netto',
			'hargasatuan' => 'Harga Satuan',
			'hargajual' => 'Harga Jual',
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

		$criteria->compare('unitdosisdetail_id',$this->unitdosisdetail_id);
		$criteria->compare('unitdosis_id',$this->unitdosis_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('LOWER(signa)',strtolower($this->signa),true);
		$criteria->compare('jmlhari',$this->jmlhari);
		$criteria->compare('jmlobat',$this->jmlobat);
		$criteria->compare('LOWER(tglinsmulai)',strtolower($this->tglinsmulai),true);
		$criteria->compare('LOWER(jaminsmulai)',strtolower($this->jaminsmulai),true);
		$criteria->compare('LOWER(tglinsstop)',strtolower($this->tglinsstop),true);
		$criteria->compare('LOWER(jaminsstop)',strtolower($this->jaminsstop),true);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('unitdosisdetail_id',$this->unitdosisdetail_id);
		$criteria->compare('unitdosis_id',$this->unitdosis_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('LOWER(signa)',strtolower($this->signa),true);
		$criteria->compare('jmlhari',$this->jmlhari);
		$criteria->compare('jmlobat',$this->jmlobat);
		$criteria->compare('LOWER(tglinsmulai)',strtolower($this->tglinsmulai),true);
		$criteria->compare('LOWER(jaminsmulai)',strtolower($this->jaminsmulai),true);
		$criteria->compare('LOWER(tglinsstop)',strtolower($this->tglinsstop),true);
		$criteria->compare('LOWER(jaminsstop)',strtolower($this->jaminsstop),true);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}