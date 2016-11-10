<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); //print_r($userdata);?>
    <div class="transbox-b col-sm-8 col-sm-offset-2 col-xs-12">
        <?php if(isset($user->songbook_name) && !empty($user->songbook_name)){ ?>
        <h1><?php echo $user->songbook_name; ?></h1>
        <?php } else { ?>
        <h1><?php echo $userdata['name']; ?>'s Song Book</h1>
        <?php } ?>
    </div>
    <div class="padd-20-0 col-xs-12">
        <div class="col-md-12">
            <?php $this->load->view('songbook/albums'); ?>
        </div>
    </div>
    <div class="padd-0-20 col-xs-12">
        <div class="col-md-12">
            <?php $this->load->view('songbook/songs'); ?>
        </div>
    </div>
    </div>
</div>
</div>
<script>
setActive('home');
</script>
<?php $this->load->view('songbook/footer'); ?>