<?php $this->load->view('top'); ?>
        <div class="row col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12 padd-40-0">
            <form id="login-form" action="<?php echo base_url('auth/login'); ?>" method="post">
                <div class="login-box padd-20 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
                    <div class="form-group">
                        Email
                        <input type="text" class="form-control" name="email" style="color:#bfbfbf; font-variant: none;" 
                    value="Email" onfocus="inputFocus(this)" onblur="inputBlur(this)">
                    </div>
                    <div class="form-group">
                        Password
                        <input type="password" class="form-control" id='pass' name="pass" style="color:#bfbfbf; font-variant: none;" onfocus="inputFocus(this)" onblur="inputBlur(this)">
                    </div>
                </div>
                <div class="col-xs-4 col-xs-offset-4 center padd-20">
                    <input type="submit" id="form-btn" class="button button-info" value="Log-in">
                </div>
            </form>
        </div>
        
    </div>
</div>
<script type="text/javascript">
    var button = document.getElementById('login-button');
    button.classList = 'active';
</script>
<?php $this->load->view('footer'); ?>