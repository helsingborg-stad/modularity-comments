<?php

namespace ModularityComments;

class App
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
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
