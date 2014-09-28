<?php

namespace JhHub\Service;

use SpiffyNavigation\Service\Navigation as SpiffyNavigation;
use SpiffyNavigation\Page\Page;
use RecursiveIteratorIterator;

/**
 *
 * This is an extension which removes the merging of get parameters
 * with the route match as this means routes with query params are treated as not the same
 * eg not active @see https://github.com/spiffyjr/spiffy-navigation/issues/31
 *
 * Class Navigation
 * @package JhHub\Service
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Navigation extends SpiffyNavigation
{

    /**
     * Check if a page is marked active.
     *
     * @param Page $page
     * @return bool
     */
    public function isActive(Page $page)
    {
        $hash = spl_object_hash($page);

        if (isset($this->isActiveCache[$hash])) {
            return $this->isActiveCache[$hash];
        }

        $active = false;
        if ($this->getRouteMatch()) {
            $name = $this->getRouteMatch()->getMatchedRouteName();

            if ($page->getOption('route') == $name) {
                $reqParams = $this->getRouteMatch()->getParams();
                $pageParams = array_merge(
                    $page->getOption('params') ? $page->getOption('params') : array(),
                    $page->getOption('query_params') ? $page->getOption('query_params') : array()
                );

                $active = $this->paramsAreEqual($pageParams, $reqParams);
            } elseif ($this->getIsActiveRecursion()) {
                $iterator = new RecursiveIteratorIterator($page, RecursiveIteratorIterator::CHILD_FIRST);

                /** @var \SpiffyNavigation\Page\Page $page */
                foreach ($iterator as $leaf) {
                    if (!$leaf instanceof Page) {
                        continue;
                    }
                    if ($this->isActive($leaf)) {
                        $active = true;
                        break;
                    }
                }
            }
        }

        $this->isActiveCache[$hash] = $active;
        return $active;
    }
}
