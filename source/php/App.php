<?php

namespace ModularityTiles;

class App
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    /**
     * Enqueue required style
     * @return void
     */
    public function enqueueStyles()
    {
        wp_enqueue_style('modularity-tiles-admin-styles', MODULARITYTILES_URL . '/dist/css/admin-modularity-tiles.dev.css');
    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
    }
}
