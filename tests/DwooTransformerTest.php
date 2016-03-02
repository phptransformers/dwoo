<?php

namespace PhpTransformers\Dwoo\Test;


use Dwoo\Core;
use PhpTransformers\Dwoo\DwooTransformer;

class DwooTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $engine = new DwooTransformer();
        self::assertEquals('dwoo', $engine->getName());
    }

    public function testRenderFile()
    {
        $engine = new DwooTransformer(array('template-dir' => 'tests/Fixtures'));

        $actual = $engine->renderFile('template.tpl', array('name' => 'Linus'));

        self::assertEquals('Hello, Linus!', $actual);
    }

    public function testRender()
    {
        $engine = new DwooTransformer();

        $actual = $engine->render(
            file_get_contents('tests/Fixtures/template.tpl'),
            array('name' => 'Linus')
        );

        self::assertEquals('Hello, Linus!', $actual);
    }

    public function testConstructor()
    {
        $dwoo = new Core(sys_get_temp_dir(),sys_get_temp_dir());
        $dwoo->setTemplateDir(__DIR__ . DIRECTORY_SEPARATOR . 'Fixtures');

        $engine = new DwooTransformer(array('dwoo' => $dwoo));

        $actual = $engine->renderFile('template.tpl', array('name' => 'Linus'));

        self::assertEquals('Hello, Linus!', $actual);

        // Cache dir + compile dir test

        $engine = new DwooTransformer(array('cache-dir' => sys_get_temp_dir(), 'compile-dir' => sys_get_temp_dir()));

        $actual = $engine->renderFile(__DIR__ . '/Fixtures/template.tpl', array('name' => 'Linus'));

        self::assertEquals('Hello, Linus!', $actual);
    }

    /**
     * @dataProvider dataProvider
     * @param string $path
     */
    public function testTemplatePaths($path)
    {
        $engine = new DwooTransformer();

        $actual = $engine->renderFile($path, array('name' => 'Linus'));

        self::assertEquals('Hello, Linus!', $actual);
    }

    public function dataProvider()
    {
        return array(
            array('tests/Fixtures/template.tpl'),
            array(__DIR__.'/Fixtures/template.tpl'),
        );
    }
}
