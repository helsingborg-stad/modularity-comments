<?php

namespace ModularityComments\Module;

class Comments extends \Modularity\Module
{
    public $slug = 'comments';
    public $supports = array();

    public function init()
    {
        $this->nameSingular = __("Comment", 'modularity-comments');
        $this->namePlural = __("Comments", 'modularity-comments');
        $this->description = __("Display most recent comments", 'modularity-comments');
    }

    public function data() : array
    {
        $data = array();

        $data['comments'] = $this->getComments();
        $data['wordCount'] = 35;

        //Send to view
        return $data;
    }

    /**
     * Create tiles from db array
     * @return array or null
     */
    public function getComments()
    {
        $amount = get_field('number_of_comments', $this->ID);
        $postType = get_field('comments_from_post_type', $this->ID);
        return get_comments(array('number' => $amount, 'post_type' => $postType));
    }

    public function template() : string
    {
        return "comments.blade.php";
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
