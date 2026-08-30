<?php

/**
 * This is the model class for table "penerimaandarahpmi_t".
 *
 * The followings are the available columns in table 'penerimaandarahpmi_t':
 * @property integer $penerimaandarahpmi_id
 * @property integer $permintaandarahpmi_id
 * @property integer $petugas_penerima_id
 * @property integer $petugas_mengetahui_id
 * @property string $tgl_penerimaan
 * @property string $no_penerimaan
 * @property string $keterangan_permintaan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.models
 */
class PenerimaandarahpmiT extends CActiveRecord
{
        public $petugas_penerima_nama, $petugasnama, $pengetahuinama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaandarahpmiT the static model class
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
		return 'penerimaandarahpmi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, petugas_penerima_id, create_ruangan', 'required'),
			array('permintaandarahpmi_id, petugas_penerima_id, petugas_mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('keterangan_penerimaan, tgl_penerimaan, no_penerimaan, keterangan_permintaan, update_time, is_detailpenerimaan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaandarahpmi_id, permintaandarahpmi_id, petugas_penerima_id, petugas_mengetahui_id, tgl_penerimaan, no_penerimaan, keterangan_permintaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_penerima_id'),
			'pengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_mengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaandarahpmi_id' => 'Penerimaandarahpmi',
			'permintaandarahpmi_id' => 'Permintaandarahpmi',
			'petugas_penerima_id' => 'Petugas Penerima',
			'petugas_mengetahui_id' => 'Petugas Mengetahui',
			'tgl_penerimaan' => 'Tgl. Penerimaan',
			'no_penerimaan' => 'No Penerimaan',
			'keterangan_permintaan' => 'Keterangan Permintaan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'petugasnama' => 'Petugas',
			'pengetahuinama' => 'Pengetahui',
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

		$criteria->compare('penerimaandarahpmi_id',$this->penerimaandarahpmi_id);
		$criteria->compare('permintaandarahpmi_id',$this->permintaandarahpmi_id);
		$criteria->compare('petugas_penerima_id',$this->petugas_penerima_id);
		$criteria->compare('petugas_mengetahui_id',$this->petugas_mengetahui_id);
		$criteria->compare('tgl_penerimaan',$this->tgl_penerimaan,true);
		$criteria->compare('no_penerimaan',$this->no_penerimaan,true);
		$criteria->compare('keterangan_permintaan',$this->keterangan_permintaan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * Menyimpan data penerimaan beserta detail dari data POST.
     * 
     * @param mixed $post Data Post
     * @return boolean Transaksi berhasil dilakukan.
     */
    public function savePenerimaanDarahPMI($post) {
        $ok = true;
        
        $this->attributes = $post['PenerimaandarahpmiT'];
        
        $this->tgl_penerimaan = MyFormatter::formatDateTimeForDB($this->tgl_penerimaan);
        $this->no_penerimaan = MyGenerator::noPenerimaanDarahPMI();
        
        $this->create_time = date('Y-m-d H:i:s');
        $this->create_loginpemakai_id = Yii::app()->user->id;
        $this->create_ruangan = Yii::app()->user->getState('ruangan_id');
        
        if (isset($post['PermintaandarahpmiT']['permintaandarahpmi_id']) && !empty($post['PermintaandarahpmiT']['permintaandarahpmi_id'])) {
            $this->permintaandarahpmi_id = $post['PermintaandarahpmiT']['permintaandarahpmi_id'];
        }
        
        if ($this->validate()) {
            $ok = $ok && $this->save();
            PermintaandarahpmiT::model()->updateByPk($this->permintaandarahpmi_id, array(
                'penerimaandarahpmi_id' => $this->penerimaandarahpmi_id
            ));
        } else {
            return false;
        }
        
        foreach ($post['detail'] as $item) {
            $modDetail = new PenerimaandarahpmidetT;
            $modDetail->attributes = $item;
            $modDetail->penerimaandarahpmi_id = $this->penerimaandarahpmi_id;
            
            $modDetail->golongandarah = trim($modDetail->golongandarah);
            $modDetail->rhesus = trim($modDetail->rhesus);
            
            $ok = $ok && $modDetail->save();
        }
            
        return $ok;
    }
}