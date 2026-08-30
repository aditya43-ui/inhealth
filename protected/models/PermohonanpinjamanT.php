<?php

/**
 * This is the model class for table "permohonanpinjaman_t".
 *
 * The followings are the available columns in table 'permohonanpinjaman_t':
 * @property integer $permohonanpinjaman_id
 * @property integer $keanggotaan_id
 * @property integer $approval_id
 * @property string $jenispinjaman_permohonan
 * @property string $tglpermohonanpinjaman
 * @property string $nopermohonan
 * @property double $jmlpinjaman
 * @property integer $jangkawaktu_pinj_bln
 * @property double $jasapinjaman_bln
 * @property string $untukkeperluan
 * @property double $jmlgaji
 * @property double $jmlinsentif
 * @property double $jmlsimpanan
 * @property double $jmlpenghasilanlain
 * @property double $jmltunggakanuangpinj
 * @property double $jmltunggakanbrgpinj
 * @property double $batasplafon
 * @property integer $petugas_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property ApprovalT $approval
 * @property KeanggotaanT $keanggotaan
 * @property PinjamanT[] $pinjamanTs
 */
class PermohonanpinjamanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermohonanpinjamanT the static model class
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
		return 'permohonanpinjaman_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keanggotaan_id, jenispinjaman_permohonan, tglpermohonanpinjaman, nopermohonan, jmlpinjaman, jangkawaktu_pinj_bln, jasapinjaman_bln, untukkeperluan, batasplafon, petugas_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('keanggotaan_id, approval_id, jangkawaktu_pinj_bln, petugas_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmlpinjaman, jasapinjaman_bln, jmlgaji, jmlinsentif, jmlsimpanan, jmlpenghasilanlain, jmltunggakanuangpinj, jmltunggakanbrgpinj, batasplafon', 'numerical'),
			array('jenispinjaman_permohonan, nopermohonan', 'length', 'max'=>50),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permohonanpinjaman_id, keanggotaan_id, approval_id, jenispinjaman_permohonan, tglpermohonanpinjaman, nopermohonan, jmlpinjaman, jangkawaktu_pinj_bln, jasapinjaman_bln, untukkeperluan, jmlgaji, jmlinsentif, jmlsimpanan, jmlpenghasilanlain, jmltunggakanuangpinj, jmltunggakanbrgpinj, batasplafon, petugas_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'approval' => array(self::BELONGS_TO, 'ApprovalT', 'approval_id'),
			'keanggotaan' => array(self::BELONGS_TO, 'KeanggotaanT', 'keanggotaan_id'),
			'pinjamanTs' => array(self::HAS_MANY, 'PinjamanT', 'permohonanpinjaman_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permohonanpinjaman_id' => 'Permohonanpinjaman',
			'keanggotaan_id' => 'Keanggotaan',
			'approval_id' => 'Approval',
			'jenispinjaman_permohonan' => 'Jenis Pinjaman',
			'tglpermohonanpinjaman' => 'Tanggal Permohonan',
			'nopermohonan' => 'Nopermohonan',
			'jmlpinjaman' => 'Jmlpinjaman',
			'jangkawaktu_pinj_bln' => 'Jangkawaktu Pinj Bln',
			'jasapinjaman_bln' => 'Jasa Pinjam',
			'untukkeperluan' => 'Untukkeperluan',
			'jmlgaji' => 'Jml Gaji',
			'jmlinsentif' => 'Jml Insentif',
			'jmlsimpanan' => 'Jml Simpanan',
			'jmlpenghasilanlain' => 'Jml Penghasilan Lain',
			'jmltunggakanuangpinj' => 'Jmltunggakanuangpinj',
			'jmltunggakanbrgpinj' => 'Jmltunggakanbrgpinj',
			'batasplafon' => 'Batasplafon',
			'petugas_id' => 'Petugas',
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

		$criteria->compare('permohonanpinjaman_id',$this->permohonanpinjaman_id);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('approval_id',$this->approval_id);
		$criteria->compare('jenispinjaman_permohonan',$this->jenispinjaman_permohonan,true);
		$criteria->compare('tglpermohonanpinjaman',$this->tglpermohonanpinjaman,true);
		$criteria->compare('nopermohonan',$this->nopermohonan,true);
		$criteria->compare('jmlpinjaman',$this->jmlpinjaman);
		$criteria->compare('jangkawaktu_pinj_bln',$this->jangkawaktu_pinj_bln);
		$criteria->compare('jasapinjaman_bln',$this->jasapinjaman_bln);
		$criteria->compare('untukkeperluan',$this->untukkeperluan,true);
		$criteria->compare('jmlgaji',$this->jmlgaji);
		$criteria->compare('jmlinsentif',$this->jmlinsentif);
		$criteria->compare('jmlsimpanan',$this->jmlsimpanan);
		$criteria->compare('jmlpenghasilanlain',$this->jmlpenghasilanlain);
		$criteria->compare('jmltunggakanuangpinj',$this->jmltunggakanuangpinj);
		$criteria->compare('jmltunggakanbrgpinj',$this->jmltunggakanbrgpinj);
		$criteria->compare('batasplafon',$this->batasplafon);
		$criteria->compare('petugas_id',$this->petugas_id);
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