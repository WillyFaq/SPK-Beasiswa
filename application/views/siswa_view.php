<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Siswa</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> <?= $judul ?>
                <div class="pull-right">
                	<button class="btn btn-xs btn-success" id="btn_modal_import" data-toggle="tooltip" title="Import Excel">
                		<i class="fa fa-file-excel-o"></i>
                	</button>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
            	<?php if(isset($form)): ?>
            		<?= form_open($form, array("class" => "form-horizontal") );?>
						<div class="form-group">
							<label for="NIS" class="col-sm-2 control-label">NIS</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="NIS" name="NIS" <?= isset($NIS)?"value='".$NIS."' readonly":"required";?> placeholder="NIS" >
							</div>
						</div>
						<div class="form-group">
							<label for="NAMA_SISWA" class="col-sm-2 control-label">NAMA SISWA</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="NAMA_SISWA" name="NAMA_SISWA" value="<?= isset($NAMA_SISWA)?$NAMA_SISWA:"";?>" placeholder="NAMA SISWA" required>
							</div>
						</div>
						<div class="form-group">
							<label for="JENIS_KELAMIN" class="col-sm-2 control-label">JENIS KELAMIN</label>
							<div class="col-sm-10">
								<input type="radio" name="JENIS_KELAMIN" id="L" value="L" <?= isset($JENIS_KELAMIN) && $JENIS_KELAMIN=='L'?'checked':'checked' ?> required >&nbsp; <label for="L">Laki-laki</label> &nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="JENIS_KELAMIN" id="P" value="P" <?= isset($JENIS_KELAMIN) && $JENIS_KELAMIN=='P'?'checked':'' ?> required >&nbsp; <label for="P">Perempuan</label>
							</div>
						</div>
						<div class="form-group">
							<label for="ALAMAT" class="col-sm-2 control-label">ALAMAT</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="ALAMAT" name="ALAMAT" placeholder="ALAMAT" rows="10"><?= isset($ALAMAT)?$ALAMAT:"";?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="PEKERJAAN_ORANGTUA" class="col-sm-2 control-label">PEKERJAAN ORANG TUA</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="PEKERJAAN_ORANGTUA" name="PEKERJAAN_ORANGTUA" value="<?= isset($PEKERJAAN_ORANGTUA)?$PEKERJAAN_ORANGTUA:"";?>" placeholder="PEKERJAAN ORANGTUA" required>
							</div>
						</div>
						<div class="form-group">
							<label for="PENGHASILAN_ORANGTUA" class="col-sm-2 control-label">PENGHASILAN ORANG TUA</label>
							<div class="col-sm-10">
								<div class="input-group">
									<div class="input-group-addon">Rp.</div>
									<input type="number" class="form-control" id="PENGHASILAN_ORANGTUA" name="PENGHASILAN_ORANGTUA" min="0" value="<?= isset($PENGHASILAN_ORANGTUA)?$PENGHASILAN_ORANGTUA:"";?>" placeholder="PENGHASILAN ORANGTUA" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="JUMLAH_SAUDARA" class="col-sm-2 control-label">JUMLAH SAUDARA</label>
							<div class="col-sm-10">
								<input type="number" class="form-control" id="JUMLAH_SAUDARA" name="JUMLAH_SAUDARA" min="0" value="<?= isset($JUMLAH_SAUDARA)?$JUMLAH_SAUDARA:"";?>" placeholder="JUMLAH SAUDARA" required>
							</div>
						</div>
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
		        <h4 class="modal-title" id="myModalLabel">Import Data dari Excel</h4>
	      	</div>
	      	<div class="import_view">
	      		<div class="modal-body text-center">
					<img src="<?= base_url("assets/img/loading.gif"); ?>" alt="loading">
	      		</div>
	      	</div>
	    </div>
  	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
		$("#btn_modal_import").click(function(){
			$('#myModal').modal('show');
		});
		$('#myModal').on('shown.bs.modal', function () {
		  $('.import_view').load('<?= base_url("nilai/import_view"); ?>');
		});
		$('#myModal').on('hidden.bs.modal', function () {
			location.reload();
		});

		
    });
</script>