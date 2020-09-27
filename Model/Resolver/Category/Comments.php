<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model\Resolver\Category;

use Jbdev\Comments\Model\Resolver\DataProvider\Comment as DataProvider;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Comments implements ResolverInterface
{
    /**
     * @var DataProvider
     */
    private $dataProvider;

    /**
     * @param DataProvider $dataProvider
     */
    public function __construct(
        DataProvider $dataProvider
    ) {
        $this->dataProvider = $dataProvider;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $items = [];
        $rootId = $this->getRootId($value);
        if ($rootId) {
            $items = $this->dataProvider->getTree($rootId, 'category');
        }
        return ['items' => $items];
    }

    /**
     * @param array $value
     *
     * @return string
     */
    private function getRootId(array $value): string
    {
        if (!isset($value['id']) || !is_numeric($value['id'])) {
            return '1';
        }
        return (string) $value['id'];
    }
}
