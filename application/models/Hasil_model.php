<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_model extends CI_Model {

	public function __construct() 
	{ 
		parent::__construct(); 
	} 

	var $table = 'hasil';
	var $join = 'siswa';
	var $pk = 'ID_HASIL';
	var $fk = 'NIS';

	public function get_all()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->join, $this->table.'.'.$this->fk.' = '.$this->join.'.'.$this->fk);
		$this->db->order_by($this->table.'.TOTAL_NILAI', 'desc');
		return $this->db->get();
	}

	public function get_data($id)
	{
		$this->db->where(array($this->pk => $id));
		return $this->db->get($this->table);
	}

	public function get_kesimpulan()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->join, $this->table.'.'.$this->fk.' = '.$this->join.'.'.$this->fk);
		$this->db->order_by($this->table.'.TOTAL_NILAI', 'desc');
		$this->db->limit("1");
		return $this->db->get();
	}

	public function insert($da)
	{
		$this->db->where('NIS', $da['NIS']);
		$q = $this->db->get($this->table);
		if($q->num_rows()==0){
			return $this->db->insert($this->table, $da);
		}else{
			return $this->update($da, array("NIS" => $da['NIS']));
		}
	}

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

/* End of file Hasil_model.php */
/* Location: ./application/models/Hasil_model.php */