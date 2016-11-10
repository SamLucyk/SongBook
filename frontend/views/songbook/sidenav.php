<nav class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
    </div>
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li id='home_navbar' class="active">
                <a href="<?php echo site_url('songbook') ?>">
                    Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li id='create_navbar' class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Create 
                    <span class="caret"></span>
                    <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-plus"></span>
                </a>
                <ul class="dropdown-menu forAnimate" role="menu">
                    <li><a href="<?php echo site_url('songbook/newsong') ?>">New Song</a></li>
                    <li><a href="<?php echo site_url('songbook/newalbum') ?>">New Album</a></li>
                </ul>
            </li>    
            <li id='song_navbar' class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    My Songs 
                    <span class="caret"></span>
                    <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-music"></span>
                </a>
                <ul class="dropdown-menu forAnimate" role="menu">
                    <?php foreach($songs as $song){?>
                    <li><a href="<?php echo site_url('songbook/song/v/'.$song->ID) ?>"><?php echo $song->name; ?></a></li>
                    <?php } ?>
                </ul>
            </li>    
            <li id='album_navbar' class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    My Albums 
                    <span class="caret"></span>
                    <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-record"></span>
                </a>
                <ul class="dropdown-menu forAnimate" role="menu">
                    <?php foreach($albums as $album){?>
                    <li><a href="<?php echo site_url('songbook/album/v/'.$album->ID) ?>"><?php echo $album->name; ?></a></li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    </div>
  </div>
    <script>
        function setActive(active){
            clearActive();
            id = '#' + active + '_navbar';
            $(id).addClass('active');
        }

        function clearActive(){
            $('#home_navbar').removeClass('active');
            $('#song_navbar').removeClass('active');
            $('#album_navbar').removeClass('active');
            $('#create_navbar').removeClass('active');
            console.log('unset active');
        }
    </script>
</nav>
