<?php $this->load->view('head'); ?>
<?php $this->load->view('songbook/sidenav'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
<div class="col-md-12 center songbook-wrap">
    <h1><?php echo $userdata['name']; ?>'s Song Book</h1>
    <h2>My Albums</h2>
    <?php $this->load->view('songbook/albums'); ?>
</div>


<?php $this->load->view('songbook/footer'); ?>
