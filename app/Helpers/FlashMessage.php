<?php

namespace App\Helpers;

use function DI\get;

class FlashMessage
{
    private const FLASH_KEY = 'flash_messages';

    /**
     * Add a success message.
     */
    public static function success(string $message): void
    {
        self::add('success', $message);




        // TODO: Call the add() method with 'success' as the type
    }

    /**
     * Add an error message.
     */
    public static function error(string $message): void
    {
        // TODO: Call the add() method with 'error' as the type
        self::add('error', $message);
    }

    /**
     * Add an info message.
     */
    public static function info(string $message): void
    {
        self::add('info', $message);
        // TODO: Call the add() method with 'info' as the type
    }

    /**
     * Add a warning message.
     */
    public static function warning(string $message): void
    {
        // TODO: Call the add() method with 'warning' as the type
        self::add('warning', $message);
    }
    public static function multiple(string $message): void
    {
        // TODO: Call the add() method with 'warning' as the type
        self::add('multiple', $message);
    }


    /**
     * Add a flash message of any type.
     */
    public static function add(string $type, string $message): void
    {
        if (!isset($_SESSION[self::FLASH_KEY])) {
            $_SESSION[self::FLASH_KEY] = [];
        }

        $_SESSION[self::FLASH_KEY][] = [
            'type' => $type,
            'message' => $message
        ];

        // TODO: Check if $_SESSION[self::FLASH_KEY] is not set
        // If not set, initialize it as an empty array

        // TODO: Add a new message to the $_SESSION[self::FLASH_KEY] array
        // The message should be an associative array with 'type' and 'message' keys
    }

    /**
     * Get all flash messages and clear them.
     */
    public static function get(): array
    {
        $messages = $_SESSION[self::FLASH_KEY] ?? [];
        unset($_SESSION[self::FLASH_KEY]);
        return $messages;
        // TODO: Retrieve all messages from $_SESSION[self::FLASH_KEY]
        // Hint: Use the null coalescing operator (??) to default to an empty array

        // TODO: Remove the flash messages from the session using unset()

        // TODO: Return the retrieved messages
    }

    /**
     * Check if there are any flash messages.
     */
    public static function has(): bool
    {
        return !empty($_SESSION[self::FLASH_KEY]);
        // TODO: Check if $_SESSION[self::FLASH_KEY] exists and is not empty
        // Hint: Use the empty() function
    }

    /**
     * Clear all flash messages without retrieving them.
     */
    public static function clear(): void
    {
        unset($_SESSION[self::FLASH_KEY]);
        // TODO: Remove the flash messages from the session using unset()
    }

    /**
     * Render all flash messages as Bootstrap alerts.
     *
     * This method is provided for you as it involves complex HTML generation.
     */
    public static function render(bool $dismissible = true): string
    {
        $messages = self::get();
        if (empty($messages)) {
            return '';
        }

        $bootstrapTypes = [
            'success' => 'success',
            'error' => 'danger',
            'info' => 'info',
            'warning' => 'warning'
        ];

        $html = '';
        foreach ($messages as $flash) {
            $type = $bootstrapTypes[$flash['type']] ?? 'info';
            $message = htmlspecialchars($flash['message']);

            if ($dismissible) {
                $html .= <<<HTML
                <div class="alert alert-{$type} alert-dismissible fade show" role="alert">
                    {$message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                HTML;
            } else {
                $html .= <<<HTML
                <div class="alert alert-{$type}" role="alert">
                    {$message}
                </div>
                HTML;
            }
        }

        return $html;
    }
}
