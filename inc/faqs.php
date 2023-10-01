<?php function register_faq() {
 
 // Set UI labels for Custom Post Type
     $labels = array(
         'name'                => 'FAQ',
         'singular_name'       => 'FAQ',
         'menu_name'           => 'FAQs',
         'all_items'           => 'All FAQs',
         'view_item'           => 'View Faq',
         'add_new_item'        => 'Add New Faq',
         'add_new'             => 'Add New',
         'edit_item'           => 'Edit Faq',
         'update_item'         => 'Update Faq',
         'search_items'        => 'Search Faq',
         'not_found'           => 'Not Found',
         'not_found_in_trash'  => 'Not found in Trash',
     );
      
 // Set other options for Custom Post Type
      
     $args = array(
         'label'               => 'FAQs',
         'labels'              => $labels,
         'supports'            => array( 'title', 'editor', 'custom-fields', ),
         'hierarchical'        => false,
         'public'              => true,
         'show_ui'             => true,
         'show_in_menu'        => true,
         'show_in_nav_menus'   => true,
         'show_in_admin_bar'   => true,
         'menu_position'       => 5,
         'can_export'          => true,
         'has_archive'         => 'faqs',
         'exclude_from_search' => false,
         'publicly_queryable'  => true,
         'capability_type'     => 'page',
         'show_in_rest'        => true,
         // This is where we add taxonomies to our CPT
         'taxonomies'          => array( 'category' ),
     );
      
     // Registering your Custom Post Type
     register_post_type( 'faq', $args );
  
 }
  
 /* Hook into the 'init' action so that the function
 * Containing our post type registration is not 
 * unnecessarily executed. 
 */
  
 add_action( 'init', 'register_faq', 0 );