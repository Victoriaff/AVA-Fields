<?php
if (!defined('ABSPATH')) {
    die('-1');
}

if (!class_exists('AVA_Fields_Access')) {
    class AVA_Fields_Access
    {
        private $access;

        private $user;
        private $post;


        public function __construct($access) {

            $this->access = true;

            // Get current user
            $this->user = wp_get_current_user();

            // Get current post
            $this->post = get_post();


            /*
            'user_capability' => '',
        'user_id' => '',
        'user_role' => '',

        // post_meta
        'post_format' => '',
        'post_id' => '',
        'post_level' => '',
        'post_ancestor_id' => '',
        'post_template' => '',
        'post_term' => '',
        'post_type' => '',

        // term_meta
        'term' => '',
        'term_parent' => '',
        'term_level' => '',
        'term_ancestor' => '',
        'term_taxonomy' => '',

        // theme_options
        'blog_id' => '',
            */

            dump(get_current_screen());

            foreach ($access as $key => $data) {
                if (!empty($data)) {
                    //dump( $key . ' => ' . (is_array($data) ? sprintf($data):$data) );

                    if (method_exists(__CLASS__, $key)) {

                        // Define value
                        $value = is_array($data) && isset($data['value']) ? $data['value'] : $data;

                        // Define except
                        $except = is_array($data) && isset($data['except']) && is_bool($data['except']) ? true : false;
                        dump('except = ' . $except);

                        // Check on having access
                        $access = $this->$key($value);

                        if ($except === true) $access = !$access;

                        if ( !$access ) $this->access = false;

                        dump(($access ? 'Yes: ' : 'No: ') . $key);

                        //if (!$has_access) return false;
                    }

                }
            }


        }

        public function get() {
            return $this->access;
        }

        // Check user capability
        public function user_capability($value) {
            return !empty($this->user) && !empty($this->user->allcaps[$value]);
        }

        // Check user ID
        public function user_id($value) {
            return !empty($this->user) && $this->user->ID == $value;
        }

        // Check user role
        public function user_role($value) {
            return !empty($this->user) && in_array($value, $this->user->roles);
        }


    }
}

