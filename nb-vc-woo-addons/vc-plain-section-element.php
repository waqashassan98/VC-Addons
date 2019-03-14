<?php

/*
Element Description: Plain Section, with heading, text and link
*/

// Element Class
class vcPlainSectionBox extends WPBakeryShortCode {

    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_plainsectionbox_mapping' ) );
        add_shortcode( 'vc_plainsectionbox', array( $this, 'vc_plainsectionbox_html' ) );
    }

    // Element Mapping
    public function vc_plainsectionbox_mapping() {

        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
      
        // Map the block with vc_map()
        vc_map(
            array(
                'name' => __('Plain Section', 'text-domain'),
                'base' => 'vc_plainsectionbox',
                'class' => 'wpc-text-class',
                'description' => __('Plain Section', 'text-domain'),
                'category' => __('NextBridge', 'text-domain'),
                'icon' => plugin_dir_path( __FILE__ ) . 'assets/img/note.png',
                'params' => array(

                    array(
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __( 'Heading h1', 'text-domain' ),
                        'param_name' => 'heading_h1',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Headings Text',
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __( 'Heading h2', 'text-domain' ),
                        'param_name' => 'heading_h2',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Headings Text',
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __( 'Button Text', 'text-domain' ),
                        'param_name' => 'button_text',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Button Link',
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __( 'Button Link', 'text-domain' ),
                        'param_name' => 'button_link',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Button Link',
                    ),
                    array(
                        'type' => 'textarea',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __( 'Description paragraph', 'text-domain' ),
                        'param_name' => 'description_text',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Headings Text',
                    ),

                ),
            )
        );

    }

    // Element HTML
    public function vc_plainsectionbox_html( $atts, $content ) {

        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'heading_h1'  => '',
                    'heading_h2'  => '',
                    'button_text' => '',
                    'button_link' => '',
                    'description_text' => ''
                ),
                $atts
            )
        );

        ob_start();
        
        echo '<div class="nb-vc-plain-section">';
            if (isset($heading_h1) && !empty($heading_h1)) {
                echo "<h1>".$heading_h1."</h1>";
            }
            if (isset($heading_h2) && !empty($heading_h2)) {
                echo "<h2>".$heading_h2."</h2>";
            }
            if (isset($description_text) && !empty($description_text)) {
                echo '<p>'.$description_text.'</p>';
            }
            if (isset($button_text) && !empty($button_text)) {
                echo '<a class="orange-fancy-arrowed" href="'.$button_link.'">'.$button_text.'</a>';
            }
        echo '</div>';
        return ob_get_clean();

    }

} // End Element Class

// Element Class Init
new vcPlainSectionBox();