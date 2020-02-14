<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Perhitungan</h1>
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
            	<hr>
            	<h3>Nilai</h3>
            	<hr>
				<?= isset($table)?$table:'';?>
            	<hr>
            	<h3>Normalisasi</h3>
            	<hr>
				<?= isset($table_normal)?$table_normal:'';?>
            	<hr>
            	<h3>Hasil</h3>
            	<hr>
                <?= isset($table_hasil)?$table_hasil:'';?>
				
                <?= isset($kesimpulan)?$kesimpulan:'';?>

            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>