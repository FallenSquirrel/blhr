<?php

add_action('wpcf_after_init','q_insert_testdata');

function q_insert_testdata() {
    if(isset($_GET['inserttestdata'])) {
        /*$data = q_getstd_wpcf_data('Trendbarometers','Trendbarometer','trendbarometer');
        q_add_custom_post_type($data);*/
    }
}

function q_add_custom_post_type( $data ) {

    global $wpcf;

    $update = false;

    // Sanitize data
    if ( isset( $data['wpcf-post-type'] ) ) {
        $update = true;
        $data['wpcf-post-type'] = sanitize_title( $data['wpcf-post-type'] );
    } else {
        $data['wpcf-post-type'] = null;
    }
    if ( isset( $data['slug'] ) ) {
        $data['slug'] = sanitize_title( $data['slug'] );
    } else {
        $data['slug'] = null;
    }
    if ( isset( $data['rewrite']['slug'] ) ) {
        $data['rewrite']['slug'] = remove_accents( $data['rewrite']['slug'] );
        $data['rewrite']['slug'] = strtolower( $data['rewrite']['slug'] );
        $data['rewrite']['slug'] = trim( $data['rewrite']['slug'] );
    }

    // Set post type name
    $post_type = null;
    if ( !empty( $data['slug'] ) ) {
        $post_type = $data['slug'];
    } else if ( !empty( $data['wpcf-post-type'] ) ) {
        $post_type = $data['wpcf-post-type'];
    } else if ( !empty( $data['labels']['singular_name'] ) ) {
        $post_type = sanitize_title( $data['labels']['singular_name'] );
    }

    if ( empty( $post_type ) ) {
        wpcf_admin_message( __( 'Please set post type name', 'wpcf' ), 'error' );
        return false;
    }

    $data['slug'] = $post_type;
    $custom_types = get_option( 'wpcf-custom-types', array() );

    // Check reserved name
    $reserved = wpcf_is_reserved_name( $post_type, 'post_type' );
    if ( is_wp_error( $reserved ) ) {
        wpcf_admin_message( $reserved->get_error_message(), 'error' );
        return false;
    }

    // Check overwriting
    if ( ( !array_key_exists( 'wpcf-post-type', $data ) || $data['wpcf-post-type'] != $post_type ) && array_key_exists( $post_type, $custom_types ) ) {
        wpcf_admin_message( __( 'Custom post type already exists', 'wpcf' ), 'error' );
        return false;
    }

    /*
     * Since Types 1.2
     * We do not allow plural and singular names to be same.
     */
    if ( $wpcf->post_types->check_singular_plural_match( $data ) ) {
        wpcf_admin_message( $wpcf->post_types->message( 'warning_singular_plural_match' ), 'error' );
        return false;
    }

    // Check if renaming then rename all post entries and delete old type
    if ( !empty( $data['wpcf-post-type'] )
        && $data['wpcf-post-type'] != $post_type ) {
        global $wpdb;
        $wpdb->update( $wpdb->posts, array('post_type' => $post_type),
            array('post_type' => $data['wpcf-post-type']), array('%s'),
            array('%s')
        );


        /**
         * update post meta "_wp_types_group_post_types"
         */
        $sql = sprintf(
            'select meta_id, meta_value from %s where meta_key = \'%s\'',
            $wpdb->postmeta,
            '_wp_types_group_post_types'
        );
        $all_meta = $wpdb->get_results($sql, OBJECT_K);
        $re = sprintf( '/,%s,/', $data['wpcf-post-type'] );
        foreach( $all_meta as $meta ) {
            if ( !preg_match( $re, $meta->meta_value ) ) {
                continue;
            }
            $wpdb->update(
                $wpdb->postmeta,
                array(
                    'meta_value' => preg_replace( $re, ','.$post_type.',', $meta->meta_value ),
                ),
                array(
                    'meta_id' => $meta->meta_id,
                ),
                array( '%s' ),
                array( '%d' )
            );
        }

        /**
         * update _wpcf_belongs_{$data['wpcf-post-type']}_id
         */
        $wpdb->update(
            $wpdb->postmeta,
            array(
                'meta_key' => sprintf( '_wpcf_belongs_%s_id', $post_type ),
            ),
            array(
                'meta_key' => sprintf( '_wpcf_belongs_%s_id', $data['wpcf-post-type'] ),
            ),
            array( '%s' ),
            array( '%s' )
        );

        /**
         * update options "wpv_options"
         */
        $wpv_options = get_option( 'wpv_options', true );
        if ( is_array( $wpv_options ) ) {
            $re = sprintf( '/(views_template_(archive_)?for_)%s/', $data['wpcf-post-type'] );
            foreach( $wpv_options as $key => $value ) {
                if ( !preg_match( $re, $key ) ) {
                    continue;
                }
                unset($wpv_options[$key]);
                $key = preg_replace( $re, "$1".$post_type, $key );
                $wpv_options[$key] = $value;
            }
            update_option( 'wpv_options', $wpv_options );
        }

        /**
         * update option "wpcf-custom-taxonomies"
         */
        $wpcf_custom_taxonomies = get_option( 'wpcf-custom-taxonomies', true );
        if ( is_array( $wpcf_custom_taxonomies ) ) {
            $update_wpcf_custom_taxonomies = false;
            foreach( $wpcf_custom_taxonomies as $key => $value ) {
                if ( array_key_exists( 'supports', $value ) && array_key_exists( $data['wpcf-post-type'], $value['supports'] ) ) {
                    unset( $wpcf_custom_taxonomies[$key]['supports'][$data['wpcf-post-type']] );
                    $update_wpcf_custom_taxonomies = true;
                }
            }
            if ( $update_wpcf_custom_taxonomies ) {
                update_option( 'wpcf-custom-taxonomies', $wpcf_custom_taxonomies );
            }
        }

        // Sync action
        do_action( 'wpcf_post_type_renamed', $post_type, $data['wpcf-post-type'] );

        // Set protected data
        $protected_data_check = $custom_types[$data['wpcf-post-type']];
        // Delete old type
        unset( $custom_types[$data['wpcf-post-type']] );
        $data['wpcf-post-type'] = $post_type;
    } else {
        // Set protected data
        $protected_data_check = !empty( $custom_types[$post_type] ) ? $custom_types[$post_type] : array();
    }

    // Check if active
    if ( isset( $custom_types[$post_type]['disabled'] ) ) {
        $data['disabled'] = $custom_types[$post_type]['disabled'];
    }

    // Sync taxes with custom taxes
    if ( !empty( $data['taxonomies'] ) ) {
        $taxes = get_option( 'wpcf-custom-taxonomies', array() );
        foreach ( $taxes as $id => $tax ) {
            if ( array_key_exists( $id, $data['taxonomies'] ) ) {
                $taxes[$id]['supports'][$data['slug']] = 1;
            } else {
                unset( $taxes[$id]['supports'][$data['slug']] );
            }
        }
        update_option( 'wpcf-custom-taxonomies', $taxes );
    }

    // Preserve protected data
    foreach ( $protected_data_check as $key => $value ) {
        if ( strpos( $key, '_' ) !== 0 ) {
            unset( $protected_data_check[$key] );
        }
    }

    // Merging protected data
    $custom_types[$post_type] = array_merge( $protected_data_check, $data );

    update_option( 'wpcf-custom-types', $custom_types );

    // WPML register strings
    wpcf_custom_types_register_translation( $post_type, $data );

    wpcf_admin_message_store(
        apply_filters( 'types_message_custom_post_type_saved',
            __( 'Custom post type saved', 'wpcf' ), $data, $update ),
        'custom'
    );

    // Flush rewrite rules
    flush_rewrite_rules();

    do_action( 'wpcf_custom_types_save', $data );
}

