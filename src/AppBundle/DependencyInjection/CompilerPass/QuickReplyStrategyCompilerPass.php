<?php

namespace AppBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class QuickReplyStrategyCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // Find the definition of our context service
        $contextDefinition = $container->findDefinition('quick.reply.service');
        // Find the definitions of all the strategy services
        $strategyServiceIds = array_keys(
            $container->findTaggedServiceIds('quick-reply-strategy')
        );
        // Add an addStrategy call on the context for each strategy
        foreach ($strategyServiceIds as $strategyServiceId) {
            $contextDefinition->addMethodCall('addStrategy', [new Reference($strategyServiceId)]);
        }
    }
}