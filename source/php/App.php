<?php

namespace ModularityComments;

class App
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));

        add_filter('acf/load_field/name=comments_from_post_type', array($this, 'acf_populate_select_options'));
    }

    public function acf_populate_select_options($field)
    {
        $field['choices'] = get_post_types();
        array_unshift($field['choices'], 'any');
        return $field;
    }

    /**
     * Enqueue required style
     * @return void
     */
    public function enqueueStyles()
    {
        wp_enqueue_style('modularity-comments', MODULARITYCOMMENTS_URL . '/dist/css/modularity-comments.dev.css');
    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
    }
}
