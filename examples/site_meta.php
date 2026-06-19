<?php
/**
 * Site Metadata Helper
 * 
 * Provides structured site metadata with description generation.
 * This is a sample utility for managing basic site information.
 */

namespace App\Helpers;

class SiteMeta
{
    /**
     * @var array Site configuration data
     */
    private static $config = [
        'site_name' => '乐鱼体育',
        'base_url' => 'https://m-portal-leyusports.com.cn',
        'language' => 'zh-CN',
        'charset' => 'UTF-8',
        'description' => '乐鱼体育 - 专业体育资讯平台',
    ];

    /**
     * @var array Additional metadata fields
     */
    private static $metadata = [
        'author' => 'Site Admin',
        'keywords' => ['乐鱼体育', '体育资讯', '赛事动态'],
        'version' => '1.0.0',
        'created' => '2024-01-15',
    ];

    /**
     * Get the full site URL
     *
     * @param string $path Optional path to append
     * @return string
     */
    public static function getSiteUrl($path = '')
    {
        $base = rtrim(self::$config['base_url'], '/');
        if ($path) {
            $path = ltrim($path, '/');
            return $base . '/' . $path;
        }
        return $base;
    }

    /**
     * Get site name
     *
     * @return string
     */
    public static function getSiteName()
    {
        return self::$config['site_name'];
    }

    /**
     * Get all keywords as a comma-separated string
     *
     * @return string
     */
    public static function getKeywordsString()
    {
        return implode(', ', self::$metadata['keywords']);
    }

    /**
     * Generate a short description text from metadata
     *
     * @param int $maxLength Maximum length of description (default 150)
     * @return string
     */
    public static function generateDescription($maxLength = 150)
    {
        $parts = [
            self::$config['site_name'],
            ' - ',
            self::$config['description'],
            ' | ',
            '关键词: ' . self::getKeywordsString(),
        ];

        $text = implode('', $parts);

        if (mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength - 3) . '...';
        }

        return $text;
    }

    /**
     * Generate an HTML meta tag block for the site
     *
     * @return string
     */
    public static function renderMetaTags()
    {
        $tags = [];

        $tags[] = '<meta charset="' . htmlspecialchars(self::$config['charset'], ENT_QUOTES, 'UTF-8') . '">';
        $tags[] = '<meta name="description" content="' . htmlspecialchars(self::generateDescription(), ENT_QUOTES, 'UTF-8') . '">';
        $tags[] = '<meta name="keywords" content="' . htmlspecialchars(self::getKeywordsString(), ENT_QUOTES, 'UTF-8') . '">';
        $tags[] = '<meta name="author" content="' . htmlspecialchars(self::$metadata['author'], ENT_QUOTES, 'UTF-8') . '">';

        return implode("\n    ", $tags);
    }

    /**
     * Get all metadata as an associative array
     *
     * @return array
     */
    public static function getAllMeta()
    {
        return array_merge(self::$config, self::$metadata, [
            'full_url' => self::getSiteUrl(),
            'generated_description' => self::generateDescription(),
        ]);
    }

    /**
     * Update a configuration value (for runtime customization)
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function setConfig($key, $value)
    {
        if (array_key_exists($key, self::$config)) {
            self::$config[$key] = $value;
            return true;
        }
        return false;
    }
}

// Example usage (commented out for production):
/*
$description = SiteMeta::generateDescription(100);
echo $description;

$metaBlock = SiteMeta::renderMetaTags();
echo $metaBlock;

$all = SiteMeta::getAllMeta();
print_r($all);
*/