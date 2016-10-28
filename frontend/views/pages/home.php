<?php $userdata = $this->session->userdata('user_data'); ?>
<?php $this->load->view('top'); ?>
        <div class="row col-md-12">
            <div class="col-md-4 col-md-offset-4 center">
                <div class="padd-35-0">
                    <h2 class='white'>You Are Logged In As <?php echo $userdata['name'] ?></h2>
                </div>
                <div class="padd-20-0 col-md-4 col-md-offset-2 center">
                    <a href="<?php echo base_url('songbook') ?>"><input id="about-btn" class="button button-info" value="Enter Song Book"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>