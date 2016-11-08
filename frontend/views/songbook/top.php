<?php $this->load->view('head'); ?>
<?php $this->load->view('songbook/sidenav'); ?>
<?php $this->load->view('header'); ?>
<?php $theme = $this->session->userdata('theme'); ?>
<div class="col-xs-12 center songbook-wrap padd-65-40" style="background:url('<?php echo base_url(); ?>img/banner.jpg') no-repeat left bottom; background-position-y:30%; background-attachment: fixed; background-size: cover; min-height:750px;">
    <div class="<?php echo $theme->class; ?> col-sm-10 col-sm-offset-1 col-xs-12 padd-20-0">