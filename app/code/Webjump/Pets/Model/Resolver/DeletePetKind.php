<?php

declare(strict_types=1);

namespace Webjump\Pets\Model\Resolver;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webjump\Pets\Api\PetRepositoryInterfaceFactory;

/**
 * DeletePetKind Resolver
 */
class DeletePetKind implements ResolverInterface
{
    public const ADMIN_RESOURCE = 'Webjump_Pets::delete';
    /**
     * @var PetRepositoryInterfaceFactory
     */
    private PetRepositoryInterfaceFactory $petRepositoryFactory;

    /**
     * DeletePetKind Resolver Constructor
     *
     * @param PetRepositoryInterfaceFactory $petRepositoryFactory
     */
    public function __construct(
        PetRepositoryInterfaceFactory $petRepositoryFactory
    ) {
        $this->petRepositoryFactory = $petRepositoryFactory;
    }

    /**
     * @inheritDoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null)
    {
        if (!isset($args['entity_id'])) {
            throw New GraphQlInputException(__('PetKind ID not indicated'));
        }
        $petRepository = $this->petRepositoryFactory->create();
        try {
            $petRepository->deleteById($args['entity_id']);
            return [
                'message' => 'PetKind deleted with success.'
            ];
        } catch (CouldNotDeleteException  | NoSuchEntityException $exception) {
            return [
                'message' => $exception->getMessage()
            ];
        }
    }
}
