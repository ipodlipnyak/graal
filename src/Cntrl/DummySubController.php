<?php
namespace Cntrl;

class DymmySubController extends SubController implements SubControllerInterface
{

    protected function updateData()
    {
        // $this->render_data[$key]='';
    }

    public function updateRoutes($app)
    {
        // $app->get($this->sub->sub_url . '/{id}[/]', function (Request $request, Response $response, $args) {
        // $template = $this->sub->page_template;
        // return $this->view->render($response, $template, $this->render_data);
        // });
    }
}