<?php

/*
Element Description: Plain Section, with heading, text and link
*/

// Element Class
class vcImageStripBox extends WPBakeryShortCode {

    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_imagestripbox_mapping' ) );
        add_shortcode( 'vc_imagestripbox', array( $this, 'vc_imagestripbox_html' ) );
    }

    // Element Mapping
    public function vc_imagestripbox_mapping() {

        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
      
        // Map the block with vc_map()
        vc_map(
            array(
                'name' => __('ImageStrip', 'text-domain'),
                'base' => 'vc_imagestripbox',
                'class' => 'wpc-text-class',
                'description' => __('Image Strip', 'text-domain'),
                'category' => __('NextBridge', 'text-domain'),
                'icon' => plugin_dir_path( __FILE__ ) . 'assets/img/note.png',
                'params' => array(
                     array(
                        'type' => 'attach_images',
                        'holder' => 'img',
                        //'class' => 'text-class',
                        'heading' => __( 'Select Images (Max - 9 Images)', 'text-domain' ),
                        'param_name' => 'imgstripimages',
                        // 'value' => __( 'Default value', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Image Selection',
                    ),

                 
                ),
            )
        );

    }

    // Element HTML
    public function vc_imagestripbox_html( $atts, $content ) {

        // Params extraction
        $gallery = shortcode_atts(
            array(
                'imgstripimages'      =>  'imgstripimages',
            ), $atts );

        $image_ids = explode(',',$gallery['imgstripimages']);
        
        if (!is_array($image_ids)) {
            return;
        }
        $total_images = count($image_ids);
        ob_start();
        if ($total_images>1) {
            echo '<div class="gallery-columns-'.$total_images.' image-strip">';
            foreach ($image_ids as $imgstripimage) {
                var_dump( $imgstripimage);
                $img_url = wp_get_attachment_image_src( $imgstripimage, "full");
                echo '<img class="gallery-item" src="'.$img_url[0].'" alt="">';
            }
            echo "</div>";
        
        }
        return ob_get_clean();

    }

} // End Element Class

// Element Class Init
new vcImageStripBox();