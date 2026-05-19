<?php

declare(strict_types=1);

namespace App\Helpers;

use InvalidArgumentException;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\JsonFileLoader;

class TranslationHelper
{
    private Translator $translator;
    private string $currentLocale;
    private string $defaultLocale;
    private string $langPath;
    private array $availableLocales;

    /**
     * @param string $langPath Path to language files directory
     * @param string $defaultLocale Default locale (fallback)
     * @param array $availableLocales List of available locales
     */
    public function __construct(
        string $langPath,
        string $defaultLocale = 'en',
        array $availableLocales = ['en', 'fr']
    ) {
        $this->langPath = $langPath;
        $this->defaultLocale = $defaultLocale;
        $this->availableLocales = $availableLocales;
        $this->translator = new Translator($defaultLocale);
        $this->translator->setFallbackLocales([$defaultLocale]);
        $this->translator->addLoader('json', new JsonFileLoader());
        $this->currentLocale = $defaultLocale;
        $this->loadTranslations();
    }

    /**
     * Load translation files for all available locales.
     */
    private function loadTranslations(): void
    {
        foreach ($this->availableLocales as $locale) {
            $translationPath = $this->langPath . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . 'messages.json';
            if (is_file($translationPath)) {
                $this->translator->addResource('json', $translationPath, $locale);
            }
        }
    }

    /**
     * Translate a message.
     *
     * @param string $key Translation key (supports dot notation: 'home.welcome')
     * @param array $parameters Parameters to replace in translation
     * @param string|null $locale Override current locale for this translation
     * @return string Translated message
     */
    public function trans(string $key, array $parameters = [], ?string $locale = null): string
    {
        return $this->translator->trans($key, $parameters, null, $locale ?? $this->currentLocale);
    }

    /**
     * Set the current locale.
     *
     * @param string $locale Locale code (e.g., 'en', 'fr')
     * @throws \InvalidArgumentException If locale is not available
     */
    public function setLocale(string $locale): void
    {
        if (!in_array($locale, $this->availableLocales, true)) {
            throw new InvalidArgumentException("Requested locale is not supported");
        }
        $this->currentLocale = $locale;
        $this->translator->setLocale($locale);
    }
    public function getLocale(): string
    {
        return $this->currentLocale;
    }
    public function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }
    public function getAvailableLocales(): array
    {
        return $this->availableLocales;
    }


    // TODO: Implement the following getter methods that return
    //       the corresponding class properties:
    //       - getLocale(): string
    //       - getDefaultLocale(): string
    //       - getAvailableLocales(): array
    //       - isLocaleAvailable(string $locale): bool

    public function isLocaleAvailable(string $locale): bool
    {
        return in_array($locale, $this->availableLocales, true);
    }
}
