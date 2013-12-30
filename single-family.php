<?php
 /*Template Name: Family
 */
 
get_header(); ?>

<div id="main-content" class="main-content">

<?php
    if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
        // Include the featured content template.
        get_template_part( 'featured-content' );
    }
?>
    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">

            <?php
                // Start the Loop.
                while ( have_posts() ) : the_post();
                $person = get_post_meta(get_the_ID());
                if (( is_user_logged_in() ) || ( $person['family_private'][0] == 'False')) { 
                    $private = false;
                }
                else {
                    $private = true;
                }
            ?>

            <article id="post-<?php the_ID();?>" class="status-publish hentry">
                <header class="entry-header"><h1 class="entry-title"><?php the_title();?></h1></header>
                <div class="entry-content">

                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>

                    <table class="family-details">
                        <tr>
                            <td class="family-details-label">Gender</td>
                            <td class="family-details-value"><?php echo $person['family_gender'][0]; ?></td>
                        </tr>
                        <tr>
                            <td class="family-details-label">Birth Date</td>
                            <td class="family-details-value"><?php if($private) { echo 'private'; } else { echo family_date_display($person['family_birth_date'][0]); } ?></td>
                        </tr>
                        <tr>
                            <td class="family-details-label">Birth Place</td>
                            <td class="family-details-value"><?php if($private) { echo 'private'; } else { echo $person['family_birth_place'][0]; } ?></td>
                        </tr>
                        <tr>
                            <td class="family-details-label">Death Date</td>
                            <td class="family-details-value"><?php echo family_date_display($person['family_death_date'][0]); ?></td>
                        </tr>
                        <tr>
                            <td class="family-details-label">Death Place</td>
                            <td class="family-details-value"><?php echo $person['family_death_place'][0]; ?></td>
                        </tr>
                        <tr>
                            <td class="family-details-label">Father</td>
                            <td class="family-details-value">
                                <?php
                                    $pid = $person['family_father'][0];
                                    if($pid > 0) {
                                        $parent = get_post($pid);
                                        $plink = get_permalink($parent->ID);
                                        echo '<a href="' . $plink . '">' . $parent->post_title . '</a>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="family-details-label">Mother</td>
                            <td class="family-details-value">
                                <?php
                                    $pid = $person['family_mother'][0];
                                    if($pid > 0) {
                                        $parent = get_post($pid);
                                        $plink = get_permalink($parent->ID);
                                        echo '<a href="' . $plink . '">' . $parent->post_title . '</a>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="family-details-label">Marriage</td>
                            <td class="family-details-value">
                                <?php
                                    $marriages = family_marriage_decode($person['family_marriages'][0]);
                                    $pre = '';
                                    foreach($marriages as $m) {
                                        $spouse = get_post($m['spouse']);
                                        $plink = get_permalink($spouse->ID);
                                        echo $pre . '<a href="' . $plink . '">' . $spouse->post_title . '</a><br/>';
                                        echo $m['day'] . ' ' . $m['month'] . ' ' . $m['year'] . ' - ' . $m['place'] . '<br/>';
                                        $pre = '<br/>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="family-details-label">Children</td>
                            <td class="family-details-value">
                                <?php
                                 $querystr = "
                                    SELECT p.* 
                                    FROM $wpdb->posts p 
                                    JOIN $wpdb->postmeta m ON p.ID = m.post_id 
                                    JOIN $wpdb->postmeta o ON p.ID = o.post_id AND o.meta_key = 'family_birth_date'
                                    WHERE p.post_status = 'publish' 
                                      AND p.post_type = 'family' 
                                      AND p.post_date < NOW() 
                                      AND (
                                        (m.meta_key = 'family_father' AND m.meta_value = '$post->ID' )
                                        OR (m.meta_key = 'family_mother' AND m.meta_value = '$post->ID') )
                                    ORDER BY o.meta_value
                                 ";
                                 $pageposts = $wpdb->get_results($querystr, OBJECT);
                                 foreach ($pageposts as $post) {
                                    $child = get_post($pid);
                                    $plink = get_permalink($child->ID);
                                    echo '<a href="' . $plink . '">' . $child->post_title . '</a><br/>';
                                 }
                                 ?>
                            </td>
                        </tr>
                    </table>

                </div>
            </article>

            <?php
                endwhile;
            ?>

        </div><!-- #content -->
    </div><!-- #primary -->
    <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
?>