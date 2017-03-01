<?php $this->load->view('head'); ?>
<?php if ($this->session->userdata('user_data')['is_logged_in']){
    $this->load->view('songbook/sidenav');
}?>
<?php $this->load->view('header'); ?>
<?php $theme = $this->session->userdata('theme'); ?>
<?php if(!isset($theme)){ 
    $theme = new stdClass;
    $theme->class = 'transbox-b';
    $scheme = new stdClass;
    $scheme->name = 'Grey';
}
?>
<div class="col-xs-12 center songbook-wrap padd-65-40" style="background:url('<?php echo base_url(); ?>img/banner.jpg') no-repeat left bottom; background-position-y:30%; background-attachment: fixed; background-size: cover; min-height:750px; padding-left:3%">
    <div class="<?php echo $theme->class; ?>  col-xs-12 padd-20-0" style="width:97%">
        <script>
            <?php $scheme = $this->session->userdata('scheme'); ?>
            var elem = document.getElementById("main-container");  
            elem.style.setProperty('--light', '<?php echo constant($scheme->name . 'light'); ?>' );
            elem.style.setProperty('--light-alt', '<?php echo constant($scheme->name . 'lightalt'); ?>');
            elem.style.setProperty('--dark', '<?php echo constant($scheme->name . 'dark'); ?>');
            elem.style.setProperty('--dark-alt', '<?php echo constant($scheme->name . 'darkalt'); ?>');
        </script>