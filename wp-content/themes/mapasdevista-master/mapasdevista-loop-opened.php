<?php
$format = get_post_format() ? get_post_format() : 'default';
?>

<div id="post_<?php the_ID(); ?>" class="entry <?php echo $format; ?> clearfix">


    <h1 class="bottom"><?php the_title(); ?></h1>
<font color="#000"><?php
$categoria = get_the_category();
$nomeCategoria = $categoria[0]->cat_name;
echo $nomeCategoria;
?></font><p></p>
 
    <?php mapasdevista_get_template( 'mapasdevista-content' ); ?>

</div>
