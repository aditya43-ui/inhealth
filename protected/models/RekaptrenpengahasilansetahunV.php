<?php

/**
 * This is the model class for table "rekaptrenpengahasilansetahun_v".
 *
 * The followings are the available columns in table 'rekaptrenpengahasilansetahun_v':
 * @property integer $pegawai_id
 * @property double $periodegaji
 * @property string $nomorindukpegawai
 * @property string $nama_pegawai
 * @property string $kategoripegawai
 * @property string $kategoripegawaiasal
 * @property string $namaunitkerja
 * @property integer $unitkerja_id
 * @property string $pendidikan_nama
 * @property integer $pendidikan_id
 * @property string $tglditerima
 * @property string $jabatan_nama
 * @property integer $jabatan_id
 * @property double $pph21perbulan
 * @property double $sumjumlah_gp
 * @property double $sumjumlah_tf
 * @property double $sumjumlah_tj
 * @property double $sumjumlah_tm
 * @property double $sumjumlah_tt
 * @property double $sumjumlah_jd
 * @property double $sumjumlah_gjd
 * @property double $sumjumlah_tbn
 * @property double $sumjumlah_tbk
 * @property double $sumjumlah_tp
 * @property double $sumjumlah_jht
 * @property double $sumjumlah_jkk
 * @property double $sumjumlah_jkm
 * @property double $sumjumlah_jp
 * @property double $sumjumlah_thr
 * @property double $sumjumlah_lmbr
 * @property double $sumjumlah_bns
 * @property double $sumjumlah_rg
 * @property double $sumjumlah_pm
 * @property double $sumjumlah_tntm
 * @property double $sumjumlah_gtf
 * @property double $sumjumlah_jsp
 * @property double $sumjumlah_ps
 * @property double $sumjumlah_tbksht
 * @property double $sumjumlah_tjht
 * @property double $sumjumlah_tjp
 * @property double $sumjumlah_ptjp
 * @property double $sumjumlah_ptjht
 * @property double $sumjumlah_ptbk
 * @property double $sumjumlah_hnr
 * @property double $sumjumlah_pjkk
 * @property double $sumjumlah_pjkm
 * @property double $sumjumlah_tk
 */
