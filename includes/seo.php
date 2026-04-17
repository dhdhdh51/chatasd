<?php
function seo_meta(PDO $pdo, array $defaults = []): array
{
    return [
        'title' => app_setting($pdo, 'seo_title', $defaults['title'] ?? 'NovaSchool ERP'),
        'description' => app_setting($pdo, 'seo_description', $defaults['description'] ?? 'Premium School ERP + website built in Core PHP'),
        'keywords' => app_setting($pdo, 'seo_keywords', $defaults['keywords'] ?? 'school erp, admissions, result portal'),
        'og_image' => app_setting($pdo, 'seo_og_image', '/assets/img/og-default.jpg'),
    ];
}

function seo_head(PDO $pdo, array $defaults = []): void
{
    $meta = seo_meta($pdo, $defaults);
    echo '<title>' . e($meta['title']) . '</title>';
    echo '<meta name="description" content="' . e($meta['description']) . '">';
    echo '<meta name="keywords" content="' . e($meta['keywords']) . '">';
    echo '<meta property="og:title" content="' . e($meta['title']) . '">';
    echo '<meta property="og:description" content="' . e($meta['description']) . '">';
    echo '<meta property="og:image" content="' . e($meta['og_image']) . '">';
}
