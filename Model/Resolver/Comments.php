<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model\Resolver;

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

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        return ['items' => $this->getData($this->getIds($args))];
    }

    /**
     * @param array $args
     *
     * @return string[]
     */
    private function getIds(array $args): ?array
    {
        if (!isset($args['ids']) || !is_array($args['ids']) || count($args['ids']) === 0) {
            return null;
        }

        return $args['ids'];
    }

    /**
     * @param array $ids
     *
     * @return array
     */
    private function getData(?array $ids): array
    {
        $data = [];
        if (!$ids) {
            return $this->dataProvider->getAll();
        }
        foreach ($ids as $id) {
            try {
                $data[$id] = $this->dataProvider->getData($id);
            } catch (NoSuchEntityException $e) {
                $data[$id] = new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
            }
        }
        return $data;
    }
}
