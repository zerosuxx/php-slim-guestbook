<?php

namespace Guestbook\View;

use Psr\Http\Message\ResponseInterface;

/**
 * Class ViewRenderer
 * @package Guestbook\View
 */
class ViewRenderer
{
    /**
     * @var string
     */
    private $templatePath;

    public function __construct(string $templatesPath)
    {
        $this->templatePath = $templatesPath;
    }

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $vars [optional]
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, string $template, array $vars = [])
    {
        $file = $this->templatePath . $template;

        ob_start();
        $requireFile = function($__template, $__vars) {
            extract($__vars);
            require $__template;
        };
        $requireFile($file, $vars);

        $contents = ob_get_clean();
        $response->getBody()->write($contents);
        return $response;
    }
}