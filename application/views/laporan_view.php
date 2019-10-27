<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Laporan</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> <?= $judul ?>
                <div class="pull-right">
                    <?= isset($btn_cetak)?$btn_cetak:'';?>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php if(isset($table_normal)): ?>
                    <hr>
                    <h3>Deskripsi</h3>
                    <hr>
                    <?= isset($table_desk)?$table_desk:'';?>
                    <hr>
                    <hr>
                    <h3>Nilai</h3>
                    <hr>
                    <?= isset($table)?$table:'';?>
                    <hr>
                	<h3>Normalisasi</h3>
                	<hr>
    				<?= isset($table_normal)?$table_normal:'';?>
                <?php else: ?>
                    <hr>
                    <h3>Rangking</h3>
                    <hr>
                    <?= isset($table)?$table:'';?>
                <?php endif; ?>
            </div>
            <!-- /.panel-body -->
            <iframe src="" id="iframe_cetak" width="0" height="0"></iframe>
        </div>
    </div>
</div>

<script type="text/javascript">
    function cetak(ini) {
        //alert(ini);
        var url = "<?= base_url('laporan/cetak_'); ?>"+ini;
        $("#iframe_cetak").attr('src', url);
    }
</script>