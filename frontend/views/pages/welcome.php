<?php $this->load->view('top'); ?>
        <div class="row col-md-12 padd-60-0">
            <div class="col-md-4 col-md-offset-2 center">
                <a href="<?php echo base_url('login') ?>"><input id="about-btn" class="button button-info" value="Login"></a>
            </div>
            <div class="col-md-4 center">
                <a href="<?php echo base_url('sign-up') ?>"> <input id="form-btn" class="button button-info" value="Sign-up"></a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>