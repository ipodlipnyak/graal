<?php
namespace Cntrl;

use Model\Posts;

class SubControllerMainPage extends SubController implements SubControllerInterface
{

    protected function updateData()
    {
        // $this->render_data[$key]='';
        $this->render_data['blog_widget'] = Posts::where('parent_sub_id', 4)->get();
    }

    public function updateRoutes($app)
    {
        // $app->get($this->sub->sub_url . '/{id}[/]', function (Request $request, Response $response, $args) {
        // $template = $this->sub->page_template;
        // return $this->view->render($response, $template, $this->render_data);
        // });
    }
}