<?php
declare(strict_types=1);

namespace Team23\Core\Model;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\Serialize\SerializerInterface;

class ModuleListProcessor
{
    private const COMPOSER_JSON_FILE = 'composer.json';
    private const MODULE_SRC_PATH = '/src';

    /**
     * @var array|null
     */
    private ?array $modules = null;

    /**
     * @param ComponentRegistrarInterface $componentRegistrar
     * @param ReadFactory $readFactory
     * @param ModuleListInterface $moduleList
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private readonly ComponentRegistrarInterface $componentRegistrar,
        private readonly ReadFactory $readFactory,
        private readonly ModuleListInterface $moduleList,
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * Retrieve a list of installed TEAM23 extensions
     *
     * @return array
     */
    public function execute(): array
    {
        if ($this->modules === null) {
            $this->modules = $this->getModuleList();
        }
        return $this->modules;
    }

    /**
     * Retrieve a list of installed TEAM23 extensions with limited information
     *
     * @return array
     */
    private function getModuleList(): array
    {
        $result = [];

        foreach ($this->moduleList->getNames() as $moduleName) {
            if (!str_contains($moduleName, 'Team23_')) {
                continue;
            }

            if ($moduleInfo = $this->getModuleInfo($moduleName)) {
                $result[] = $moduleInfo;
            }
        }

        return $result;
    }

    /**
     * Retrieve extension information from `composer.json` file
     *
     * @param string $moduleName
     * @return array|null
     */
    private function getModuleInfo(string $moduleName): ?array
    {
        $componentPath = $this->componentRegistrar->getPath(
            ComponentRegistrar::MODULE,
            $moduleName
        );

        try {
            $directory = $this->readFactory->create($componentPath);
            if ($directory->isFile(self::COMPOSER_JSON_FILE)) {
                $jsonData = $directory->readFile(self::COMPOSER_JSON_FILE);
            } else {
                $directory = $this->readFactory->create(str_replace(self::MODULE_SRC_PATH, '', $componentPath));
                if ($directory->isFile(self::COMPOSER_JSON_FILE)) {
                    $jsonData = $directory->readFile(self::COMPOSER_JSON_FILE);
                }
            }
        } catch (\Exception) {
            return null;
        }

        if (!isset($jsonData)) {
            return null;
        }

        $moduleData = $this->serializer->unserialize($jsonData);
        return [
            'name' => $moduleName,
            'description' => $moduleData['description'] ?? '',
            'version' => $moduleData['version'] ?? '',
        ];
    }
}
