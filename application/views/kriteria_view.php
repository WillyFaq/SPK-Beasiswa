<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Kriteria</h1>
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
            		<?= form_open($form, array("class" => "form-horizontal"), array("ID_KRITERIA" => isset($ID_KRITERIA)?$ID_KRITERIA:'') );?>

						<div class="form-group">
							<label for="NAMA_KRITERIA" class="col-sm-2 control-label">NAMA KRITERIA</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="NAMA_KRITERIA" name="NAMA_KRITERIA" value="<?= isset($NAMA_KRITERIA)?$NAMA_KRITERIA:"";?>" placeholder="NAMA KRITERIA" required>
							</div>
						</div>
						<div class="form-group">
							<label for="ATRIBUT" class="col-sm-2 control-label">ATRIBUT</label>
							<div class="col-sm-10">
								<?php
									$opt = array('1'=>'Benefit', '2'=>'Cost');
									$js = 'class="form-control"';
									echo form_dropdown('ATRIBUT', $opt, isset($ATRIBUT)?$ATRIBUT:"", $js);
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="BOBOT" class="col-sm-2 control-label">BOBOT</label>
							<div class="col-sm-10">
								<input type="number" class="form-control" id="BOBOT" name="BOBOT" min="0" max="<?= $max_bobot; ?>" value="<?= isset($BOBOT)?$BOBOT:"";?>" placeholder="BOBOT" required>
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

