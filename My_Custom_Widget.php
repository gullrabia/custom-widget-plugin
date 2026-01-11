<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class My_Custom_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'my_custom_widget',
            'My Custom Widget',
            array( 'description' => 'Display recent posts or a static message' )
        );
    }

    public function form( $instance ) {
        $title        = isset( $instance['title'] ) ? $instance['title'] : '';
        $display_type = isset( $instance['display_type'] ) ? $instance['display_type'] : 'recent_posts';
        $post_count   = isset( $instance['post_count'] ) ? $instance['post_count'] : 5;
        $message      = isset( $instance['message'] ) ? $instance['message'] : '';

        $style_post_count = ($display_type === 'recent_posts') ? '' : 'display:none;';
        $style_message    = ($display_type === 'static_message') ? '' : 'display:none;';
        ?>
        <p>
            <label>Title</label>
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label>Display Type</label>
            <select class="widefat mcw-display-type" name="<?php echo $this->get_field_name('display_type'); ?>">
                <option value="recent_posts" <?php selected( $display_type, 'recent_posts' ); ?>>Recent Posts</option>
                <option value="static_message" <?php selected( $display_type, 'static_message' ); ?>>Static Message</option>
            </select>
        </p>

        <p class="mcw-post-count" style="<?php echo $style_post_count; ?>">
            <label>Number of Posts</label>
            <input class="widefat" name="<?php echo $this->get_field_name('post_count'); ?>" type="number" min="1" value="<?php echo esc_attr($post_count); ?>">
        </p>

        <p class="mcw-message-field" style="<?php echo $style_message; ?>">
            <label>Your Message</label>
            <input class="widefat" name="<?php echo $this->get_field_name('message'); ?>" type="text" value="<?php echo esc_attr($message); ?>">
        </p>

        <script>
        jQuery(document).ready(function($){
            $('.mcw-display-type').on('change', function(){
                var type = $(this).val();
                var $form = $(this).closest('form');
                if(type === 'recent_posts'){
                    $form.find('.mcw-post-count').show();
                    $form.find('.mcw-message-field').hide();
                } else {
                    $form.find('.mcw-post-count').hide();
                    $form.find('.mcw-message-field').show();
                }
            }).trigger('change');
        });
        </script>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['title']        = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['display_type'] = ! empty( $new_instance['display_type'] ) ? sanitize_text_field( $new_instance['display_type'] ) : 'recent_posts';
        $instance['post_count']   = ! empty( $new_instance['post_count'] ) ? absint( $new_instance['post_count'] ) : 5;
        $instance['message']      = ! empty( $new_instance['message'] ) ? sanitize_text_field( $new_instance['message'] ) : '';
        return $instance;
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
        }

        $display_type = ! empty( $instance['display_type'] ) ? $instance['display_type'] : 'recent_posts';

        if ( $display_type === 'recent_posts' ) {
            $query = new WP_Query( array( 'posts_per_page' => $instance['post_count'] ) );
            if ( $query->have_posts() ) {
                echo '<ul>';
                while ( $query->have_posts() ) {
                    $query->the_post();
                    echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
                }
                echo '</ul>';
                wp_reset_postdata();
            }
        } else {
            echo '<p>' . esc_html( $instance['message'] ) . '</p>';
        }

        echo $args['after_widget'];
    }
}

function register_my_custom_widget() {
    register_widget( 'My_Custom_Widget' );
}
add_action( 'widgets_init', 'register_my_custom_widget' );
