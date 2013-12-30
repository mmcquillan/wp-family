<?php


add_filter( 'wp_insert_post_data' , 'set_post_title' , '99', 2 );

function set_post_title( $data , $postarr )
{
    if ( $data['post_type'] == 'family' ) {
        if( isset( $_POST['family_last_name'] ) ) {
            $full_name = $_POST['family_first_name'] . ' ' . $_POST['family_middle_name'] . ' ' . $_POST['family_last_name'];
            $data['post_title'] = preg_replace( "/\s+/", " ", $full_name);
            $data['post_name'] = strtolower( preg_replace( "/\s+/", "-", $full_name ) );
        }
    }
    return $data;
}


add_action( 'save_post', 'save_post_family', 10, 2 );

function save_post_family( $family_id, $family ) {
    
    if ( $family->post_type == 'family' ) {

        // save all text fields
        $meta_fields = array(
            'family_first_name',
            'family_middle_name',
            'family_last_name',
            'family_gender',
            'family_birth_place',
            'family_death_place',
            'family_father',
            'family_mother',
            'family_private'
        );
        foreach ($meta_fields as $field) {
            if ( isset( $_POST[$field] ) ) {
                update_post_meta( $family_id, $field, $_POST[$field] );
            }
        }

        // save date fields
        update_post_meta( $family_id, 'family_birth_date', family_date_encode($_POST['family_birth_year'],$_POST['family_birth_month'],$_POST['family_birth_day']));
        update_post_meta( $family_id, 'family_death_date', family_date_encode($_POST['family_death_year'],$_POST['family_death_month'],$_POST['family_death_day']));

        // build new marriage array
        $cnt = count($_POST['family_marriage_spouse']);
        $marriages = array();
        for($i=0;$i<$cnt;$i++) {
            if ($_POST['family_marriage_spouse'][$i] != '0') {
                $m = array(
                    'spouse' => $_POST['family_marriage_spouse'][$i],
                    'year' => $_POST['family_marriage_year'][$i],
                    'month' => $_POST['family_marriage_month'][$i],
                    'day' => $_POST['family_marriage_day'][$i],
                    'place' => $_POST['family_marriage_place'][$i]
                );
                array_push($marriages, $m);
            }
        }

        // loop through and update each spouse
        foreach($marriages as $m) {
            $s = get_post_meta($m['spouse'], 'family_marriages', true);
            $s = family_update_marriages($s, $family_id, $m['year'], $m['month'], $m['day'], $m['place']);
            update_post_meta($m['spouse'], 'family_marriages', $s);
        }

        // save this marriage array
        $encmarriage = family_marriage_encode($marriages);
        update_post_meta($family_id, 'family_marriages', $encmarriage);

    }
}

?>