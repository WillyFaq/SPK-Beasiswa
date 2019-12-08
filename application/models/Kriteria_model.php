<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria_model extends CI_Model {

	public function __construct() 
	{ 
		parent::__construct(); 
	} 

	var $table = 'kriteria';
	var $pk = 'ID_KRITERIA';

	public function get_all()
	{
		$this->db->order_by('ID_KRITERIA', 'asc');
		return $this->db->get($this->table);
	}

	public function get_data($id)
	{
		$this->db->where(array($this->pk => $id));
		return $this->db->get($this->table);
	}

	public function get_where($id)
	{
		$this->db->where($id);
		return $this->db->get($this->table);
	}

	public function add($da)
	{
		return $this->db->insert($this->table, $da);
	}

	public function update($data, $_id)
	{
		$this->db->set($data);
		$this->db->where($this->pk, $_id);
		return $this->db->update($this->table);
	}

	public function delete($id)
	{
		return $this->db->delete($this->table, array($this->pk => $id));
	}

	public function get_for_bobot()
	{
		$this->db->select("IFNULL(SUM(BOBOT), 0) as BOBOT");
		$this->db->from($this->table);
		$q = $this->db->get();
		$res = $q->result();
		$bobot = 0;
		foreach ($res as $row) {
			$bobot =  $row->BOBOT;
		}
		return 100 - $bobot;
	}


}