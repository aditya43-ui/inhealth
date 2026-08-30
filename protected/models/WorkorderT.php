<?php

/**
 * This is the model class for table "workorder_t".
 *
 * The followings are the available columns in table 'workorder_t':
 * @property integer $workorder_id
 * @property integer $invperalatan_id
 * @property string $workorder_tgl
 * @property string $workorder_no
 * @property integer $wo_supplier_id
 * @property integer $wo_pegawai_id
 * @property integer $wo_ruangan_id
 * @property string $tglpemeliharaan
 * @property string $tglpemeliharaan_selesai
 * @property integer $pj_pemeliharaan_id
 * @property string $jenisteknisi
 * @property integer $teknisiperalatan_id
 * @property integer $teknisiint_id
 * @property string $ket_pemeliharaan
 * @property string $status_pemeliharaan
 * @property integer $kontrakpemeliharaan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TeknisiperalatanM $teknisiperalatan
 * @property InvperalatanT $invperalatan
 */
class WorkorderT extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $pj_pemeliharaan_nama;
        public $nip;
        public $jabatan_nama;
        public $unitkerja;         
        public $pj_jabatan_nama;
        public $pj_unitkerja_nama;
        public $pj_nip;
        public $jenisperalatan;
        public $nomoraset;
        public $teknisiint_nama;
        public $teknisiperalatan_nama;
        public $isinternal;
        public $kondisi_barang;
        public $pegawai_id;
        public $pegawai_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WorkorderT the static model class
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
		return 'workorder_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invperalatan_id, workorder_tgl, workorder_no, wo_pegawai_id, wo_ruangan_id, jenisteknisi, status_pemeliharaan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('invperalatan_id, wo_supplier_id, wo_pegawai_id, wo_ruangan_id, pj_pemeliharaan_id, teknisiperalatan_id, teknisiint_id, kontrakpemeliharaan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('workorder_no', 'length', 'max'=>100),
			array('jenisteknisi', 'length', 'max'=>20),
			array('status_pemeliharaan', 'length', 'max'=>50),
			array('isinternal, prevmainten_id, tglpemeliharaan, tglpemeliharaan_selesai, ket_pemeliharaan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invperalatan_id, workorder_tgl, workorder_no, wo_supplier_id, wo_pegawai_id, wo_ruangan_id, tglpemeliharaan, tglpemeliharaan_selesai, pj_pemeliharaan_id, jenisteknisi, teknisiperalatan_id, teknisiint_id, ket_pemeliharaan, status_pemeliharaan, kontrakpemeliharaan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'teknisiperalatan' => array(self::BELONGS_TO, 'TeknisiperalatanM', 'teknisiperalatan_id'),
                        'teknisiint' => array(self::BELONGS_TO, 'PegawaiM', 'teknisiint_id'),
			'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'workorder_id' => 'Workorder',
			'invperalatan_id' => 'Invperalatan',
			'workorder_tgl' => 'Workorder Tgl',
			'workorder_no' => 'Workorder No',
			'wo_supplier_id' => 'Wo Supplier',
			'wo_pegawai_id' => 'Wo Pegawai',
			'wo_ruangan_id' => 'Wo Ruangan',
			'tglpemeliharaan' => 'Tglpemeliharaan',
			'tglpemeliharaan_selesai' => 'Tglpemeliharaan Selesai',
			'pj_pemeliharaan_id' => 'Pj Pemeliharaan',
			'jenisteknisi' => 'Jenisteknisi',
			'teknisiperalatan_id' => 'Teknisiperalatan',
			'teknisiint_id' => 'Teknisiint',
			'ket_pemeliharaan' => 'Ket Pemeliharaan',
			'status_pemeliharaan' => 'Status Pemeliharaan',
			'kontrakpemeliharaan_id' => 'Kontrakpemeliharaan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('workorder_id',$this->workorder_id);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('workorder_tgl',$this->workorder_tgl,true);
		$criteria->compare('workorder_no',$this->workorder_no,true);
		$criteria->compare('wo_supplier_id',$this->wo_supplier_id);
		$criteria->compare('wo_pegawai_id',$this->wo_pegawai_id);
		$criteria->compare('wo_ruangan_id',$this->wo_ruangan_id);
		$criteria->compare('tglpemeliharaan',$this->tglpemeliharaan,true);
		$criteria->compare('tglpemeliharaan_selesai',$this->tglpemeliharaan_selesai,true);
		$criteria->compare('pj_pemeliharaan_id',$this->pj_pemeliharaan_id);
		$criteria->compare('jenisteknisi',$this->jenisteknisi,true);
		$criteria->compare('teknisiperalatan_id',$this->teknisiperalatan_id);
		$criteria->compare('teknisiint_id',$this->teknisiint_id);
		$criteria->compare('ket_pemeliharaan',$this->ket_pemeliharaan,true);
		$criteria->compare('status_pemeliharaan',$this->status_pemeliharaan,true);
		$criteria->compare('kontrakpemeliharaan_id',$this->kontrakpemeliharaan_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}