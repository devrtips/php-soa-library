<?php

namespace Devrtips\Soa\Support;

use Symfony\Component\Translation\TranslatorInterface;

class Lang
{
    protected static $translator = null;

    /**
     * Set translator.
     * 
     * @param TranslatorInterface $translator
     */
    public static function setTranslator(TranslatorInterface $translator)
    {
        self::$translator = $translator;
    }

    /**
     * Translates the given message.
     * 
     * @param string $key
     * @return string
     */
    public static function trans($key)
    {
        if ($key === null) {
            return "";
        }

        return self::$translator->get($key);
    }
}