<?php

namespace CSC\Translate;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * Trait TranslateTrait
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
trait TranslateTrait
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @param string     $id
     * @param array|null $parameters
     *
     * @return string
     */
    public function trans(string $id, ?array $parameters = []): string
    {
        return $this->translator->trans($id, $parameters);
    }
}