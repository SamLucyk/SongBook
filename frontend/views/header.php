<?php $userdata = $this->session->userdata('user_data'); ?>
<div id="main-container">
<form class="navbar-form" role="search">
    <a class="navbar-brand navbar-left" href="<?php echo base_url('songbook')?>">
        <img alt="Home" src="<?php echo base_url('img/logo-alt.min.png')?>">
    </a>
    <ul class="nav navbar-right nav-pills">
        <?php if( isset($userdata['is_logged_in']) && $userdata['is_logged_in'] == true ){ ?>
            <li class="nav-pill" id='logout-button' role="presentation"><a href="<?php echo site_url('auth?logout=true'); ?>">Logout</a></li>
            <li class="nav-pill" id='profile-button' role="presentation"><a href="<?php echo base_url('profile')?>"><?php echo $userdata['name']?></a></li>
        <?php } else { ?>
            <li class="nav-pill" id='login-button' role="presentation"><a href="<?php echo base_url('login')?>">Login</a></li>
            <li class="nav-pill" id='signup-button' role="presentation"><a href="<?php echo base_url('sign-up')?>">Sign-up</a></li>
        <?php } ?>
    </ul>
</form>


