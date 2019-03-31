<?php
namespace Cntrl;

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Config;
use Model\Subdirectory;
use Slim\Container;
use Model\Users;
use Model\Posts;
use TOC\TocGenerator;

/**
 * Routes
 *
 * @author havactik
 *        
 */
final class Routes extends SlimWrapper implements SlimModule
{

    public function init()
    {
        $this->test();
        $this->routerInit();
        $this->restApiInit();
    }

    protected function test()
    {
        /* test get request */
        $this->app->get('/test/{id}', function (Request $request, Response $response, $args) {
            $data = [];
            foreach (Config::all() as $config) {
                $data[$config->config_key] = $config->config_value;
            }
            $data['test-id'] = $args['id'];

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($data));
        });

        // Render Twig template in route
        $this->app->get('/hello/{name}', function (Request $request, Response $response, $args) {
            return $this->view->render($response, 'test.twig', [
                'name' => $args['name'],
                'title' => 'whats up'
            ]);
        });
    }

    protected function routerInit()
    {
        $sub_list = Subdirectory::all();

        foreach ($sub_list as $sub) {
            $args_suffix = '[/]';

            $render_data = [
                'theme' => $sub->theme_template,
                'title' => $sub->sub_name,
                'login' => $_SERVER['PHP_AUTH_USER']
            ];

            /* nav menu for dashboard */
            $nav_menu = [];
            $first_lvl_sub_list = Subdirectory::where('hidden', 0)->where('parent_sub_id', 2)->get();
            foreach ($first_lvl_sub_list as $first_lvl_sub) {

                $nav_link = [
                    'class' => $first_lvl_sub->sub_id == $sub->sub_id ? 'active' : '',
                    'name' => $first_lvl_sub->sub_name,
                    'url' => $first_lvl_sub->sub_url
                ];

                if (Subdirectory::where('hidden', 0)->where('parent_sub_id', $first_lvl_sub->sub_id)->count() > 0) {
                    $nav_link['class'] .= ' treeview';
                    $nav_link['nested_ul'] = [];
                    $second_lvl_sub_list = Subdirectory::where('hidden', 0)->where('parent_sub_id', $first_lvl_sub->sub_id)->get();
                    foreach ($second_lvl_sub_list as $second_lvl_sub) {
                        $nested_li = [
                            'name' => $second_lvl_sub->sub_name,
                            'url' => $second_lvl_sub->sub_url
                        ];

                        if ($second_lvl_sub->sub_id == $sub->sub_id) {
                            $nav_link['class'] .= ' active menu-open';
                            $nested_li['class'] = 'active';
                        }

                        array_push($nav_link['nested_ul'], $nested_li);
                    }
                }
                array_push($nav_menu, $nav_link);
            }
            $render_data['menu_links'] = $nav_menu;

            /* For every sub possible to create a controller wich can modify routes */
            /* @var $sub_controller SubController */
            $sub_type = $sub->data_controller;
            if ($sub_type) {
                $sub_type = "Cntrl\\" . $sub_type;
                $sub_controller = new $sub_type($sub, $render_data);
                $sub_controller->updateRoutes($this->app);
            } else {
                $sub_controller = null;
            }

            $this->app->get($sub->sub_url . $args_suffix, function (Request $request, Response $response, $args) use ($sub, $sub_controller, $render_data) {
                /* @var $this Container */
                if ($sub->sub_redirect_code && $sub->sub_redirect_path) {
                    return $response->withStatus((int) $sub->sub_redirect_code)
                        ->withHeader('Location', $sub->sub_redirect_path);
                } else {
                    /* if sub have a specified page template we will show it when args would be provided */
                    if ($args['id']) {
                        $template = $sub->page_template;
                    } else {
                        $template = $sub->sub_template;
                    }

                    /* For every sub possible to create a controller wich can modify render data for twig template */
                    /* @var $sub_controller SubController */
                    // $sub_type = $sub->data_controller;
                    if ($sub_controller)
                        $render_data = $sub_controller->getRenderData($this, $args);

                    return $this->view->render($response, $template, $render_data);
                }
            });
        }
    }

    protected function restApiInit()
    {
        $this->app->get('/api/blog/get_posts[/{id}]', function (Request $request, Response $response, $args) {

            $public_folder = __DIR__ . '/../../public';

            if ($args['id']) {
                $data = Posts::select('post_name', 'post_text', 'image', 'create_time', 'update_time')->where('parent_sub_id', 4)
                    ->where('post_id', $args['id'])
                    ->first()
                    ->toArray();

                $data['image_size'] = getimagesize($public_folder . $data['image']);
                
                /* @todo TOC generator for post */
//                 $toc_gen = new TocGenerator();
//                 $toc_menu = $toc_gen->getMenu($data['post_text']);
//                 foreach ($toc_menu as $key => $toc_item) {
//                     $data['toc'][$key] = $toc_item->getUri();
//                 }
                
            } else {
                $data = Posts::select('post_id', 'post_name', 'post_text_brief', 'image', 'create_time', 'update_time')->where('parent_sub_id', 4)
                    ->get()
                    ->toArray();

                foreach ($data as $key => $post) {
                    $data[$key]['image_size'] = getimagesize($public_folder . $post['image']);
                }
            }
            

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($data));
        });

        $this->app->get('/api/get_config', function (Request $request, Response $response, $args) {
            $data = [];
            foreach (Config::all() as $config) {
                $data[$config->config_key] = $config->config_value;
            }
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($data));
        });

        $this->app->get('/api/admin/get_user/{id}', function (Request $request, Response $response, $args) {
            $data = Users::select([
                'user_id',
                'login',
                'email',
                'create_time',
                'update_time'
            ])->find($args['id'])
                ->toArray();

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($data));
        });

        // $this->app->get('/api/get_user[/{id}]', function (Request $request, Response $response, $args) {
        // if ($args['id']) {
        // $data = Users::select([
        // 'user_id',
        // 'login',
        // 'email',
        // 'create_time',
        // 'update_time'
        // ])->find($args['id'])
        // ->toArray();
        // } else {
        // $data = Users::where('login', $_SERVER['PHP_AUTH_USER'])->select([
        // 'user_id',
        // 'login',
        // 'email',
        // 'create_time',
        // 'update_time'
        // ])
        // ->first()
        // ->toArray();
        // }

        // return $response->withStatus(200)
        // ->withHeader('Content-Type', 'application/json')
        // ->write(json_encode($data));
        // });

        $this->app->post('/api/admin/update_config', function (Request $request, Response $response, $args) {
            $data = [];

            $config_list = $request->getParsedBody();
            foreach ($config_list as $key => $value) {
                $config = config::where('config_key', $key)->first();
                $config->config_value = $value;
                $config->save();
            }

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($data));
        });

        $this->app->get('/api/user/get_user', function (Request $request, Response $response, $args) {
            $data = Users::where('login', $_SERVER['PHP_AUTH_USER'])->select([
                'user_id',
                'login',
                'email',
                'create_time',
                'update_time'
            ])
                ->first()
                ->toArray();

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($data));
        });

        $this->app->post('/api/user/update_user', function (Request $request, Response $response, $args) {
            $data = [];

            $new_data = $request->getParsedBody();
            $user = Users::find($new_data['user_id']);
            unset($new_data['user_id']);
            unset($new_data['create_time']);
            unset($new_data['update_time']);
            foreach ($new_data as $key => $value) {
                $user->$key = $value;
            }
            $user->save();

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($data));
        });

        $this->app->post('/api/user/update_password', function (Request $request, Response $response, $args) {
            $data = [];

            $user = Users::find($request->getParsedBody()['user_id']);
            $user->password = $request->getParsedBody()['password'];
            $user->save();

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($data));
        });
    }
}


