<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model\Resolver;

use Jbdev\Comments\Api\CommentRepositoryInterface;
use Jbdev\Comments\Model\CommentFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class CreateComment implements ResolverInterface
{
    /**
     * @var CommentFactory
     */
    private $commentFactory;
    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepository;

    public function __construct(
        CommentFactory $commentFactory,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->commentFactory = $commentFactory;
        $this->commentRepository = $commentRepository;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $input = $args['input'];
        unset($input['comment_id']);
        $comment = $this->commentFactory->create();
        $comment->setData($input);
        $this->commentRepository->save($comment);
        return true;
    }
}
