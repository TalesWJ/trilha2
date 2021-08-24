<?php

declare(strict_types=1);

namespace Webjump\Pets\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webjump\Pets\Api\Data\PetInterfaceFactory;
use Webjump\Pets\Api\PetRepositoryInterfaceFactory;


/**
 * UpdatePetKind Resolver
 */
class UpdatePetKind implements ResolverInterface
{
    public const ADMIN_RESOURCE = 'Webjump_Pets::edit';
    /**
     * @var PetRepositoryInterfaceFactory
     */
    private PetRepositoryInterfaceFactory $petRepositoryFactory;

    /**
     * @var PetInterfaceFactory
     */
    private PetInterfaceFactory $petFactory;

    /**
     * UpdatePetKind Resolver Constructor
     *
     * @param PetRepositoryInterfaceFactory $petRepositoryFactory
     * @param PetInterfaceFactory $petFactory
     */
    public function __construct(
        PetRepositoryInterfaceFactory $petRepositoryFactory,
        PetInterfaceFactory $petFactory
    ) {
        $this->petFactory = $petFactory;
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
        if (!isset(
            $args['input']['name'],
            $args['input']['description'],
            $args['input']['entity_id']
        )) {
            throw New GraphQlInputException(__('Missing Information'));
        }
        $petKind = $this->petFactory->create();
        $petKind->setData($args['input']);
        $petRepository = $this->petRepositoryFactory->create();
        $petRepository->save($petKind);
        return [
            'petkind' => $petKind,
        ];
    }
}
