<?php

namespace ModularityTiles\Module;

class Tiles extends \Modularity\Module
{
    public $slug = 'tiles';
    public $supports = array();

    public function init()
    {
        $this->nameSingular = __("Tiles", 'modularity-tiles');
        $this->namePlural = __("Tiles", 'modularity-tiles');
        $this->description = __("Display a tile-style post/page grid", 'modularity-tiles');
    }

    public function data() : array
    {
        $data = array();

        $data['tiles'] = $this->getTiles();

        //Send to view
        return $data;
    }

    public function getTiles()
    {
        if (!get_field('modularity-tiles', $this->ID)) {
            return;
        }

        $tiles = array();

        foreach (get_field('modularity-tiles', $this->ID) as $tile) {
            $tiles[] = new \ModularityTiles\Tile($tile);
        }

        return $tiles;
    }

    public function template() : string
    {
        return "tiles.blade.php";
    }

    /**
     * Available "magic" methods for modules:
     * init()            What to do on initialization
     * data()            Use to send data to view (return array)
     * style()           Enqueue style only when module is used on page
     * script            Enqueue script only when module is used on page
     * adminEnqueue()    Enqueue scripts for the module edit/add page in admin
     * template()        Return the view template (blade) the module should use when displayed
     */
}
