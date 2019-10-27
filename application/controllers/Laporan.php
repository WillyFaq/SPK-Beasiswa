<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Siswa_model", "", TRUE);
		$this->load->model("Kriteria_model", "", TRUE);
		$this->load->model("Range_nilai_model", "", TRUE);
		$this->load->model("Nilai_model", "", TRUE);
		$this->load->model("Hasil_model", "", TRUE);
	}

	public function index()
	{
		
	}

	public function gen_table(){
		$query=$this->Nilai_model->get_siswa();
		$res = $query->result();
		$num_rows = $query->num_rows();

		$kq = $this->Kriteria_model->get_all();
		$kres = $kq->result();
		$head = [];
		array_push($head, 'NIS'); 
		array_push($head, 'NAMA SISWA'); 
		foreach ($kres as $rop) {
			array_push($head, $rop->NAMA_KRITERIA); 
		}

		$dada = [];
		foreach ($res as $row){
			$ini = array($row->NIS,$row->NAMA_SISWA);

			$nq = $this->Nilai_model->get_kriteria($row->NIS);
			$nres = $nq->result();
			foreach ($nres as $nrow) {
				array_push($ini, $nrow->NILAI);
			}
			array_push($dada, $ini);
		}

		$tmpl = array(  'table_open'    => '<table class="table table-bordered table-striped table-hover">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading($head);
		if ($num_rows > 0)
		{
			$i = 0;
			foreach ($dada as $da){
				$this->table->add_row($da);
			}
		}
		return $this->table->generate();
	}



	public function gen_table_desk(){
		$query=$this->Nilai_model->get_siswa();
		$res = $query->result();
		$num_rows = $query->num_rows();

		$kq = $this->Kriteria_model->get_all();
		$kres = $kq->result();
		$head = [];
		array_push($head, 'NIS'); 
		array_push($head, 'NAMA SISWA'); 
		foreach ($kres as $rop) {
			array_push($head, $rop->NAMA_KRITERIA); 
		}

		$dada = [];
		foreach ($res as $row){
			$ini = array($row->NIS,$row->NAMA_SISWA);

			$nq = $this->Nilai_model->get_kriteria($row->NIS);
			$nres = $nq->result();
			foreach ($nres as $nrow) {
				array_push($ini, $nrow->KETERANGAN);
			}
			array_push($dada, $ini);
		}

		$tmpl = array(  'table_open'    => '<table class="table table-bordered table-striped table-hover">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading($head);
		if ($num_rows > 0)
		{
			$i = 0;
			foreach ($dada as $da){
				$this->table->add_row($da);
			}
		}
		return $this->table->generate();
	}

	public function gen_table_normal(){
		$query=$this->Nilai_model->get_siswa();
		$res = $query->result();
		$num_rows = $query->num_rows();

		$kq = $this->Kriteria_model->get_all();
		$kres = $kq->result();
		$head = [];
		array_push($head, 'NIS'); 
		array_push($head, 'NAMA SISWA'); 
		foreach ($kres as $rop) {
			array_push($head, str_replace(" ", "<br>", $rop->NAMA_KRITERIA).' <br>('.$rop->BOBOT.'%)'); 
		}

		$dada = [];
		foreach ($res as $row){
			$ini = array('NIS' => $row->NIS, 'NAMA' => $row->NAMA_SISWA);

			$nq = $this->Nilai_model->get_kriteria($row->NIS);
			$nres = $nq->result();
			$nil = [];
			foreach ($nres as $nrow) {
				array_push($ini, number_format($nrow->NORMALISASI, 2));

			}
			//$ini['NILAI'] = $nil;
			//array_push($ini, array('NILAI' => $nil));
			array_push($dada, $ini);
		}

		$tmpl = array(  'table_open'    => '<table class="table table-bordered table-striped table-hover">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading($head);
		if ($num_rows > 0)
		{
			$i = 0;
			foreach ($dada as $da){
				$this->table->add_row($da);
			}
		}
		return $this->table->generate();
	}


	public function gen_table_hasil()
	{
		$query = $this->Hasil_model->get_all();
		$res = $query->result();
		$num_rows = $query->num_rows();

		$tmpl = array(  'table_open'    => '<table class="table table-bordered table-striped table-hover">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading("Rangking", "NIS", "NAMA", "TOTAL NILAI");
		if ($num_rows > 0)
		{
			$i = 0;
			foreach ($res as $row) {
				$this->table->add_row(
										++$i,
										$row->NIS,
										$row->NAMA_SISWA,
										number_format($row->TOTAL_NILAI,2)
										);
			}
		}
		return $this->table->generate();
	}

	public function hitung()
	{
		
		$data = array(	'page' 		=> 'laporan_view', 
				'judul' 			=> 'Laporan Perhitungan',
				'btn_cetak'			=> '<button class="btn btn-xs btn-success" title="cetak" data-toggle="tooltip" onclick="cetak(\'hitung\')"><i class="fa fa-print"></i></button>',
				'table'				=> $this->gen_table(),
				'table_normal'		=> $this->gen_table_normal(),
				'table_desk'		=> $this->gen_table_desk()
				);
		$this->load->view('index', $data);
	}

	public function cetak_hitung()
	{
		$data = array(	'page' 		=> 'laporan_view', 
				'judul' 	=> 'Laporan Perhitungan',
				'table'		=> $this->gen_table(),
				'table_normal'		=> $this->gen_table_normal(),
				'table_desk'		=> $this->gen_table_desk()
				);
		$this->load->view('laporan_cetak_view', $data);
	}

	public function rangking()
	{
		
		$data = array(	'page' 		=> 'laporan_view', 
				'judul' 	=> 'Laporan Rangking',
				'btn_cetak'			=> '<button class="btn btn-xs btn-success" title="cetak" data-toggle="tooltip" onclick="cetak(\'rangking\')"><i class="fa fa-print"></i></button>',
				'table'		=> $this->gen_table_hasil()
				);
		$this->load->view('index', $data);
	}

	public function cetak_rangking()
	{
		$data = array(	'page' 		=> 'laporan_view', 
				'judul' 	=> 'Laporan Rangking',
				'table'		=> $this->gen_table_hasil()
				);
		$this->load->view('laporan_cetak_view', $data);
	}

}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */