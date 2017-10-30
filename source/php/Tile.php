<?php

namespace ModularityTiles;

class Tile
{
    public $grid = array();

    public $tile = array();

    public $url;

    public $title;

    public $content;

    public $image;


    public function __construct($tile)
    {
        $this->setSize($tile['tile_size']);

        if ($tile['link_type'] !== 'image') {
            $this->setTitle($tile);
            $this->setUrl($tile);
            $this->setContent($tile);
        } else {
            $this->image = $tile['custom_image']['url'];
            $this->tile[] = 'tile-img';
        }

        //Convert class arrays to string
        $this->grid = implode(' ', $this->grid);
        $this->tile = implode(' ', $this->tile);
    }

    public function setContent($tile)
    {
        if ($tile['tile_size'] == 'horizontal' || $tile['tile_size'] == 'vertical') {
            $this->content = $tile['lead'];
            $this->tile[] = 'invert';
            $this->grid['xs'] = 'grid-xs-12';
        }
    }

    public function setSize($size)
    {
        $this->tile[] = 'tile';
        if ($size == 'square') {
            $this->grid['xs'] = 'grid-xs-6';
            $this->grid['lg'] = 'grid-lg-4';
        } elseif ($size == 'horizontal') {
            $this->grid['xs'] = 'grid-xs-12';
            $this->grid['lg'] = 'grid-lg-8';
            $this->tile[] = 'tile-h';
        } elseif ($size == 'vertical') {
            $this->grid['xs'] = 'grid-xs-6';
            $this->grid['lg'] = 'grid-lg-4';
            $this->tile[] = 'tile-v';
        }
    }

    public function setUrl($tile)
    {
        if ($tile['link_type'] == 'internal') {
            $this->url = get_permalink($tile['page']->ID);
        } else {
            $this->url = $tile['link_url'];
        }
    }

    public function setTitle($tile)
    {
        if ($tile['link_type'] == 'internal' && !$tile['title']) {
            $this->title = $tile['page']->post_title;
        } else {
            $this->title = $tile['title'];
        }
    }
}
