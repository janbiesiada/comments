<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model\Resolver\Product;

use Jbdev\Comments\Model\Resolver\DataProvider\Comment as DataProvider;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
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
            $items = $this->dataProvider->getTree($rootId, 'product');
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
        if (!isset($value['entity_id']) || !is_numeric($value['entity_id'])) {
            return '1';
        }
        return (string) $value['entity_id'];
    }
}
