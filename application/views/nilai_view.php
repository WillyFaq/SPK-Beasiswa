<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Penilaian</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> <?= $judul ?>
                <div class="pull-right">
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
            	<?php if(isset($form)): ?>
            		<?= form_open($form, array("class" => "form-horizontal") );?>
						<div class="form-group">
							<label for="NIS" class="col-sm-2 control-label">NIS</label>
							<div class="col-sm-10">
								<div class="input-group">
									<input type="text" class="form-control" id="NIS" name="NIS" <?= isset($NIS)?"value='".$NIS."' readonly":"required";?> placeholder="NIS" >
									<span class="input-group-addon btn btn-success" id="btn_modal_nis">
										<i class="fa fa-search"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="load_siswa">
							<?= isset($load_siswa)?$load_siswa:''; ?>
						</div>
						<hr>
						
						<?php

							$q = $this->Kriteria_model->get_all();
							$res = $q->result();
							foreach ($res as $row):
								if($row->NAMA_KRITERIA != 'Pendapatan Orang Tua' && $row->NAMA_KRITERIA != 'Tanggungan Orang Tua'):
						?>
						<div class="form-group">
							<label for="<?= $row->NAMA_KRITERIA?>" class="col-sm-2 control-label"><?= $row->NAMA_KRITERIA?></label>
							<div class="col-sm-10">
								<?php
									$r = $this->Range_nilai_model->get_bykriteria($row->ID_KRITERIA);
									$rres = $r->result();
									$opt = array();
									foreach ($rres as $rrow) {
										$opt[$rrow->ID_RANGE] = $rrow->KETERANGAN;
									}
									$js = 'class="form-control"';
									$val = isset(${'K'.$row->ID_KRITERIA})?${'K'.$row->ID_KRITERIA}:'';
									echo form_dropdown('kriteria['.$row->ID_KRITERIA.']', $opt, 
														$val, 
														$js);
									echo '<input type="hidden" name="kri['.$row->ID_KRITERIA.']" value="'.$val.'"> ';
								?>
							</div>
						</div>
						<?php endif; endforeach; ?>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-success">Simpan</button>
							</div>
						</div>
					</form>

            	<?php else: ?>
                	<?= isset($link_add)?$link_add:'';?>
                	<br><br>
					<?= isset($table)?$table:'';?>
            	<?php endif; ?>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>

<?php 
	$msg = $this->session->flashdata("msg");
	$msg_status = $this->session->flashdata("msg_status");
	$msg_title = $this->session->flashdata("msg_title");
	if(isset($msg)): 
?>
	<div class="alert <?= $msg_status; ?> alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 id="omg-error-txt"><?= $msg_title; ?><a class="anchorjs-link" href="#omg-error-txt"><span class="anchorjs-icon"></span></a></h4>
		<p><?php echo $msg; ?></p>
	</div>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Data Siswa</h4>
	      	</div>
	      	<div class="modal-body import_view">
	      		<div class="text-center">
					<img src="<?= base_url("assets/img/loading.gif"); ?>" alt="loading">
	      		</div>
	      	</div>
	    </div>
  	</div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
		$("#btn_modal_nis").click(function(){
			$('#myModal').modal('show');
		});
		$('#myModal').on('shown.bs.modal', function () {
		 	$('.import_view').load('<?= base_url("nilai/gen_table_siswa"); ?>', function(){
            	$('.dataTable').DataTable();
		 	});
		});
		$('#myModal').on('hidden.bs.modal', function () {
			//location.reload();
		});

		$("#NIS").keyup(function(){
			var val = $(this).val();
			load_siswa(val);
		});
		
    });

    function pilih_nis(nis) {
    	$('#myModal').modal('hide');
    	$("#NIS").val(nis);
    	load_siswa(nis);
    }

    function load_siswa (nis) {
		$(".load_siswa").load('<?= base_url("nilai/load_siswa"); ?>/'+nis);
    }
</script>