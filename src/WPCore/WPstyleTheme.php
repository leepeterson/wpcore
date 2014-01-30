<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore;

/**
 * WP style theme
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPstyleTheme extends WPstyle
{
    protected $load_condition = true;
    protected $allowOverride = false;
    protected $overrideDir = 'assets/css/';

    public function __construct($load_condition, $handle, $src = "", $deps = array(), $ver = false, $media = 'all', $allowOverride = false)
    {
        parent::__construct($handle, $src, $deps, $ver, $media);

        $this->load_condition = $load_condition;
        $this->allowOverride = $allowOverride;
    }

    //This is unsafe but will do for now
    public function isNeeded()
    {
        $isNeeded = $this->load_condition;
        eval("\$isNeeded = $isNeeded;");

        return $isNeeded;
    }

    public function setOverrideDir($subDir)
    {
        $this->overrideDir = $subdir.'/';
        return $this;
    }

    public function enqueue()
    {
        if ($this->isNeeded()) {
            if ($this->allowOverride === true) {
                $name = basename($this->src);
                if ($override = locate_template($this->overrideDir.$name)) {
                    $this->src = get_template_directory_uri() . '/'.$this->overrideDir.$name;
                }
            }
            parent::enqueue();
        }
    }
}
