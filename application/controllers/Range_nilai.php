<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Range_nilai extends CI_Controller {

	public function __construct() 
	{ 
		parent::__construct();
		$this->load->model("Range_nilai_model", "", TRUE);
		$this->load->model("Kriteria_model", "", TRUE);
	}

	public function gen_table()
	{
		$query=$this->Range_nilai_model->get_all();
		$res = $query->result();
		$num_rows = $query->num_rows();

		$tmpl = array(  'table_open'    => '<table class="table table-striped table-hover dataTable">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'KRITERIA', 'KETERANGAN', 'NILAI', 'Aksi');
		if ($num_rows > 0)
		{
			$i = 0;
			foreach ($res as $row){
				$this->table->add_row(	++$i,
							$row->NAMA_KRITERIA,
							$row->KETERANGAN,
							$row->NILAI,
							anchor('range_nilai/ubah/'.$row->ID_RANGE,'<span class="fa fa-pencil"></span>',array( 'title' => 'Ubah', 'class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip')).'&nbsp;'.
							anchor('range_nilai/hapus/'.$row->ID_RANGE,'<span class="fa fa-trash"></span>',array( 'title' => 'Hapus', 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip'))
						);
			}
		}
		return  $this->table->generate();
	}

	public function index()
	{
		$data = array(	'page' 		=> 'range_nilai_view', 
				'link_add' 	=> anchor('range_nilai/tambah', 'Tambah Data', array('class' => 'btn btn-success',  )),
				'judul' 	=> 'Data Range Nilai',
				'table'		=> $this->gen_table()
				);
		$this->load->view('index', $data);
	}

	public function combo_kriteria($sel)
	{
		$ret = '<div class="form-group"><label for="jenis" class="col-sm-2 control-label">KRITERIA</label><div class="col-sm-10">';
    	$query=$this->Kriteria_model->get_all();
    	$res = $query->result();
    	$opt = array();
		foreach ($res as $row) {
			//echo $row->type;
			$opt[$row->ID_KRITERIA] = $row->NAMA_KRITERIA;
		}
		$js = 'class="form-control"';
		$ret= $ret.''.form_dropdown('ID_KRITERIA',$opt,$sel,$js);
		$ret= $ret.'</div></div>';
		return $ret;
	}

	public function tambah()
	{
		$data = array(	'page' 		=> 'range_nilai_view', 
				'judul' 	=> 'Tambah Range Nilai',
				'form'		=> 'range_nilai/add',
				'cb_kriteria'	=> $this->combo_kriteria("")
				);
		$this->load->view('index', $data);
	}

	public function add()
	{
		$inputan = array(
				'ID_RANGE' 	=> $this->input->post('ID_RANGE'),
				'ID_KRITERIA' 	=> $this->input->post('ID_KRITERIA'),
				'KETERANGAN' 	=> $this->input->post('KETERANGAN'),
				'NILAI' 	=> $this->input->post('NILAI'),
				);

		if($this->Range_nilai_model->add($inputan)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('range_nilai');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('range_nilai/tambah');
		}
	}

	public function ubah($v)
	{
		$data = array(	'page' 		=> 'range_nilai_view', 
				'judul' 	=> 'Ubah Range Nilai',
				'form'		=> 'range_nilai/update',
				);

		$q = $this->Range_nilai_model->get_data($v);
		$res = $q->result();
		foreach ($res as $row) {
			$data['ID_RANGE'] 	= $row->ID_RANGE;
			$data['ID_KRITERIA'] 	= $row->ID_KRITERIA;
			$data['KETERANGAN'] 	= $row->KETERANGAN;
			$data['NILAI'] 	= $row->NILAI;
			$data['cb_kriteria']	= $this->combo_kriteria($row->ID_KRITERIA);
		}
		

		$this->load->view('index', $data);
	}

	public function update()
	{
		$inputan = array(
				'ID_KRITERIA' 	=> $this->input->post('ID_KRITERIA'),
				'KETERANGAN' 	=> $this->input->post('KETERANGAN'),
				'NILAI' 	=> $this->input->post('NILAI'),
				);

		if($this->Range_nilai_model->update($inputan, $this->input->post('ID_RANGE'))){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('range_nilai');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('range_nilai/ubah/'.$this->input->post('ID_RANGE'));
		}
	}

	public function hapus($v='')
	{
		if($this->Range_nilai_model->delete($v)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil dihapus! ');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal dihapus! ');
		}
		redirect('range_nilai');
	}


}