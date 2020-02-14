<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">User</h1>
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
							<label for="USERNAME" class="col-sm-2 control-label">USERNAME</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="USERNAME" name="username" <?= isset($username)?"value='".$username."' readonly":"required";?> placeholder="USERNAME" >
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-sm-2 control-label">PASSWORD</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="password" name="password" value="<?= isset($password)?$password:"";?>" placeholder="PASSWORD" required>
							</div>
						</div>
						<div class="form-group">
							<label for="nama_admin" class="col-sm-2 control-label">NAMA ADMIN</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="nama_admin" name="nama_admin" value="<?= isset($nama_admin)?$nama_admin:"";?>" placeholder="NAMA ADMIN" required>
							</div>
						</div>
						<?= isset($cbjabatan)?$cbjabatan:''; ?>
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
