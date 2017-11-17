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

            // Get resized Images
            if ($tile['tile_size'] == 'horizontal') {
                $this->image = $this->getResizedImageUrl($tile['custom_image'], array(854, 427));
            } elseif ($tile['tile_size'] == 'vertical') {
                $this->image = $this->getResizedImageUrl($tile['custom_image'], array(427, 854));
            }

            //Add class if ok!
            if (is_null($this->image)) {
                $this->tile[] = 'tile-img';
            }
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

    public function getResizedImageUrl($imageObject, $size = array(100, 100))
    {
        if (!isset($imageObject['id'])) {
            return null;
        }

        if (isset($imageObject['id']) && !is_numeric($imageObject['id'])) {
            return null;
        }

        if ($image = wp_get_attachment_image_src($imageObject['id'], $size)) {
            if (is_array($image) && count($image) == 4) {
                return $image[0];
            }
        }

        return null;
    }
}
