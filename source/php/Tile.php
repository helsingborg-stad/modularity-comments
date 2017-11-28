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
        $this->tileSize($tile);
        $this->tileContent($tile);
        $this->stringifyClasses();
    }

    public function stringifyClasses()
    {
        $this->grid = implode(' ', $this->grid);
        $this->tile = implode(' ', $this->tile);
    }

    public function tileContent($tile)
    {
        $avalibleTileContent = array(
            'image' => [
                'title' => false,
                'content' => false,
                'url' => true,
                'image' => true
            ],
            'internal' => [
                'title' => true,
                'content' => true,
                'url' => true,
                'image' => false
            ],
            'external' => [
                'title' => true,
                'content' => true,
                'url' => true,
                'image' => false
            ]
        );

        foreach ($avalibleTileContent as $acfValue => $tileContent) {
            if (isset($tile['link_type']) && $tile['link_type'] == $acfValue) {
                if (isset($tileContent['title']) && $tileContent['title'] == true) {
                    $this->setTitle($tile);
                }

                if (isset($tileContent['content']) && $tileContent['content'] == true) {
                    $this->setContent($tile);
                }

                if (isset($tileContent['url']) && $tileContent['url'] == true) {
                    $this->setUrl($tile);
                }

                if (isset($tileContent['image']) && $tileContent['image'] == true) {
                    $this->setImage($tile);
                }
            }
        }
    }

    /**
     * Set tile size according to settings provided
     * @return void
     * @param $tile A tile object
     */

    public function tileSize($tile)
    {
        $avalibleTiles = array(
            'tile_size' => array(
                'square' => [
                    'grid' => 'grid-lg-4',
                    'tile' => 'tile'
                ],
                'horizontal' =>  [
                    'grid' => 'grid-lg-8',
                    'tile' => 'tile tile--lg-horizontal'
                ],
                'vertical' =>  [
                    'grid' => 'grid-lg-4',
                    'tile' => 'tile tile--lg-vertical'
                ],
            ),
            'tile_size_mobile' => array(
                'square' => [
                    'grid' => 'grid-xs-6',
                    'tile' => ''
                ],
                'square2x' => [
                    'grid' => 'grid-xs-12',
                    'tile' => 'tile--sm-horizontal'
                ],
                'horizontal' =>  [
                    'grid' => 'grid-xs-12',
                    'tile' => 'tile--xs-horizontal'
                ],
                'vertical' =>  [
                    'grid' => 'grid-xs-6',
                    'tile' => 'tile--xs-vertical'
                ],
            )
        );

        foreach ($avalibleTiles as $fieldName => $fieldValue) {
            if (isset($tile[$fieldName])) {
                $this->grid[] = $fieldValue[$tile[$fieldName]]['grid'];
                $this->tile[] = $fieldValue[$tile[$fieldName]]['tile'];
            }
        }
    }

    /**
     * Set url from textfield or linked item
     * @return void
     * @param $tile A tile object
     */

    public function setUrl($tile)
    {
        switch ($tile['link_type']) {
            case 'internal':
                $this->url = get_permalink($tile['page']->ID);
                break;
            case 'external':
                $this->url = $tile['link_url'];
                break;
            case 'image':
                if (isset($tile['link_options']) && $tile['link_options'] == 'internal') {
                    $this->url = get_permalink($tile['page']->ID);
                } elseif (isset($tile['link_options']) && $tile['link_options'] == 'external') {
                    $this->url = $tile['link_url'];
                }
                break;
        }
    }



    /**
     * Get image that shouild been used and append class
     * @return void
     */

    public function setImage($tile)
    {
        if ($tile['tile_size'] == 'horizontal') {
            $this->image = $this->getResizedImageUrl($tile['custom_image'], array(854, 427));
        } elseif ($tile['tile_size'] == 'vertical') {
            $this->image = $this->getResizedImageUrl($tile['custom_image'], array(427, 854));
        } elseif ($tile['tile_size'] == 'square') {
            $this->image = $this->getResizedImageUrl($tile['custom_image'], array(427, 427));
        }
    }

    /**
     * Set the title of the tile, get title from link if not set.
     * @return void
     * @param $tile A tile object
     */

    public function setTitle($tile)
    {
        if (isset($tile['page']) && $tile['page'] && !$tile['title']) {
            $this->title = $tile['page']->post_title;
        } else {
            $this->title = $tile['title'];
        }
    }

    /**
     * Set content sizes
     * @return void
     * @param $tile A tile object
     */

    public function setContent($tile)
    {
        if (!isset($tile['tile_content']) || $tile['tile_content'] == false) {
            return;
        }

        if (isset($tile['lead']) && $tile['lead']) {
            $this->content = $tile['lead'];
        } elseif (isset($tile['page']->excerpt) && $tile['page']->excerpt) {
             $this->content = $tile['page']->excerpt;
        }
        $this->tile[] = 'invert';
    }

    /**
     * Resize image and return url of the resize
     * @return string or null
     * @param array $imageObject standard wordpress image data array (4 items)
     * @param array $size array with width and height of the image that should be returned
     */

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
