<?php

namespace Drupal\bootstrap_library\Hook;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Url;
use Drupal\Core\Installer\InstallerKernel;
use Drupal\Core\Hook\Attribute\Hook;
/**
 * Hook implementations for bootstrap_library.
 */
class BootstrapLibraryHooks
{
    /**
     * Implements hook_page_attachments().
     *
     * Use Libraries API to load the js & css files into header.
     */
    #[Hook('page_attachments')]
    public function pageAttachments(array &$page)
    {
        // Don't add the JavaScript and CSS during installation.
        if (\Drupal\Core\Installer\InstallerKernel::installationAttempted()) {
            return;
        }
        // Don't add the JavaScript and CSS on specified paths or themes.
        if (!_bootstrap_library_check_theme() || !_bootstrap_library_check_url()) {
            return;
        }
        $config = \Drupal::config('bootstrap_library.settings');
        $cdn = $config->get('cdn.bootstrap');
        if ($cdn) {
            $page['#attached']['library'][] = 'bootstrap_library/bootstrap-cdn';
        } else {
            $variant_options = [
                'source',
                'minified',
                'composer',
            ];
            $variant = $variant_options[$config->get('minimized.options')];
            switch ($variant) {
                case 'minified':
                    $page['#attached']['library'][] = 'bootstrap_library/bootstrap';
                    break;
                case 'source':
                    $page['#attached']['library'][] = 'bootstrap_library/bootstrap-dev';
                    break;
                case 'composer':
                    $page['#attached']['library'][] = 'bootstrap_library/bootstrap-composer';
                    break;
            }
        }
    }
    /**
     * Implements hook_library_info_build().
     */
    #[Hook('library_info_build')]
    public function libraryInfoBuild()
    {
        $libraries = [
        ];
        $config = \Drupal::config('bootstrap_library.settings');
        $cdn = $config->get('cdn.bootstrap');
        if ($cdn) {
            $data = $config->get('cdn.options');
            $cdn_options = json_decode($data);
            $list = _bootstrap_library_object_to_array($cdn_options->bootstrap);
            if (!is_array($list[$cdn]['js'])) {
                $list[$cdn]['js'] = [
                    $list[$cdn]['js'],
                ];
            }
            $css_uri = $list[$cdn]['css'];
            $libraries['bootstrap-cdn'] = [];
            $libraries['bootstrap-cdn']['css']['base'][$css_uri] = [
                'type' => 'external',
            ];
            foreach ($list[$cdn]['js'] as $js_uri) {
                $libraries['bootstrap-cdn']['js'][$js_uri] = [
                    'type' => 'external',
                ];
            }
        }
        return $libraries;
    }
}
