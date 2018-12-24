<?php

namespace TeeLaravel\Menu;

use Teelaravel\Menu\Facades\Menu as FMenu;

class Menu {
    public $title;
    public $slug = 'root';
    public $icon;
    public $url;
    public $items = [];
    public $active = false;

    public function __construct($slug=null,$title=null,$url=null,$icon=null) {
        if($slug) $this->slug = $slug;
        if($title) $this->title = $title;
        if($url) $this->url = $url;
        if($icon) $this->icon = $icon;
    }

    public function use($slug = null) {
        if($slug == null) return $this;
        if(!isset($this->items[$slug])) {
            $this->items[$slug] = new Menu($slug);
        }
        return $this->items[$slug];
    }

    public function create($slug,$title=null,$url=null,$icon=null) {
        return new Menu($slug,$title,$url,$icon);
    }

    public function getItems() {
        return $this->items;
    }

    public function hasItems() {
        return sizeof($this->items) > 0;
    }

    public function setActive() {
        $this->active = true;
        return $this;
    }

    public static function setActiveSlug($slug) {
        $paths = explode('.',$slug);
        $menus = data_get(FMenu::use()->items,'*.items.'.implode('.items.',$paths));
        if($menus && sizeof($menus) > 0) {
            foreach($menus as $menu) {
                $menu->setActive();
            }
        }
    }

    public function isActive($active='active',$default='') {
        if(url()->current() ==  $this->url) return $active;
        if($this->active == true) return $active;
        return $default;
    }

    public function add(Menu $menu) {
        $this->items[$menu->slug] = $menu;
        return $this;
    }
    public function addTo($path) {
        $paths = explode('.',$path);
        data_get(FMenu::use()->items,implode('.items.',$paths))->add($this);
        return $this;
    }
}