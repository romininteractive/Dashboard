<?php

namespace Modules\Dashboard\Foundation\Widgets;

use Illuminate\Contracts\View\Factory;
use Modules\Dashboard\Composers\WidgetViewComposer;
use Modules\User\Entities\UserInterface;

abstract class BaseWidget
{
    /**
     * Boot the widget and add the data to the dashboard view composer
     */
    public function boot()
    {
        $widgetViewComposer = app(WidgetViewComposer::class);
        /** @var Factory $view */
        $view = app(Factory::class);

        if ($view->exists($this->view())) {
            $html = $view->make($this->view())
                ->with($this->data())
                ->render();

            $sluggedName = str_slug($this->name());

            $widgetViewComposer
                ->setWidgetName($sluggedName)
                ->addSubView($sluggedName, $html)
                ->addWidgetOptions($sluggedName, $this->options());
        }
    }

    /**
     * Get the widget name
     * @return string
     */
    abstract protected function name();

    /**
     * Return an array of widget options
     * Possible options:
     *  x, y, width, height
     * @return array
     */
    abstract protected function options();

    /**
     * Get the widget view
     * @return string
     */
    abstract protected function view();

    /**
     * Get the widget data to send to the view
     * @return array
     */
    abstract protected function data();

    /**
     * Checks whatever the user has permission to view the widget
     * on dashboard or not
     *
     * @param  UserInterface $user
     * @return boolean
     *
     * @author Daksh Mehta <dakshhmehta@gmail.com>
     */
    public function hasAccess(UserInterface $user)
    {
        return true;
    }
}
