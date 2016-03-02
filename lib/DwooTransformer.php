<?php

namespace PhpTransformers\Dwoo;

use Dwoo\Core;
use Dwoo\Exception;
use Dwoo\Exception\CoreException;
use Dwoo\Template\Str;
use PhpTransformers\PhpTransformer\TransformerInterface;

/**
 * Class DwooTransformer.
 *
 * The PhpTransformer for Dwoo template engine.
 * {@link http://dwoo.org/}
 *
 * @author  MacFJA
 * @package PhpTransformers\Dwoo
 * @license MIT
 */
class DwooTransformer implements TransformerInterface
{
    /** @var Core */
    protected $dwoo;

    /**
     * The transformer constructor.
     *
     * Options are:
     *   - "dwoo" a Dwoo\Core instance
     *   - "cache-dir" the directory where Dwoo will search and store templates outout
     *   - "compile-dir" the directory where Dwoo will compile templates into Php code
     *   - "template-dir" the directory where Dwoo will search templates
     * if the option "dwoo" is provided, options "cache-dir", "compile-dir" and "template-dir" are ignored.
     *
     * @param array $options The DwooTransformer options
     *
     * @throws CoreException
     */
    public function __construct(array $options = array())
    {
        if (array_key_exists('dwoo', $options)) {
            $this->dwoo = $options['dwoo'];
            return;
        }

        $this->dwoo = new Core();

        $this->dwoo->setCacheDir(sys_get_temp_dir());
        if (array_key_exists('cache-dir', $options)) {
            $this->dwoo->setCacheDir($options['cache-dir']);
        }

        $this->dwoo->setCompileDir(sys_get_temp_dir());
        if (array_key_exists('compile-dir', $options)) {
            $this->dwoo->setCompileDir($options['compile-dir']);
        }

        $this->dwoo->setTemplateDir(getcwd());// Current working directory
        $this->dwoo->setTemplateDir(null);// File System root
        if (array_key_exists('template-dir', $options)) {
            $this->dwoo->setTemplateDir($options['template-dir']);
        }

    }

    /**
     * Get the transformer name
     *
     * @return string
     */
    public function getName()
    {
        return 'dwoo';
    }

    /**
     * Render a file
     *
     * @param string $file The file to render
     * @param array $locals The variable to use in template
     * @return null|string
     *
     * @throws CoreException
     * @throws Exception
     * @throws \Exception
     */
    public function renderFile($file, array $locals = array())
    {
        return $this->dwoo->get($file, $locals);
    }

    /**
     * Render a string
     *
     * @param string $template The template content to render
     * @param array $locals The variable to use in template
     * @return null|string
     *
     * @throws CoreException
     * @throws Exception
     * @throws \Exception
     */
    public function render($template, array $locals = array())
    {
        $templateObject = new Str($template);

        return $this->dwoo->get($templateObject, $locals);
    }
}
