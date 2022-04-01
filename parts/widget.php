<?php
/**
 * Bigup Web: Table of Contents - Widget
 *
 * This template defines the TOC.Xo widget including settings form,
 * front end html and saving settings.
 *
 * @package bigup_toc
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2021, Jefferson Real
 * @license GPL2+
 * @link https://jeffersonreal.uk
 */


class Bigup_TOC_Widget extends WP_Widget {


     /**
      * Construct the widget.
      */
     function __construct() {

         $widget_options = array (
             'classname' => 'bigup_toc_widget',
             'description' => 'Add an self-generating table of contents.'
         );
         parent::__construct( 'bigup_toc_widget', 'Bigup Web: Table Of Contents', $widget_options );

     }


     /**
      * output the widget settings form.
      */
     function form( $instance ) {

         $title = ! empty( $instance['title'] ) ? $instance['title'] : 'Table of Contents';
         $offset = ! empty( $instance['offset'] ) ? $instance['offset'] : '20';
         $stopat = ! empty( $instance['stopat'] ) ? $instance['stopat'] : 'h4';

         ?>

         <p>
         <label for="<?php echo $this->get_field_id( 'title'); ?>">Title:</label>
         <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
         </p>

         <p>
         <label for="<?php echo $this->get_field_id( 'stopat'); ?>">Which heading level to stop scraping at:</label>
         <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'stopat' ); ?>" name="<?php echo $this->get_field_name( 'stopat' ); ?>" value="<?php echo esc_attr( $stopat ); ?>" />
         </p>

         <p>
         <label for="<?php echo $this->get_field_id( 'offset'); ?>">Scroll offset in pixels:</label>
         <input class="widefat" type="number" id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" value="<?php echo esc_attr( $offset ); ?>" />
         </p>

         <?php
     }


     /**
      * display the widget on the front end.
      */
     function widget( $args, $instance ) {

         //enqueue toc scripts and styles
         wp_enqueue_script('bigup_toc_generator_js');
         wp_enqueue_style('bigup_toc_widget_css');

         //define variables
         $title = apply_filters( 'widget_title', $instance['title'] );
         $stopat = $instance['stopat'];
         $offset = $instance['offset'];

         //output code
         echo $args['before_widget'];

         echo '<div class="bigup_toc" data-stopat="' . $instance['stopat'] . '" data-offset="' . $instance['offset'] . '">';
             if ( ! empty( $title ) ) {
                 echo $args['before_title'] . $title . $args['after_title'];
             };
         echo '</div>';

         echo $args['after_widget'];
     }


     /**
      * define the data saved by the widget.
      */
     function update( $new_instance, $old_instance ) {
         $instance = $old_instance;
         $instance['title'] = strip_tags( $new_instance['title'] );
         $instance['stopat'] = strip_tags( $new_instance['stopat'] );
         $instance['offset'] = strip_tags( $new_instance['offset'] );
         return $instance;
     }

 } // Class Bigup_TOC_Widget end


 /**
  * Register and load the widget.
  */
 function bigup_toc_load_widget() {
     register_widget( 'bigup_toc_widget' );
 }
 add_action( 'widgets_init', 'bigup_toc_load_widget' );