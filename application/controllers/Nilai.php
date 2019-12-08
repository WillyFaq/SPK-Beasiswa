<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Siswa_model", "", TRUE);
		$this->load->model("Kriteria_model", "", TRUE);
		$this->load->model("Range_nilai_model", "", TRUE);
		$this->load->model("Nilai_model", "", TRUE);
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
		array_push($head, 'AKSI'); 

		$dada = [];
		foreach ($res as $row){
			$ini = array($row->NIS,$row->NAMA_SISWA);

			$nq = $this->Nilai_model->get_kriteria($row->NIS);
			$nres = $nq->result();
			foreach ($nres as $nrow) {
				array_push($ini, $nrow->KETERANGAN);
			}
			array_push($ini, anchor('nilai/ubah/'.$row->NIS,'<span class="fa fa-pencil"></span>',array( 'title' => 'Ubah', 'class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip')) );

			array_push($dada, $ini);
		}

		$tmpl = array(  'table_open'    => '<table class="table table-striped table-hover dataTable">',
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

	public function index()
	{
		
		$data = array(	'page' 		=> 'nilai_view', 
				'link_add' 	=> anchor('nilai/tambah', 'Tambah Data', array('class' => 'btn btn-success',  )),
				'judul' 	=> 'Data Penilaian',
				'table'		=> $this->gen_table()
				);
		$this->load->view('index', $data);
	}

	public function gen_table_siswa()
	{
		$query=$this->Siswa_model->get_all();
		$res = $query->result();
		$num_rows = $query->num_rows();

		$tmpl = array(  'table_open'    => '<table class="table table-striped table-hover dataTable">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('NIS', 'NAMA SISWA', 'JENIS KELAMIN', 'ALAMAT', 'PEKERJAAN ORANGTUA', 'PENGHASILAN ORANGTUA', 'JUMLAH SAUDARA', 'Aksi');
		if ($num_rows > 0)
		{
			$i = 0;
			foreach ($res as $row){
				$this->table->add_row(	//++$i,
							$row->NIS,
							$row->NAMA_SISWA,
							$row->JENIS_KELAMIN=='L'?'Laki-laki':'Perempuan',
							$row->ALAMAT,
							$row->PEKERJAAN_ORANGTUA,
							'Rp. '.number_format($row->PENGHASILAN_ORANGTUA),
							$row->JUMLAH_SAUDARA,
							'<button onclick="pilih_nis(\''.$row->NIS.'\')" type="button" title="Pilih" class="btn btn-success btn-xs" data-toggle="tooltip"><span class="fa fa-plus"></span></button>'
						);
			}
		}
		echo  $this->table->generate();
	}

	public function load_siswa($nis='')
	{

		$query=$this->Siswa_model->get_data($nis);
		$res = $query->result();
		if($query->num_rows() > 0){
			$ret = "";
			foreach ($res as $row) {
				foreach ($row as $k => $v) {
					if($k!="NIS"){

						$ret .= '<div class="form-group">';
						$ret .= '<label for="'.$k.'" class="col-sm-2 control-label">'.str_replace("_", " ", $k).'</label>';
						$ret .= '<div class="col-sm-10" style="padding-top: 7px;">';
						if($k=='JENIS_KELAMIN'){
							$ret .= '<p>'.($v=="L")?'Laki-laki':'Perempuan'.'</p>';
						}else if($k == 'PENGHASILAN_ORANGTUA'){
							$ret .= '<p>Rp. '.number_format($v).'</p>';
							$ret .= '<input type="hidden" name="kriteria[5]" value="'.$this->penghasilan_ortu($v).'">';
						}else if($k == 'JUMLAH_SAUDARA'){
							$ret .= '<p>'.$v.'</p>';
							$ret .= '<input type="hidden" name="kriteria[6]" value="'.$this->jumlah_saudara($v).'">';
						}else{
							$ret .= '<p>'.$v.'</p>';
						}
						$ret .= '</div>';
						$ret .= '</div>';
					}
				}
			}
			echo $ret;
		}else{
			echo "NIS Siswa tidak ada!";
		}
	}

	public function var_load_siswa($nis='')
	{

		$query=$this->Siswa_model->get_data($nis);
		$res = $query->result();
		if($query->num_rows() > 0){
			$ret = "";
			foreach ($res as $row) {
				foreach ($row as $k => $v) {
					if($k!="NIS"){

						$ret .= '<div class="form-group">';
						$ret .= '<label for="'.$k.'" class="col-sm-2 control-label">'.str_replace("_", " ", $k).'</label>';
						$ret .= '<div class="col-sm-10" style="padding-top: 7px;">';
						if($k=='JENIS_KELAMIN'){
							$ret .= '<p>'.($v=="L")?'Laki-laki':'Perempuan'.'</p>';
						}else if($k == 'PENGHASILAN_ORANGTUA'){
							$ret .= '<p>Rp. '.number_format($v).'</p>';
							$ret .= '<input type="hidden" name="kriteria[5]" value="'.$this->penghasilan_ortu($v).'">';
							$ret .= '<input type="hidden" name="kri[5]" value="'.$this->penghasilan_ortu($v).'">';
						}else if($k == 'JUMLAH_SAUDARA'){
							$ret .= '<p>'.$v.'</p>';
							$ret .= '<input type="hidden" name="kriteria[6]" value="'.$this->jumlah_saudara($v).'">';
							$ret .= '<input type="hidden" name="kri[6]" value="'.$this->jumlah_saudara($v).'">';
						}else{
							$ret .= '<p>'.$v.'</p>';
						}
						$ret .= '</div>';
						$ret .= '</div>';
					}
				}
			}
			return $ret;
		}else{
			return "NIS Siswa tidak ada!";
		}
	}

	public function penghasilan_ortu($v='')
	{
		$q = $this->Range_nilai_model->get_bykriteria(5);
		$res = $q->result();
		foreach ($res as $row) {
			//echo $row->KETERANGAN."<br>";

			if(strpos($row->KETERANGAN, 'Lebih dari') !== false){
				$a = explode(" ", $row->KETERANGAN);
				$ak = str_replace(",", "", $a[3]);
				if($v > (int)$ak){
					return $row->ID_RANGE;
				}
			}else if(strpos($row->KETERANGAN, 'Kurang dari') !== false){
				$a = explode(" ", $row->KETERANGAN);
				$ak = str_replace(",", "", $a[3]);
				if($v < (int)$ak){
					return $row->ID_RANGE;
				}
			}else{
				$a = explode(" ", $row->KETERANGAN);
				//print_r($a);
				$aw = str_replace(",", "", $a[1]);
				$ak = str_replace(",", "", $a[3]);

				if($v >= (int)$aw && $v <= (int)$ak){
					return $row->ID_RANGE;
				}
			}
		}
	}

	public function jumlah_saudara($v='')
	{
		$q = $this->Range_nilai_model->get_bykriteria(6);
		$res = $q->result();
		foreach ($res as $row) {

			if(strpos($row->KETERANGAN, 'Lebih dari') !== false){
				$a = explode(" ", $row->KETERANGAN);
				$ak = $a[2];
				if($v > (int)$ak){
					return $row->ID_RANGE;
				}
			}else {
				if($v == (int)$row->KETERANGAN){
					return $row->ID_RANGE;
				}
			}
		}
	}

	public function tambah()
	{
		$data = array(	
				'page' 		=> 'nilai_view', 
				'judul' 	=> 'Tambah Penilaian',
				'form'		=> 'nilai/add',
				);
		$this->load->view('index', $data);
	}

	public function add()
	{
		//print_r($this->input->post());
		$ins = [];
		foreach ($this->input->post('kriteria') as $key => $value) {
			$inputan = array('ID_RANGE' => $value, 'NIS' => $this->input->post('NIS'));
			echo $value.'<br>';
			array_push($ins, $this->Nilai_model->add($inputan));
		}

		if(!in_array(false, $ins)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('nilai');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('nilai/tambah');
		}
		/*$inputan = array(
				'ID_RANGE' 	=> $this->input->post('ID_RANGE'),
				'NIS' 	=> $this->input->post('NIS')
				);*/
	}



	public function ubah($nis)
	{
		$data = array(	
				'page' 		=> 'nilai_view', 
				'judul' 	=> 'Ubah Penilaian',
				'form'		=> 'nilai/update',
				);

		$q = $this->Nilai_model->get_where(array('NIS' => $nis));
		$res = $q->result();
		foreach ($res as $row) {
			$data['NIS'] = $row->NIS;
			$data['load_siswa'] = $this->var_load_siswa($row->NIS);
			$data['K'.$row->ID_KRITERIA] = $row->ID_RANGE;
		}
		$this->load->view('index', $data);
	}

	public function update()
	{
		$ins = [];
		$kri = $this->input->post('kri');
		
		foreach ($this->input->post('kriteria') as $key => $value) {
			$inputan = array('ID_RANGE' => $value, 'NIS' => $this->input->post('NIS'));
			$where = array('ID_RANGE' => $kri[$key], 'NIS' => $this->input->post('NIS'));
			//echo $value.'<br>';
			print_r($inputan);
			//print_r($where);
			$nis = $this->input->post('NIS');
			echo "UPDATE nilai SET ID_RANGE = $value, NIS = $nis WHERE ID_RANGE = $kri[$key] AND NIS = $nis";
			echo '<hr>';
			array_push($ins, $this->Nilai_model->update($inputan, $where));
			//echo $this->db->last_query().'<br>';
		}

		if(!in_array(false, $ins)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('nilai');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('nilai/tambah');
		}
	}

}

/* End of file Nilai.php */
/* Location: ./application/controllers/Nilai.php */