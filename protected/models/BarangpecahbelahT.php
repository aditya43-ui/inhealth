<?php

/**
 * This is the model class for table "barangpecahbelah_t".
 *
 * The followings are the available columns in table 'barangpecahbelah_t':
 * @property integer $barangpecahbelah_id
 * @property integer $ruangan_id
 * @property string $barangpecahbelah_no
 * @property string $barangpecahbelah_tgl
 * @property string $keterangan
 * @property integer $pegmenerima_id
 * @property integer $pegmengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BarangpecahbelahdetT[] $barangpecahbelahdetTs
 * @property RuanganM $ruangan
 * @property PegawaiM $pegmenerima
 * @property PegawaiM $pegmengetahui
 */
class BarangpecahbelahT extends CActiveRecord
{
    public $instalasi_id;
    public $pegawaimenerima_nama, $pegawaimengetahui_nama;
    public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BarangpecahbelahT the static model class
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
		return 'barangpecahbelah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, barangpecahbelah_no, barangpecahbelah_tgl, pegmenerima_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, pegmenerima_id, pegmengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('barangpecahbelah_no', 'length', 'max'=>20),
			array('keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, barangpecahbelah_id, ruangan_id, barangpecahbelah_no, barangpecahbelah_tgl, keterangan, pegmenerima_id, pegmengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'barangpecahbelahdetTs' => array(self::HAS_MANY, 'BarangpecahbelahdetT', 'barangpecahbelah_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pegmenerima' => array(self::BELONGS_TO, 'PegawaiM', 'pegmenerima_id'),
			'pegmengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'barangpecahbelah_id' => 'Barangpecahbelah',
			'ruangan_id' => 'Ruangan',
			'barangpecahbelah_no' => 'No. Pencatatan',
			'barangpecahbelah_tgl' => 'Tgl. Pencatatan',
			'keterangan' => 'Keterangan',
			'pegmenerima_id' => 'Pegmenerima',
			'pegmengetahui_id' => 'Pegmengetahui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'instalasi_id' => 'Instalasi',
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

		$criteria->compare('t.barangpecahbelah_id',$this->barangpecahbelah_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('lower(t.barangpecahbelah_no)',strtolower($this->barangpecahbelah_no),true);
		$criteria->compare('t.barangpecahbelah_tgl',$this->barangpecahbelah_tgl,true);
		$criteria->compare('t.keterangan',$this->keterangan,true);
		$criteria->compare('t.pegmenerima_id',$this->pegmenerima_id);
		$criteria->compare('t.pegmengetahui_id',$this->pegmengetahui_id);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchInformasi() {
        $prov = $this->search();
        $prov->criteria->with = array('ruangan');
		$prov->criteria->compare('ruangan.instalasi_id',$this->instalasi_id);
        
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $prov->criteria->addBetweenCondition('t.barangpecahbelah_tgl', $this->tgl_awal, $this->tgl_akhir);
        }
        
        return $prov;
    }
}