<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); //print_r($userdata);?>
    <div class="transbox-b col-sm-8 col-sm-offset-2 col-xs-12">
        <h1><?php echo $userdata['name']; ?>'s Song Book</h1>
    </div>
    <div class="padd-20 col-xs-12">
        <h2>My Songs</h2>
        <div class="col-md-12">
            <?php $this->load->view('songbook/songs'); ?>
        </div>
    </div>
    <div class="padd-40-20 col-xs-12">
        <h2>My Albums</h2>
        <div class="col-md-12">
            <?php $this->load->view('songbook/albums'); ?>
        </div>
    </div>
    </div>
</div>
</div>
<?php $this->load->view('songbook/footer'); ?>