<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hitung extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Siswa_model", "", TRUE);
		$this->load->model("Kriteria_model", "", TRUE);
		$this->load->model("Range_nilai_model", "", TRUE);
		$this->load->model("Nilai_model", "", TRUE);
		$this->load->model("Hasil_model", "", TRUE);
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
				//echo $nrow->NAMA_KRITERIA." = ".$nrow->NILAI." ";
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
			array_push($head, str_replace(" ", "<br>", $rop->NAMA_KRITERIA).' <br>('.$rop->BOBOT.')'); 
		}

		$dada = [];
		foreach ($res as $row){
			$ini = array('NIS' => $row->NIS, 'NAMA' => $row->NAMA_SISWA);

			$nq = $this->Nilai_model->get_kriteria($row->NIS);
			$nres = $nq->result();
			$nil = [];
			foreach ($nres as $nrow) {
				array_push($nil, array('NILAI' => $nrow->NILAI, 'ATTR' => $nrow->ATRIBUT));

			}
			$ini['NILAI'] = $nil;
			//array_push($ini, array('NILAI' => $nil));
			array_push($dada, $ini);
		}
		$nilai = [];
		foreach ($dada as $key => $value) {
			foreach ($value['NILAI'] as $k => $v) {
				$nilai[$k]['ATTR'] = $v['ATTR'];
				$nilai[$k]['NIL'][$key] = $v['NILAI'];
			}
		}

		$data_normal = [];
		foreach ($res as $row){
			$ini = array($row->NIS,$row->NAMA_SISWA);

			$nq = $this->Nilai_model->get_kriteria($row->NIS);
			$nres = $nq->result();
			foreach ($nres as $k => $nrow) {
				$per = 0;
				if($nilai[$k]['ATTR']=='1'){
					$per = $nrow->NILAI / max($nilai[$k]['NIL']);
					array_push($ini, number_format($per,2));
				}else{
					$per = min($nilai[$k]['NIL']) / $nrow->NILAI;
					array_push($ini, number_format($per,2));
				}
				$input = array('NORMALISASI' => $per);
				$where = array('ID_RANGE' => $nrow->ID_RANGE, 'NIS' => $row->NIS);
				$this->Nilai_model->update($input, $where);
			}

			array_push($data_normal, $ini);
		}

		//$dada = [];
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
			foreach ($data_normal as $da){
				$this->table->add_row($da);
			}
		}
		return $this->table->generate();
	}

	public function gen_table_hasil()
	{
		$query=$this->Nilai_model->get_siswa();
		$res = $query->result();
		$num_rows = $query->num_rows();

		$dada = [];
		foreach ($res as $row){
			$ini = array('NIS' => $row->NIS, 'NAMA' => $row->NAMA_SISWA);

			$nq = $this->Nilai_model->get_kriteria($row->NIS);
			//echo $this->db->last_query();
			$nres = $nq->result();
			$nil = [];
			$hasil = 0;
			foreach ($nres as $nrow) {
				$a = $nrow->NORMALISASI*$nrow->BOBOT;
				$hasil += $a;
				/*$input = array('HASIL' => $a);
				$where = array('ID_RANGE' => $nrow->ID_RANGE, 'NIS' => $row->NIS);
				$this->Nilai_model->update($input, $where);*/
				array_push($nil, "($nrow->NORMALISASI x $nrow->BOBOT)");
			}
			$ini['NILAI'] = $hasil;
			$input = array('NIS' => $row->NIS, 'TOTAL_NILAI' => $hasil);
			$this->Hasil_model->insert($input);
			//array_push($dada, $ini);
			$dada[$row->NIS] =  join(" + ", $nil)." = ".$hasil;
		}

		//manual sorting
		/*$data_hasil = [];
		foreach ($dada as $k => $v) {
			if($k <= sizeof($dada)-2){
				if($v['NILAI'] > $dada[$k+1]['NILAI']){
					$tmp = $v;
					$dada[$k] = $dada[$k+1];
					$dada[$k+1] = $tmp; 
				}
			}
		}
		$rank = 1;
		$j=0;
		for($i = sizeof($dada)-1; $i>=0; $i--){
			$data_hasil[$j]['ranking'] = $rank;
			$data_hasil[$j]['NIS'] = $dada[$i]['NIS'];
			$data_hasil[$j]['NAMA'] = $dada[$i]['NAMA'];
			$data_hasil[$j]['NILAI'] = number_format($dada[$i]['NILAI'],2);

			$rank++;
			$j++;
		}*/
		//print_r($dada);
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

	public function index()
	{
		
		$data = array(	'page' 		=> 'hitung_view', 
				'judul' 	=> 'Perhitungan',
				'table'		=> $this->gen_table(),
				'table_normal'		=> $this->gen_table_normal(),
				'table_hasil'		=> $this->gen_table_hasil(),
				);
		$this->load->view('index', $data);
	}

}

/* End of file Hitung.php */
/* Location: ./application/controllers/Hitung.php */