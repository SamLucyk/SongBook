
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
            $first = true;
            foreach($albums as $album){?>
            <div class="item <?php if($first){ echo "active"; }?>">
                <div class="center">
                    <div class="col-md-12"><img src="<?php if(isset($album->picture)){ echo $album->picture; } else { echo base_url('img/default-album-art.png');} ?>" alt="<?php echo $album->name; ?>"></div>
                    <div class="col-md-12"><?php echo $album->name; ?></div>
                </div>
            </div>
        <?php $first = false;
            } ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>