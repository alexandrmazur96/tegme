<?php

namespace Tegme\Tests\Unit;

use Tegme\Builders\DomPageBuilder;
use Tegme\Tests\TestCase;
use Tegme\Types\Dom\DomPage;
use Tegme\Types\Dom\Nodes\NodeInterface;
use Tegme\Types\Dom\Tags\A;
use Tegme\Types\Dom\Tags\Aside;
use Tegme\Types\Dom\Tags\Blockquote;
use Tegme\Types\Dom\Tags\Br;
use Tegme\Types\Dom\Tags\H3;
use Tegme\Types\Dom\Tags\I;
use Tegme\Types\Dom\Tags\P;
use Tegme\Types\Dom\Tags\Pre;

class DomPageBuilderTest extends TestCase
{
    public function testCreateSimplePage()
    {
        $builder = new DomPageBuilder();

        $createdNode = $builder->addNewNodeWithValue(new H3(), 'Hymn');
        $this->assertInstanceOf(NodeInterface::class, $createdNode);

        $createdNode = $builder->addNewNode(new Aside(), 'author_block');
        $this->assertInstanceOf(NodeInterface::class, $createdNode);

        $builder->addChildrenNodeElement('author_block', new P(), 'name');
        $builder->addChildrenNodeElement('author_block', new P(), 'date');
        $createdNode = $builder->addChildrenNodeText('name', 'Ivan Franko');
        $this->assertInstanceOf(NodeInterface::class, $createdNode);

        $createdNode = $builder->addChildrenNodeText('date', '1880 year');
        $this->assertInstanceOf(NodeInterface::class, $createdNode);

        $createdNode = $builder->addNewNodeWithValue(new P(), 'The Eternal Revolutionary - ');
        $this->assertInstanceOf(NodeInterface::class, $createdNode);

        $builder->addNewNodeWithValue(new P(), 'The spirit that thirsts for battle,');
        $builder->addNewNodeWithValue(new P(), 'He cries for progress, happiness and will,');
        $builder->addNewNodeWithValue(new P(), 'He lives, he has not yet died.');
        $builder->addNewNodeWithValue(new P(), 'No priest torture,');
        $builder->addNewNodeWithValue(new P(), 'Not royal prison walls,');
        $builder->addNewNodeWithValue(new P(), 'All military forces,');
        $builder->addNewNodeWithValue(new P(), 'No guns are polished,');
        $builder->addNewNodeWithValue(new P(), 'Not spy craft');
        $builder->addNewNodeWithValue(new P(), 'He has not been taken to the mound yet.');

        $builder->addNewNode(new Br());
        $builder->addNewNodeWithValue(new I(), 'to be continued...');

        $page = $builder->build();

        $this->assertInstanceOf(DomPage::class, $page);

        $expected = '[{"tag":"h3","children":["Hymn"]},{"tag":"aside","children":[{"tag":"p","children":["Ivan Franko"]},{"tag":"p","children":["1880 year"]}]},{"tag":"p","children":["The Eternal Revolutionary - "]},{"tag":"p","children":["The spirit that thirsts for battle,"]},{"tag":"p","children":["He cries for progress, happiness and will,"]},{"tag":"p","children":["He lives, he has not yet died."]},{"tag":"p","children":["No priest torture,"]},{"tag":"p","children":["Not royal prison walls,"]},{"tag":"p","children":["All military forces,"]},{"tag":"p","children":["No guns are polished,"]},{"tag":"p","children":["Not spy craft"]},{"tag":"p","children":["He has not been taken to the mound yet."]},{"tag":"br"},{"tag":"i","children":["to be continued..."]}]';

        $this->assertEquals($expected, json_encode($page));
    }

    public function testCreateComplexPage()
    {
        $builder = new DomPageBuilder();

        $builder->addNewNode(new Blockquote(), 'blockquote');
        $builder->addChildrenNodeElementWithValue('blockquote', new P(), 'blah blah blah', 'blockquote_p');
        $builder->addChildrenNodeElementWithValue('blockquote_p', new A(['href' => 'example.com']), 'example link');
        $builder->addChildrenNodeElement('blockquote_p', new Pre(), 'blockquote_p_pre');
        $builder->addChildrenNodeText('blockquote_p_pre', '$hello = \'World\'');
        $builder->addChildrenNodeText('blockquote_p_pre', '//this is tegme library');

        $builder->addNewNodeWithValue(new P(), 'have a nice day!');

        $page = $builder->build();

        $this->assertInstanceOf(DomPage::class, $page);

        $expected = '[{"tag":"blockquote","children":[{"tag":"p","children":["blah blah blah",{"tag":"a","attrs":{"href":"example.com"},"children":["example link"]},{"tag":"pre","children":["$hello = \'World\'","\/\/this is tegme library"]}]}]},{"tag":"p","children":["have a nice day!"]}]';
        $this->assertEquals($expected, json_encode($page));
    }

    public function testCreatingPageWithMissedId()
    {
        $builder = new DomPageBuilder();

        $builder->addNewNode(new Aside(), 'node_id');

        $createdChildrenNode = $builder->addChildrenNodeElement('undefined_node_id', new P());
        $this->assertNull($createdChildrenNode);

        $createdChildrenNode = $builder->addChildrenNodeElementWithValue('undefined_node_id', new P(), 'test_value');
        $this->assertNull($createdChildrenNode);

        $createdChildrenNode = $builder->addChildrenNodeText('undefined_node_id', 'test_value');
        $this->assertNull($createdChildrenNode);

        $page = $builder->build();

        $this->assertInstanceOf(DomPage::class, $page);
        $this->assertEquals('[{"tag":"aside"}]', json_encode($page));
    }
}
