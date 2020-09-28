<?php

namespace Jbdev\Comments\Model\Resolver\Product;

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
            ->setMethods(['getTree'])
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
            ->with('2', 'product')
            ->willReturn(['item2']);
        $this->assertEquals(
            ['items' => ['item2']],
            $this->resolver->resolve($this->field, $this->context, $this->info, ['entity_id' => '2'], [])
        );
    }
}
