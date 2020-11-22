<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/dist/excanvas.min.js"></script><![endif]-->

<script language="javascript" type="text/javascript" src="<?= base_url(); ?>assets/js/dist/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/dist/jquery.jqplot.min.css" />

<!--End-Action boxes-->
<div class="conteudopainel">
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">

        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fas fa-signal"></i></span>
                <h5>Estatísticas do Sistema</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                        <ul class="site-stats">
                            <li class="bg_lh"><i class="fas fa-users"></i> <strong>
                                    <?= $this->db->count_all('clientes'); ?></strong> <small>Clientes</small></li>
    
                            <li class="bg_lh"><i class="fas fa-diagnoses"></i> <strong>
                                    <?= $this->db->count_all('os'); ?></strong> <small>Ordens de Serviço</small></li>

                            <li class="bg_lh"><i class="fas fa-wrench"></i> <strong>
                                    <?= $this->db->count_all('servicos'); ?></strong> <small>Serviços</small></li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<?php if ($os != null && $this->permission->checkPermission($this->session->userdata('permissao'), 'rOs')) { ?>
    <div class="row-fluid" style="margin-top: 0">

        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"><span class="icon"><i class="fas fa-diagnoses"></i></span>
                    <h5>Estatísticas de OS</h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span12">
                            <div id="chart-os" style=""></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if ($os != null && $this->permission->checkPermission($this->session->userdata('permissao'), 'rOs')) { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var data = [
                <?php foreach ($os as $o) {
                        echo "['" . $o->status . "', " . $o->total . "],";
                    } ?>

            ];
            var plot1 = jQuery.jqplot('chart-os', [data], {
                seriesDefaults: {
                    // Make this a pie chart.
                    renderer: jQuery.jqplot.PieRenderer,
                    rendererOptions: {
                        // Put data labels on the pie slices.
                        // By default, labels show the percentage of the slice.
                        showDataLabels: true
                    }
                },
                legend: {
                    show: true,
                    location: 'e'
                }
            });

        });
    </script>

<?php
} ?>


