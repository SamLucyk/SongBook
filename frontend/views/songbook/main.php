<?php $this->load->view('head'); ?>
<?php $this->load->view('songbook/sidenav'); ?>
<?php $this->load->view('header'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
<div class="col-md-12 center songbook-wrap padd-40-40">
    <h1><?php echo $userdata['name']; ?>'s Song Book</h1>
    <div class="padd-20">
        <h2>My Albums</h2>
        <div class="padd-20 col-md-12">
            <?php $this->load->view('songbook/albums'); ?>
        </div>
    </div>
    <div class="padd-40-20">
        <h2>My Songs</h2>
        <div class="col-md-12 padd-20">
            <?php $this->load->view('songbook/songs'); ?>
        </div>
    </div>
    
</div>


<?php $this->load->view('songbook/footer'); ?>