function q_getstd_wpcf_data($pl,$sg,$sl) {
    $data = array('labels' => array(
        'singular_name' => $sg,
        'name' => $pl,
        'add_new' => 'Neue hinzufügen',
        'add_new_item' => 'Neue/n/s %s hinzufügen',
        'edit_item' => '%s bearbeiten',
        'new_item' => 'Neue/s/r %s',
        'view_item' => '%s ansehen',
        'search_items' => '%s suchen',
        'not_found' => 'Kein(e) %s gefunden',
        'not_found_in_trash' => 'Keine %s im Papierkorb gefunden',
        'parent_item_colon' => 'Übergeordneter Text',
        'all_items' => 'Alle Objekte'
    ),
        'slug' => $sl,
        'description' => '',
        'icon' => 'admin-post',
        'public' => 'public',
        'menu_position' => '',
        'menu_icon' => '',
        'supports' => array(
            'title' => 1,
            'editor' => 1
        ),
        'rewrite' => array(
            'enabled' => 1,
            'custom' => 'normal',
            'with_front' => 1,
            'feeds' => 1,
            'pages' => 1,
            'slug' => ''
        ),
        'has_archive' => 1,
        'show_in_menu' => 1,
        'show_in_menu_page' => 0,
        'show_ui' => 1,
        'publicly_queryable' => 1,
        'can_export' => 1,
        'show_in_nav_menus' => 1,
        'query_var_enabled' => 1,
        'query_var' => '',
        'permalink_epmask' => 'EP_PERMALINK',
        'wpcf-post-type' => NULL

    );

    return $data;
}