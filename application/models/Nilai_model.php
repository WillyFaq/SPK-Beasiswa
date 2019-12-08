<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_model extends CI_Model {

	public function __construct() 
	{ 
		parent::__construct(); 
	} 

	var $table = 'nilai';
	var $pk = 'NIS';

	public function get_all()
	{
		return $this->db->get($this->table);
	}

	public function get_data($id)
	{
		$this->db->where(array($this->pk => $id));
		return $this->db->get($this->table);
	}

	public function get_where($id)
	{
		$this->db->select('*');
		$this->db->from('nilai a');
		$this->db->join('range_nilai b', 'a.ID_RANGE = b.ID_RANGE');
		$this->db->join('kriteria c', 'b.ID_KRITERIA = c.ID_KRITERIA');
		$this->db->where($id);
		return $this->db->get();
	}

	//=============================================================================================

	public function get_siswa()
	{
		$this->db->select('a.NIS, d.NAMA_SISWA');
		$this->db->from('nilai a');
		$this->db->join('siswa d', 'a.NIS = d.NIS');
		$this->db->group_by('a.NIS');
		return $this->db->get();
	}

	public function get_kriteria($nis='')
	{
		$this->db->select('b.KETERANGAN, a.ID_RANGE, c.NAMA_KRITERIA, c.ATRIBUT, c.BOBOT, b.NILAI, a.NORMALISASI');
		$this->db->from('nilai a');
		$this->db->join('range_nilai b', 'a.ID_RANGE = b.ID_RANGE');
		$this->db->join('kriteria c', 'b.ID_KRITERIA = c.ID_KRITERIA');
		$this->db->order_by('c.ID_KRITERIA', 'asc');
		$this->db->where('a.NIS', $nis);
		return $this->db->get();
	}

	//=============================================================================================

	public function add($da)
	{
		return $this->db->insert($this->table, $da);
	}

	public function update($data, $_id)
	{
		$this->db->set($data);
		$this->db->where($_id);
		return $this->db->update($this->table);
	}

	public function delete($id)
	{
		return $this->db->delete($this->table, array($this->pk => $id));
	}


}