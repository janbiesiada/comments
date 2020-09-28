<?php

namespace Jbdev\Comments\Model\Resolver;

use Jbdev\Comments\Model\Resolver\DataProvider\Comment as CommentDataProvider;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class CommentsTest extends TestCase
{
    /**
     * @var Comments
     */
    private $resolver;
    /**
     * @var CommentDataProvider
     */
    private $dataProvider;
    /**
     * @var Field
     */
    private $field;
    /**
     * @var ContextInterface
     */
    private $context;
    /**
     * @var ResolveInfo
     */
    private $info;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->dataProvider = $this->getMockBuilder(CommentDataProvider::class)
            ->disableOriginalConstructor()
            ->setMethods(['getTree','getData'])
            ->getMock();
        $this->field = $this->getMockBuilder(Field::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->context = $this->getMockBuilder(ContextInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->info = $this->getMockBuilder(ResolveInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->resolver = $objectManager->getObject(Comments::class, [
            'dataProvider' => $this->dataProvider
        ]);
    }

    public function testResolve()
    {
        $this->dataProvider->expects($this->any())
            ->method('getTree')
            ->willReturn(['item tree']);
        $this->dataProvider->expects($this->any())
            ->method('getData')
            ->with('1')
            ->willReturn(['item']);
        $this->assertEquals(
            ['items' => ['item tree']],
            $this->resolver->resolve($this->field, $this->context, $this->info, [], [])
        );
        $this->assertEquals(
            ['items' => ['1' => ['item']]],
            $this->resolver->resolve($this->field, $this->context, $this->info, [], ['ids' => ['1']])
        );
    }
}
