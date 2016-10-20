<?php $this->load->view('header', array('menu_style' => 'dark')); ?>

    <div class="main-wraper padd-100">
        <div class="container">

            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <div class="second-title">
                        <h4 class="subtitle color-dr-blue-2 underline">NOTIFICATION</h4>
                        <h2>OOPS! THERE WAS AN ERROR</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

                    <div class="second-description text-center">
                        <?php if( isset($message) ): ?>
                            <?php echo $message; ?><br/>
                        <?php endif; ?>
                        We couldn't perform your request right now. Please try again or contact us for support.
                    </div>

                    <p class="text-center">
                        <a href="<?php echo site_url('contact/support'); ?>" class="c-button bg-blue">Contact support</a>
                    </p>

                    <p class="text-center"><img src="<?php echo base_url(); ?>/img/icon.min.png" alt="LocalAventura" /></p>

                    <div class="second-description content-body text-center ">
                        Go back to <a href="<?php echo site_url(); ?>">homepage</a>.
                    </div>

                </div>
            </div>

        </div>
    </div>

<?php $this->load->view('footer'); ?>
