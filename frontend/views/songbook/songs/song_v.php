<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    <span class="page-label">Song</span>
     <div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 padd-0-20">
        <div class='under_shadow'>
        <div class="song_album_pic col-xs-12" style="background-image:url(<?php echo $song->album->pic->src; ?>)"></div>
        </div>
            <div class="playlist">
            <audio class="under_shadow" style="width:100%" id="audio" controls>
                <source src="" type="audio/mp3">
            </audio>
            <a onclick="mediaActive('audio')" class="col-xs-6 no-padd"><div id="audio-button" class="center media-label media-label-active padd-5">Audio</div></a>
            <a onclick="mediaActive('video')" class="col-xs-6 no-padd"><div id="video-button" class="media-label padd-5 center ">Video</div></a>
            <ul id="playlist" class="col-xs-12 inner_layer">
                <div class="audio_options">
                    
                <?php if(isset($audios) && !empty($audios)){ 
                    $x = 1;                                 
                    foreach($audios as $audio){ ?>
                        <li class="" id="<?php echo 'audio_'.$x ?>">
                            <a href="<?php echo $audio->src; ?>">
                                <?php echo $audio->name; ?>
                            </a>
                        </li>
                <?php $x++;
                    } 
                }?>
                </div>
                <div class="video_options" style='display:none'>
                <?php if(isset($videos) && !empty($video)){ 
                    $x = 1;                                 
                    foreach($videos as $video){ ?>
                        <li class="" id="<?php echo 'video_'.$x ?>">
                            <a href="<?php echo $video->src; ?>">
                                <?php echo $video->name; ?>
                            </a>
                        </li>
                <?php $x++;
                    }
                }?>
                </div>
            </ul>
         </div>
    </div>
    <div class="transbox-b-dark col-sm-8 col-xs-12">
        <h1><?php echo $song->name;?></h1>
        <h4>By <?php echo $song->artist; ?></h4>
    </div>
    <div class="padd-20 col-xs-12 col-sm-8">
        <div class="col-xs-12 padd-20" id="info-container">
            <div class="col-xs-12 transbox-b">
                <div id='status' class="col-md-4">
                    <h4>Status: <?php echo $song->status->name; ?></h4>
                </div>
                <div id='album' class="col-md-4">
                    <h4>Album: <a href="<?php echo base_url("songbook/album/v").'/'.$song->album->ID?>"><?php echo $song->album->name; ?></a></h4>
                </div>
                <div id='created' class="col-md-4">
                    <h4>Created: <?php echo $song->created_at; ?></h4>
                </div>
            </div>
        </div>
        
        
        <div class="col-xs-12 padd-20 inner_shadow inner_layer">
            <div class="section-label">Lyrics</div>
            <div class="transbox-b-dark lyric-container padd-20-0 col-sm-12">
                <?php if($song->lyrics->content != ''){ echo $song->lyrics->content;}
                else { ?> 
                <a href="<?php echo site_url('songbook/song/e/'.$song->ID) ?>"><p>Click here to add lyrics!</p></a>
                <?php }?>
            </div>
        </div>
        <div class="col-xs-12 padd-20-20">
            <div class="col-md-6 center">
                <a href="<?php echo site_url('songbook/song/e/'.$song->ID) ?>"><input id="about-btn" class="button button-info" value="Edit"></a>
            </div>
            <div class="col-md-6 center">
                <a class="confirm" href="<?php echo base_url('songbook/delete_song/'.$song->ID) ?>"> <input id="form-btn" class="button button-info" value="Delete"></a>
            </div>
        </div>    
</div>
</div>
</div>
<script>
    setActive('song');
    $(function() {
        $('.confirm').click(function() {
            return window.confirm("Are you sure you want to delete \"<?php echo $song->name ?>\"? (This can not be undone)");
        });
    });
    
    function toggle(ele){
        var item = document.getElementById(ele + '-container');
        var toggle = document.getElementById(ele + '-toggle');
        if(item.style.display == 'none'){
            item.style.display = '';
            toggle.classList = 'glyphicon glyphicon-chevron-down';
        } else{
            item.style.display = 'none';
            toggle.classList = 'glyphicon glyphicon-chevron-up';
        }
    }
    
    init();
    function init(){
        var current = 0;
        var audio = $('#audio');
        var playlist = $('#playlist');
        var tracks = playlist.find('li a');
        var len = tracks.length - 1;
        audio[0].volume = .10;
        audio[0].play();
        playlist.find('a').click(function(e){
            e.preventDefault();
            link = $(this);
            current = link.parent().index();
            run(link, audio[0]);
        });
        audio[0].addEventListener('ended',function(e){
            current++;
            if(current == len){
                current = 0;
                link = playlist.find('a')[0];
            }else{
                link = playlist.find('a')[current];    
            }
            run($(link),audio[0]);
        });
    }
    function run(link, player){
            player.src = link.attr('href');
            par = link.parent();
            par.addClass('active').siblings().removeClass('active');
            player.load();
            player.play();
    }
    
    function mediaActive(active){
        if(active == 'video'){
            jQuery('#video-button').addClass('media-label-active');
            jQuery('#audio-button').removeClass('media-label-active');
            jQuery('#video-options').css('display','');
            jQuery('#audio-options').css('display','none');
        } 
        if(active == 'audio'){
            jQuery('#video-button').removeClass('media-label-active');
            jQuery('#audio-button').addClass('media-label-active');
            jQuery('#video-options').css('display','none');
            jQuery('#audio-options').css('display','');
        }
    }
    

</script>

<?php $this->load->view('songbook/footer'); ?>