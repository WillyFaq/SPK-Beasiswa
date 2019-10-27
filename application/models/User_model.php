<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct() 
	{ 
		parent::__construct(); 
	} 

	var $table = 'admin';
	var $pk = 'username';

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

	public function login($dada)
	{
		$this->db->where($dada);
		$q = $this->db->get($this->table);
		if($q->num_rows()>0){;
			$res = $q->result();
			foreach ($res as $row) {
				$_SESSION[md5("User")] = $row->username;
				$_SESSION[md5("nama")] = $row->nama_admin;
			}
			return true;
		}else{;
			return false;
		}
	}
}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */