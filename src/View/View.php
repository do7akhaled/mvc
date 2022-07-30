<?php

namespace Do7a\Mvc\View;

class View
{
    public static function make($view, $params): array|bool|string
    {
        $baseContent = self::getBaseContent();
        $viewContent = self::getViewContent($view, params: $params);

         return (str_replace('{{content}}', $viewContent, $baseContent));

    }

    public static function makeError($error)
    {
        return self::getViewContent($error, true);
    }



    private static function getBaseContent(): bool|string
    {
        ob_start();
        include base_path('views/layouts/main.php');
        return ob_get_clean();
    }

    private static function  getViewContent($view, $isError = false, $params = [])
    {
        $path = $isError ? view_path('errors/') : view_path();
        if (str_contains($view, '.'))
        {
            $views = explode('.', $view);
            foreach ($views as $view)
            {
                if (is_dir($path  . $view))
                    $path = $path . $view . '/';
            }

            $view = $path . end($views) . '.php';


        }else{
            $view = $path . $view . '.php';
        }


        foreach ($params as $param => $value)
            $$param = $value;

        if ($isError)
            return include $view;


        ob_start();
        include $view;
        return ob_get_clean();

    }
}