class RekaptrenpengahasilansetahunV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekaptrenpengahasilansetahunV the static model class
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
		return 'rekaptrenpengahasilansetahun_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, unitkerja_id, pendidikan_id, jabatan_id', 'numerical', 'integerOnly'=>true),
			array('periodegaji, pph21perbulan, sumjumlah_gp, sumjumlah_tf, sumjumlah_tj, sumjumlah_tm, sumjumlah_tt, sumjumlah_jd, sumjumlah_gjd, sumjumlah_tbn, sumjumlah_tbk, sumjumlah_tp, sumjumlah_jht, sumjumlah_jkk, sumjumlah_jkm, sumjumlah_jp, sumjumlah_thr, sumjumlah_lmbr, sumjumlah_bns, sumjumlah_rg, sumjumlah_pm, sumjumlah_tntm, sumjumlah_gtf, sumjumlah_jsp, sumjumlah_ps, sumjumlah_tbksht, sumjumlah_tjht, sumjumlah_tjp, sumjumlah_ptjp, sumjumlah_ptjht, sumjumlah_ptbk, sumjumlah_hnr, sumjumlah_pjkk, sumjumlah_pjkm, sumjumlah_tk', 'numerical'),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('nama_pegawai, kategoripegawaiasal, pendidikan_nama', 'length', 'max'=>50),
			array('kategoripegawai', 'length', 'max'=>128),
			array('namaunitkerja', 'length', 'max'=>200),
			array('jabatan_nama', 'length', 'max'=>100),
			array('tglditerima', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, periodegaji, nomorindukpegawai, nama_pegawai, kategoripegawai, kategoripegawaiasal, namaunitkerja, unitkerja_id, pendidikan_nama, pendidikan_id, tglditerima, jabatan_nama, jabatan_id, pph21perbulan, sumjumlah_gp, sumjumlah_tf, sumjumlah_tj, sumjumlah_tm, sumjumlah_tt, sumjumlah_jd, sumjumlah_gjd, sumjumlah_tbn, sumjumlah_tbk, sumjumlah_tp, sumjumlah_jht, sumjumlah_jkk, sumjumlah_jkm, sumjumlah_jp, sumjumlah_thr, sumjumlah_lmbr, sumjumlah_bns, sumjumlah_rg, sumjumlah_pm, sumjumlah_tntm, sumjumlah_gtf, sumjumlah_jsp, sumjumlah_ps, sumjumlah_tbksht, sumjumlah_tjht, sumjumlah_tjp, sumjumlah_ptjp, sumjumlah_ptjht, sumjumlah_ptbk, sumjumlah_hnr, sumjumlah_pjkk, sumjumlah_pjkm, sumjumlah_tk', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'periodegaji' => 'Periodegaji',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'kategoripegawai' => 'Kategoripegawai',
			'kategoripegawaiasal' => 'Kategoripegawaiasal',
			'namaunitkerja' => 'Namaunitkerja',
			'unitkerja_id' => 'Unitkerja',
			'pendidikan_nama' => 'Pendidikan Nama',
			'pendidikan_id' => 'Pendidikan',
			'tglditerima' => 'Tglditerima',
			'jabatan_nama' => 'Jabatan Nama',
			'jabatan_id' => 'Jabatan',
			'pph21perbulan' => 'Pph21perbulan',
			'sumjumlah_gp' => 'Sumjumlah Gp',
			'sumjumlah_tf' => 'Sumjumlah Tf',
			'sumjumlah_tj' => 'Sumjumlah Tj',
			'sumjumlah_tm' => 'Sumjumlah Tm',
			'sumjumlah_tt' => 'Sumjumlah Tt',
			'sumjumlah_jd' => 'Sumjumlah Jd',
			'sumjumlah_gjd' => 'Sumjumlah Gjd',
			'sumjumlah_tbn' => 'Sumjumlah Tbn',
			'sumjumlah_tbk' => 'Sumjumlah Tbk',
			'sumjumlah_tp' => 'Sumjumlah Tp',
			'sumjumlah_jht' => 'Sumjumlah Jht',
			'sumjumlah_jkk' => 'Sumjumlah Jkk',
			'sumjumlah_jkm' => 'Sumjumlah Jkm',
			'sumjumlah_jp' => 'Sumjumlah Jp',
			'sumjumlah_thr' => 'Sumjumlah Thr',
			'sumjumlah_lmbr' => 'Sumjumlah Lmbr', 
			'sumjumlah_bns' => 'Sumjumlah Bns',
			'sumjumlah_rg' => 'Sumjumlah Rg',
			'sumjumlah_pm' => 'Sumjumlah Pm',
			'sumjumlah_tntm' => 'Sumjumlah Tntm',
			'sumjumlah_gtf' => 'Sumjumlah Gtf',
			'sumjumlah_jsp' => 'Sumjumlah Jsp',
			'sumjumlah_ps' => 'Sumjumlah Ps',
			'sumjumlah_tbksht' => 'Sumjumlah Tbksht',
			'sumjumlah_tjht' => 'Sumjumlah Tjht',
			'sumjumlah_tjp' => 'Sumjumlah Tjp',
			'sumjumlah_ptjp' => 'Sumjumlah Ptjp',
			'sumjumlah_ptjht' => 'Sumjumlah Ptjht',
			'sumjumlah_ptbk' => 'Sumjumlah Ptbk',
			'sumjumlah_hnr' => 'Sumjumlah Hnr',
			'sumjumlah_pjkk' => 'Sumjumlah Pjkk',
			'sumjumlah_pjkm' => 'Sumjumlah Pjkm',
			'sumjumlah_tk' => 'Sumjumlah Tk',
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

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('periodegaji',$this->periodegaji);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('kategoripegawaiasal',$this->kategoripegawaiasal,true);
		$criteria->compare('namaunitkerja',$this->namaunitkerja,true);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('tglditerima',$this->tglditerima,true);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pph21perbulan',$this->pph21perbulan);
		$criteria->compare('sumjumlah_gp',$this->sumjumlah_gp);
		$criteria->compare('sumjumlah_tf',$this->sumjumlah_tf);
		$criteria->compare('sumjumlah_tj',$this->sumjumlah_tj);
		$criteria->compare('sumjumlah_tm',$this->sumjumlah_tm);
		$criteria->compare('sumjumlah_tt',$this->sumjumlah_tt);
		$criteria->compare('sumjumlah_jd',$this->sumjumlah_jd);
		$criteria->compare('sumjumlah_gjd',$this->sumjumlah_gjd);
		$criteria->compare('sumjumlah_tbn',$this->sumjumlah_tbn);
		$criteria->compare('sumjumlah_tbk',$this->sumjumlah_tbk);
		$criteria->compare('sumjumlah_tp',$this->sumjumlah_tp);
		$criteria->compare('sumjumlah_jht',$this->sumjumlah_jht);
		$criteria->compare('sumjumlah_jkk',$this->sumjumlah_jkk);
		$criteria->compare('sumjumlah_jkm',$this->sumjumlah_jkm);
		$criteria->compare('sumjumlah_jp',$this->sumjumlah_jp);
		$criteria->compare('sumjumlah_thr',$this->sumjumlah_thr);
		$criteria->compare('sumjumlah_lmbr',$this->sumjumlah_lmbr);
		$criteria->compare('sumjumlah_bns',$this->sumjumlah_bns);
		$criteria->compare('sumjumlah_rg',$this->sumjumlah_rg);
		$criteria->compare('sumjumlah_pm',$this->sumjumlah_pm);
		$criteria->compare('sumjumlah_tntm',$this->sumjumlah_tntm);
		$criteria->compare('sumjumlah_gtf',$this->sumjumlah_gtf);
		$criteria->compare('sumjumlah_jsp',$this->sumjumlah_jsp);
		$criteria->compare('sumjumlah_ps',$this->sumjumlah_ps);
		$criteria->compare('sumjumlah_tbksht',$this->sumjumlah_tbksht);
		$criteria->compare('sumjumlah_tjht',$this->sumjumlah_tjht);
		$criteria->compare('sumjumlah_tjp',$this->sumjumlah_tjp);
		$criteria->compare('sumjumlah_ptjp',$this->sumjumlah_ptjp);
		$criteria->compare('sumjumlah_ptjht',$this->sumjumlah_ptjht);
		$criteria->compare('sumjumlah_ptbk',$this->sumjumlah_ptbk);
		$criteria->compare('sumjumlah_hnr',$this->sumjumlah_hnr);
		$criteria->compare('sumjumlah_pjkk',$this->sumjumlah_pjkk);
		$criteria->compare('sumjumlah_pjkm',$this->sumjumlah_pjkm);
		$criteria->compare('sumjumlah_tk',$this->sumjumlah_tk);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}