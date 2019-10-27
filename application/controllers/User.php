<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() 
	{ 
		parent::__construct();
		$this->load->model("User_model", "", TRUE);
	}

	public function gen_table()
	{
		$query=$this->User_model->get_all();
		$res = $query->result();
		$num_rows = $query->num_rows();

		$tmpl = array(  'table_open'    => '<table class="table table-striped table-hover">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);

		$this->table->set_empty("&nbsp;");

		$this->table->set_heading('No', 'Password', 'Nama admin', 'Aksi');

		if ($num_rows > 0)
		{
			$i = 0;

			foreach ($res as $row){
				$this->table->add_row(	++$i,
							$row->password,
							$row->nama_admin,
							anchor('user/ubah/'.$row->username,'<span class="fa fa-pencil"></span>',array( 'title' => 'Ubah', 'class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip')).'&nbsp;'.
							anchor('user/hapus/'.$row->username,'<span class="fa fa-trash"></span>',array( 'title' => 'Hapus', 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip'))
						);
			}
		}
		return  $this->table->generate();
	}

	public function index()
	{
		$data = array(	
				'form' 	=> 'user/login',
				);
		$this->load->view('login_view', $data);
	}

	public function setting()
	{
		$data = array(	'page' 		=> 'user_view', 
				'link_add' 	=> anchor('user/tambah', 'Tambah Data', array('class' => 'btn btn-success',  )),
				'judul' 	=> 'User',
				'table'		=> $this->gen_table()
				);
		$this->load->view('index', $data);
	}

	public function login()
	{
		$inputan = array(
						'username' => $this->input->post('username'), 
						'password' => $this->input->post('pass'), 
						);
		if($this->User_model->login($inputan)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('dashboard');
		}else{
			$this->session->set_flashdata('msg_title', 'Login Gagal!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Username/password salah! ');
			redirect('user');
		}
	}

	public function logout()
	{
		$_SESSION[md5("User")] = '';
		unset($_SESSION[md5("User")]);
		redirect('user');
	}


	public function tambah()
	{
		$data = array(	'page' 		=> 'user_view', 
				'judul' 	=> 'Tambah User',
				'form'		=> 'user/add',
				);
		$this->load->view('index', $data);
	}

	public function add()
	{
		$inputan = array(
				'username' 	=> $this->input->post('username'),
				'password' 	=> $this->input->post('password'),
				'nama_admin' 	=> $this->input->post('nama_admin'),
				);

		if($this->User_model->add($inputan)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('user');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('user/tambah');
		}
	}

	public function ubah($v)
	{
		$data = array(	'page' 		=> 'user_view', 
				'judul' 	=> 'Ubah User',
				'form'		=> 'user/update',
				);

		$q = $this->User_model->get_data($v);
		$res = $q->result();
		foreach ($res as $row) {
			$data['username'] 	= $row->username;
			$data['password'] 	= $row->password;
			$data['nama_admin'] 	= $row->nama_admin;
		}

		$this->load->view('index', $data);
	}

	public function update()
	{
		$inputan = array(
				'password' 	=> $this->input->post('password'),
				'nama_admin' 	=> $this->input->post('nama_admin'),
				);

		if($this->User_model->update($inputan, $this->input->post('username'))){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('user');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('user/ubah/'.$this->input->post('username'));
		}
	}

	public function hapus($v='')
	{
		if($this->User_model->delete($v)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil dihapus! ');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal dihapus! ');
		}
		redirect('user');
	}
}

/* End of file User.php */
/* Location: ./application/controllers/User.php */