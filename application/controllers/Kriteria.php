<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {

	public function __construct() 
	{ 
		parent::__construct();
		$this->load->model("Kriteria_model", "", TRUE);
	}

	public function gen_table()
	{
		$query=$this->Kriteria_model->get_all();
		$res = $query->result();
		$num_rows = $query->num_rows();

		$tmpl = array(  'table_open'    => '<table class="table table-striped table-hover dataTable">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);

		$this->table->set_empty("&nbsp;");

		$this->table->set_heading('No', 'NAMA KRITERIA', 'ATRIBUT', 'BOBOT', 'Aksi');

		if ($num_rows > 0)
		{
			$i = 0;

			foreach ($res as $row){
				$this->table->add_row(	++$i,
							$row->NAMA_KRITERIA,
							$row->ATRIBUT==1?'<span class="label label-success">Benefit</span>':'<span class="label label-danger">Cost</span>',
							$row->BOBOT,
							anchor('kriteria/ubah/'.$row->ID_KRITERIA,'<span class="fa fa-pencil"></span>',array( 'title' => 'Ubah', 'class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip')).'&nbsp;'.
							anchor('kriteria/hapus/'.$row->ID_KRITERIA,'<span class="fa fa-trash"></span>',array( 'title' => 'Hapus', 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip'))
						);
			}
		}
		return  $this->table->generate();
	}

	public function index()
	{
		$data = array(	'page' 		=> 'kriteria_view', 
				'link_add' 	=> anchor('kriteria/tambah', 'Tambah Data', array('class' => 'btn btn-success',  )),
				'judul' 	=> 'Data Kriteria',
				'table'		=> $this->gen_table()
				);
		$this->load->view('index', $data);
	}

	public function tambah()
	{
		$data = array(	'page' 		=> 'kriteria_view', 
				'judul' 	=> 'Tambah Kriteria',
				'form'		=> 'kriteria/add',
				'max_bobot' => $this->Kriteria_model->get_for_bobot(),
				);
		$this->load->view('index', $data);
	}

	public function add()
	{
		$inputan = array(
				'ID_KRITERIA' 	=> $this->input->post('ID_KRITERIA'),
				'NAMA_KRITERIA' 	=> $this->input->post('NAMA_KRITERIA'),
				'ATRIBUT' 	=> $this->input->post('ATRIBUT'),
				'BOBOT' 	=> $this->input->post('BOBOT'),
				);

		if($this->Kriteria_model->add($inputan)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('kriteria');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('kriteria/tambah');
		}
	}

	public function ubah($v)
	{
		$data = array(	'page' 		=> 'kriteria_view', 
				'judul' 	=> 'Ubah Kriteria',
				'form'		=> 'kriteria/update',
				'max_bobot' => $this->Kriteria_model->get_for_bobot(),
				);

		$q = $this->Kriteria_model->get_data($v);
		$res = $q->result();
		foreach ($res as $row) {
			$data['ID_KRITERIA'] 	= $row->ID_KRITERIA;
			$data['NAMA_KRITERIA'] 	= $row->NAMA_KRITERIA;
			$data['ATRIBUT'] 	= $row->ATRIBUT;
			$data['BOBOT'] 	= $row->BOBOT;
		}

		$this->load->view('index', $data);
	}

	public function update()
	{
		$inputan = array(
				'NAMA_KRITERIA' 	=> $this->input->post('NAMA_KRITERIA'),
				'ATRIBUT' 	=> $this->input->post('ATRIBUT'),
				'BOBOT' 	=> $this->input->post('BOBOT'),
				);

		if($this->Kriteria_model->update($inputan, $this->input->post('ID_KRITERIA'))){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('kriteria');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('kriteria/ubah/'.$this->input->post('ID_KRITERIA'));
		}
	}

	public function hapus($v='')
	{
		if($this->Kriteria_model->delete($v)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil dihapus! ');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal dihapus! ');
		}
		redirect('kriteria');
	}


}