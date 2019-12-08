<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

	public function __construct() 
	{ 
		parent::__construct();
		$this->load->model("Siswa_model", "", TRUE);
	}

	public function gen_table()
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
							anchor('siswa/ubah/'.$row->NIS,'<span class="fa fa-pencil"></span>',array( 'title' => 'Ubah', 'class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip')).'&nbsp;'.
							anchor('siswa/hapus/'.$row->NIS,'<span class="fa fa-trash"></span>',array( 'title' => 'Hapus', 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip'))
						);
			}
		}
		return  $this->table->generate();
	}

	public function index()
	{
		$data = array(	'page' 		=> 'siswa_view', 
				'link_add' 	=> anchor('siswa/tambah', 'Tambah Data', array('class' => 'btn btn-success',  )),
				'judul' 	=> 'Data Siswa',
				'table'		=> $this->gen_table()
				);
		$this->load->view('index', $data);
	}

	public function tambah()
	{
		$data = array(	'page' 		=> 'siswa_view', 
				'judul' 	=> 'Tambah Siswa',
				'form'		=> 'siswa/add',
				);
		$this->load->view('index', $data);
	}

	public function add()
	{
		$inputan = array(
				'NIS' 	=> $this->input->post('NIS'),
				'NAMA_SISWA' 	=> $this->input->post('NAMA_SISWA'),
				'JENIS_KELAMIN' 	=> $this->input->post('JENIS_KELAMIN'),
				'ALAMAT' 	=> $this->input->post('ALAMAT'),
				'PEKERJAAN_ORANGTUA' 	=> $this->input->post('PEKERJAAN_ORANGTUA'),
				'PENGHASILAN_ORANGTUA' 	=> $this->input->post('PENGHASILAN_ORANGTUA'),
				'JUMLAH_SAUDARA' 	=> $this->input->post('JUMLAH_SAUDARA'),
				);

		if($this->Siswa_model->add($inputan)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('siswa');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('siswa/tambah');
		}
	}

	public function ubah($v)
	{
		$data = array(	'page' 		=> 'siswa_view', 
				'judul' 	=> 'Ubah Siswa',
				'form'		=> 'siswa/update',
				);

		$q = $this->Siswa_model->get_data($v);
		$res = $q->result();
		foreach ($res as $row) {
			$data['NIS'] 	= $row->NIS;
			$data['NAMA_SISWA'] 	= $row->NAMA_SISWA;
			$data['JENIS_KELAMIN'] 	= $row->JENIS_KELAMIN;
			$data['ALAMAT'] 	= $row->ALAMAT;
			$data['PEKERJAAN_ORANGTUA'] 	= $row->PEKERJAAN_ORANGTUA;
			$data['PENGHASILAN_ORANGTUA'] 	= $row->PENGHASILAN_ORANGTUA;
			$data['JUMLAH_SAUDARA'] 	= $row->JUMLAH_SAUDARA;
		}

		$this->load->view('index', $data);
	}

	public function update()
	{
		$inputan = array(
				'NAMA_SISWA' 	=> $this->input->post('NAMA_SISWA'),
				'JENIS_KELAMIN' 	=> $this->input->post('JENIS_KELAMIN'),
				'ALAMAT' 	=> $this->input->post('ALAMAT'),
				'PEKERJAAN_ORANGTUA' 	=> $this->input->post('PEKERJAAN_ORANGTUA'),
				'PENGHASILAN_ORANGTUA' 	=> $this->input->post('PENGHASILAN_ORANGTUA'),
				'JUMLAH_SAUDARA' 	=> $this->input->post('JUMLAH_SAUDARA'),
				);

		if($this->Siswa_model->update($inputan, $this->input->post('NIS'))){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil disimpan! ');
			redirect('siswa');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal disimpan! ');
			redirect('siswa/ubah/'.$this->input->post('NIS'));
		}
	}

	public function hapus($v='')
	{
		if($this->Siswa_model->delete($v)){
			$this->session->set_flashdata('msg_title', 'Sukses!');
			$this->session->set_flashdata('msg_status', 'alert-success');
			$this->session->set_flashdata('msg', 'Data berhasil dihapus! ');
		}else{
			$this->session->set_flashdata('msg_title', 'Terjadi Kesalahan!');
			$this->session->set_flashdata('msg_status', 'alert-danger');
			$this->session->set_flashdata('msg', 'Data gagal dihapus! ');
		}
		redirect('siswa');
	}

	public function import_view()
	{
		return $this->load->view('import_view');
	}

	public function proses_import()
	{
		$fname = 'import_excel_'.date('dmY');
		$data['name'] = $fname;
		$upload = $this->upload_file($fname);
      	
	    if($upload['result'] == "success"){ // Jika proses upload sukses
	        // Load plugin PHPExcel nya
	        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
	        
	        $excelreader = new PHPExcel_Reader_Excel2007();
	        $loadexcel = $excelreader->load('assets/excel/'.$fname.'.xlsx'); // Load file yang tadi diupload ke folder excel
	        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
	        
	        // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
	        // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
	        $data['sheet'] = $sheet;
	        $data['dada'] = '';
	        foreach ($sheet as $key => $value) {
	        	if($key>=2){
		        	$input = array(
		        					"NIS" => $value['A'], 
		        					"NAMA_SISWA" => $value['B'], 
		        					"JENIS_KELAMIN" => $value['C'], 
		        					"ALAMAT" => $value['D'], 
		        					"PEKERJAAN_ORANGTUA" => $value['E'], 
		        					"PENGHASILAN_ORANGTUA" => $value['F'], 
		        					"JUMLAH_SAUDARA" => $value['G'], 
		        					);
		        	if($this->Siswa_model->add($input)){
		        		$data['dada'] .= $value['A']." Imported.\n";		
		        	}else{
		        		$data['dada'] .= $value['A']." Failed to Imported.\n";		
		        	}
	        	}
	        }
	    }else{ // Jika proses upload gagal
	        $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
	    }
      	echo json_encode($data);
	}


	public function upload_file($filename){
	    $this->load->library('upload'); // Load librari upload
	    
	    $config['upload_path'] = './assets/excel/';
	    $config['allowed_types'] = 'xlsx';
	    $config['max_size']  = '2048';
	    $config['overwrite'] = true;
	    $config['file_name'] = $filename;
	  
	    $this->upload->initialize($config); // Load konfigurasi uploadnya
	    if($this->upload->do_upload('upload_excel')){ // Lakukan upload dan Cek jika proses upload berhasil
	      // Jika berhasil :
	      $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
	      return $return;
	    }else{
	      // Jika gagal :
	      $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
	      return $return;
	    }
  	}

}