<?php
/*Template Name: Family List
 */

get_header(); ?>

<section id="primary" class="content-area">
<div id="content" class="site-content" role="main">

    <header class="entry-header"><h1 class="entry-title">Family</h1></header><!-- .entry-header -->
    <div class="entry-content">
        <ul>
        <?php
        $args = array( 'post_type'=> 'family', 'showposts'=> 1000, 'orderby'=>'name', 'order'=>'ASC' );
        $archive_query = new WP_Query($args);
        while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; ?>
        </ul>
    </div>

</div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
?>
