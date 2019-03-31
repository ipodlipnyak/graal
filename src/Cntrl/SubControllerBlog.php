<?php
namespace Cntrl;

use Model\Posts;
use Slim\Http\Request;
use Slim\Http\Response;

class SubControllerBlog extends SubController implements SubControllerInterface
{

    public function updateRoutes($app)
    {
        /* post page render */
        if (Posts::where('parent_sub_id', $this->sub->sub_id)->count() > 0) {
            $sub = $this->sub;
            $render_data = $this->render_data;
            $app->get($this->sub->sub_url . '/{id}[/]', function (Request $request, Response $response, $args) use ($sub, $render_data) {
                $blog_post = Posts::find($args['id']);

                $template = $sub->page_template;

                $render_data['post_name'] = $blog_post->post_name;
                $render_data['post_text'] = $blog_post->post_text;

                return $this->view->render($response, $template, $render_data);
            });
        }
    }
}