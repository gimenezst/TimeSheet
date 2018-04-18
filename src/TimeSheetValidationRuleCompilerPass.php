<?php

namespace UCS\Bundle\TimeSheetBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TimeSheetValidationRuleCompilerPass implements CompilerPassInterface
{
    const SERVICE_ID = 'ucs.time_sheet_validator';
    const TAG_ID = 'ucs.time_sheet_validation_rule';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::SERVICE_ID)) {
            return;
        }

        $definition = $container->getDefinition(self::SERVICE_ID);
        $taggedServices = [];

        foreach ($container->findTaggedServiceIds(self::TAG_ID) as $serviceId => $tags) {
            foreach ($tags as $tag) {
                $alias = isset($tag['alias'])
                    ? $tag['alias']
                    : $serviceId;

                $taggedServices[$alias] = new Reference($serviceId);
            }
        }

        $definition->replaceArgument(0, $taggedServices);
    }
}