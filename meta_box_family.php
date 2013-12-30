<?php

add_action( 'admin_init', 'meta_box_family' );

function meta_box_family() {
    add_meta_box(
        'family_details',
        'Family Member Details',
        'display_family_details',
        'family',
        'normal',
        'high'
    );
}

function display_family_details( $family ) {

    global $wpdb;

    $person = get_post_meta($family->ID);

    $family_first_name     = $person['family_first_name'][0];
    $family_middle_name    = $person['family_middle_name'][0];
    $family_last_name      = $person['family_last_name'][0];
    $family_gender         = $person['family_gender'][0];
    $family_birth_date     = $person['family_birth_date'][0];
    $family_birth_year     = family_date_get_year($family_birth_date);
    $family_birth_month    = family_date_get_month($family_birth_date);
    $family_birth_day      = family_date_get_day($family_birth_date);
    $family_birth_place    = $person['family_birth_place'][0];
    $family_death_date     = $person['family_death_date'][0];
    $family_death_year     = family_date_get_year($family_death_date);
    $family_death_month    = family_date_get_month($family_death_date);
    $family_death_day      = family_date_get_day($family_death_date);
    $family_death_place    = $person['family_death_place'][0];
    $family_father         = $person['family_father'][0];
    $family_mother         = $person['family_mother'][0];
    $family_marriages      = family_marriage_decode($person['family_marriages'][0]);
    $family_private        = $person['family_private'][0];

    ?>
    <table>
        <tr valign="top">
            <td>
                <label for="family_first_name">First Name</label>
            </td>
            <td>
                <input type="text" id="family_first_name" name="family_first_name" value="<?php echo $family_first_name; ?>" />
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_middle_name">Middle Name</label>
            </td>
            <td>
                <input type="text" id="family_middle_name" name="family_middle_name" value="<?php echo $family_middle_name; ?>" />
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_last_name">Last Name</label>
            </td>
            <td>
                <input type="text" id="family_last_name" name="family_last_name" value="<?php echo $family_last_name; ?>" />
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_gender">Gender</label>
            </td>
            <td>
                <select id="family_gender" name="family_gender">
                    <option value="" <?php echo selected($family_gender,'');?>></option>
                    <option value="Male" <?php echo selected($family_gender,'Male');?>>Male</option>
                    <option value="Female" <?php echo selected($family_gender,'Female');?>>Female</option>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_birth_date">Birth Date</label>
            </td>
            <td>
                <select id="family_birth_day" name="family_birth_day">
                <?php
                    foreach(family_day_array() as $day) {
                        echo '<option value="' . $day . '" ' . selected($family_birth_day, $day) . '>' . $day . '</option>';
                    }
                ?>
                </select>
                <select id="family_birth_month" name="family_birth_month">
                <?php
                    foreach(family_month_array() as $month) {
                        echo '<option value="' . $month . '" ' . selected($family_birth_month, $month) . '>' . $month . '</option>';
                    }
                ?>
                </select>
                <select id="family_birth_year" name="family_birth_year">
                <?php
                    foreach(family_year_array() as $year) {
                        echo '<option value="' . $year . '" ' . selected($family_birth_year, $year) . '>' . $year . '</option>';
                    }
                ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_birth_place">Birth Place</label>
            </td>
            <td>
                <input type="text" id="family_birth_place" name="family_birth_place" value="<?php echo $family_birth_place; ?>" />
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_death_date">Death Date</label>
            </td>
            <td>
                <select id="family_death_day" name="family_death_day">
                <?php
                    foreach(family_day_array() as $day) {
                        echo '<option value="' . $day . '" ' . selected($family_death_day, $day) . '>' . $day . '</option>';
                    }
                ?>
                </select>
                <select id="family_death_month" name="family_death_month">
                <?php
                    foreach(family_month_array() as $month) {
                        echo '<option value="' . $month . '" ' . selected($family_death_month, $month) . '>' . $month . '</option>';
                    }
                ?>
                </select>
                <select id="family_death_year" name="family_death_year">
                <?php
                    foreach(family_year_array() as $year) {
                        echo '<option value="' . $year . '" ' . selected($family_death_year, $year) . '>' . $year . '</option>';
                    }
                ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_death_place">Death Place</label>
            </td>
            <td>
                <input type="text" id="family_death_place" name="family_death_place" value="<?php echo $family_death_place; ?>" />
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_father">Father</label>
            </td>
            <td>
                <select id="family_father" name="family_father">
                    <option value="0" <?php echo selected($family_father,'0');?>></option>
                    <?php
                     $querystr = "
                        SELECT p.* 
                        FROM $wpdb->posts p 
                        JOIN $wpdb->postmeta m ON p.ID = m.post_id 
                        WHERE m.meta_key = 'family_gender' 
                          AND m.meta_value = 'Male' 
                          AND p.post_status = 'publish' 
                          AND p.post_type = 'family' 
                          AND p.post_date < NOW() 
                          AND p.id != $family->ID 
                        ORDER BY p.post_name
                     ";
                     $pageposts = $wpdb->get_results($querystr, OBJECT);
                     foreach ($pageposts as $post) {
                        echo '<option value="' . $post->ID . '" ' . selected($family_father, $post->ID) . '>' . $post->post_title . '</option>';
                     }
                     ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_mother">Mother</label>
            </td>
            <td>
                <select id="family_mother" name="family_mother">
                    <option value="0" <?php echo selected($family_mother,'0');?>></option>
                    <?php
                     $querystr = "
                        SELECT p.* 
                        FROM $wpdb->posts p 
                        JOIN $wpdb->postmeta m ON p.ID = m.post_id 
                        WHERE m.meta_key = 'family_gender' 
                          AND m.meta_value = 'Female' 
                          AND p.post_status = 'publish' 
                          AND p.post_type = 'family' 
                          AND p.post_date < NOW() 
                          AND p.id != $family->ID 
                        ORDER BY p.post_name
                     ";
                     $pageposts = $wpdb->get_results($querystr, OBJECT);
                     foreach ($pageposts as $post) {
                        echo '<option value="' . $post->ID . '" ' . selected($family_mother, $post->ID) . '>' . $post->post_title . '</option>';
                     }
                     ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_marriages">Marriages</label>
            </td>
            <td>
    <?php 
    $querystr = "
        SELECT p.* 
        FROM $wpdb->posts p 
        WHERE p.post_status = 'publish' 
          AND p.post_type = 'family' 
          AND p.post_date < NOW() 
          AND p.id != $family->ID 
        ORDER BY p.post_name
    ";
    $pageposts = $wpdb->get_results($querystr, OBJECT);
    foreach($family_marriages as $m) { ?>
                <select id="family_marriage_spouse" name="family_marriage_spouse[]">
                    <option value="0"></option>
                    <?php
                     foreach ($pageposts as $post) {
                        echo '<option value="' . $post->ID . '" ' . selected($m['spouse'], $post->ID) . '>' . $post->post_title . '</option>';
                     }
                     ?>
                </select>
                <select id="family_marriage_day" name="family_marriage_day[]">
                <?php
                    foreach(family_day_array() as $day) {
                        echo '<option value="' . $day . '" ' . selected($m['day'], $day) . '>' . $day . '</option>';
                    }
                ?>
                </select>
                <select id="family_marriage_month" name="family_marriage_month[]">
                <?php
                    foreach(family_month_array() as $month) {
                        echo '<option value="' . $month . '" ' . selected($m['month'], $month) . '>' . $month . '</option>';
                    }
                ?>
                </select>
                <select id="family_marriage_year" name="family_marriage_year[]">
                <?php
                    foreach(family_year_array() as $year) {
                        echo '<option value="' . $year . '" ' . selected($m['year'], $year) . '>' . $year . '</option>';
                    }
                ?>
                </select>
                <input type="text" id="family_marriage_place" name="family_marriage_place[]" value="<?php echo $m['place']; ?>" />
                <br/>
    <?php } ?>
                <select id="family_marriage_spouse" name="family_marriage_spouse[]">
                    <option value="0"></option>
                    <?php
                     foreach ($pageposts as $post) {
                        echo '<option value="' . $post->ID . '">' . $post->post_title . '</option>';
                     }
                     ?>
                </select>
                <select id="family_marriage_day" name="family_marriage_day[]">
                <?php
                    foreach(family_day_array() as $day) {
                        echo '<option value="' . $day . '">' . $day . '</option>';
                    }
                ?>
                </select>
                <select id="family_marriage_month" name="family_marriage_month[]">
                <?php
                    foreach(family_month_array() as $month) {
                        echo '<option value="' . $month . '" >' . $month . '</option>';
                    }
                ?>
                </select>
                <select id="family_marriage_year" name="family_marriage_year[]">
                <?php
                    foreach(family_year_array() as $year) {
                        echo '<option value="' . $year . '">' . $year . '</option>';
                    }
                ?>
                </select>
                <input type="text" id="family_marriage_place" name="family_marriage_place[]" value="" />
            </td>
        </tr>
        <tr valign="top">
            <td>
                <label for="family_private">Private</label>
            </td>
            <td>
                <select id="family_private" name="family_private">
                    <option value="False" <?php echo selected($family_private,'False');?>>False</option>
                    <option value="True" <?php echo selected($family_private,'True');?>>True</option>
                </select>
            </td>
        </tr>
    </table>
    <br/><br/>

    <strong>Editing Notes:</strong>
    <ul>
        <li>If you want to display a picture of the family member, use the featured image.</li>
        <li>To add multiple marriages, add the first one, then update the post to add the next. Repeat as needed.</li>
        <li>To delete a marriage, set the spouse name to the empty value and update, but you must also do this on the spouses side.</li>
    </ul>
    <?php
}

?>