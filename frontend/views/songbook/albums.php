
<div id="myCarousel" class="carousel slide col-md-6 col-md-offset-3 padd-40-0" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php 
            $first = true;
            $count = 0;
            foreach($albums as $album){?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $count; ?>" class="<?php if($first){ echo "active"; }?>"></li>
        <?php 
            $count += 1;
            $first = false;
            } ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php 
            if(isset($albums) && !empty($albums)){
            $first = true;
            foreach($albums as $album){?>
            <div class="item <?php if($first){ echo "active"; }?>">
                <div class="center">
                    <a href='<?php echo site_url('songbook/album/v/'.$album->ID) ?>'>
                    <div class="col-md-12"><img src="<?php if(isset($album->picture)){ echo $album->picture; } else { echo base_url('img/default-album-art.png');} ?>" alt="<?php echo $album->name; ?>"><div class="caption col-md-12"><?php echo $album->name; ?></div></div>
                    </a>
                </div>
            </div>
        <?php $first = false;
            }} else { ?>
                <div class="item active">
                <a href='<?php echo site_url('songbook/newalbum') ?>'><div class="center">
                    <div class="col-md-12"><img src="<?php echo base_url('img/default-album-art.png'); ?>" alt="Create Album"><div class="caption col-md-12">Create Album</div></div>
                </div></a>
            </div>
        <?php } ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" style="background-image:none" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" style="background-image:none" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<script>
</script>