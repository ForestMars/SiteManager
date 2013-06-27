<?php
/**
 * Contains SiteManager\Core\Route\SiteCommands.
 */

namespace SiteManager\Core\Route;

use Drupal\Core\Database\Database;
use SiteManager\Core\Annotation\Route;
use SiteManager\Core\RouteBase;
use SiteManager\Core\Container;

/**
 * @Route(
 *   id = "site_commands",
 *   path = "/site/{site}",
 *   context = {
 *     "site" = {
 *       "class" = "SiteManager\Core\Context\Site"
 *     }
 *   }
 * )
 */
class SiteCommands extends RouteBase {
  protected $type = 'xhtml';

  public function render() {
    $site = $this->getContextValue('site');
    print print_r($site->all(), TRUE);
    // Updating
    $site->url = 'test.com';
    $test = $site->save();
    print print_r($site->all(), TRUE);
    // Creating: This requires a bunch of bs code we shouldn't have to do because this class isn't meant for this.
    $contextManager = Container::get('plugin.manager.context');
    $newsite = $contextManager->createInstance('site');
    $newsite->url = 'mynewsite.com';
    $newsite->status = 'inactive';
    $newsite->save();
    print print_r($newsite->all(), TRUE);
    $storage = $contextManager->getStorage('route');
    $route = $storage->loadMultiple(array(), array('name' => 'site_commands'));
    $route = array_pop($route);
    print print_r($route->all(), TRUE);

  }
}
