<?php
namespace Cntrl;

use Model\Realms;
use Model\Permissions;
use Model\Users;
use Model\Config;
use Model\PathRealm;
use Illuminate\Database\Eloquent\Model;
use Tuupola\Middleware\HttpBasicAuthentication;

/**
 * Application middleware
 * e.g: $this->app->add(new \Slim\Csrf\Guard);
 *
 * @author havactik
 *        
 */
final class Middleware extends SlimWrapper implements SlimModule
{

    function init()
    {
        $this->authInit();
    }

    protected function authInit()
    {
        /* @var $realm Model */
        foreach (Realms::all() as $realm) {
            $users_list = [];
            foreach (Permissions::where('realm_id', $realm->realm_id)->pluck('user_id') as $user_id) {
                /* @var $user Model */
                $user = Users::find($user_id);
                $users_list[$user->login] = $user->password;
            }

            if (Config::where('config_key', 'app_secure')->select('config_value') == "true") {
                $secure = true;
            } else {
                $secure = false;
            }

            /* @var $path Model */
            foreach (PathRealm::where('realm_id', $realm->realm_id)->get() as $path) {
                $this->app->add(new HttpBasicAuthentication([
                    "path" => $path->ac_path,
                    "realm" => $realm->name,
                    "secure" => $secure,
                    "users" => $users_list
                ]));
            }
        }
    }
}