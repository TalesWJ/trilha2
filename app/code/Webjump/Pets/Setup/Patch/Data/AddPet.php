<?php

declare(strict_types=1);

namespace Webjump\Pets\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Webjump\Pets\Model\PetFactory;
use Webjump\Pets\Model\PetRepository;

class AddPet implements DataPatchInterface
{
    /**
     * @var PetFactory
     */
    private PetFactory $petFactory;

    /**
     * @var PetRepository
     */
    private PetRepository $petRepository;

    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @param PetFactory $petFactory
     * @param PetRepository $petRepository
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        PetFactory $petFactory,
        PetRepository $petRepository,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->petRepository = $petRepository;
        $this->petFactory = $petFactory;
    }

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Add new pet!
     *
     * @return $this
     */
    public function apply(): AddPet
    {
        $this->moduleDataSetup->startSetup();
        $petDTO = $this->petFactory->create();
        $petDTO->setPetName('Laura Rezende');
        $petDTO->setPetOwner('Cacau');
        $petDTO->setOwnerTelephone('5532988291039');
        $petDTO->setOwnerId(2);
        $this->petRepository->save($petDTO);
        $this->moduleDataSetup->endSetup();
        return $this;
    }
}
