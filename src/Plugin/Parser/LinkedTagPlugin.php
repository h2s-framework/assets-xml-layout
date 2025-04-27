<?php

namespace Siarko\AssetsXmlLayout\Plugin\Parser;

use Siarko\Assets\Api\AssetUrlProviderInterface;
use Siarko\BlockLayout\Definitions\TagData;
use Siarko\FileParserXml\Api\Parser\Result\NodeInterface;
use Siarko\LayoutParserXml\Parser\Node\Parser\AbstractLinkedTag;
use Siarko\Plugins\Config\Attribute\PluginMethod;

class LinkedTagPlugin
{

    public const ATTRIBUTE_ASSET = 'asset';

    public function __construct(
        private readonly AssetUrlProviderInterface $assetUrlProvider
    )
    {
    }

    #[PluginMethod]
    public function afterParse(AbstractLinkedTag $subject, TagData $result, ?NodeInterface $parent, NodeInterface $node): TagData
    {
        if($node->getAttribute(self::ATTRIBUTE_ASSET)){
            $assetId = $node->getAttribute(self::ATTRIBUTE_ASSET);
            $result->addExtraData('href', $this->assetUrlProvider->getFullAssetUrl($assetId));
        }
        return $result;
    }
}