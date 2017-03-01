<?php $this->load->view('songbook/top'); ?>
    <span class="page-label">Public Song</span>
     <div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 padd-0-20">
        <div id="video_frame"  style="display:none">
            <video width="100%" class='under_shadow' id="video" controls>
                <source src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div id="audio_frame">
            <div class="song_album_pic col-xs-12 under_shadow" style="background-image:url(<?php echo $song->album->pic->src; ?>)"></div>
            <audio class="under_shadow" style="width:100%" id="audio" controls>
                <source src="" type="audio/mp3">
            </audio>
        </div>
        <div>
            <a onclick="mediaActive('audio')" class="col-xs-6 no-padd"><div id="audio-button" class="center media-label media-label-active padd-5">Audio</div></a>
            <a onclick="mediaActive('video')" class="col-xs-6 no-padd"><div id="video-button" class="media-label padd-5 center ">Video</div></a>
            <ul class="media-playlist inner_layer col-xs-12" id="audio_playlist" class="col-xs-12 inner_layer">
                <div id="audio_options" class="media_options">
                    
                <?php if(isset($audios) && !empty($audios)){ 
                    $x = 1;                                 
                    foreach($audios as $audio){ ?>
                        <li id="<?php echo 'audio_'.$x ?>">
                            <a class="media" href="<?php echo $audio->src; ?>">
                                <span class="glyphicon glyphicon-play-circle float-right"></span>
                                <?php echo $audio->name; ?>
                            </a>
                        </li>
                <?php $x++;
                    } 
                } else { ?>
                    <li>
                        <a>
                            No Current Recordings.
                        </a>
                    </li>
                    <?php } ?>
                </div>
            </ul>
            <ul class="media-playlist inner_layer col-xs-12" id="video_playlist" class="col-xs-12 inner_layer" style='display:none'>
                <div id="video_options" class="media_options">
                <?php if(isset($videos) && !empty($videos)){ 
                    $x = 1;                                 
                    foreach($videos as $video){ ?>
                        <li class="" id="<?php echo 'video_'.$x ?>">
                            <a class="media" href="<?php echo $video->src; ?>">
                                <span class="glyphicon glyphicon-play-circle float-right"></span>
                                <?php echo $video->name; ?>
                            </a>
                        </li>
                <?php $x++;
                    }
                } else { ?>
                    <li>
                        <a>
                            No Current Videos.
                        </a>
                    </li>
                    <?php } ?>
                </div>
            </ul>
         </div>
         <div class="padd-0-10">
            <div id='status' class="col-xs-6">
                <div data-toggle="tooltip" data-placement="bottom" title="Status" class="status_badge under_shadow"><?php echo $song->status->name; ?></div>
            </div>
            <div id='created' class="col-xs-6">
                <div data-toggle="tooltip" data-placement="bottom" title="Created" class="status_badge under_shadow"><?php echo $song->created_at; ?></div>
            </div>
         </div>
    </div>
    <div class="title-transbox col-sm-8 col-xs-12">
        <h1><?php echo $song->name;?></h1>
        <h4><?php echo $song->artist; ?> - <a data-toggle="tooltip" data-placement="right" title="Album" href="<?php echo base_url($song->album->path); ?>"><?php echo $song->album->name; ?></a></h4>
    </div>
    <div id="lyric-container" class="col-xs-12 col-sm-8 padd-20 marg-20-40">
        <span class="lyrics-label">Lyrics</span>
        <span id="lyrics-pause" class="lyrics-pause glyphicon glyphicon-pause float-right"></span>
        <span id="lyrics-play" class="lyrics-play glyphicon glyphicon-play-circle float-right"></span>
        <span data-toggle="tooltip" data-placement="right" title="Play Speed" class="lyrics-slide-val"><span id="slide-val">75</span>%</span>
        <span class="lyrics-slide"><input id="slider" onchange="updateTextInput(this.value)" min=".5" max="1" step='.01' val='.75' type="range" orient="vertical" /></span>
        <div id="scrollable-lyric-container" class="transbox-b-dark lyric-container padd-20-0 col-sm-12">
            <?php if($song->lyrics->content != ''){ echo $song->lyrics->content;}
            else { ?> 
            <a href="<?php echo site_url('songbook/song/e/'.$song->ID) ?>"><p>Click here to add lyrics!</p></a>
            <?php }?>
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
    init2();
    function init(){
        var current = 0;
        var video = $('#video');
        var audio = $('#audio');
        var playlist = $('#audio_playlist');
        var tracks = playlist.find('li a');
        var len = tracks.length - 1;
        audio[0].volume = .5;
        playlist.find('a.media').click(function(e){
            e.preventDefault();
            link = $(this);
            video[0].pause();
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
    
    function init2(){
        var current = 0;
        var video = $('#video');
        var audio = $('#audio');
        var playlist = $('#video_playlist');
        var tracks = playlist.find('li a');
        var len = tracks.length - 1;
        video[0].volume = .5;
        playlist.find('a.media').click(function(e){
            e.preventDefault();
            link = $(this);
            current = link.parent().index();
            audio[0].pause();
            run(link, video[0]);
        });
        video[0].addEventListener('ended',function(e){
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
            jQuery('#video_playlist').show();
            jQuery('#audio_playlist').hide();
            if ($('#video_playlist').find('a.media').length){
                jQuery('#video_frame').show();
                jQuery('#audio_frame').hide();
            }
        } 
        if(active == 'audio'){
            jQuery('#video-button').removeClass('media-label-active');
            jQuery('#audio-button').addClass('media-label-active');
            jQuery('#video_playlist').hide();
            jQuery('#audio_playlist').show();
            jQuery('#video_frame').hide();
            jQuery('#audio_frame').show();
        }
    }
    
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    
    function updateTextInput(val) {
       $('#slide-val').html(val*100); 
    } 
    
    $("#lyrics-play").click(function(){
        $('#scrollable-lyric-container').stop();
        var speed = $('#slider').val();
        console.log(speed);
        var fullSpeed = (1.1 - speed) * 300000;
        
        $('html, body').animate({
            scrollTop: $("#lyric-container").offset().top
        }, 2000);
        
        $('#scrollable-lyric-container').animate({
            scrollTop: $('#scrollable-lyric-container').prop("scrollHeight")
        }, fullSpeed);
    });
    
    $("#lyrics-pause").click(function(){ 
        $('#scrollable-lyric-container').stop();
    });
    
    $("#slider").change(function(){
        var animated = $(":animated");
        if (animated.length > 0){
            console.log("animated");
           $( "#lyrics-play" ).trigger( "click" ); 
        };
    })
</script>

<?php $this->load->view('songbook/footer'); ?>