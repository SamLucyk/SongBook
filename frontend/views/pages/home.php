<?php $userdata = $this->session->userdata('user_data'); ?>
<?php $this->load->view('top'); ?>
        <div class="row col-xs-12">
            <div class="padd-20-0 col-xs-4 col-md-offset-4 center">
                <div class="transbox-b-dark padd-10">
                    <h2 class='white'>You Are Logged In As <?php echo $userdata['name'] ?></h2>
                </div>
                <div class="padd-20-0 col-xs-12 center">
                    <a href="<?php echo base_url('songbook') ?>"><input id="about-btn" class="button button-info" value="Enter Song Book"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>