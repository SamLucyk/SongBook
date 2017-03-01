    <!-- Wrapper for slides -->
    <div class="album-slider col-md-8 col-md-offset-2" >
        
             <?php foreach($albums as $album) { ?>
                    <a href='<?php echo site_url('songbook/album/v/'.$album->ID) ?>'>
                        <div>
                        <img class="pic" src="<?php echo $album->pic->src; ?>" alt="<?php echo $album->name; ?>">
                        <div class="caption"><?php echo $album->name; ?></div>
                        </div>
                    </a>
             <?php } ?>
    </div>

<script>
    $(document).ready(function(){
        $('.album-slider').slick({
            autoplay: true,
        autoplaySpeed: 3000,
            centerMode: true,
              infinite: true,
              slidesToShow: 3,
              slidesToScroll: 1,
              variableWidth: true
        });
        $(".pic").addClass('under_shadow');
        $(".slick-list").addClass('inner_shadow');
        $(".slick-list").addClass('inner_layer');
    });
</script>